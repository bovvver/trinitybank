<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavouritesResource;
use App\Http\Resources\TransferResource;
use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Services\TransferService;
use DB;
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
        $firstId = $accounts->first()->id;

        $lastTransfers = $this->transferService->getLastTransfers($firstId);
        $favouriteAccounts = $this->transferService->getFavouriteAccounts($firstId);
        $incomes = $this->transferService->getIncome($firstId);
        $spendsByCategories = $this->transferService->getSpendsPerCategory($firstId);
        $statistics = $this->transferService->getStatistics($firstId);

        return Inertia::render('Dashboard', [
            'transfers' => TransferResource::collection($lastTransfers),
            'favourites' => FavouritesResource::collection($favouriteAccounts),
            'incomes' => $incomes,
            'spendsByCategories' => $spendsByCategories,
            'statistics' => $statistics
        ]);
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
