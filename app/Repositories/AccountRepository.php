<?php
namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountRepository
{
    public function getUserAccounts($userId)
    {
        return Account::where('user_id', $userId)->get();
    }

    public function getFavouriteAccounts($accountId, $limit = 4)
    {
        return DB::table('transfers')
            ->select(
                DB::raw('COUNT(transfers.receiver_id) as receiver_count'),
                'users.name',
                'users.surname',
                'accounts.account_number',
            )
            ->join('accounts', 'transfers.receiver_id', '=', 'accounts.id')
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->groupBy('users.name', 'users.surname', 'accounts.account_number')
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

    public function getCreditCards($userId)
    {
        return DB::table('Accounts')
            ->select('account_number', 'card_last_digits', 'balance', 'currency')
            ->where('user_id', $userId)
            ->get();
    }
}