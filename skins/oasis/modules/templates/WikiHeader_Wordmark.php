<h1 class="wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
	<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>">
		<? if (!empty($wordmarkUrl)) { ?>
			<img src="<?= $wordmarkUrl ?>" alt="<?= htmlspecialchars($wordmarkText) ?>" width="250" height="65">
		<? } else { ?>
			<?= htmlspecialchars($wordmarkText) ?>
		<? } ?>
	</a>
</h1>