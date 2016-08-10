<i class="thumb-up-icon"></i>
<h4>Nice work!</h4>
<?php foreach( $appreciations as $appreciation ): ?>
	<p class="message"><?= wfMessage( 'appreciation-user' )
			->rawParams( $appreciation['diffLink'], implode( ', ', $appreciation['userLinks'] ) )
			->escaped(); ?>
	</p>
<?php endforeach ?>
<?php if ( $numberOfAppreciations > 2 ): ?>
	<a href="#" class="expand-link">
		<?= wfMessage( 'appreciation-user-see-more', ( $numberOfAppreciations - 2 ) )->escaped() ?>&nbsp;&rarr;
	</a>
<?php endif ?>
