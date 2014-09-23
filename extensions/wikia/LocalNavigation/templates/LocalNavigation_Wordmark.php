<header class="wordmark-container <?= $wordmarkFontSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
	<a class="wordmark" accesskey="z" href="<?= htmlspecialchars( $mainPageURL ) ?>">
		<? if (!empty($wordmarkUrl)) { ?>
			<img alt="<?= htmlspecialchars( $wordmarkText ) ?>" src="<?= $wordmarkUrl ?>">
		<? } else { ?>
			<span><?= htmlspecialchars( $wordmarkText ) ?></span>
		<? } ?>
	</a>
</header>
