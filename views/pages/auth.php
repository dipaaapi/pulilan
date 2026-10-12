<section class="auth-layout">
    <div class="auth-story"><span class="eyebrow">Pulilan · Bulacan</span><h1>A stronger community<br>starts with us.</h1><p>One place for community profiles, local surveys, and the information that helps our barangays move forward.</p><div class="auth-story-note">Community-Based Monitoring System<br><strong>Connected people. Informed decisions.</strong></div></div>
    <div class="auth-card card">
        <span class="eyebrow">Community portal</span><h2><?= $page==='login' ? 'Welcome back' : 'Join your community' ?></h2>
        <p class="muted"><?= $page==='login' ? 'Sign in to your municipal workspace.' : 'Create a resident account. Municipal staff accounts are managed by the administrator.' ?></p>
        <form method="post" action="<?= e(url($page)) ?>" class="stack" data-submit>
            <?= csrf() ?>
            <?php if ($page==='register'): ?>
                <?= field('name','Full name',$_POST['name'] ?? '',['required'=>true,'maxlength'=>80,'autocomplete'=>'name']) ?>
                <?= field('email','Email address',$_POST['email'] ?? '',['type'=>'email','required'=>true,'maxlength'=>100,'autocomplete'=>'email']) ?>
                <?= field('contact','Contact number',$_POST['contact'] ?? '',['type'=>'tel','required'=>true,'maxlength'=>20,'autocomplete'=>'tel']) ?>
                <?= field('brgy_location','Barangay',$_POST['brgy_location'] ?? '',['type'=>'select','options'=>[''=>'Choose your barangay'] + array_diff_key(choices('brgy_location'),['Unassigned'=>true]),'required'=>true]) ?>
            <?php endif; ?>
            <?= field('username','Username',$_POST['username'] ?? '',['required'=>true,'maxlength'=>100,'autocomplete'=>'username','pattern'=>'[A-Za-z0-9_.\-]{3,100}']) ?>
            <?= field('password','Password','',['type'=>'password','required'=>true,'autocomplete'=>$page==='login' ? 'current-password' : 'new-password','maxlength'=>72,'minlength'=>$page==='register' ? 12 : 1,'hint'=>$page==='register' ? 'Use 12–72 bytes. Spaces are allowed.' : '']) ?>
            <?php if ($page==='register'): ?><?= field('cpassword','Confirm password','',['type'=>'password','required'=>true,'autocomplete'=>'new-password','maxlength'=>72,'minlength'=>12]) ?>
            <?php else: ?><?= checkbox('remember_me','Keep me signed in on this device') ?><?php endif; ?>
            <?= button($page==='login' ? 'Sign in' : 'Create resident account',['class'=>'button--full']) ?>
        </form>
        <p class="auth-switch"><?= $page==='login' ? 'New here?' : 'Already registered?' ?> <a href="<?= e(url($page==='login' ? 'register' : 'login')) ?>"><?= $page==='login' ? 'Create an account' : 'Sign in' ?></a></p>
        <a class="muted" href="<?= e(url()) ?>">← Back to Pulilan</a>
    </div>
</section>
