<?php
namespace App\Repositories;

use App\Enums\TransferCategories;
use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;

class TransferRepository
{
    private function getLatestSpends($accountId, $isSender)
    {
        return DB::table('transfers')
            ->select(
                'transfers.message',
                'transfers.input_amount as amount',
                'sender_accounts.currency',
                'transfers.dispatch_date as transaction_date',
                'transfers.category',
                'receiver_accounts.account_number',
                'receiver_users.name',
                'receiver_users.surname',
                'receiver_users.avatar_path',
                DB::raw("$isSender as is_sender")
            )
            ->join('accounts as sender_accounts', 'transfers.sender_id', '=', 'sender_accounts.id')
            ->join('accounts as receiver_accounts', 'transfers.receiver_id', '=', 'receiver_accounts.id')
            ->join('users as receiver_users', 'receiver_accounts.user_id', '=', 'receiver_users.id')
            ->where('transfers.sender_id', '=', $accountId);
    }
    

    private function getLatestIncomes($accountId, $isSender)
    {
        return DB::table('transfers')
            ->select(
                'transfers.message',
                'transfers.amount',
                'transfers.currency',
                'transfers.dispatch_date as transaction_date',
                'transfers.category',
                'accounts.account_number',
                'users.name',
                'users.surname',
                'users.avatar_path',
                DB::raw("$isSender as is_sender")
            )
            ->join('accounts', "transfers.sender_id", '=', 'accounts.id')
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->where("transfers.receiver_id", '=', $accountId);
    }

    public function getLastTransfers($accountId, $limit = 4)
    {
        $sentTransfers = $this->getLatestSpends($accountId, 1);
        $receivedTransfers = $this->getLatestIncomes($accountId, 0);

        return $sentTransfers
            ->union($receivedTransfers)
            ->orderBy('transaction_date', 'desc')
            ->limit($limit)
            ->get();
    }


    public function getIncome($accountId)
    {
        return DB::table('transfers')
            ->selectRaw("SUM(CASE WHEN receiver_id = ? AND DATE(dispatch_date) = CURDATE() THEN amount ELSE 0 END) as todayIncome,
            SUM(CASE WHEN receiver_id = ? AND dispatch_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) THEN amount ELSE 0 END) as monthIncome,
            SUM(CASE WHEN sender_id = ? AND dispatch_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) THEN input_amount ELSE 0 END) as monthSpend
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
            $selectRaw .= "SUM(CASE WHEN sender_id = ? AND dispatch_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND category = ? THEN input_amount ELSE 0 END) as $alias,";
            array_push($bindings, $accountId, $category);
        }

        $selectRaw = rtrim($selectRaw, ',');

        return DB::table('transfers')
            ->selectRaw($selectRaw, $bindings)
            ->first();
    }

    public function getTransfersHistory($accountId)
    {
        $sentTransfers = $this->getLatestSpends($accountId, 1);
        $receivedTransfers = $this->getLatestIncomes($accountId, 0);

        return $sentTransfers
            ->union($receivedTransfers)
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);
    }

    public function getTransferAccounts($userId, $senderCard, $receiverAccount)
    {
        $sender = DB::table('accounts')->select('id', 'balance', 'currency')->where('user_id', $userId)->where('card_last_digits', $senderCard)->first();
        $receiver = DB::table('accounts')->select('id', 'balance', 'currency')->where('account_number', $receiverAccount)->first();

        return collect([
            'sender' => $sender,
            'receiver' => $receiver,
        ]);
    }

    public function addToBalance($accountId, $amount)
    {
        $account = Account::findOrFail($accountId);

        $newBalance = $account->balance + $amount;

        $account->update(['balance' => $newBalance]);
    }

    public function removeFromBalance($accountId, $amount)
    {
        $this->addToBalance($accountId, -$amount);
    }

    public function getExchangeRates($sender, $receiver)
    {
        return DB::table('exchange_rates')
            ->select('code', 'rate')
            ->whereIn('code', [$receiver->currency, $sender->currency])
            ->pluck('rate', 'code');
    }

    public function makeTransfer($sender, $receiver, $message, $category, $baseAmount, $amount, $date)
    {
        Transfer::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => $message,
            'input_amount' => $baseAmount,
            'amount' => $amount,
            'currency' => $receiver->currency,
            'category' => $category,
            'dispatch_date' => $date
        ]);
    }
}