<?
	$includesRestrictedPages = false;
	foreach ( $groups as $group => $sortedPages ) {
		$middle = ceil( count($sortedPages)/2 );
		$total = count($sortedPages);
		$count = 0;
?>
<section>
<header class="AdminDashboardGeneralHeader">
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
			$link = $sk->linkKnown( $title , htmlspecialchars( $desc ), array('data-tracking' => 'advanced/'.str_replace(" ", "", $title->getText()) ));
?>
				<li><?= $link ?></li>
<?
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
