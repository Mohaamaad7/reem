<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$page = App\Models\EducationalPage::where('slug', 'extra-weft')->first();
file_put_contents('extra_weft_db.json', json_encode($page->sections, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Done";
