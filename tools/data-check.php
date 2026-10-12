<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit;
require dirname(__DIR__) . '/app/database.php';
if ((getenv('DB_NAME') ?: 'pulilan') !== 'pulilan') throw new RuntimeException('Data preservation checks require the live database.');
$path = dirname(__DIR__) . '/storage/backups/data-preservation.json';
$tables = ['mainuser_acc'=>'user_id','brgydetails_tbl'=>'brgydetails_id','residentdetails_tbl'=>'user_id','brgy_tbl'=>'psgc','brgy_q'=>'question_id','resident_q'=>'question_id','memo'=>'memo_id','achievement_tbl'=>'achievement_id','message_tbl'=>'message_id','contact'=>'contact_id','check_tbl'=>'check_id','loghistory'=>'log_id'];
$mode = $argv[1] ?? 'verify';
$before = $mode==='snapshot' ? [] : json_decode(file_get_contents($path),true,512,JSON_THROW_ON_ERROR);
$result = [];
foreach ($tables as $table=>$key) {
    $fields = $before[$table]['fields'] ?? array_values(array_diff(array_column(columns($table),'Field'),['password','app_enabled','session_version','remarks','created_by']));
    // Some historical tables have different primary-key names.
    $primary = array_values(array_filter(columns($table),fn($column)=>$column['Key']==='PRI'))[0]['Field'];
    $select = implode(',',array_map(fn($name)=>"`$name`",$fields));
    $rows = query("SELECT $select FROM `$table` ORDER BY `$primary`")->fetchAll();
    foreach ($rows as &$row) if ($table==='resident_q' && empty($row['latest_vote']) || $table==='resident_q' && ($row['latest_vote'] ?? '')==='0000-00-00') $row['latest_vote'] = null;
    unset($row);
    $result[$table] = ['fields'=>$fields,'count'=>count($rows),'hash'=>hash('sha256',json_encode($rows,JSON_THROW_ON_ERROR))];
    if ($mode!=='snapshot' && ($result[$table]['hash']!==$before[$table]['hash'])) throw new RuntimeException("Preservation mismatch: $table");
}
if ($mode==='snapshot') {
    $json = json_encode($result,JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR);
    if (in_array('--stdout', $argv, true)) echo $json;
    else {
        if (file_put_contents($path,$json) === false) throw new RuntimeException('Unable to save fingerprints; use snapshot --stdout with a read-only mount.');
        echo "Recorded fingerprints of 12 original tables.\n";
    }
} else {
    foreach (['mainuser_acc','residentdetails_tbl','brgydetails_tbl'] as $table) foreach (query("SELECT password FROM `$table` WHERE password <> ''")->fetchAll(PDO::FETCH_COLUMN) as $password) if (password_get_info($password)['algo']===null) throw new RuntimeException("Unhashed password remains in $table");
    echo "PASS: All 12 original tables preserved; nonempty passwords are hashed.\n";
}
