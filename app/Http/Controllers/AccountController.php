<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransferResource;
use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use DB;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = auth()->user()->accounts;
        $firstId = $accounts->first()->id;

        $sentTransfers = DB::table('transfers')
            ->select(
                'transfers.message',
                'transfers.amount',
                'transfers.currency',
                'transfers.created_at as transaction_date',
                'users.name',
                'users.surname',
                DB::raw('1 as is_sender')
            )
            ->join('users', 'transfers.receiver_id', '=', 'users.id')
            ->where('transfers.sender_id', '=', $firstId);

        $receivedTransfers = DB::table('transfers')
            ->select(
                'transfers.message',
                'transfers.amount',
                'transfers.currency',
                'transfers.created_at as transaction_date',
                'users.name',
                'users.surname',
                DB::raw('0 as is_sender')
            )
            ->join('users', 'transfers.sender_id', '=', 'users.id')
            ->where('transfers.receiver_id', '=', $firstId);

        $lastTransfers = $sentTransfers
            ->union($receivedTransfers)
            ->orderBy('transaction_date', 'desc')
            ->limit(4)
            ->get();

        return Inertia::render('Dashboard', [
            'transfers' => TransferResource::collection($lastTransfers)
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
