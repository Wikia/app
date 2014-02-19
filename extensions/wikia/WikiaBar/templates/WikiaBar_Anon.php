<div class="ad">
	<?php //todo: use renderView('Ad', 'index'); instead of line below ?>
	<div id="WIKIA_BAR_BOXAD_1" class="noprint" style="width: 300px; position: relative;"></div>
</div>
<div
	class="message<?if (empty($status)): ?> failsafe<? endif; ?>"
	data-messagetooltip="<?= wfMsg('wikiabar-message-tooltip') ?>"
	data-wikiabarcontent="<?= htmlentities(json_encode($barContents['messages']), ENT_QUOTES) ?>"
></div>
<? foreach ($barContents['buttons'] as $idx => $button): ?>
	<a class="wikiabar-button" href="<?= $button['href'] ?>" data-index="<?= $idx; ?>">
		<img src="<?= $button['image_url'] ?>" class="icon <?= $button['class'] ?>" />
		<span><?= $button['text'] ?></span>
	</a>
<? endforeach; ?>
