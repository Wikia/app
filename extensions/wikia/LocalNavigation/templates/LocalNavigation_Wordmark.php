<h3 class="wordmark-container <?= !empty( $wordmarkUrl ) ? 'wordmark-icon' : ''; ?>">
	<span>
		<a class="wordmark" accesskey="z" href="<?= htmlspecialchars( $mainPageURL ) ?>">
			<? if ( !empty( $wordmarkUrl ) ) { ?>
				<img alt="<?= htmlspecialchars( $wordmarkText ) ?>" src="<?= $wordmarkUrl ?>" <?= $wordmarkStyle ?>>
			<? } else { ?>
				<span class="wordmark-text <?= $wordmarkFontSize ?>"><?= htmlspecialchars( $wordmarkText ) ?></span>
			<? } ?>
		</a>
	</span>
</h3>
