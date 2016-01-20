<?php if (! isset($poll)) {
	echo F::app()->renderView('Error', 'Index', array('Poll does not exist'));
} else { ?>
<section class="CreateWikiaPoll" id="CreateWikiaPoll" data-pollid="<?=$poll->getID()?>">

	<h1><?= wfMsg('wikiapoll-editpoll-headline') ?></h1>

	<form>
	<input type="hidden" name="token" value="<?= Sanitizer::encodeAttribute( $editToken ) ?>">
	<label>question</label>

	<div class="question">
		<span><?= wfMsg("wikiapoll-question-mark-before") ?></span>
		<input type="text" name="question" value="<?= htmlspecialchars($data['question']) ?>">
		<span><?= wfMsg("wikiapoll-question-mark-after") ?></span>
	</div>

	<ul>
		<li class="new-item">
			<label>#0</label>
			<span><input type="text" name ="answer[]"></span>
			<img src="<?= $wg->blankImgUrl ?>" class="sprite trash">
			<img src="<?= $wg->blankImgUrl ?>" class="sprite drag">
		</li>
	<?php foreach($data['answers'] as $n => $answer) { ?>
		<li>
			<label><?="#".($n+1)?></label>
			<span><input type="text" name ="answer[]" value="<?= htmlspecialchars($answer['text']) ?>"></span>
			<img src="<?= $wg->blankImgUrl ?>" class="sprite trash">
			<img src="<?= $wg->blankImgUrl ?>" class="sprite drag">
		</li>
	<?php } ?>
	</ul>

	<div class="add-new">
		<a href="#" class="wikia-button secondary">+</a><?= wfMsg('wikiapoll-addnewitem-label') ?>
	</div>

	<div class="toolbar">
		<input type="button" value="<?= wfMsg('wikiapoll-cancel-label') ?>" class="cancel secondary">
		<input type="button" value="<?= wfMsg('wikiapoll-publish-label') ?>" class="create">
	</div>

	<input type="hidden" name ="pollId" value="<?=$poll->getID()?>">

	</form>
</section>
<?php } ?>
