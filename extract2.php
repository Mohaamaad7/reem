<?php
$logPath = 'C:\\Users\\mohaa\\.gemini\\antigravity-ide\\brain\\6fa1a340-4888-4a2d-bff8-8a97756fb1a8\\.system_generated\\logs\\transcript_full.jsonl';
$lines = file($logPath);
$count = 0;
foreach ($lines as $line) {
    if (strpos($line, 'technique.blade.php') !== false) {
        $data = json_decode($line, true);
        if ($data['type'] === 'PLANNER_RESPONSE' && isset($data['tool_calls'])) {
            foreach ($data['tool_calls'] as $call) {
                if (isset($call['args']['TargetFile']) && strpos($call['args']['TargetFile'], 'technique.blade.php') !== false) {
                    file_put_contents("recovered_tool_call_{$count}.json", json_encode($call, JSON_PRETTY_PRINT));
                    $count++;
                }
            }
        }
    }
}
echo "Found $count tool calls.";
