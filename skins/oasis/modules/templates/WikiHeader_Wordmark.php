<h1 class="wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
	<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>">
		<? if (!empty($wordmarkUrl)) { ?>
			<img src="<?= $wordmarkUrl ?>" alt="<?= htmlspecialchars($wordmarkText) ?>">
		<? } else { ?>
			<?= htmlspecialchars($wordmarkText) ?>
		<? } ?>
	</a>
</h1>
