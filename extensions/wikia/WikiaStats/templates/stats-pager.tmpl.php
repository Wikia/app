<table style="padding:3px; width:100%; font-size:9pt;">
<tr><td width="15%">&nbsp;</td><td align="center" width="70%" style="vertical-align:middle;">
<?
if ($page_count > 1 || $only_next) 
{
	if ($page!=0) 
	{
?>
<a href="<?=$link?>&page=<?=($page-1)?>"><?=$lcL_ARROW." ".$lcPREVIOUS?></a>&nbsp;&nbsp;
<?	} 
	$i = $page - $NUM_NUMBER;
	if ( ($page - $NUM_NUMBER) < 0 ) 
	{
		$i = 0;
	}
	#---
	if ($i > 0 && $only_next == 0)
	{
?>
<a href="<?=$link?>&page=0">1</a>&nbsp;
<?
		if ($i != 1) 
		{
?>
&nbsp;...&nbsp;&nbsp;
<?
		}
	}
	
	for (; $i < $page ; $i++)
	{
?>
<a href="<?=$link?>&page=<?=$i?>"><?=($i+1)?></a>&nbsp;&nbsp;
<?
	}
?>	
<b><?=($page+1)?></b>&nbsp;&nbsp;
<?
	$to=$page+$NUM_NUMBER+1;
	if ( ($page + $NUM_NUMBER +1 ) > $page_count )
	{
		$to = $page_count;
	}

	for ($i = $page+1; $i < $to; $i++)
	{
?>		
<a href="<?=$link?>&page=<?=$i?>"><?=($i+1)?></a>&nbsp;&nbsp;
<?
	}
	#----
	if ($to < $page_count && $only_next == 0)
	{
		if ($to != $page_count-1) 
		{
?>
&nbsp;...&nbsp;&nbsp;
<?
		}
?>
<a href="<?=$link?>&page=<?=($page_count-1)?>"><?=$page_count?></a>
<?
	}
	#---
	if (($page+1)!=$page_count || $only_next == 1)
	{
?>		
<a href="<?=$link?>&page="<?=($page+1)?>"><?=$lcNEXT." ".$lcR_ARROW?></a>
<?
	}
}
else
{
?>
&nbsp;&nbsp;<b><?=($page+1)?></b>&nbsp;&nbsp;
<?
}
?>
</td><td width="15%">&nbsp;</td>
</tr></table>
