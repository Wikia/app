<?
	$includesRestrictedPages = false;
	foreach ( $groups as $group => $sortedPages ) {
		$middle = ceil( count($sortedPages)/2 );
		$total = count($sortedPages);
		$count = 0;
?>
<section>
<header class="ControlCenterGeneralHeader">
	<h1 class="mw-specialpagesgroup">
		<?= wfMsgNoTrans( "specialpages-group-$group" ) ?>
	</h1>
</header>
<table style='width: 100%;' class='mw-specialpages-table'>
	<tr>
		<td width='30%' valign='top'>
			<ul>
<?
		foreach( $sortedPages as $desc => $specialpage ) {
			list( $title, $restricted ) = $specialpage;
			$link = $sk->linkKnown( $title , htmlspecialchars( $desc ) );
			if( $restricted ) {
				$includesRestrictedPages = true;
?>
				<li class='mw-specialpages-page mw-specialpagerestricted'><strong><?= $link ?></strong></li>
<?
			} else {
?>
				<li><?= $link ?></li>
<?
			}

			# Split up the larger groups
			$count++;
			if( $total > 3 && $count == $middle ) {
?>
			</ul>
		</td>
		<td width='10%'></td>
		<td width='30%' valign='top'>
			<ul>
<?
			}
		}
?>
			</ul>
		</td>
		<td width='30%' valign='top'></td>
	</tr>
</table>
</section>
<?
	}

	if ( $includesRestrictedPages ) {
?>
<div class="mw-specialpages-notes">
	<?= wfMsgNoTrans( "specialpages-note" ) ?>
</div>
<?
	}
?>