<div class="CreateWikiaQuiz" id="CreateWikiaQuiz">

	<h1><?= wfMsg('wikiaquiz-createquiz-headline') ?></h1>

	<form>

	<label><?= wfMsg('wikiaquiz-title-label') ?></label>
	<div class="title">
		<input type="text" name="title">
	</div>

	<label><?= wfMsg('wikiaquiz-titlescreentext-label') ?></label>
	<div class="titlescreentext">
		<input type="text" name="titlescreentext">
	</div>

	<label><?= wfMsg('wikiaquiz-fbrecommendationtext-label') ?></label>
	<div class="fbrecommendationtext">
		<input type="text" name="fbrecommendationtext">
	</div>

	<label><?= wfMsg('wikiaquiz-titlescreenimages-label') ?></label>
	<div class="titlescreenimages">
		<div><input type="text" name="titlescreenimage[]"></div>
		<div><input type="text" name="titlescreenimage[]"></div>
		<div><input type="text" name="titlescreenimage[]"></div>
	</div>

	<label><?= wfMsg('wikiaquiz-moreinfoheading-label') ?></label>
	<div class="moreinfoheading">
		<input type="text" name="moreinfoheading">
	</div>

	<label class="requireemail">
		<input type="checkbox" name="requireemail">
		<?= wfMsg('wikiaquiz-requireemail-label') ?>
	</label>

	<label><?= wfMsg('wikiaquiz-moreinfolinks-label') ?></label>
	<div class="moreinfolinks">
		<div><label><?= wfMsg('wikiaquiz-moreinfoarticle-label') ?></label><input type="text" name="moreinfoarticle[]"><label><?= wfMsg('wikiaquiz-moreinfolinktext-label') ?></label><input type="text" name="moreinfolinktext[]"></div>
		<div><label><?= wfMsg('wikiaquiz-moreinfoarticle-label') ?></label><input type="text" name="moreinfoarticle[]"><label><?= wfMsg('wikiaquiz-moreinfolinktext-label') ?></label><input type="text" name="moreinfolinktext[]"></div>
		<div><label><?= wfMsg('wikiaquiz-moreinfoarticle-label') ?></label><input type="text" name="moreinfoarticle[]"><label><?= wfMsg('wikiaquiz-moreinfolinktext-label') ?></label><input type="text" name="moreinfolinktext[]"></div>
	</div>

	<label><?= wfMsg('wikiaquiz-questions-label') ?></label>
	<ul>
		<li class="new-item">
			<label class="order">#0</label>
			<div class="details"><div><input type="text" name="question[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label class="order">#1</label>
			<div class="details"><div><input type="text" name="question[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label class="order">#2</label>
			<div class="details"><div><input type="text" name="question[]"></div></div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
		<li>
			<label class="order">#3</label>
			<div class="details"><div><input type="text" name="question[]"></div></div>
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