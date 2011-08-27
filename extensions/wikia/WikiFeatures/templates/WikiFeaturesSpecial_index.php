<section class="WikiFeatures" id="WikiFeatures">
	<h2>
		<?= wfMsg('wikifeatures-heading') ?>
	</h2>
	<p>
		<?= wfMsg('wikifeatures-creative') ?>
	</p>
	
	<ul class="features">
		<? foreach ($features as $feature) { ?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature ) ) ?>
		<? } ?>
	</ul>
	
	<h2>
		<?= wfMsg('wikifeatures-labs-heading') ?>
	</h2>
	<p>
		<?= wfMsg('wikifeatures-labs-creative') ?>
	</p>
	
	<ul class="features">
		<? foreach ($labsFeatures as $feature) { ?>
			<?= F::app()->getView( 'WikiFeaturesSpecial', 'feature', array('feature' => $feature ) ) ?>
		<? } ?>
	</ul>
</section>
<div id="FeedbackDialog" class="FeedbackDialog">
	<h1>Feedback</h1>

	<div class="feature-highlight">
		<h2>Wikia Editor Redesign</h2>
		<img src="<?= $wg->BlankImgUrl ?>">
	</div>

	<form>
		<p>We love getting feedback on features that are in WikiaLabs.  If you have an idea for how we can improve this feature, or if you have discovered a bug, please add a comment below and the people working on this feature will get your message.</p>
		<label>Your rating:</label>
		<div class="star-rating" >
			<? for ($i = 0; $i < 5; $i++) { ?>
				<img src="<?= $wg->BlankImgUrl ?>">
			<? } ?>
		</div>
		<input type="hidden" name="rating" value="0">
		
		<label>What's this about?</label>
		<select name="feedback">
			<option value="">Select box</option>
		</select>
		
		<div style="clear:both"></div>
		
		<label for="comment">Comment:</label>
		<textarea name="comment"></textarea>
		
		<span class="comment-character-count">0/1000</span>
		
		<input type="submit" value="Submit">
	</form>

	
</div>