<?php
declare(strict_types=1);

/** Legacy read-only bookmarks resolve to consolidated screens; old mutations are retired. */
function legacy_route(string $path): ?array {
    $path = ltrim($path,'/');
    $file = basename($path);
    if (in_array($file,['login.php','registration.php','change_password.php'],true)) return ['page'=>['login.php'=>'login','registration.php'=>'register','change_password.php'=>'profile'][$file]];
    if ($file === 'logout.php') return ['page'=>'profile'];
    if (in_array($path,['admin/index.php','dilg/index.php','adminindex.php','residentindex.php','brgyindex.php','executiveindex.php','dilgindex.php'],true)) return ['page'=>'dashboard'];
    $groups = [
        'accounts'=>['general_account_table.php','resident_account_table.php','brgylist_table.php','executive_list.php','executive_account_table_accounttype.php','resident_account_table_accounttype.php','deleted_history_brgy.php','deleted_history_resident.php','deactivatedresidenthistory.php'],
        'resident-records'=>['brgy_resident_account_table.php'],
        'official-records'=>['brgygrid.php','grid.php'],
        'memos'=>['memo.php','admin_memo.php','adminmemo.php','dilg_memo.php','executiveviewmemo.php','brgyviewmemo.php','dilgviewmemo.php'],
        'achievements'=>['dilg_achievement.php','dilg_achivement.php'],
        'messages'=>['admin_messages.php','messagehistory.php','see_request.php'],
        'resident-surveys'=>['residentquestion.php','residentanswer.php','resident_q.php','brgyresidentanswer.php','cutcotresidentanswer.php','balatongaresidentanswer.php','balatongbresidentanswer.php','dampol1stresidentanswer.php','updateresidentregistration.php'],
        'barangay-surveys'=>['brgyquestion.php','brgyanswer.php','viewbrgyanswer.php','brgy_q.php','brgy_q2.php','brgymonitoring.php'],
    ];
    foreach ($groups as $resource=>$files) if (in_array($file,$files,true)) return ['page'=>'records','resource'=>$resource];
    if (str_contains($file,'final_report') || $file === 'history_final_report.php' || $file === 'brgy_chart_population.php') return ['page'=>'reports'];
    if ($file === 'loghistory.php') return ['page'=>'history'];
    return null;
}
