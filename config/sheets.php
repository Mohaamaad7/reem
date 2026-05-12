<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Sheets Configuration
    |--------------------------------------------------------------------------
    */

    'spreadsheet_id'   => env('GOOGLE_SHEETS_SPREADSHEET_ID', ''),
    'credentials_path' => env('GOOGLE_SHEETS_CREDENTIALS_PATH', storage_path('app/google-credentials.json')),
];
