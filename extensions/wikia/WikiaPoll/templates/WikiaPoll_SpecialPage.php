<section class="CreateWikiaPoll" id="CreateWikiaPoll">

	<h1>Create Poll</h1>
	
	<form>
	<label>question</label>
	
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
		<a href="#" class="wikia-button secondary">+</a>Add new item
	</div>
	
	<div class="toolbar">
		<input type="button" value="Cancel" class="cancel secondary">
		<input type="button" value="Create Poll" class="create">
	</div>
	
	</form>
</section>