<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Http\Resources\CreditCardResource;
use App\Http\Resources\FavouritesResource;
use App\Services\ProfileDataService;
use App\Services\TransferService;
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

        $cards = $this->profileDataService->getActiveCreditCards($userId);
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
}
