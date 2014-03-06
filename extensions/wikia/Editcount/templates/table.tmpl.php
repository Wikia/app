<!-- s:<?= __FILE__ ?> -->
<table class="TablePager">
<tr>
	<th rowspan="2" class="ecrowright" valign="bottom"><?=$total?></th>
	<th colspan="2" class="ecrowcenter"><?=$wikiName?></th>
	<th class="ecrowright" style="border-top:0; border-bottom: 0;">&nbsp;</th>
	<th colspan="2" class="ecrowcenter"><?=wfMsg('editcount_allwikis')?></th>
</tr>
</tr>	
	<th class="ecrowright"><?=$ftotal?></th>
	<th class="ecrowright"><?=$percent?></th>
	<th class="ecrowright" style="border-top:0; border-bottom: 0;">&nbsp;</th>
	<th class="ecrowright"><?=$ftotalall?></th>
	<th class="ecrowright"><?=$percentall?></th>
</tr>
<?php foreach ($nscount as $ns => $edits) { 
	/* current wiki */
	$fedits = $wgLang->formatNum( $edits );
	$fns = ($ns == NS_MAIN) ? wfMsg( 'blanknamespace' ) : $wgLang->getFormattedNsText( $ns );
	$percent = ($edits > 0 && $wikitotal > 0) ? wfPercent( $edits / $wikitotal * 100 ) : wfPercent(0);
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
	<td class="ecrowright" style="border-top:0; border-bottom: 0;">&nbsp;</td>
	<td class="ecrowright"><?=$feditsall?></td>
	<td class="ecrowright"><?=$fpercentall?></td>
</tr>
<?	} ?>
<?php if ( $arcount > 0 ) {
	/* current wiki total number of archived revisions */
	$farcount = $wgLang->formatNum( $arcount );
	$percent = ($arcount > 0 && $wikitotal > 0) ? wfPercent( $arcount / $wikitotal * 100 ) : wfPercent(0);
	$fpercent = $wgLang->formatNum( $percent );
?>
<tr>
	<td class="ecrowcenter"><?=wfMessage('editcount_archived_revisions')->escaped()?></td>
	<td class="ecrowright"><?=$farcount?></td>
	<td class="ecrowright"><?=$fpercent?></td>
	<td class="ecrowright" style="border-top:0; border-bottom: 0;">&nbsp;</td>
	<td class="ecrowright"><?=wfMessage('editcount_no_data')->escaped()?></td>
	<td class="ecrowright">-</td>
</tr>
<?php
}
?>
</table>
<!-- e:<?= __FILE__ ?> -->
