<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreditCardResource;
use App\Http\Resources\FavouritesResource;
use App\Http\Resources\TransferResource;
use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Services\TransferService;
use Inertia\Inertia;

class AccountController extends Controller
{
    protected $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
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
                'transfers' => TransferResource::collection($this->transferService->getLastTransfers($account->id))->resolve(),
                'favourites' => FavouritesResource::collection($this->transferService->getFavouriteAccounts($account->id))->resolve(),
                'incomes' => $this->transferService->getIncome($account->id),
                'spendsByCategories' => $this->transferService->getSpendsPerCategory($account->id),
                'statistics' => $this->transferService->getStatistics($account->id),
            ];
        });

        $cards = $this->transferService->getCreditCards(auth()->user()->id);

        return Inertia::render('Dashboard', [
            'accountsData' => $data,
            'cards' => CreditCardResource::collection($cards)
        ]);
    }

    public function history()
    {
        return Inertia::render('History');
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
