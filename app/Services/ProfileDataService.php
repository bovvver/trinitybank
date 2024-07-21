<?php

namespace App\Services;

use App\Http\Requests\CardCreationRequest;
use App\Http\Requests\CardUpdateRequest;
use App\Http\Resources\FavouritesResource;
use App\Http\Resources\TransferResource;
use App\Models\Account;
use App\Models\User;
use App\Repositories\AccountRepository;
use App\Repositories\TransferRepository;
use Illuminate\Support\Facades\Gate;


class ProfileDataService extends Service
{
    protected $transferRepository;
    protected $accountRepository;
    protected $accountCreationService;

    public function __construct(TransferRepository $transferRepository, AccountRepository $accountRepository, AccountCreationService $accountCreationService)
    {
        $this->transferRepository = $transferRepository;
        $this->accountRepository = $accountRepository;
        $this->accountCreationService = $accountCreationService;
    }

    public function getAccountsData($userId)
    {
        $accounts = $this->accountRepository->getUserAccounts($userId);

        return $accounts->map(function ($account) {
            return [
                'id' => $account->id,
                'cardNumber' => $account->card_last_digits,
                'transfers' => TransferResource::collection($this->getLastTransfers($account->id))->resolve(),
                'favourites' => FavouritesResource::collection($this->getFavouriteAccounts($account->id))->resolve(),
                'incomes' => $this->getIncome($account->id),
                'spendsByCategories' => $this->getSpendsPerCategory($account->id),
                'statistics' => $this->getStatistics($account->id),
            ];
        });
    }

    public function updateCard(CardUpdateRequest $request)
    {
        $userId = auth()->user()->id;
        $newColor = $request->newColor;
        $cardDigits = $request->cardDigits;
        $newStatus = $request->newStatus === true ? 1 : 0;

        $account = Account::where('card_last_digits', $cardDigits)->first();

        Gate::authorize('access', $account);

        $this->accountRepository->updateCard($userId, $cardDigits, $newColor, $newStatus);

        return $this->successResponse("Card updated.");
    }

    public function createCard(CardCreationRequest $request)
    {
        $userId = auth()->user()->id;
        $bankingProduct = $request->bankingProduct;
        $currency = $request->currency;

        $this->accountCreationService->createAccount($userId, $bankingProduct, $currency);

        return $this->successResponse("Card created.");
    }

    public function getPersonalData()
    {
        $userId = auth()->user()->id;
        return $this->accountRepository->getPersonalData($userId);
    }

    public function getLastTransfers($accountId)
    {
        return $this->transferRepository->getLastTransfers($accountId);
    }

    public function getAllFavouriteAccounts($userId)
    {
        return $this->accountRepository->getAllFavouriteAccounts($userId);
    }

    public function getFavouriteAccounts($accountId)
    {
        return $this->accountRepository->getFavouriteAccounts($accountId);
    }

    public function getIncome($accountId)
    {
        return $this->transferRepository->getIncome($accountId);
    }

    public function getSpendsPerCategory($accountId)
    {
        return $this->transferRepository->getSpendsPerCategory($accountId);
    }

    public function getStatistics($accountId)
    {
        return $this->accountRepository->getStatistics($accountId);
    }

    public function getAllCreditCards($userId)
    {
        return $this->accountRepository->getAllCreditCards($userId);
    }

    public function getActiveCreditCards($userId)
    {
        return $this->accountRepository->getActiveCreditCards($userId);
    }

    public function getTransfersHistory($accountId)
    {
        return $this->transferRepository->getTransfersHistory($accountId);
    }
}