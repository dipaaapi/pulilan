<?php
$viewer = current_user();
$isPortal = $viewer && !in_array($page,['home','citizen-charter','login','register','error'],true);
$pageStyles = match ($page) { 'home'=>'landing', 'login','register'=>'auth', default=>'portal' };
$notice = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pulilan's Community-Based Monitoring System — community profiles, surveys, and municipal services.">
    <title><?= e($title) ?></title>
    <link rel="icon" href="<?= e(asset('images/official/pulilan-icon.png')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/global.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/components.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/pages/' . $pageStyles . '.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/accessibility.css')) ?>">
    <script src="<?= e(asset('js/app.js')) ?>" defer></script>
    <script src="<?= e(asset('js/accessibility.js')) ?>" defer></script>
    <?php if ($page === 'home'): ?><script src="<?= e(asset('js/carousel.js')) ?>" defer></script><?php endif; ?>
    <?php if ($page === 'home'): ?><script src="<?= e(asset('js/documents.js')) ?>" defer></script><?php endif; ?>
</head>
<body class="page-<?= e($page) ?><?= $isPortal ? ' portal' : '' ?>">
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header" id="page-top" tabindex="-1" aria-label="Page top">
    <a class="brand" href="<?= e(url()) ?>"><img src="<?= e(asset('images/official/pulilan-logo.png')) ?>" alt="Pulilan municipal seal" width="44" height="44"><span>PULILAN <small>Community-Based Monitoring System</small></span></a>
    <nav class="header-nav" aria-label="Main navigation">
        <?php if ($viewer): ?>
            <?= button('Dashboard',['href'=>url('dashboard'),'variant'=>'quiet']) ?>
            <details class="dropdown"><summary><?= e($viewer['name'] ?: $viewer['username']) ?></summary><div class="dropdown-panel"><a href="<?= e(url('profile')) ?>">My profile</a><form method="post" action="<?= e(url('action')) ?>"><?= csrf() ?><input type="hidden" name="action" value="logout"><?= button('Sign out',['variant'=>'quiet']) ?></form></div></details>
        <?php else: ?>
            <?= button('Sign in',['href'=>url('login'),'variant'=>'quiet']) ?>
            <?= button('Register',['href'=>url('register')]) ?>
        <?php endif; ?>
    </nav>
</header>
<?php if ($isPortal): ?>
<div class="portal-shell">
<aside class="sidebar" id="sidebar">
    <details class="portal-menu" open><summary>Workspace navigation</summary>
    <div class="sidebar-intro"><span class="eyebrow">Your workspace</span><strong><?= e(choices('type')[$viewer['type']] ?? $viewer['type']) ?></strong><small><?= e($viewer['brgy_location']) ?></small></div>
    <nav aria-label="Workspace">
        <a href="<?= e(url('dashboard')) ?>"<?= $page==='dashboard' ? ' aria-current="page"' : '' ?>>Overview</a>
        <?php foreach (resources() as $key=>$item): if (!in_array($viewer['type'],$item['read'],true)) continue; ?>
            <a href="<?= e(url('records',['resource'=>$key])) ?>"<?= in_array($page,['records','edit','detail'],true) && $resourceName===$key ? ' aria-current="page"' : '' ?>><?= e($item['title']) ?><?php if (in_array($key,['messages','memos'],true) && ($unread=unread_count($key))>0): ?><span class="unread-count" aria-label="<?= $unread ?> unread"><?= $unread ?></span><?php endif; ?></a>
        <?php endforeach; ?>
        <a href="<?= e(url('reports')) ?>"<?= $page==='reports' ? ' aria-current="page"' : '' ?>>Reports</a>
        <?php if ($viewer['type']==='admin'): ?><a href="<?= e(url('history')) ?>"<?= $page==='history' ? ' aria-current="page"' : '' ?>>Activity history</a><?php endif; ?>
        <a href="<?= e(url('profile')) ?>"<?= $page==='profile' ? ' aria-current="page"' : '' ?>>My profile</a>
    </nav></details>
    <div class="sidebar-note">Community data.<br>Better local decisions.</div>
</aside>
<?php endif; ?>
<main id="main" class="<?= $isPortal ? 'workspace' : 'site-main' ?>" tabindex="-1">
<?php if ($notice): ?><div class="alert alert--success" role="status"><?= e($notice) ?></div><?php endif; ?>
<?php if (!empty($error)): ?><div class="alert alert--error" role="alert"><?= e($error) ?></div><?php endif; ?>
