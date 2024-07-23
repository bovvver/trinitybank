<?php
namespace App\Repositories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AccountRepository
{
    public function getUserAccounts($userId)
    {
        return Account::where('user_id', $userId)->get();
    }

    public function getAllFavouriteAccounts($userId, $limit = 4)
    {
        $accountIds = Account::select('id')
            ->from('accounts')
            ->where('user_id', $userId);

        return DB::table('transfers')
            ->select(
                DB::raw('COUNT(transfers.receiver_id) as receiver_count'),
                'users.name',
                'users.surname',
                'users.avatar_path',
                'accounts.account_number'
            )
            ->join('accounts', 'transfers.receiver_id', '=', 'accounts.id')
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->whereIn('transfers.sender_id', $accountIds)
            ->whereDate('transfers.dispatch_date', '>=', Carbon::now()->subMonth())
            ->groupBy('users.name', 'users.surname', 'accounts.account_number', 'users.avatar_path')
            ->orderBy('receiver_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getFavouriteAccounts($accountId, $limit = 4)
    {
        return DB::table('transfers')
            ->select(
                DB::raw('COUNT(transfers.receiver_id) as receiver_count'),
                'users.name',
                'users.surname',
                'users.avatar_path',
                'accounts.account_number',
            )
            ->join('accounts', 'transfers.receiver_id', '=', 'accounts.id')
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->groupBy('users.name', 'users.surname', 'accounts.account_number', 'users.avatar_path')
            ->where('transfers.sender_id', $accountId)
            ->whereDate('transfers.dispatch_date', '>=', Carbon::now()->subMonth())
            ->orderBy('receiver_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStatistics($accountId)
    {
        $months = [];
        for ($i = 0; $i < 6; $i++)
            $months[] = now()->subMonths($i)->format('F');

        $months = array_reverse($months);

        $results = DB::table('Transfers')
            ->selectRaw(
                "MONTHNAME(dispatch_date) as month,
                SUM(CASE WHEN sender_id = ? THEN amount ELSE 0 END) as spends,
                SUM(CASE WHEN receiver_id = ? THEN amount ELSE 0 END) as incomes",
                [$accountId, $accountId]
            )
            ->where('dispatch_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('dispatch_date', 'desc')
            ->get()
            ->keyBy('month');

        $statistics = [];
        foreach ($months as $month) {
            $statistics[] = [
                'month' => $month,
                'spends' => isset($results[$month]) ? $results[$month]->spends : 0,
                'incomes' => isset($results[$month]) ? $results[$month]->incomes : 0,
            ];
        }
        return $statistics;
    }

    public function getAllCreditCards($userId)
    {
        return DB::table('Accounts')
            ->select('account_number', 'card_last_digits', 'balance', 'currency', 'card_color', 'active')
            ->where('user_id', $userId)
            ->get();
    }

    public function getActiveCreditCards($userId)
    {
        return DB::table('Accounts')
            ->select('account_number', 'card_last_digits', 'balance', 'currency', 'card_color')
            ->where('user_id', $userId)->where('active', true)
            ->get();
    }

    public function updateCard($userId, $cardDigits, $newColor, $newStatus)
    {
        Account::where('user_id', $userId)
            ->where('card_last_digits', $cardDigits)
            ->update(['card_color' => $newColor, 'active' => $newStatus]);
    }

    public function getPersonalData($userId)
    {
        return User::select('name', 'surname', 'email', 'ssn_number', 'phone_number', 'city', 'street', 'zip_code', 'house_number', 'created_at')->where('id', $userId)->first();
    }

    public function getCardsCount($userId)
    {
        return Account::where('user_id', $userId)->count();
    }

    public function updateContact($userId, $phoneNumber, $email)
    {
        User::findOrFail($userId)->update(['phone_number' => $phoneNumber, 'email' => $email]);
    }

    public function uploadAvatar($userId, $avatarPath)
    {
        User::findOrFail($userId)->update(['avatar_path' => $avatarPath]);
    }

    public function getAvatar($userId)
    {
        return User::where('id', $userId)->value('avatar_path');
    }
}