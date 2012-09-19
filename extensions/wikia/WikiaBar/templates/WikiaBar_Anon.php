<div class="ad">
	<?php //todo: use renderView('Ad', 'index'); instead of line below ?>
	<div id="WIKIA_BAR_BOXAD_1" class="noprint" style="height: 250px; width: 300px; position: relative;"><div id="Liftium_300x250_98"><iframe width="300" height="250" id="WIKIA_BAR_BOXAD_1_iframe" class="" noresize="true" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" style="border:none" target="_blank"></iframe></div></div>
</div>
<div class="message<?if (empty($status)): ?> failsafe<? endif; ?>" data-content="<?= htmlentities(json_encode($barContents['messages']), ENT_QUOTES)  ?>"></div>
<? foreach ($barContents['buttons'] as $idx => $button): ?>
	<a class="wikiabar-button" href="<?= $button['href'] ?>" data-index="<?= $idx; ?>">
		<img src="<?= $wg->BlankImgUrl ?>" class="icon <?= $button['class'] ?>" />
		<span><?= $button['text'] ?></span>
	</a>
<? endforeach; ?>
