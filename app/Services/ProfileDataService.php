<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Enums\TransferCategories;

class ProfileDataService
{
    private function getTransfersQuery($accountId, $from, $to, $isSender)
    {
        return DB::table('transfers')
            ->select(
                'transfers.message',
                'transfers.amount',
                'transfers.currency',
                'transfers.created_at as transaction_date',
                'users.name',
                'users.surname',
                DB::raw("$isSender as is_sender")
            )
            ->join('accounts', "transfers.$from", '=', 'accounts.id')
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->where("transfers.$to", '=', $accountId);
    }

    public function getLastTransfers($accountId, $limit = 4)
    {
        $receiver = "receiver_id";
        $sender = "sender_id";

        $sentTransfers = $this->getTransfersQuery($accountId, $receiver, $sender, 1);
        $receivedTransfers = $this->getTransfersQuery($accountId, $sender, $receiver, 0);

        return $sentTransfers
            ->union($receivedTransfers)
            ->orderBy('transaction_date', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getFavouriteAccounts($accountId, $limit = 4)
    {
        return DB::table('transfers')
            ->select(
                DB::raw('COUNT(transfers.receiver_id) as receiver_count'),
                'users.name',
                'users.surname'
            )
            ->join('accounts', 'transfers.receiver_id', '=', 'accounts.id')
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->groupBy('users.name', 'users.surname')
            ->where('transfers.sender_id', $accountId)
            ->whereDate('transfers.created_at', '>=', Carbon::now()->subMonth())
            ->orderBy('receiver_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getIncome($accountId)
    {
        return DB::table('transfers')
            ->selectRaw("SUM(CASE WHEN receiver_id = ? AND DATE(created_at) = CURDATE() THEN amount ELSE 0 END) as todayIncome,
            SUM(CASE WHEN receiver_id = ? AND created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) THEN amount ELSE 0 END) as monthIncome,
            SUM(CASE WHEN sender_id = ? AND created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) THEN amount ELSE 0 END) as monthSpend
            ", [$accountId, $accountId, $accountId])->first();
    }

    public function getSpendsPerCategory($accountId)
    {
        $categories = [
            'education' => TransferCategories::EDUCATION,
            'food' => TransferCategories::FOOD,
            'hygiene' => TransferCategories::HYGIENE,
            'transport' => TransferCategories::TRANSPORT,
            'work' => TransferCategories::WORK,
            'investments' => TransferCategories::INVESTMENTS,
            'others' => TransferCategories::OTHERS,
        ];

        $selectRaw = '';
        $bindings = [];

        foreach ($categories as $alias => $category) {
            $selectRaw .= "SUM(CASE WHEN sender_id = ? AND created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND category = ? THEN amount ELSE 0 END) as $alias,";
            array_push($bindings, $accountId, $category);
        }

        $selectRaw = rtrim($selectRaw, ',');

        return DB::table('transfers')
            ->selectRaw($selectRaw, $bindings)
            ->first();
    }

    public function getStatistics($accountId)
    {
        $months = [];
        for ($i = 0; $i < 6; $i++)
            $months[] = now()->subMonths($i)->format('F');

        $months = array_reverse($months);

        $results = DB::table('Transfers')
            ->selectRaw(
                "MONTHNAME(created_at) as month,
                SUM(CASE WHEN sender_id = ? THEN amount ELSE 0 END) as spends,
                SUM(CASE WHEN receiver_id = ? THEN amount ELSE 0 END) as incomes",
                [$accountId, $accountId]
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('created_at', 'desc')
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
            ->select('card_last_digits', 'balance', 'currency')
            ->where('user_id', $userId)
            ->get();
    }

    public function getTransfersHistory($accountId)
    {
        $receiver = "receiver_id";
        $sender = "sender_id";

        $sentTransfers = $this->getTransfersQuery($accountId, $receiver, $sender, 1);
        $receivedTransfers = $this->getTransfersQuery($accountId, $sender, $receiver, 0);

        return $sentTransfers
            ->union($receivedTransfers)
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);
    }
}