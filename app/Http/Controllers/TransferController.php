<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Http\Resources\CreditCardResource;
use App\Http\Resources\FavouritesResource;
use App\Models\Transfer;
use App\Services\ProfileDataService;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransferController extends Controller
{
    protected $profileDataService;
    protected $transferService;

    public function __construct(ProfileDataService $profileDataService, TransferService $transferService)
    {
        $this->profileDataService = $profileDataService;
        $this->transferService = $transferService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->user()->id;

        $cards = $this->profileDataService->getAllCreditCards($userId);
        $favourites = $this->profileDataService->getAllFavouriteAccounts($userId);

        return Inertia::render('TransferForm', [
            'cards' => CreditCardResource::collection($cards),
            'favourites' => FavouritesResource::collection($favourites),
        ]);
    }

    public function makeTransfer(TransferRequest $request)
    {
        return $this->transferService->sendTransfer($request);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transaction)
    {
        //
    }
}
