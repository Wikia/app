<div class="CreateWikiaQuizArticle" id="CreateWikiaQuizArticle">

	<h1><?= wfMsg('wikiaquiz-createquizarticle-headline') ?></h1>

	<form>
	<label><?= wfMsg('wikiaquiz-question-label') ?></label>
	<div class="question">
		<input type="text" name="question">
	</div>

	<label><?= wfMsg('wikiaquiz-image-label') ?></label>
	<div class="image">
		<input type="text" name="image">
	</div>

<? /* Video is broken and has been for a while.  Commenting this out so users don't get the idea they can use it.
	<label><?= wfMsg('wikiaquiz-video-label') ?></label>
	<div class="image">
		<input type="text" name="video">
	</div>
*/ ?>
	<input type="hidden" name="video">

	<label><?= wfMsg('wikiaquiz-explanation-label') ?></label>
	<div class="explanation">
		<textarea name="explanation"></textarea>
	</div>

	<label><?= wfMsg('wikiaquiz-quiz-label') ?></label>
	<div class="quiz">
		<input type="quiz" name="quiz">
	</div>

	<label><?= wfMsg('wikiaquiz-answers-label') ?></label>
	<ul>
		<li class="new-item">
			<label class="order">#0</label>
			<div class="details"><div><label><?= wfMsg('wikiaquiz-answer-label') ?></label><input type="text" name="answer[]"></div><div><label><?= wfMsg('wikiaquiz-correct-label') ?></label><input type="radio" name="correct" value="0" class="correct"></div><div><label><?= wfMsg('wikiaquiz-image-label') ?></label><input type="text" name ="answer-image[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label class="order">#1</label>
			<div class="details"><div><label><?= wfMsg('wikiaquiz-answer-label') ?></label><input type="text" name="answer[]"></div><div><label><?= wfMsg('wikiaquiz-correct-label') ?></label><input type="radio" name="correct" value="1" class="correct"></div><div><label><?= wfMsg('wikiaquiz-image-label') ?></label><input type="text" name ="answer-image[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label class="order">#2</label>
			<div class="details"><div><label><?= wfMsg('wikiaquiz-answer-label') ?></label><input type="text" name="answer[]"></div><div><label><?= wfMsg('wikiaquiz-correct-label') ?></label><input type="radio" name="correct" value="2" class="correct"></div><div><label><?= wfMsg('wikiaquiz-image-label') ?></label><input type="text" name ="answer-image[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label class="order">#3</label>
			<div class="details"><div><label><?= wfMsg('wikiaquiz-answer-label') ?></label><input type="text" name="answer[]"></div><div><label><?= wfMsg('wikiaquiz-correct-label') ?></label><input type="radio" name="correct" value="3" class="correct"></div><div><label><?= wfMsg('wikiaquiz-image-label') ?></label><input type="text" name ="answer-image[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
	</ul>

	<div class="add-new">
		<a href="#" class="wikia-button secondary">+</a><?= wfMsg('wikiaquiz-addnewitem-label') ?>
	</div>

	<div class="toolbar">
		<input type="button" value="<?= wfMsg('wikiaquiz-cancel-label') ?>" class="cancel secondary">
		<input type="button" value="<?= wfMsg('wikiaquiz-publish-label') ?>" class="create">
	</div>

	</form>
</div>