<?php
declare(strict_types=1);

function download_file(): never {
    require_user();
    $file = query('SELECT * FROM app_files WHERE id = ?',[(int)($_GET['id'] ?? 0)])->fetch();
    if (!$file) fail(404,'Attachment unavailable.');
    record($file['resource'],$file['record_id']);
    $path = ROOT . '/storage/uploads/' . basename($file['stored_name']);
    if (!is_file($path)) fail(404,'Attachment file unavailable.');
    header('Content-Type: ' . $file['mime']);
    header('Content-Length: ' . filesize($path));
    header('Content-Disposition: attachment; filename="attachment.' . pathinfo($file['stored_name'],PATHINFO_EXTENSION) . '"; filename*=UTF-8\'\'' . rawurlencode($file['original_name']));
    readfile($path);
    exit;
}
function export_records(): never {
    $name = (string)($_GET['resource'] ?? 'resident-surveys');
    $config = resource($name);
    allow_roles($config['read']);
    if (!in_array($name,['resident-surveys','barangay-surveys','barangays','accounts','resident-records','official-records'],true)) fail(400,'This resource cannot be exported.');
    [$rows] = resource_rows($name,trim((string)($_GET['q'] ?? '')),false,1,true);
    $fields = array_values(array_diff(array_column(columns($config['table']),'Field'),['password']));
    audit('export',$name);
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $name . '-' . date('Y-m-d') . '.csv"');
    $stream = fopen('php://output','w');
    fwrite($stream,"\xEF\xBB\xBF");
    fputcsv($stream,array_map('label',$fields),',','"','');
    foreach ($rows as $row) fputcsv($stream,array_map(fn($field)=>csv_value($row[$field] ?? ''),$fields),',','"','');
    fclose($stream); exit;
}
function render_page(string $page): void {
    if ($page === 'download') download_file();
    if ($page === 'export') export_records();
    if (!in_array($page,['home','citizen-charter','dashboard','records','detail','edit','reports','history','profile'],true)) fail(404,'That page could not be found.');
    $user = in_array($page,['home','citizen-charter'],true) ? current_user() : require_user();
    $title = 'Pulilan · Community-Based Monitoring System';
    $error = $_SESSION['form_error'] ?? '';
    unset($_SESSION['form_error']);
    $resourceName = (string)($_GET['resource'] ?? 'barangays');
    $view = $page;
    if (in_array($page,['records','detail','edit'],true)) {
        $config = resource($resourceName);
        allow_roles($config['read']);
        $title = $config['title'] . ' · Pulilan CBMS';
        if ($page === 'records') {
            $search = trim(substr((string)($_GET['q'] ?? ''),0,200));
            $archived = ($_GET['archived'] ?? '') === '1';
            if ($archived && !can_archive($resourceName)) fail(403,'Your account cannot view this archive.');
            $pageNumber = max(1,(int)($_GET['p'] ?? 1));
            [$rows,$count] = resource_rows($resourceName,$search,$archived,$pageNumber);
        } else {
            $id = (string)($_GET['id'] ?? '');
            $row = $id !== '' ? record($resourceName,$id) : [];
            if ($page === 'detail' && !$row) fail(404,'Choose a record to view.');
            if ($page === 'edit') {
                allow_roles($config['write']);
                $values = ($_SESSION['form_values'] ?? []) + $row;
                unset($_SESSION['form_values']);
                $fields = editable_fields($resourceName);
            }
        }
    }
    if ($page === 'history') allow_roles(['admin']);
    if ($page === 'home') $barangays = query("SELECT b.* FROM brgy_tbl b LEFT JOIN app_archives a ON a.resource='barangays' AND a.record_id=b.psgc WHERE a.record_id IS NULL ORDER BY b.brgy_name")->fetchAll();
    require ROOT . '/views/layouts/header.php';
    require ROOT . '/views/pages/' . $view . '.php';
    require ROOT . '/views/layouts/footer.php';
}
