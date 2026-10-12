<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit;
require dirname(__DIR__) . '/app/bootstrap.php';
require ROOT . '/app/routes.php';
$count = 0;
function check(bool $condition, string $message): void {
    global $count;
    if (!$condition) throw new RuntimeException($message);
    $count++;
}
check(e('<script>" &') === '&lt;script&gt;&quot; &amp;', 'Escape dynamic content');
check(!valid_date('2026-02-30') && valid_date('2024-02-29'), 'Reject impossible dates');
check(!valid_date('0000-00-00'), 'Reject zero dates');
check(!password_valid('short') && password_valid('A long password with spaces'), 'Password validation');
foreach (['=1+1','+SUM(1,2)','@SUM(1,2)','-1+1','  =cmd'] as $value) check(str_starts_with(csv_value($value),"'"),'CSV formula injection protection');
check(csv_value('Tibag')==='Tibag','Preserve regular CSV content');
$select = field('test','Choose','b',['type'=>'select','options'=>['a'=>'First','b'=>'Second'],'error'=>'Choose carefully']);
check(str_contains($select,'value="b" selected'),'Selected option state');
check(str_contains($select,'aria-invalid="true"') && str_contains($select,'aria-describedby="field-test-error"'),'Accessible validation');
check(str_contains(button('Save',['disabled'=>true]),'disabled'),'Disabled button state');
check(str_contains(field('secret','Password','must-not-render',['type'=>'password']),'aria-pressed="false"'),'Password toggle state');
check(!str_contains(field('secret','Password','must-not-render',['type'=>'password']),'must-not-render'),'Never repopulate passwords');
check(str_contains(checkbox('agree','Agree',true),'checked'),'Checkbox selected state');
check(legacy_route('admin/admin_memo.php')===['page'=>'records','resource'=>'memos'],'Consolidate old memo route');
check(legacy_route('delete_acc.php')===null,'Retire old destructive route');
check(resource('accounts')['write']===['admin'],'Privileged account writes');
echo "PASS: $count domain and component assertions.\n";
