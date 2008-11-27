<!-- s:<?= __FILE__ ?> -->
<table border="0"><tr><td width="15%">&nbsp;</td>
<td align="center" width="70%">
<?
$i = 0;
if ($iPageCount > 1) {
	if ($iPage!=0) {
?>		
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=".($iPage - 1))?>">&#171; <?=wfMsg('blog-newerposts')?></a>&nbsp;&nbsp;
<?
	}
	if ( ($iPage - $iNbrShow) < 0 ) {
		$i = 0;
	} else {
		$i = $iPage - $iNbrShow;
	}
	if ($i > 0 && $bShowNext == 0) { 
?>
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=0")?>">1</a>&nbsp;";
<?
		if ( $i != 1) {
?>
&nbsp;...&nbsp;&nbsp;
<?
		}	
	}
	for (; $i < $iPage ; $i++) { 
?>
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=".$i)?>"><?=($i+1)?></a>&nbsp;&nbsp;
<?
	}
?>
<b><?=($iPage+1)?></b>&nbsp;&nbsp;
<?
	$to = $iPage + $iNbrShow + 1;
	if ( $to > $iPageCount ) {
		$to = $iPageCount;
	} 
	
	for ($i = $iPage+1; $i < $to; $i++) {
?>
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=".$i)?>"><?=($i+1)?></a>&nbsp;&nbsp;
<?
	}

	if ( $to < $iPageCount && $bShowNext == 0 ) {
		if ( $to != $iPageCount - 1 ) {
?>
&nbsp;...&nbsp;&nbsp;
<?
		}
?>
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=".($iPageCount-1))?>"><?=$iPageCount?></a>
<?
	}
	if ( ($iPage + 1) != $iPageCount ) {
?>
<a href="<?=$wgTitle->getFullURL($pageOffsetName."=".($iPage+1))?>"><?=wfMsg('blog-olderposts')?> &#187;</a>
<?
	}
} else {
	if ($iPageCount	> 1) {
?>
&nbsp;&nbsp;<b><?=($iPage+1)?></b>&nbsp;&nbsp;
<?
	}
}
?>
</td><td width="15%">&nbsp;</td></tr></table>
<!-- e:<?= __FILE__ ?> -->
