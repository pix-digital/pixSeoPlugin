<h1>Liste des pages satelittes</h1>
<ul>
    <?php foreach ($page_sats as $page_sat): ?>
    <li>
        <?php echo link_to($page_sat->keyword, '@pix_page_sat_auto_show?slug='.$page_sat->slug); ?>
    </li>
    <?php endforeach; ?>
</ul>
