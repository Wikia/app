<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="thumbs-up-svg">
<g class="thumbs-up-icon">
	<path d="M7.2,48 L2.4,48 C0.96,48 0,47.04 0,45.6 L0,24 C0,22.56 0.96,21.6 2.4,21.6 L7.2,21.6 C8.64,21.6 9.6,22.56 9.6,24 L9.6,45.6 C9.6,47.04 8.64,48 7.2,48 L7.2,48 Z"/>
	<path d="M43.2,19.2 L31.2,19.2 L31.2,12 C31.2,7.92 28.8,2.4 25.2,0.24 C23.52,-0.48 21.6,0.48 21.6,2.4 L21.6,12 L14.4,20.64 L14.4,45.6 L15.12,45.84 C17.76,47.28 20.88,48 24,48 L40.8,48 C43.44,48 45.6,45.84 45.6,43.2 L48,24 C48,21.36 45.84,19.2 43.2,19.2 L43.2,19.2 Z"/>
</g>
</svg>
<div class="banner-body">
	<h4>Nice work!</h4>
	<?php foreach( $appreciations as $appreciation ): ?>
		<p class="message"><?= wfMessage( 'appreciation-user' )
				->rawParams( $appreciation['diffLink'], implode( ', ', $appreciation['userLinks'] ) )
				->escaped(); ?>
		</p>
	<?php endforeach ?>
	<?php if ( $numberOfHiddenAppreciations ): ?>
		<a href="#" class="expand-link">
			<?= wfMessage( 'appreciation-user-see-more', $numberOfHiddenAppreciations )->escaped() ?>&nbsp;&rarr;
		</a>
	<?php endif ?>
</div>
