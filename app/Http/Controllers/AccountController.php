<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardCreationRequest;
use App\Http\Requests\CardUpdateRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ActiveCreditCardResource;
use App\Http\Resources\CreditCardResource;
use App\Http\Resources\PersonalDataResource;
use App\Http\Resources\TransferResource;
use App\Services\ProfileDataService;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $profileDataService;

    public function __construct(ProfileDataService $profileDataService)
    {
        $this->profileDataService = $profileDataService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $accountsData = $this->profileDataService->getAccountsData($userId);
        $cards = $this->profileDataService->getActiveCreditCards($userId);
        $selectedCard = $request->session()->get("selectedAccount");

        return Inertia::render('Dashboard', [
            'accountsData' => $accountsData,
            'cards' => CreditCardResource::collection($cards),
            'selectedCard' => $selectedCard
        ]);
    }

    public function history(Request $request)
    {
        $selectedAccount = $request->session()->get("selectedAccount");
        $history = $this->profileDataService->getTransfersHistory($selectedAccount);

        return Inertia::render('History', [
            'history' => TransferResource::collection($history)
        ]);
    }

    public function cards()
    {
        return Inertia::render('CardsManager', [
            'cards' => ActiveCreditCardResource::collection($this->profileDataService->getAllCreditCards(auth()->user()->id)),
            'personalData' => new PersonalDataResource($this->profileDataService->getPersonalData())
        ]);
    }

    public function updateCard(CardUpdateRequest $request)
    {
        return $this->profileDataService->updateCard($request);
    }

    public function createCard(CardCreationRequest $request)
    {
        return $this->profileDataService->createCard($request);
    }

    public function updateContact(UpdateContactRequest $request)
    {
        return $this->profileDataService->updateContact($request);
    }

    public function profile()
    {
        return Inertia::render('Profile', [
            'cardsCount' => $this->profileDataService->getCardsCount(),
            'personalData' => new PersonalDataResource($this->profileDataService->getPersonalData())
        ]);
    }
}
