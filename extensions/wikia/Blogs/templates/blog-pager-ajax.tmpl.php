<!-- s:<?= __FILE__ ?> -->
<?
if ($iPageCount > 1) {
?>
<?
	$pages = new Wikia\Paginator\Paginator( $iTotal, min( $iCount, 50 ), '' );
	$pages->setActivePage( $iPage + 1 );
	echo $pages->getBarHTML( 'BlogPaginator' );
?>
<script type="text/javascript" src="<?=$wgExtensionsPath?>/wikia/Blogs/js/BlogsPager.js"></script>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
