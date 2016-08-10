<p>Thank you <?= $userName ?></p>
<?php foreach( $appreciations as $appreciation ): ?>
	<p><?= wfMessage( 'appreciation-user', count( $appreciation['userLinks'] ) )->rawParams(
			implode( ', ', $appreciation['userLinks'] ),
			$appreciation['diffLink']
		)->escaped() ?></p>
<?php endforeach ?>
