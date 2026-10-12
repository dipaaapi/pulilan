<?php
declare(strict_types=1);

function resources(): array {
    $managers = ['admin','dilg','executive'];
    $all = [...$managers,'official','resident'];
    return [
        'accounts'=>['title'=>'Accounts','table'=>'mainuser_acc','key'=>'user_id','read'=>['admin'],'write'=>['admin'],'fields'=>['name','username','email','contact','type','brgy_location','position','gender','app_enabled','password'],'list'=>['name','username','type','brgy_location','app_enabled']],
        'resident-records'=>['title'=>'Resident records','table'=>'residentdetails_tbl','key'=>'user_id','read'=>['admin','official'],'write'=>['admin','official'],'fields'=>['name','email','contact','gender','brgy_location','province','address','city_municipality','purok_district','civil_status','position'],'list'=>['name','brgy_location','gender','contact']],
        'official-records'=>['title'=>'Official records','table'=>'brgydetails_tbl','key'=>'brgydetails_id','read'=>['admin'],'write'=>['admin'],'fields'=>['fullname','email','contact','brgy_location','gender','position','no_purok','major_sources','brgy_classification','char_brgy','male_tanod','female_tanod','male_health_worker','female_health_worker','male_nutrition_scholar','female_nutrition_scholar','male_purok_leaders','female_purok_leaders','male_librarian','female_librarian','male_day_care_worker','female_day_care_worker','male_utility_worker','female_utility_worker'],'list'=>['fullname','brgy_location','position','contact']],
        'barangays'=>['title'=>'Barangays','table'=>'brgy_tbl','key'=>'psgc','read'=>$all,'write'=>['admin'],'fields'=>['psgc','brgy_name','classification','brgy_alt_name','density','land_area_per_square_meter','c_pop'],'list'=>['brgy_name','classification','density','c_pop']],
        'memos'=>['title'=>'Memos','table'=>'memo','key'=>'memo_id','read'=>$all,'write'=>['admin','executive'],'fields'=>['project_name','project_description','memo_date','receiver'],'list'=>['project_name','memo_date','receiver','memo_status'],'attachment'=>true],
        'achievements'=>['title'=>'Achievements','table'=>'achievement_tbl','key'=>'achievement_id','read'=>$all,'write'=>['admin','dilg'],'fields'=>['project_name','project_description'],'list'=>['project_name','date_submitted'],'attachment'=>true],
        'messages'=>['title'=>'Messages','table'=>'message_tbl','key'=>'message_id','read'=>['admin','official','resident','executive','dilg'],'write'=>$all,'fields'=>['subject','message'],'list'=>['name','subject','brgy_location','date_created']],
        'resident-surveys'=>['title'=>'Resident surveys','table'=>'resident_q','key'=>'question_id','read'=>$all,'write'=>['admin','official','resident'],'fields'=>null,'list'=>['name','brgy_location','date']],
        'barangay-surveys'=>['title'=>'Barangay surveys','table'=>'brgy_q','key'=>'question_id','read'=>[...$managers,'official'],'write'=>['admin','official'],'fields'=>null,'list'=>['name','brgy_location','no_household','date']],
    ];
}
function resource(string $name): array {
    $config = resources()[$name] ?? null;
    if (!$config) fail(404, 'That page could not be found.');
    return $config;
}
function can_write(string $name): bool { return in_array(current_user()['type'] ?? '',resource($name)['write'],true); }
function unread_count(string $name): int {
    $config = resource($name);
    [$where,$params] = scope($name);
    return (int)query("SELECT COUNT(*) FROM `{$config['table']}` r LEFT JOIN app_notifications n ON n.user_id = ? AND n.resource = ? AND n.record_id = CAST(r.`{$config['key']}` AS CHAR) LEFT JOIN app_archives a ON a.resource = ? AND a.record_id = CAST(r.`{$config['key']}` AS CHAR) WHERE ($where) AND n.record_id IS NULL AND a.record_id IS NULL",[current_user()['user_id'],$name,$name,...$params])->fetchColumn();
}
function can_archive(string $name): bool {
    $role = current_user()['type'] ?? '';
    return $role === 'admin' || ($role === 'official' && in_array($name,['resident-records','resident-surveys','barangay-surveys'],true));
}
function editable_fields(string $name): array {
    $config = resource($name);
    return $config['fields'] ?? array_values(array_diff(array_column(columns($config['table']),'Field'), [$config['key'],'user_id','type','visibility','date']));
}
function scope(string $name, string $alias = 'r'): array {
    $user = require_user();
    $role = $user['type'];
    if ($name === 'messages' && $role !== 'admin') return ["$alias.user_id = ?", [$user['user_id']]];
    if ($name === 'memos' && in_array($role,['official','resident'],true)) {
        return ["$alias.memo_status = 'APPROVED' AND ($alias.receiver IN ('All Barangays','All Residents','All Users', ?) OR $alias.receiver = ?)", [$user['brgy_location'],$role]];
    }
    if (in_array($name,['resident-records','resident-surveys','barangay-surveys'],true)) {
        if ($role === 'resident') return ["$alias.user_id = ?",[$user['user_id']]];
        if ($role === 'official') {
            if ($user['brgy_location'] === '' || $user['brgy_location'] === 'Unassigned') return ['1 = 0',[]];
            return ["$alias.brgy_location = ?",[$user['brgy_location']]];
        }
    }
    return ['1 = 1',[]];
}
function record(string $name, string $id, bool $includeArchived = false): array {
    $config = resource($name);
    allow_roles($config['read']);
    [$where,$params] = scope($name);
    $archiveWhere = $includeArchived ? '' : ' AND a.record_id IS NULL';
    $row = query("SELECT r.* FROM `{$config['table']}` r LEFT JOIN app_archives a ON a.resource = ? AND a.record_id = CAST(r.`{$config['key']}` AS CHAR) WHERE r.`{$config['key']}` = ? AND ($where)$archiveWhere",[$name,$id,...$params])->fetch();
    if (!$row) fail(404,'This record is unavailable.');
    return $row;
}
function resource_rows(string $name, string $search = '', bool $archived = false, int $pageNumber = 1, bool $export = false): array {
    $config = resource($name);
    allow_roles($config['read']);
    [$where,$params] = scope($name);
    $params = [$name,...$params];
    $where .= $archived ? ' AND a.record_id IS NOT NULL' : ' AND a.record_id IS NULL';
    if ($search !== '') {
        $parts = [];
        foreach ($config['list'] as $field) { $parts[] = "CAST(r.`$field` AS CHAR) LIKE ?"; $params[] = '%' . $search . '%'; }
        $where .= ' AND (' . implode(' OR ', $parts) . ')';
    }
    $from = "FROM `{$config['table']}` r LEFT JOIN app_archives a ON a.resource = ? AND a.record_id = CAST(r.`{$config['key']}` AS CHAR) WHERE ($where)";
    $count = (int)query("SELECT COUNT(*) $from",$params)->fetchColumn();
    $limit = $export ? '' : ' LIMIT 25 OFFSET ' . ((max(1,$pageNumber)-1)*25);
    $rows = query("SELECT r.* $from ORDER BY r.`{$config['key']}` DESC$limit",$params)->fetchAll();
    return [$rows,$count];
}
function choices(string $field): ?array {
    return match ($field) {
        'type'=>['admin'=>'Administrator','official'=>'Barangay official','resident'=>'Resident','dilg'=>'DILG','executive'=>'Executive'],
        'gender'=>['Male'=>'Male','Female'=>'Female','Not Specified'=>'Prefer not to say'],
        'civil_status','civil_stat'=>array_combine(['Single','Married','Widowed','Separated'],['Single','Married','Widowed','Separated']),
        'classification','brgy_classification'=>['Urban'=>'Urban','Rural'=>'Rural'],
        'char_brgy'=>array_combine(['Plain','Coastal','Mountainous'],['Plain','Coastal','Mountainous']),
        'app_enabled'=>['1'=>'Enabled','0'=>'Disabled'],
        'brgy_location'=>array_column(query('SELECT brgy_name FROM brgy_tbl ORDER BY brgy_name')->fetchAll(),'brgy_name','brgy_name') + ['Unassigned'=>'Unassigned'],
        'receiver'=>['All Barangays'=>'All Barangays','All Residents'=>'All Residents','All Users'=>'All Users','dilg'=>'DILG','executive'=>'Executive','official'=>'Officials','resident'=>'Residents'] + array_column(query('SELECT brgy_name FROM brgy_tbl ORDER BY brgy_name')->fetchAll(),'brgy_name','brgy_name'),
        'have_electricity','indigenous','registered_civil','registered_voters'=>['Yes'=>'Yes','No'=>'No'],
        default=>null,
    };
}
function field_config(string $resourceName, string $name): array {
    $column = array_values(array_filter(columns(resource($resourceName)['table']),fn($column)=>$column['Field']===$name))[0];
    $options = choices($name);
    $type = $options ? 'select' : (str_contains($column['Type'],'int') || str_starts_with($name,'no_') ? 'number' : 'text');
    if ($name === 'password') $type = 'password';
    elseif ($name === 'email') $type = 'email';
    elseif (str_starts_with($column['Type'],'date')) $type = 'date';
    elseif (in_array($name,['project_description','message','address','boundaries','former_residences','skills','honors'],true)) $type = 'textarea';
    $maxlength = preg_match('/varchar\((\d+)\)/',$column['Type'],$match) ? (int)$match[1] : 10000;
    return ['type'=>$type,'options'=>$options,'maxlength'=>$maxlength,'min'=>0];
}
function validate_fields(string $resourceName, array $input, bool $editing = false): array {
    $values = [];
    foreach (editable_fields($resourceName) as $name) {
        if (!is_scalar($input[$name] ?? '')) throw new InvalidArgumentException(label($name) . ' is invalid.');
        $value = $name === 'password' ? (string)($input[$name] ?? '') : trim((string)($input[$name] ?? ''));
        $config = field_config($resourceName,$name);
        if ($name === 'password') {
            if ($editing && $value === '') continue;
            if (!password_valid($value)) throw new InvalidArgumentException('Use a password of 12–72 bytes.');
            $values[$name] = password_hash($value,PASSWORD_DEFAULT);
            continue;
        }
        if ($name === 'latest_vote' && $value === '') { $values[$name] = null; continue; }
        if (in_array($name,['name','fullname','username','email','project_name','project_description','message','brgy_name','psgc','receiver','memo_date'],true) && $value === '') throw new InvalidArgumentException(label($name) . ' is required.');
        if (strlen($value) > $config['maxlength']) throw new InvalidArgumentException(label($name) . ' is too long.');
        if ($config['options'] && !array_key_exists($value,$config['options'])) throw new InvalidArgumentException('Choose a valid ' . strtolower(label($name)) . '.');
        if ($config['type'] === 'email' && $value !== '' && !filter_var($value,FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('Enter a valid email address.');
        if ($config['type'] === 'number' && (!preg_match('/^\d{1,9}$/',$value))) throw new InvalidArgumentException(label($name) . ' must be a non-negative whole number.');
        if ($config['type'] === 'date' && !valid_date($value)) throw new InvalidArgumentException(label($name) . ' needs a valid date.');
        if ($name === 'psgc' && !preg_match('/^\d{9}$/',$value)) throw new InvalidArgumentException('Use the nine-digit PSGC code.');
        $values[$name] = $value;
    }
    return $values;
}
