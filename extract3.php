<?php
$lines = file('C:\\Users\\mohaa\\.gemini\\antigravity-ide\\brain\\6fa1a340-4888-4a2d-bff8-8a97756fb1a8\\.system_generated\\logs\\transcript_full.jsonl');
foreach ($lines as $line) {
    if (strpos($line, 'technique.blade.php') !== false && strpos($line, 'File Path: ') !== false) {
        $data = json_decode($line, true);
        if ($data['type'] === 'TOOL_RESPONSE') {
            file_put_contents('recovered_old_technique.txt', $data['content'], FILE_APPEND);
        }
    }
}
echo "Done";
