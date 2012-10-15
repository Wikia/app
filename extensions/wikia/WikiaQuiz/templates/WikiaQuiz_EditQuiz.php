<?php if (! isset($quiz)) {
	echo F::app()->renderView('Error', 'Index', array('Quiz does not exist'));
} else { ?>
<div class="CreateWikiaQuiz" id="CreateWikiaQuiz" data-quizid="<?=$quiz->getID()?>">

	<h1><?= wfMsg('wikiaquiz-editquiz-headline') ?></h1>

	<form>

	<label><?= wfMsg('wikiaquiz-title-label') ?></label>
	<div class="title">
		<p><?=$data['name'] ?></p>
	</div>

	<label><?= wfMsg('wikiaquiz-titlescreentext-label') ?></label>
	<div class="titlescreentext">
		<input type="text" name="titlescreentext" value="<?= htmlspecialchars($data['titlescreentext']) ?>">
	</div>

	<label><?= wfMsg('wikiaquiz-fbrecommendationtext-label') ?></label>
	<div class="fbrecommendationtext">
		<input type="text" name="fbrecommendationtext" value="<?= htmlspecialchars($data['fbrecommendationtext']) ?>">
	</div>

	<label><?= wfMsg('wikiaquiz-titlescreenimages-label') ?></label>
	<div class="titlescreenimages">
		<div><input type="text" name="titlescreenimage[]" value="<?= isset($data['imageShorts'][0]) ? htmlspecialchars($data['imageShorts'][0]) : '' ?>"></div>
		<div><input type="text" name="titlescreenimage[]" value="<?= isset($data['imageShorts'][1]) ? htmlspecialchars($data['imageShorts'][1]) : '' ?>"></div>
		<div><input type="text" name="titlescreenimage[]" value="<?= isset($data['imageShorts'][2]) ? htmlspecialchars($data['imageShorts'][2]) : '' ?>"></div>
	</div>

	<label><?= wfMsg('wikiaquiz-moreinfoheading-label') ?></label>
	<div class="moreinfoheading">
		<input type="text" name="moreinfoheading" value="<?= htmlspecialchars($data['moreinfoheading']) ?>">
	</div>

	<label class="requireemail">
		<input type="checkbox" name="requireemail"<?= !empty($data['requireEmail']) ? ' checked' : '' ?>>
		<?= wfMsg('wikiaquiz-requireemail-label') ?>
	</label>

	<label><?= wfMsg('wikiaquiz-moreinfolinks-label') ?></label>
	<div class="moreinfolinks">
		<div><label><?= wfMsg('wikiaquiz-moreinfoarticle-label') ?></label><input type="text" name="moreinfoarticle[]" value="<?= isset($data['moreinfo'][0]['article']) ? htmlspecialchars($data['moreinfo'][0]['article']) : '' ?>"><label><?= wfMsg('wikiaquiz-moreinfolinktext-label') ?></label><input type="text" name="moreinfolinktext[]" value="<?= isset($data['moreinfo'][0]['text']) ? htmlspecialchars($data['moreinfo'][0]['text']) : '' ?>"></div>
		<div><label><?= wfMsg('wikiaquiz-moreinfoarticle-label') ?></label><input type="text" name="moreinfoarticle[]" value="<?= isset($data['moreinfo'][1]['article']) ? htmlspecialchars($data['moreinfo'][1]['article']) : '' ?>"><label><?= wfMsg('wikiaquiz-moreinfolinktext-label') ?></label><input type="text" name="moreinfolinktext[]" value="<?= isset($data['moreinfo'][1]['text']) ? htmlspecialchars($data['moreinfo'][1]['text']) : '' ?>"></div>
		<div><label><?= wfMsg('wikiaquiz-moreinfoarticle-label') ?></label><input type="text" name="moreinfoarticle[]" value="<?= isset($data['moreinfo'][2]['article']) ? htmlspecialchars($data['moreinfo'][2]['article']) : '' ?>"><label><?= wfMsg('wikiaquiz-moreinfolinktext-label') ?></label><input type="text" name="moreinfolinktext[]" value="<?= isset($data['moreinfo'][2]['text']) ? htmlspecialchars($data['moreinfo'][2]['text']) : '' ?>"></div>
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
