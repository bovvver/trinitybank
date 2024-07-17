<?php
namespace App\Services;

use App\Http\Requests\SetAccountIdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Account;

class SessionService extends Service
{
    public function setSelectedAccount(SetAccountIdRequest $request)
    {
        $account = Account::findOrFail($request->accountId);
        Gate::authorize('access', $account);

        $request->session()->put('selectedAccount', $request->accountId);
        return response()->json(['status' => 'success']);
    }

    public static function setDefaultAccount(Request $request)
    {
        $account = auth()->user()->accounts()->first();

        if ($account)
            $request->session()->put('selectedAccount', $account->id);
    }
}