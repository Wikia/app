<!-- s:<?= __FILE__ ?> -->
<?
if ($iPageCount > 1) {
?>
<?
	$pages = Paginator::newFromArray( $iTotal, $iCount, 50 );
	$pages->setActivePage($iPage);
	echo $pages->getBarHTML( '', 'BlogPaginator' );
?>
<script type="text/javascript" src="<?=$wgExtensionsPath?>/wikia/Blogs/js/BlogsPager.js"></script>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
