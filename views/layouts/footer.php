</main>
<?php if ($isPortal ?? false): ?></div><?php endif; ?>
<footer class="site-footer" id="page-footer" tabindex="-1"><span>Pulilan, Bulacan · Community-Based Monitoring System</span><span>© <?= date('Y') ?> · Municipal community portal</span></footer>
<aside class="page-tools" aria-label="Page navigation and accessibility">
    <?= button('Back to top',['href'=>'#page-top','variant'=>'secondary','class'=>'back-to-top','data-back-to-top'=>true]) ?>
    <?= button('Accessibility & Help',['href'=>url('citizen-charter'),'variant'=>'secondary','data-help-open'=>true,'aria-haspopup'=>'dialog','aria-controls'=>'accessibility-options']) ?>
</aside>
<?php require ROOT . '/views/components/accessibility.php'; ?>
<dialog id="confirmation" aria-labelledby="confirmation-title" aria-describedby="confirmation-description">
    <h2 id="confirmation-title">Confirm action</h2>
    <p id="confirmation-description">Continue with this action?</p>
    <div class="actions"><?= button('Cancel',['type'=>'button','variant'=>'secondary','data-dialog-cancel'=>true]) ?><?= button('Confirm',['type'=>'button','variant'=>'danger','data-dialog-confirm'=>true]) ?></div>
</dialog>
</body>
</html>
