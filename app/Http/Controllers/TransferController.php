<?php

namespace App\Http\Controllers;

use App\Http\Resources\CreditCardResource;
use App\Http\Resources\FavouritesResource;
use App\Models\Transfer;
use App\Services\ProfileDataService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransferController extends Controller
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
        $userId = auth()->user()->id;

        $cards = $this->profileDataService->getCreditCards($userId);
        $favourites = $this->profileDataService->getFavouriteAccounts($userId);

        return Inertia::render('TransferForm', [
            'cards' => CreditCardResource::collection($cards),
            'favourites' => FavouritesResource::collection($favourites),
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
