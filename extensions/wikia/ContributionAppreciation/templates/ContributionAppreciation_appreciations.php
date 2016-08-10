<i class="thumb-up-icon"></i>
<p class="header">Nice work!</p>
<?php foreach( $appreciations as $appreciation ): ?>
	<p><?= wfMessage( 'appreciation-user' )
			->rawParams( $appreciation['diffLink'], implode( ', ', $appreciation['userLinks'] ) )
			->escaped(); ?>
	</p>
<?php endforeach ?>
<p class="expand-link"></p>
