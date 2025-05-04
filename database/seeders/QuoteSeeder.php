<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class QuoteSeeder extends Seeder
{
    public function run()
    {
        $apis = [
            'https://api.kanye.rest' => 'processKanyeQuotes',
            'https://api.breakingbadquotes.xyz/v1/quotes' => 'processBreakingBadQuotes',
            'https://zenquotes.io/api/random' => 'processZenQuotes',
            'https://api.animechan.io/v1/quotes/random' => 'processAnimechanQuotes',
            'https://strangerthingsquotes.shadowdev.xyz/api/quotes' => 'processStrangerThingsQuotes',
            'https://ron-swanson-quotes.herokuapp.com/v2/quotes' => 'processRonSwansonQuotes',
            'https://luciferquotes.shadowdev.xyz/api/quotes' => 'processLuciferQuotes',
            'https://api.gameofthronesquotes.xyz/v1/random' => 'processGameOfThronesQuotes',
        ];

        $maxRequests = 10; // Customize per your needs
        $quotes = [];

        foreach ($apis as $apiUrl => $handler) {
            if (!method_exists($this, $handler)) {
                $this->command->error("Handler method {$handler} does not exist for API: {$apiUrl}");
                continue;
            }

            $this->command->info("Processing API: $apiUrl");
            $apiQuotes = $this->fetchMultipleQuotes($apiUrl, $maxRequests, $handler);
            $quotes = array_merge($quotes, $apiQuotes);
        }

        if (count($quotes) > 0) {
            DB::table('quotes')->insertOrIgnore($quotes);
            $this->command->info(count($quotes) . ' quotes inserted successfully.');
        } else {
            $this->command->error('No quotes to insert.');
        }
    }

    private function fetchMultipleQuotes(string $api, int $maxRequests, string $handler): array
    {
        $allQuotes = [];

        for ($i = 0; $i < $maxRequests; $i++) {
            $this->command->info("Fetching from: $api (Request #" . ($i + 1) . ")");
            $response = Http::get($api);

            if ($response->successful()) {
                $processed = $this->{$handler}($response);
                $allQuotes = array_merge($allQuotes, $processed);
            } else {
                $this->command->error("Failed request to $api. Status: " . $response->status());
                break; // Optionally break on failure
            }
        }

        return $allQuotes;
    }

    private function processKanyeQuotes($response): array
    {
        return [[
            'text' => $response->json()['quote'],
            'author' => 'Kanye West',
            'approved' => 1,
        ]];
    }

    private function processBreakingBadQuotes($response): array
    {
        $data = $response->json()[0];

        return [[
            'text' => $data['quote'],
            'author' => $data['author'],
            'approved' => 1,
        ]];
    }

    private function processZenQuotes($response): array
    {
        $data = $response->json()[0];
        return [[
            'text' => $data['q'],
            'author' => $data['a'],
            'approved' => 1,
        ]];
    }

    private function processAnimechanQuotes($response): array
    {
        $data = $response->json()['data'];
        return [[
            'text' => $data['content'],
            'author' => $data['character']['name'] . " - " . $data['anime']['name'],
            'approved' => 1,
        ]];
    }

    private function processStrangerThingsQuotes($response): array
    {
        $quotes = $response->json();
        $result = [];

        foreach ($quotes as $quote) {
            $result[] = [
                'text' => $quote['quote'],
                'author' => $quote['author'],
                'approved' => 1,
            ];
        }

        return $result;
    }

    private function processRonSwansonQuotes($response): array
    {
        return [[
            'text' => $response->json()[0],
            'author' => 'Ron Swanson',
            'approved' => 1,
        ]];
    }

    private function processLuciferQuotes($response): array
    {
        $quotes = $response->json();
        $result = [];

        foreach ($quotes as $quote) {
            $result[] = [
                'text' => $quote['quote'],
                'author' => 'Lucifer',
                'approved' => 1,
            ];
        }

        return $result;
    }

    private function processGameOfThronesQuotes($response): array
    {
        $data = $response->json();
        return [[
            'text' => $data['sentence'],
            'author' => $data['character']['name'] . " - " . $data['character']['house']['name'],
            'approved' => 1,
        ]];
    }
}