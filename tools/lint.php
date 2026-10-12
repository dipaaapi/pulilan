<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit;
$root = dirname(__DIR__);
$failed = false;
$count = 0;
foreach (['app','views','public','database','tools','tests'] as $folder) {
    if (!is_dir($root . '/' . $folder)) continue;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/' . $folder)) as $file) {
        if ($file->getExtension() !== 'php') continue;
        exec(PHP_BINARY . ' -l ' . escapeshellarg($file->getPathname()) . ' 2>&1',$output,$status);
        if ($status) { echo implode("\n",$output),"\n"; $failed = true; }
        $output = [];
        $count++;
    }
}
echo "$count PHP files checked.\n";
exit($failed ? 1 : 0);
