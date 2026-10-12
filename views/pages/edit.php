<?php
$defaults = ['brgy_location'=>$user['brgy_location'],'gender'=>'Not Specified','name'=>$user['name'],'position'=>$user['position'],'type'=>'resident','app_enabled'=>'1','province'=>'Bulacan','city_municipality'=>'Pulilan','memo_date'=>date('Y-m-d'),'latest_vote'=>'','receiver'=>'All Barangays'];
$values += $defaults;
?>
<div class="page-heading"><div><span class="eyebrow"><?= e($config['title']) ?></span><h1><?= $row ? 'Edit record' : 'Add a record' ?></h1><p class="muted">Fields marked * are required. Changes are recorded in activity history.</p></div><?= button('Back to records',['href'=>url('records',['resource'=>$resourceName]),'variant'=>'secondary']) ?></div>
<?php if ($resourceName==='resident-records' || $resourceName==='official-records'): ?><div class="alert">This maintains a community profile. Sign-in accounts are managed separately under Accounts.</div><?php endif; ?>
<form method="post" action="<?= e(url('action')) ?>" enctype="multipart/form-data" class="card record-form" data-submit>
    <?= csrf() ?><input type="hidden" name="action" value="save"><input type="hidden" name="resource" value="<?= e($resourceName) ?>"><input type="hidden" name="id" value="<?= e($id) ?>">
    <?php if ($resourceName==='resident-surveys' && $user['type']!=='resident' && !$row):
        $subjectParams = []; $subjectWhere = '';
        if ($user['type']==='official') { $subjectWhere = ' AND brgy_location = ?'; $subjectParams[] = $user['brgy_location']; }
        $subjects = query("SELECT user_id,name,brgy_location FROM mainuser_acc WHERE type = 'resident'$subjectWhere ORDER BY name",$subjectParams)->fetchAll();
        $subjectOptions = [''=>'Choose the resident account']; foreach ($subjects as $subject) $subjectOptions[$subject['user_id']] = $subject['name'] . ' · ' . $subject['brgy_location'];
        echo field('subject_user_id','Resident account',$values['subject_user_id'] ?? '',['type'=>'select','options'=>$subjectOptions,'required'=>true,'hint'=>'The survey will be linked to this resident; their name and barangay are saved automatically.']);
    endif; ?>
    <div class="form-grid">
    <?php foreach ($fields as $name):
        $options = field_config($resourceName,$name);
        $value = $values[$name] ?? ($options['type']==='number' ? '0' : '');
        if ($options['type']==='select' && !array_key_exists((string)$value,$options['options'])) $value = array_key_first($options['options']);
        $required = in_array($name,['name','fullname','username','email','project_name','project_description','message','brgy_name','psgc','receiver','memo_date'],true) || ($options['type']==='number') || ($options['type']==='date' && $name!=='latest_vote') || ($name==='password' && !$row);
        $options['required'] = $required;
        if ($name==='password') { $options['autocomplete']='new-password'; $options['hint']=$row ? 'Leave blank to keep the current password.' : 'Use 12–72 bytes.'; }
        if ($name==='psgc' && $row) $options['readonly']=true;
        echo field($name,label($name),$value,$options);
    endforeach; ?>
    <?php if (!empty($config['attachment'])): ?><?= field('attachment','Add an attachment','',['type'=>'file','accept'=>'.pdf,.jpg,.jpeg,.png,.webp','hint'=>'PDF, JPEG, PNG, or WebP; up to 5 MB. Existing attachments are preserved.']) ?><?php endif; ?>
    </div>
    <div class="form-actions"><?= button('Save record') ?><?= button('Cancel',['href'=>url('records',['resource'=>$resourceName]),'variant'=>'secondary']) ?></div>
</form>
