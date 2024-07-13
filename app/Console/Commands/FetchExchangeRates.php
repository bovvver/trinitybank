<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch exchange rates from currencyAPI and store in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = env('CURRENCY_API_KEY');

        $response = Http::get("https://api.currencyapi.com/v3/latest?apikey={$apiKey}");

        if ($response->ok()) {
            $rates = $response->json()['data'];

            foreach ($rates as $currency => $rate) {
                ExchangeRate::updateOrCreate(['code' => $currency], ['rate' => $rate['value']]);
            }
        }
    }
}
