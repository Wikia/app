<h2 class="wordmark <?= $wordmarkSize ?> <?= $wordmarkType ?> <?= $wordmarkFontClass ?>">
	<a accesskey="z" href="<?= Sanitizer::encodeAttribute( $mainPageURL ); ?>">
		<? if (!empty($wordmarkUrl)) { ?>
			<img src="<?= $wordmarkUrl ?>" alt="<?= Sanitizer::encodeAttribute( $wordmarkText ); ?>" <? if (!empty($wordmarkStyle)) { ?><?= $wordmarkStyle ?><? } ?>>
		<? } else { ?>
			<?= htmlspecialchars($wordmarkText) ?>
		<? } ?>
	</a>
</h2>
