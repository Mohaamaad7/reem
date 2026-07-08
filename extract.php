<?php
$logPath = 'C:\\Users\\mohaa\\.gemini\\antigravity-ide\\brain\\6fa1a340-4888-4a2d-bff8-8a97756fb1a8\\.system_generated\\logs\\transcript_full.jsonl';
$lines = file($logPath);
$found = [];
foreach ($lines as $line) {
    if (strpos($line, 'technique.blade.php') !== false || strpos($line, 'code_artifact') !== false) {
        $data = json_decode($line, true);
        if ($data['type'] === 'PLANNER_RESPONSE' && isset($data['tool_calls'])) {
            foreach ($data['tool_calls'] as $call) {
                if ($call['name'] === 'write_to_file' && strpos($call['args']['TargetFile'], 'technique.blade.php') !== false) {
                    file_put_contents('recovered_technique.html', $call['args']['CodeContent']);
                }
                if ($call['name'] === 'write_to_file' && strpos($call['args']['TargetFile'], 'code_artifact') !== false) {
                    file_put_contents('recovered_code_artifact.html', $call['args']['CodeContent']);
                }
            }
        }
        if ($data['type'] === 'USER_INPUT' && strpos($data['content'], 'code_artifact.html') !== false) {
            file_put_contents('recovered_user_input.txt', $data['content'], FILE_APPEND);
        }
    }
}
echo "Extraction done.";
