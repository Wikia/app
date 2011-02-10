<section class="CreateWikiaPoll" id="CreateWikiaPoll" data-pollId="<?=$poll->getID()?>">

	<h1>Edit Poll</h1>
	
	<form>
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
		<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
		<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
	</li>
	<?php foreach($data['answers'] as $n => $answer) { ?>
		<li>
			<label><?="#".($n+1)?></label>
			<span><input type="text" name ="answer[]" value="<?= htmlspecialchars($answer['text']) ?>"></span>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
	<?php } ?>
	</ul>
	
	<div class="add-new">
		<a href="#" class="wikia-button secondary">+</a>Add new item
	</div>
	
	<div class="toolbar">
		<input type="button" value="Cancel" class="cancel secondary">
		<input type="button" value="Edit Poll" class="create">
	</div>
	
	<input type="hidden" name ="pollId" value="<?=$poll->getID()?>">

	</form>
</section>