<?php
$dir = 'c:\\laragon\\www\\reem1\\public\\images\\technique';
$files = scandir($dir);
foreach($files as $file) {
    if(in_array($file, ['.','..'])) continue;
    echo $file . "\n";
}
