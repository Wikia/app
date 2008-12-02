<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript" src="<?=$wgExtensionsPath?>/wikia/Blogs/js/BlogsPager.js?<?=$wgStyleVersion?>"></script>
<table border="0"><tr><td width="15%">&nbsp;</td>
<td align="center" width="70%">
<?
$i = 0; if ($iPageCount > 1) { 	if ( $iPage != 0 ) {
?>		
<a href="#" id="wk-blog-prev-link" onclick="wkBlogShowPage(-1);">&#171; <?=wfMsg('blog-newerposts')?></a>
<? } ?>	
&nbsp;&nbsp;<strong id="wk-blog-current-page"><?=($iPage+1)?></strong>&nbsp;&nbsp;
<? if ( ($iPage + 1) != $iPageCount ) { ?>
<a href="#" id="wk-blog-next-link" onclick="wkBlogShowPage(1);"><?=wfMsg('blog-olderposts')?> &#187;</a>
<? } } ?>
</td><td width="15%">&nbsp;</td></tr></table>
<!-- e:<?= __FILE__ ?> -->
