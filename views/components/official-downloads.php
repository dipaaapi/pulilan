<?php
$officialAssets = json_decode(file_get_contents(ROOT . '/app/content/official-assets.json'), true, 512, JSON_THROW_ON_ERROR);
$descriptions = [
    'planning-charter-2026.pdf' => 'Development permits and locational clearance guidance for municipal planning.',
    'social-welfare-charter-2026.pdf' => 'Guidance on crisis assistance and other social welfare services.',
    'population-charter-2026.pdf' => 'Population records and demographic data requests for planning and research.',
    'building-permit.pdf' => 'Blank application form published by the Municipal Engineering Office.',
    'occupancy-application.pdf' => 'Blank certificate-of-occupancy application published by the Municipal Engineering Office.',
];
?>
<section class="landing-section" id="official-downloads" aria-labelledby="official-downloads-title">
    <div class="section-heading"><span class="eyebrow">Resident resources</span><h2 id="official-downloads-title">Municipal guides and forms.</h2><p>Local reference copies from the official Pulilan website. Contact the responsible municipal office for current requirements and submissions.</p></div>
    <article class="card stack"><h3>Citizen guide for this portal</h3><p>Learn how to register, submit surveys, read updates, and ask for assistance. Project draft; municipal technology-office reference: MICTO.</p><div class="actions"><?= button('View project Citizen Charter',['href'=>url('citizen-charter')]) ?><?= button('Download project guide (PDF)',['href'=>base_path().'/documents/project/citizen-charter.pdf','variant'=>'secondary','download'=>'pulilan-cbms-citizen-charter.pdf']) ?></div></article>
    <?php $documents = array_values(array_filter($officialAssets, fn($item)=>in_array($item['kind'], ['charter','form'], true)));
    $documentActions = function(array $document): string {
        $href = base_path().'/'.$document['local_path'];
        return '<div class="actions">'.button('View PDF',['href'=>$href,'variant'=>'secondary','data-pdf-view'=>true,'data-pdf-title'=>$document['title'],'aria-label'=>'View '.$document['title'].' (PDF)']).button('Download PDF',['href'=>$href,'variant'=>'secondary','download'=>basename($document['local_path']),'aria-label'=>'Download '.$document['title'].' (PDF)']).'</div>';
    }; ?>
    <div class="actions document-view-switch" role="group" aria-label="Document list layout" data-document-switch hidden>
        <?= button('Table view',['type'=>'button','variant'=>'secondary','data-document-view'=>'table','aria-pressed'=>'true','aria-controls'=>'documents-table']) ?>
        <?= button('Card view',['type'=>'button','variant'=>'secondary','data-document-view'=>'cards','aria-pressed'=>'false','aria-controls'=>'documents-cards']) ?>
    </div>
    <div class="table-scroll" id="documents-table"><table><caption>Official municipal guides and blank forms</caption><thead><tr><th scope="col">Document</th><th scope="col">Type</th><th scope="col">File / date</th><th scope="col">Actions</th></tr></thead><tbody>
        <?php foreach ($documents as $document): ?><tr>
            <td><strong><?= e($document['title']) ?></strong><p><?= e($descriptions[basename($document['local_path'])] ?? '') ?></p><a href="<?= e($document['source_page']) ?>">Official source</a></td>
            <td><?= badge($document['kind']==='charter' ? '2026 Citizen Charter' : 'Blank form') ?></td>
            <td>PDF ? <?= e(number_format($document['bytes']/1024/1024,2)) ?> MB<br><time datetime="<?= e($document['retrieved']) ?>"><?= e($document['retrieved']) ?></time></td>
            <td><?= $documentActions($document) ?></td>
        </tr><?php endforeach; ?>
    </tbody></table></div>
    <div class="grid grid--3" id="documents-cards" hidden>
        <?php foreach ($documents as $document): ?>
        <article class="card stack">
            <?= badge($document['kind'] === 'charter' ? '2026 Citizen Charter' : 'Blank form') ?>
            <h3><?= e($document['title']) ?></h3>
            <p><?= e($descriptions[basename($document['local_path'])] ?? '') ?></p>
            <?= $documentActions($document) ?>
            <small>PDF ? <?= e(number_format($document['bytes']/1024/1024,2)) ?> MB ? Retrieved <?= e($document['retrieved']) ?></small>
            <a href="<?= e($document['source_page']) ?>">Official source and latest versions</a>
        </article><?php endforeach; ?>
    </div>
    <dialog class="document-modal" id="document-preview" aria-labelledby="document-preview-title">
        <header class="help-header"><h2 id="document-preview-title">Document preview</h2><?= button('Close',['type'=>'button','variant'=>'secondary','data-pdf-close'=>true,'autofocus'=>true]) ?></header>
        <p>Use the PDF viewer controls to zoom, change pages, or print. If the preview is unavailable, open or download the PDF.</p>
        <div class="actions"><a class="button button--secondary" data-pdf-open>Open PDF</a><a class="button button--secondary" data-pdf-download download>Download PDF</a></div>
        <iframe class="pdf-reader" data-pdf-frame title="PDF document preview"></iframe>
    </dialog>
    <p class="muted">This project stores community surveys; it does not issue municipal permits or submit these forms to government offices. Some PDFs use complex tables or scanned pages. For help obtaining an accessible version, contact the office listed in the official directory.</p>
</section>
