<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit;
require dirname(__DIR__) . '/app/database.php';
$root = dirname(__DIR__);
$types = ['application/pdf'=>'pdf','image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
$folders = ['legacy/achievment/temp','legacy/achievement/temp','legacy/admin/temp','legacy/img','legacy/assets/img','legacy/build'];
foreach (['memos'=>['memo','memo_id'],'achievements'=>['achievement_tbl','achievement_id']] as $resource=>[$table,$key]) {
    foreach (query("SELECT `$key`,picture FROM `$table` WHERE picture IS NOT NULL AND picture <> ''")->fetchAll() as $row) {
        if (query('SELECT 1 FROM app_files WHERE resource = ? AND record_id = ?',[$resource,(string)$row[$key]])->fetchColumn()) continue;
        $filename = basename(str_replace('\\','/',$row['picture']));
        foreach ($folders as $folder) {
            $path = $root . '/' . $folder . '/' . $filename;
            if (!is_file($path) || filesize($path)>5*1024*1024) continue;
            $mime = (new finfo(FILEINFO_MIME_TYPE))->file($path);
            if (!isset($types[$mime])) continue;
            $stored = bin2hex(random_bytes(24)) . '.' . $types[$mime];
            copy($path,$root . '/storage/uploads/' . $stored);
            query('INSERT INTO app_files (resource,record_id,stored_name,original_name,mime) VALUES (?, ?, ?, ?, ?)',[$resource,(string)$row[$key],$stored,$filename,$mime]);
            echo 'Imported attachment for ' . $resource . ' ' . $row[$key] . "\n";
            break;
        }
    }
}
