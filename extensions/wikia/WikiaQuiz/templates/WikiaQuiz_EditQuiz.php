<?php if (! isset($quiz)) {
	echo wfRenderModule('Error', 'Index', array('Quiz does not exist'));
} else { ?>
<div class="CreateWikiaQuiz" id="CreateWikiaQuiz" data-quizId="<?=$quiz->getID()?>">

	<h1><?= wfMsg('wikiaquiz-editquiz-headline') ?></h1>
	
	<form>
		
	<label><?= wfMsg('wikiaquiz-title-label') ?></label>	
	<div class="title">
		<p><?=$data['name'] ?></p>
	</div>

	<label><?= wfMsg('wikiaquiz-questions-label') ?></label>	
	<ul>
		<li class="new-item">
			<label class="order">#0</label>
			<div class="details"><div><input type="text" name="question[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<?php foreach($data['elements'] as $n => $element) { ?>
		<li>
			<label class="order"><?="#".($n+1)?></label>
			<div class="details"><div><input type="text" name="question[]" value="<?=$element['question'] ?>"></div></div>
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
	
	<input type="hidden" name ="quizId" value="<?=$quiz->getID()?>">

	</form>
</div>
<?php } ?>