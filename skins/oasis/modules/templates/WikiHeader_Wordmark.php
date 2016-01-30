<? if ( $seoTestOneH1 ): ?>
	<h2 class="wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
		<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>">
			<? if (!empty($wordmarkUrl)) { ?>
				<img src="<?= $wordmarkUrl ?>" alt="<?= htmlspecialchars($wordmarkText) ?>" <? if (!empty($wordmarkStyle)) { ?><?= $wordmarkStyle ?><? } ?>>
			<? } else { ?>
				<?= htmlspecialchars($wordmarkText) ?>
			<? } ?>
		</a>
	</h2>
<? else: ?>
	<h1 class="wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
		<a accesskey="z" href="<?= htmlspecialchars($mainPageURL) ?>">
			<? if (!empty($wordmarkUrl)) { ?>
				<img src="<?= $wordmarkUrl ?>" alt="<?= htmlspecialchars($wordmarkText) ?>" <? if (!empty($wordmarkStyle)) { ?><?= $wordmarkStyle ?><? } ?>>
			<? } else { ?>
				<?= htmlspecialchars($wordmarkText) ?>
			<? } ?>
		</a>
	</h1>
<? endif; ?>
