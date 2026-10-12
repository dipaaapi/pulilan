<div class="page-heading"><div><span class="eyebrow">Your community workspace</span><h1>Welcome, <?= e($user['name'] ?: $user['username']) ?>.</h1><p class="muted">A clear view of your community information and municipal work.</p></div><?= badge(choices('type')[$user['type']]) ?></div>
<div class="grid grid--3 metric-grid">
<?php foreach (resources() as $key=>$item): if (!in_array($user['type'],$item['read'],true)) continue; [, $total] = resource_rows($key); ?>
    <a class="card metric-card" href="<?= e(url('records',['resource'=>$key])) ?>"><span><?= e($item['title']) ?></span><strong><?= number_format($total) ?></strong><small>View records →</small></a>
<?php endforeach; ?>
</div>
<section class="card workspace-welcome"><span class="eyebrow">Start here</span><h2>Keep your community up to date.</h2><p>Use the navigation to maintain records, complete surveys, read approved memos, and explore reports. Your account only shows the information your role can access.</p><div class="actions"><?= button('View reports',['href'=>url('reports'),'variant'=>'secondary']) ?><?= button('Update my profile',['href'=>url('profile'),'variant'=>'quiet']) ?></div></section>
