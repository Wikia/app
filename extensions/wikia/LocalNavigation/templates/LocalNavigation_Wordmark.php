<header class="wordmark-container <?= $wordmarkFontSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
	<div class="wordmark">
		<a accesskey="z" href="<?= htmlspecialchars( $mainPageURL ) ?>">
			<? if (!empty($wordmarkUrl)) { ?>
				<img alt="<?= htmlspecialchars( $wordmarkText ) ?>" src="<?= $wordmarkUrl ?>">
			<? } else { ?>
				<span><?= htmlspecialchars( $wordmarkText ) ?></span>
			<? } ?>
		</a>
	</div>
</header>
