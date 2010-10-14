<!-- s:<?= __FILE__ ?> -->
<? 
$i = 0; $prevPage = $nextPage = "";
if ($iPageCount > 1) {
	if ( $iPage != 0 ) { 
		$prevPage = '<a href="javascript:wkBlogShowPage(-1);" id="wk-blog-prev-link">&#171; '.wfMsg('blog-newerposts').'</a>';
	} 
	if ( ($iPage + 1) != $iPageCount ) {
		$nextPage = '<a href="javascript:wkBlogShowPage(1);" id="wk-blog-next-link">'.wfMsg('blog-olderposts').' &#187;</a>';
	}	
?>	
<script type="text/javascript" src="<?=$wgExtensionsPath?>/wikia/Blogs/js/BlogsPager.js?<?=$wgStyleVersion?>"></script>
<div style="text-align:right; padding:2px 5px;"><?=$prevPage?>&nbsp;&nbsp;<strong id="wk-blog-current-page"><?=($iPage+1)?></strong>&nbsp;&nbsp;<?=$nextPage?></div>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
