<?php

namespace App\Services;

use App\Http\Resources\FavouritesResource;
use App\Http\Resources\TransferResource;
use App\Repositories\AccountRepository;
use App\Repositories\TransferRepository;

class ProfileDataService
{
    protected $transferRepository;
    protected $accountRepository;

    public function __construct(TransferRepository $transferRepository, AccountRepository $accountRepository)
    {
        $this->transferRepository = $transferRepository;
        $this->accountRepository = $accountRepository;
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

    public function getLastTransfers($accountId)
    {
        return $this->transferRepository->getLastTransfers($accountId);
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

    public function getCreditCards($userId)
    {
        return $this->accountRepository->getCreditCards($userId);
    }

    public function getTransfersHistory($accountId)
    {
        return $this->transferRepository->getTransfersHistory($accountId);
    }
}