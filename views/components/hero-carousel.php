<?php $communityImages = json_decode(file_get_contents(ROOT . '/app/content/community-images.json'), true, 512, JSON_THROW_ON_ERROR); ?>
<div class="hero-carousel" data-carousel role="region" aria-roledescription="carousel" aria-label="Scenes from Pulilan">
    <?php foreach ($communityImages as $index=>$photo): ?>
    <img src="<?= e(asset($photo['image'])) ?>" alt="<?= e($photo['alt']) ?>" width="750" height="560" <?= $index === 0 ? 'fetchpriority="high"' : 'hidden' ?> decoding="async" data-carousel-slide>
    <?php endforeach; ?>
</div>
