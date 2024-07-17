<?php

namespace App\Console\Commands;

use App\Models\Transfer;
use App\Repositories\TransferRepository;
use Illuminate\Console\Command;

class MakeTodayTransfers extends Command
{
    protected TransferRepository $transferRepository;

    public function __construct(TransferRepository $transferRepository)
    {
        parent::__construct();
        $this->transferRepository = $transferRepository;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-today-transfers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make transfers scheduled for today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transfers = Transfer::where('dispatch_date', today())->get();

        foreach ($transfers as $transfer) {
            $this->transferRepository->addToBalance($transfer->receiver_id, $transfer->amount);
        }
    }
}
