<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreditCardResource;
use App\Http\Resources\FavouritesResource;
use App\Http\Resources\TransferResource;
use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
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
    public function index()
    {
        $accounts = auth()->user()->accounts;

        $data = $accounts->map(function ($account) {
            return [
                'id' => $account->id,
                'cardNumber' => $account->card_last_digits,
                'transfers' => TransferResource::collection($this->profileDataService->getLastTransfers($account->id))->resolve(),
                'favourites' => FavouritesResource::collection($this->profileDataService->getFavouriteAccounts($account->id))->resolve(),
                'incomes' => $this->profileDataService->getIncome($account->id),
                'spendsByCategories' => $this->profileDataService->getSpendsPerCategory($account->id),
                'statistics' => $this->profileDataService->getStatistics($account->id),
            ];
        });

        $cards = $this->profileDataService->getCreditCards(auth()->user()->id);

        return Inertia::render('Dashboard', [
            'accountsData' => $data,
            'cards' => CreditCardResource::collection($cards)
        ]);
    }

    public function history(Request $request)
    {
        $selectedAccount = $request->session()->get("selectedAccount");

        return Inertia::render('History', [
            'history' => $this->profileDataService->getTransfersHistory($selectedAccount)
        ]);
    }

    public function cards()
    {
        return Inertia::render('CardsManager');
    }

    public function profile()
    {
        return Inertia::render('Profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
