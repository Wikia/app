<header class="wordmark-container">
	<span>
		<a class="wordmark" accesskey="z" href="<?= htmlspecialchars( $mainPageURL ) ?>">
			<? if ( !empty( $wordmarkUrl ) ) { ?>
				<img alt="<?= htmlspecialchars( $wordmarkText ) ?>" src="<?= $wordmarkUrl ?>">
			<? } else { ?>
				<span class="wordmark-text <?= $wordmarkFontSize ?>"><?= htmlspecialchars( $wordmarkText ) ?></span>
			<? } ?>
		</a>
	</span>
</header>
