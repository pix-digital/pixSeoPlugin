<h1>Liste des pages satelittes</h1>
<ul>
    <?php foreach ($page_sats as $page_sat): ?>
    <li>
        <?php echo link_to($page_sat->getTitle(), pixSeoTools::urlForPage($page_sat->getSlug())); ?>
    </li>
    <?php endforeach; ?>
</ul>
