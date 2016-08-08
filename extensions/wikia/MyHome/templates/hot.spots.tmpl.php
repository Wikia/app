<?php if ( count( $data ) == 5 ): ?>
	<?= wfMessage( 'myhome-hot-spots-newest' )->escaped(); ?>
<ul class="clearfix" style="margin-top: 5px;">
<?php foreach ( $data as $item ): ?>
	<li>
		<span>
			<a href="<?= Sanitizer::encodeAttribute( $item['url'] ); ?>" class="title" rel="nofollow">
				<?= htmlspecialchars( $item['title'] );  ?>
			</a>
		</span>
	</li>
<?php endforeach; ?>
</ul>
<?php elseif ( count( $data ) == 2 ): ?>
<p style="margin-bottom: 5px"><?= wfMessage( 'myhome-hot-spots-definition', $data['interval'] )->escaped(); ?></p>
<?php
	$hotSpotSeverity = 1; //used to set background color heat level. 1 (hottest) - 5 (coolest).
	$hotSpotLast = []; //used to compare the last rendered item to current.
	$hotSpotFire = '';
	if ( $data['results'][0]['count'] - $data['results'][1]['count'] > 2 ) {
		$hotSpotFire = ' class="fire"';
	}
?>
<ul id="myhome-hot-spots" class="reset">
	<?php foreach ( $data['results'] as $row ) {
		if ( isset( $hotSpotLast['count'] ) && ( $row['count'] == $hotSpotLast['count'] ) ) { //same count as before?
			$thisSeverity = $hotSpotLast['severity']; //use the last severity level
		} else {
			$thisSeverity = $hotSpotSeverity; //use the actual severity level for this row
		}
?>
		<li<?= $hotSpotFire ?>>
			<div class="myhome-hot-spots-fire">
				<div class="hot-spot-severity-<?=$thisSeverity?>">
					<big><?= $row['count'] ?></big>
					<small><?= wfMessage( 'myhome-hot-spots-number-of-editors' )->escaped(); ?></small>
				</div>
			</div>
			<span>
				<a href="<?= Sanitizer::encodeAttribute( $row['url'] ); ?>" class="title" rel="nofollow">
					<?= htmlspecialchars( $row['title'] ); ?>
				</a>
			</span>
		</li>
<?php
		$hotSpotLast['count'] = $row['count'];
		$hotSpotLast['severity'] = $thisSeverity;

		$hotSpotFire = '';
		$hotSpotSeverity++;
	} // endforeach;
?>
</ul>
<?php endif; ?>
