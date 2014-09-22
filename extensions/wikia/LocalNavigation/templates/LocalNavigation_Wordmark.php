<header class="wordmark-container <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
	<div class="wordmark">
		<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>">
			<? if (!empty($wordmarkUrl)) { ?>
				<img
					alt="<?= htmlspecialchars($wordmarkText) ?>"
					height="<?= $wordmarkMaxHeight ?>"
					src="<?= $wordmarkUrl ?>"
					width="<?= $wordmarkMaxWidth ?>"
				>
			<? } else { ?>
				<span><?= htmlspecialchars($wordmarkText) ?></span>
			<? } ?>
		</a>
	</div>
</header>
