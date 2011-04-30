<!-- s:<?= __FILE__ ?> -->
<table border="0"><tr><td width="15%">&nbsp;</td>
<td align="center" width="70%">
<?
$i = 0;
if ($iPageCount > 1) {
	if ( $iPage != 0 ) {
?>		
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=".($iPage - 1))?>">&#171; <?=wfMsg('blog-newerposts')?></a>
<?
	}
?>	
&nbsp;&nbsp;<b><?=($iPage+1)?></b>&nbsp;&nbsp;
<?
	if ( ($iPage + 1) != $iPageCount ) {
?>
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=".($iPage+1))?>"><?=wfMsg('blog-olderposts')?> &#187;</a>
<?
	}
} 
?>
</td><td width="15%">&nbsp;</td></tr></table>
<!-- e:<?= __FILE__ ?> -->
