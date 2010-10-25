<!-- s:<?= __FILE__ ?> -->
<table class="TablePager">
<tr>
	<th rowspan="2" class="ecrowright" valign="bottom"><?=$total?></th>
	<th colspan="2" class="ecrowcenter"><?=$wikiName?></th>
	<th class="ecrowright" style="border-top:0px; border-bottom: 0px;">&nbsp;</th>
	<th colspan="2" class="ecrowcenter"><?=wfMsg('editcount_allwikis')?></th>
</tr>
</tr>	
	<th class="ecrowright"><?=$ftotal?></th>
	<th class="ecrowright"><?=$percent?></th>
	<th class="ecrowright" style="border-top:0px; border-bottom: 0px;">&nbsp;</th>
	<th class="ecrowright"><?=$ftotalall?></th>
	<th class="ecrowright"><?=$percentall?></th>
</tr>
<?php foreach ($nscount as $ns => $edits) { 
	/* current wiki */
	$fedits = $wgLang->formatNum( $edits );
	$fns = ($ns == NS_MAIN) ? wfMsg( 'blanknamespace' ) : $wgLang->getFormattedNsText( $ns );
	$percent = ($edits > 0 && $nstotal > 0) ? wfPercent( $edits / $nstotal * 100 ) : wfPercent(0);
	$fpercent = $wgLang->formatNum( $percent );
	/* all wikis */
	$editsall = (array_key_exists($ns, $nscountall)) ? $nscountall[$ns] : 0;
	$feditsall = (array_key_exists($ns, $nscountall)) ? $wgLang->formatNum( $nscountall[$ns] ) : 0;
	$percentall = ($editsall > 0 && $nstotalall > 0) ? wfPercent( $editsall / $nstotalall * 100 ) : wfPercent(0);
	$fpercentall = $wgLang->formatNum( $percentall );
?>
<tr>
	<td class="ecrowcenter"><?=$fns?></td>
	<td class="ecrowright"><?=$fedits?></td>
	<td class="ecrowright"><?=$fpercent?></td>
	<td class="ecrowright" style="border-top:0px; border-bottom: 0px;">&nbsp;</td>
	<td class="ecrowright"><?=$feditsall?></td>
	<td class="ecrowright"><?=$fpercentall?></td>
</tr>
<?	} ?>
</table>
<!-- e:<?= __FILE__ ?> -->
