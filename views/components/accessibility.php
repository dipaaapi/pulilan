<dialog class="help-modal" id="accessibility-options" aria-labelledby="help-title" aria-describedby="help-description">
    <header class="help-header"><div><h2 id="help-title">Accessibility &amp; Help</h2><p id="help-description">Adjust reading settings, find answers, or send the project a message.</p></div><?= button('Close',['type'=>'button','variant'=>'secondary','data-help-close'=>true,'autofocus'=>true]) ?></header>
    <div class="help-navigation" role="tablist" aria-label="Help sections">
        <button type="button" role="tab" id="tab-settings" aria-controls="help-settings" aria-selected="true" data-help-tab="help-settings">Accessibility Options</button>
        <button type="button" role="tab" id="tab-faq" aria-controls="help-faq" aria-selected="false" tabindex="-1" data-help-tab="help-faq">FAQ</button>
        <button type="button" role="tab" id="tab-message" aria-controls="help-message" aria-selected="false" tabindex="-1" data-help-tab="help-message">Message Us</button>
    </div>
    <div class="stack accessibility-panel">
        <section class="stack" id="help-settings" role="tabpanel" aria-labelledby="tab-settings" tabindex="0"><h3>Accessibility Options</h3>
        <p class="muted">Adjust this website to suit your reading preferences.</p>
        <fieldset class="stack"><legend>Display</legend>
            <?= field('a11y-size','Text size','100',['type'=>'select','data-a11y'=>'size','options'=>['100'=>'Default (100%)','125'=>'Larger (125%)','150'=>'Large (150%)','200'=>'Extra large (200%)']]) ?>
            <?= field('a11y-theme','Color mode','default',['type'=>'select','data-a11y'=>'theme','options'=>['default'=>'Default','dark'=>'Dark mode','contrast'=>'High contrast']]) ?>
            <label class="check"><input type="checkbox" data-a11y="grayscale"> Grayscale content</label>
            <label class="check"><input type="checkbox" data-a11y="hideImages"> Hide decorative images</label>
        </fieldset>
        <fieldset class="stack"><legend>Reading</legend>
            <label class="check"><input type="checkbox" data-a11y="readable"> Plain Arial font</label>
            <label class="check"><input type="checkbox" data-a11y="spacing"> Increase text and line spacing</label>
            <label class="check"><input type="checkbox" data-a11y="links"> Emphasize links</label>
        </fieldset>
        <fieldset class="stack"><legend>Motion</legend>
            <label class="check"><input type="checkbox" data-a11y="reduceMotion"> Reduce motion</label>
            <label class="check"><input type="checkbox" data-a11y="smooth" id="smooth-scroll"> Smooth scrolling</label>
            <small>Your device's reduced-motion preference always takes priority.</small>
        </fieldset>
        <nav class="actions" aria-label="Accessibility navigation"><a href="#main" data-help-jump>Skip to content</a><a href="#page-footer" data-help-jump>Skip to footer</a></nav>
        <?= button('Reset preferences',['type'=>'button','variant'=>'secondary','data-a11y-reset'=>true]) ?>
        <small>Preferences are saved in this browser when storage is available. Use Tab to navigate, Enter or Space to activate controls, and Escape to close.</small>
        <p class="sr-only" role="status" data-a11y-status></p>
        <noscript>JavaScript is required to apply display preferences. Navigation links still work.</noscript>
        </section>
        <section class="stack" id="help-faq" role="tabpanel" aria-labelledby="tab-faq" tabindex="0" hidden><div class="stack" id="help-guide"><h3>Quick project guide</h3><ol class="help-guide"><li><strong>Explore:</strong> Browse barangay profiles and reference documents on the home page.</li><li><strong>Register:</strong> Create a resident account, choose your barangay, and wait for administrator activation.</li><li><strong>Participate:</strong> Sign in and open Resident surveys to save or update your own answers.</li><li><strong>Stay informed:</strong> Read approved updates available to your account and use permitted reports.</li><li><strong>Ask for help:</strong> Submit an inquiry to the project inbox. Never include your password.</li></ol><p><?= button('Read the full Citizen Charter',['href'=>url('citizen-charter'),'variant'=>'secondary']) ?></p></div>
        <h3>Frequently asked questions</h3>
            <?php foreach (require ROOT . '/app/content/faq.php' as $question=>$answer): ?>
            <details class="help-faq"><summary><?= e($question) ?></summary><p><?= e($answer) ?></p></details>
            <?php endforeach; ?>
        </section>
        <section class="stack" id="help-message" role="tabpanel" aria-labelledby="tab-message" tabindex="0" hidden>
            <h3>Message Us</h3><p>Send a question or concern to this project's administrator. Messages are saved in the project inbox, not emailed to municipal offices. Never include your password.</p>
            <form method="post" action="<?= e(url('contact')) ?>" class="stack" data-submit>
                <?= csrf() ?>
                <?= field('name','Full name','',['id'=>'contact-name','required'=>true,'maxlength'=>80,'autocomplete'=>'name']) ?>
                <?= field('email','Email address','',['id'=>'contact-email','type'=>'email','required'=>true,'maxlength'=>100,'autocomplete'=>'email']) ?>
                <?= field('message','Your message','',['id'=>'contact-message','type'=>'textarea','required'=>true,'maxlength'=>10000]) ?>
                <?= button('Send message') ?>
            </form>
            <p class="muted">To reach the municipality directly, use the <a href="https://pulilan.gov.ph/government/office-directories/">official office directory</a>.</p>
        </section>
    </div>
</dialog>
