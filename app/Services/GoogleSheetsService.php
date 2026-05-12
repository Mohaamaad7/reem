<?php

namespace App\Services;

use App\Models\SurveyResponse;

class GoogleSheetsService
{
    private string $spreadsheetId;
    private string $credentialsPath;

    public function __construct()
    {
        $this->spreadsheetId   = config('sheets.spreadsheet_id', '');
        $this->credentialsPath = config('sheets.credentials_path');
    }

    public function appendResponse(SurveyResponse $response): void
    {
        if (empty($this->spreadsheetId)) {
            \Log::info('Google Sheets not configured — skipping sync');
            return;
        }

        if (!class_exists(\Google\Client::class)) {
            throw new \RuntimeException('google/apiclient is not installed. Run: composer require google/apiclient:^2.0');
        }

        $client = new \Google\Client();
        $client->setAuthConfig($this->credentialsPath);
        $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

        $service = new \Google\Service\Sheets($client);

        $values = [[
            $response->id,
            $response->created_at->format('Y-m-d H:i'),
            $response->participant_code,
            $response->participant_name,
            $response->fabric_chosen,
            $response->pattern_chosen,
            $response->tool_ease_rating,
            $response->tool_visual_rating,
            $response->morris_knowledge_before,
            $response->morris_knowledge_after,
            $response->technique_clarity,
            $response->eco_fabric_awareness,
            $response->app_overall_rating,
            $response->app_usefulness,
            $response->would_recommend,
            $response->most_liked,
            $response->improvement_suggestions,
            $response->design_ideas,
            $response->language_used,
            $response->time_spent_seconds,
            $response->device_type,
        ]];

        $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
        $service->spreadsheets_values->append(
            $this->spreadsheetId,
            'Sheet1!A:U',
            $body,
            ['valueInputOption' => 'RAW']
        );

        $response->update(['synced_to_sheets' => true]);
    }
}
