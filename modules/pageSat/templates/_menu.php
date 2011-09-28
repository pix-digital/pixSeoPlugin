<?php if($pages_sat->count() > 0): ?>
    <ul>
    <?php foreach($pages_sat as $page_sat): ?>
        <li><?php echo link_to($page_sat->getTitle(), pixSeoTools::urlForPage($page_sat->slug, array('host' => $page_sat->host))); ?></li>
    <?php endforeach; ?>
        <li><?php echo link_to(__('Lien vers la liste des pages à personnaliser'), '@pix_page_sat_index'); ?></li>
    </ul>
<?php endif; ?>