<?php

namespace App\Services;

use GuzzleHttp\Client;

class ContentModerator
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function validateReview(string $text): bool
    {
    $response = $this->client->post(
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent",
        [
            'verify' => false, // 👈 ignora SSL (use só em dev!)
            'query' => [
                'key' => $this->apiKey,
            ],
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Analyze this comment and respond only with 'Safe' if appropriate or 'Unsafe' if it is offensive, racist or inappropriate:\n\n{$text}"]
                        ]
                    ]
                ]
            ]
        ]
    );

        $data = json_decode($response->getBody(), true);

        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('API response error.');
        }

        $result = strtolower($data['candidates'][0]['content']['parts'][0]['text'] ?? '');

        return trim($result) === 'safe';
    }
}
