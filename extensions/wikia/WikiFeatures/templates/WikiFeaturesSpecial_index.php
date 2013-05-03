<section class="WikiFeatures" id="WikiFeatures">
	<h2 class="heading-features">
		<?= wfMsg('wikifeatures-heading') ?>
	</h2>
	<p class="creative">
		<?= wfMsg('wikifeatures-creative') ?>
	</p>
	
	<ul class="features">
		<? foreach ($features as $feature) { ?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature, 'editable' => $editable ) ) ?>
		<? } ?>
	</ul>
	
	<h2 class="heading-labs">
		<?= wfMsg('wikifeatures-labs-heading') ?>
	</h2>
	<p class="creative">
		<?= wfMsg('wikifeatures-labs-creative') ?>
	</p>
	
	<ul class="features">
		<? if (!empty($labsFeatures)) { ?>
			<? foreach ($labsFeatures as $feature) { ?>
				<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature, 'editable' => $editable ) ) ?>
			<? } ?>
		<? } else { ?>
		<? 
			$feature = array(
				"name" => "emptylabs"
			); 
		?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature, 'editable' => $editable ) ) ?>
		<? } ?>
	</ul>
</section>
<div id="FeedbackDialog" class="FeedbackDialog">
	<h1><?= wfMsg('wikifeatures-feedback-heading') ?></h1>

	<div class="feature-highlight">
		<h2></h2>
		<img src="<?= $wg->BlankImgUrl ?>">
	</div>

	<form>
		<p><?= wfMsg('wikifeatures-feedback-description') ?></p>
		
		<div class="input-group">
			<label><?= wfMsg('wikifeatures-feedback-type-label') ?></label>
			<select name="feedback">
			<?php foreach (WikiFeaturesHelper::$feedbackCategories as $i => $cat) {
				echo "<option value=\"$i\">".wfMsg($cat['msg'])."</option>";
			} ?>
			</select>
		</div>
		
		<div class="comment-group">
			<label for="comment"><?= wfMsg('wikifeatures-feedback-comment-label') ?>:</label>
			<textarea name="comment"></textarea>
			<span class="comment-character-count">0</span>/1000
		</div>
		
		<input type="submit" value="Submit">
		<span class="status-msg"></span>
	</form>

	
</div>
<div id="DeactivateDialog" class="DeactivateDialog">
	<h1><?= wfMsg('wikifeatures-deactivate-heading') ?></h1>
	<p><?= wfMsg('wikifeatures-deactivate-description') ?></p>
	<p><?= wfMsg('wikifeatures-deactivate-notification') ?></p>
	<nav>
		<button class="cancel secondary"><?= wfMsg('wikifeatures-deactivate-cancel-button') ?></button>
		<button class="confirm"><?= wfMsg('wikifeatures-deactivate-confirm-button') ?></button>
	</nav>
</div>