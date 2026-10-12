<section class="landing-section" id="official-information" aria-labelledby="official-information-title">
    <div class="section-heading"><span class="eyebrow">Municipal reference</span><h2 id="official-information-title">Discover Pulilan.</h2><p><?= e($municipality['history']) ?></p></div>
    <div class="grid grid--3">
        <?php foreach ($municipality['contacts'] as [$office,$phone,$dial,$email]): ?>
        <article class="card"><h3><?= e($office) ?></h3><p><a href="<?= e('tel:'.$dial) ?>"><?= e($phone) ?></a></p><p><a href="<?= e('mailto:'.$email) ?>"><?= e($email) ?></a></p></article>
        <?php endforeach; ?>
    </div>
    <nav class="actions official-links" aria-label="Official municipal resources">
        <?php foreach ($municipality['links'] as [$label,$href]): ?><?= button($label,['href'=>$href,'variant'=>'secondary']) ?><?php endforeach; ?>
    </nav>
    <p class="muted">Source: <a href="https://pulilan.gov.ph/">Municipality of Pulilan official website</a>. Reviewed <time datetime="<?= e($municipality['reviewed']) ?>"><?= e($municipality['reviewed']) ?></time>. Demographic references include historical figures; the barangay cards below show this project’s recorded profiles.</p>
</section>
