<div class="CreateWikiaPoll" id="CreateWikiaPoll">

	<h1><?= wfMsg('wikiapoll-createpoll-headline') ?></h1>
	
	<form>
	<label><?= wfMsg('wikiapoll-question-label') ?></label>
	
	<div class="question">
		<span><?= wfMsg("wikiapoll-question-mark-before") ?></span>
		<input type="text" name="question">
		<span><?= wfMsg("wikiapoll-question-mark-after") ?></span>
	</div>
	
	<ul>
		<li class="new-item">
			<label>#0</label>
			<span><input type="text" name ="answer[]"></span>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label>#1</label>
			<span><input type="text" name="answer[]"></span>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label>#2</label>
			<span><input type="text" name="answer[]"></span>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label>#3</label>
			<span><input type="text" name="answer[]"></span>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
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