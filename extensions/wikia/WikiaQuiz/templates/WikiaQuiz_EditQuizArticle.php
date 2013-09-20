<?php if (! isset($quizElement)) {
	echo F::app()->renderView('Error', 'Index', array('Quiz Question and Answers do not exist'));
} else { ?>
<section class="CreateWikiaQuizArticle" id="CreateWikiaQuizArticle" data-quizelementid="<?=$quizElement->getID()?>">

	<h1><?= wfMsg('wikiaquiz-editquizarticle-headline') ?></h1>

	<form>
	<label><?= wfMsg('wikiaquiz-question-label') ?></label>
	<div class="question">
		<p><?= htmlspecialchars($data['question']) ?></p>
	</div>

	<label><?= wfMsg('wikiaquiz-image-label') ?></label>
	<div class="image">
		<input type="text" name="image" value="<?= htmlspecialchars($data['imageShort']) ?>">
	</div>

<? /* Video is broken and has been for a while.  Commenting this out so users don't get the idea they can use it.
	<label><?= wfMsg('wikiaquiz-video-label') ?></label>
	<div class="video">
		<input type="text" name="video" value="<?= htmlspecialchars($data['videoName']) ?>">
	</div>
*/ ?>
	<input type="hidden" name="video">

	<label><?= wfMsg('wikiaquiz-explanation-label') ?></label>
	<div class="explanation">
		<textarea name="explanation"><?= htmlspecialchars($data['explanation']) ?></textarea>
	</div>

	<label><?= wfMsg('wikiaquiz-quiz-label') ?></label>
	<div class="quiz">
		<p><?= htmlspecialchars($data['quiz']) ?></p>
		<p>Order: <?=$data['order'] ?></p>
	</div>

	<label><?= wfMsg('wikiaquiz-answers-label') ?></label>
	<ul>
	<li class="new-item">
		<label class="order">#0</label>
		<div class="details"><div><label><?= wfMsg('wikiaquiz-answer-label') ?></label><input type="text" name="answer[]"></div><div><label><?= wfMsg('wikiaquiz-correct-label') ?></label><input type="radio" name="correct" value="0" class="correct"></div><div><label><?= wfMsg('wikiaquiz-image-label') ?></label><input type="text" name ="answer-image[]"></div></div>
		<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
		<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
	</li>
	<?php foreach($data['answers'] as $n => $answer) { ?>
	<li>
		<label class="order"><?="#".($n+1)?></label>
		<div class="details"><div><label><?= wfMsg('wikiaquiz-answer-label') ?></label><input type="text" name="answer[]" value="<?= htmlspecialchars($answer['text']) ?>"></div><div><label><?= wfMsg('wikiaquiz-correct-label') ?></label><input type="radio" name="correct" value="<?=$n+1?>" class="correct"<?= $answer['correct'] ? " checked" : "" ?>></div><div><label><?= wfMsg('wikiaquiz-image-label') ?></label><input type="text" name ="answer-image[]" value="<?= htmlspecialchars($answer['imageShort']) ?>"></div></div>
		<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
		<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
	</li>
	<?php } ?>
	</ul>

	<div class="add-new">
		<a href="#" class="wikia-button secondary">+</a><?= wfMsg('wikiaquiz-addnewitem-label') ?>
	</div>

	<div class="toolbar">
		<input type="button" value="<?= wfMsg('wikiaquiz-cancel-label') ?>" class="cancel secondary">
		<input type="button" value="<?= wfMsg('wikiaquiz-publish-label') ?>" class="create">
	</div>

	<input type="hidden" name ="quizElementId" value="<?=$quizElement->getID()?>">

	</form>
</section>
<?php } ?>
