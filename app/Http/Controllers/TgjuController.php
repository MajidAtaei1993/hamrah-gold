<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TgjuController extends Controller
{
    public function price()
    {
        try {
            // Generate random "rev" parameter to avoid cached responses
            $revCode = $this->generateBase62String();
            $url = 'https://call.tgju.org/ajax.json?rev=' . $revCode;

            // Request headers (to look like a normal browser/postman call)
            $headers = [
                'User-Agent' => 'PostmanRuntime/7.44.0',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'Accept' => 'application/json',
            ];

            // Make the request to TGJU
            $response = Http::withoutVerifying()
                ->withHeaders($headers)
                ->timeout(30)
                ->get($url);

            if ($response->successful()) {
                $data = $response->json();
                $gold = $data['current']['geram18'] ?? null;

                // If gold data exists
                if ($gold) {
                    return (object) [
                        'name'         => "gold-18",
                        'buy_price'    => $this->formatWithDots($gold['p']),
                        'sell_price'   => $this->formatWithDots($gold['h']),
                        'low_price'    => $this->formatWithDots($gold['l']),
                        'change'       => floatval($gold['d'] ?? 0),
                        'change_percent' => isset($gold['dp']) ? floatval($gold['dp']) . ' 0%' : null,
                        'date_time'         =>$gold['ts']
                    ];
                }

                // If no gold data found
                return response()->json([
                    'success' => false,
                    'message' => 'Gold price data not found.'
                ], 404);
            }

            // If TGJU request failed
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from TGJU.',
                'status' => $response->status(),
            ], $response->status());

        } catch (\Throwable $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Generate a random Base62 string (used for cache-busting)
    private function generateBase62String($length = 58)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    // Format a number with dots, e.g. 109,227,000 → 109.227.000
    private function formatWithDots($price)
    {
        $number = preg_replace('/[^0-9]/', '', $price);
        if (empty($number)) return '0';
        return str_replace(',', ',', number_format($number, 0, '', ','));
    }
}