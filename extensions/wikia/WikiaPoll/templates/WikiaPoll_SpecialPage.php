<div class="CreateWikiaPoll" id="CreateWikiaPoll">

	<h1><?= wfMsg('wikiapoll-createpoll-headline') ?></h1>

	<form>
	<input type="hidden" name="token" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>">
	<label><?= wfMsg('wikiapoll-question-label') ?></label>

	<div class="question">
		<span><?= wfMsg("wikiapoll-question-mark-before") ?></span>
		<input type="text" name="question">
		<span><?= wfMsg("wikiapoll-question-mark-after") ?></span>
	</div>

	<ul>
<?php
// #0 item is a hidden row used to generate new rows in JavaScript code
for ($i=0; $i<=3; $i++):?>
		<li<?= ($i == 0 ? ' class="new-item"' : '') ?>>
			<label>#<?= $i ?></label>
			<span><input type="text" name="answer[]"></span>
			<img src="<?= $wg->blankImgUrl ?>" class="sprite trash">
			<img src="<?= $wg->blankImgUrl ?>" class="sprite drag">
		</li>
<?php endfor; ?>
	</ul>

	<div class="add-new">
		<a href="#" class="wikia-button secondary">+</a><?= wfMsg('wikiapoll-addnewitem-label') ?>
	</div>

	<div class="toolbar">
		<input type="button" value="<?= wfMsg('wikiapoll-cancel-label') ?>" class="cancel secondary">
		<input type="button" value="<?= wfMsg('wikiapoll-publish-label') ?>" class="create">
	</div>

	</form>
</div>