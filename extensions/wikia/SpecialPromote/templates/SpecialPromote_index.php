<form method='post' name='upload-tool' class='WikiaForm UploadTool' enctype="multipart/form-data">
	<p class='introduction'>
		<strong><?= wfMsg('promote-introduction-header'); ?></strong><br/>
		<?= wfMsg('promote-introduction-copy'); ?>
	</p>
	<fieldset>
		<legend><?= wfMsg('promote-description'); ?></legend>

		<div class='input-group required'>
			<label><?= wfMsg('promote-description-header'); ?></label>
			<p class="error"></p>
			<div class="description-wrapper">
				<input data-min='<?= $minHeaderLength; ?>' data-max='<?= $maxHeaderLength; ?>' type='text' name='title'
					   value="<?= $wikiHeadline; ?>"
					   placeholder='<?= wfMsg('promote-description-header'); ?>'>
			</div>
			<span class='explanatory-copy'><?= wfMsg('promote-description-header-explanation'); ?></span>
		</div>
		<div class='input-group required'>
			<label><?= wfMsg('promote-description-about'); ?></label>
			<p class="error"></p>
			<div class="description-wrapper">
				<textarea data-min='<?= $minDescriptionLength; ?>' data-max='<?= $maxDescriptionLength; ?>' type='text'
						  name='description'
						  placeholder="<?= wfMsg('promote-description-about'); ?>"><?= $wikiDesc; ?></textarea>
				<p class="character-counter"></p>
			</div>
			<span class='explanatory-copy'><?= wfMsg('promote-description-about-explanation'); ?></span>
		</div>
	</fieldset>

	<fieldset>
		<legend><?= wfMsg('promote-upload'); ?></legend>

		<div class='input-group main-image required'>
			<label><?= wfMsg('promote-upload-main-photo-header'); ?></label>
			<a href="#" data-image-type="main" class="wikia-button upload-button" title="<?= wfMsg('promote-add-photo'); ?>">
				<img src="<?= $wg->BlankImageUrl; ?>" class="sprite photo" />
				<?= wfMsg('promote-add-photo'); ?>
			</a>
			<br class="clear" />
			<div class='large-photo'>
				<div class="modify-remove">
					<a class="modify" href="#"><?= wfMsg('promote-modify-photo'); ?></a>
				</div>
				<?php if (!empty($mainImage)): ?>
					<img id="curMainImageName" src="<?= $mainImage['image_url']; ?>" data-filename="<?= $mainImage['image_filename']; ?>" />
				<? endif; ?>
			</div>
			<span class='explanatory-copy'><?= wfMsg('promote-upload-main-photo-explanation'); ?></span>
		</div>
		<div class='input-group more-images required'>
			<label><?= wfMsg('promote-upload-additional-photos-header'); ?></label>
			<a href="#" data-image-type="additional" class="wikia-button upload-button" title="<?= wfMsg('promote-add-photo'); ?>">
				<img src="<?= $wg->BlankImageUrl; ?>" class="sprite photo" />
				<?= wfMsg('promote-add-photo'); ?>
			</a>
			<br class="clear" />
			<p class="error"></p>
			<div class='small-photos'>
				<? if (!empty($additionalImages)): ?>
					<? $i=1; foreach ($additionalImages as $image): ?>
						<div class="small-photos-wrapper">
							<div class="modify-remove">
								<a class="modify" href="#"><?= wfMsg('promote-modify-photo') ?></a>
								<a class="remove" href="#"><?= wfMsg('promote-remove-photo') ?></a>
							</div>
							<img
								src="<?= $image['image_url']; ?>"
								data-filename="<?= $image['image_filename']; ?>"
								data-imageIndex="<?= $i ?>"
								data-imageType="additional"
							/>
						</div>
					<? $i++; endforeach; ?>
				<? endif; ?>
			</div>
			<span class='explanatory-copy'><?= wfMsg('promote-upload-additional-photos-explanation'); ?></span>
		</div>
	</fieldset>

	<div class='submits'>
		<input type='submit' value='<?= wfMsg('promote-publish'); ?>' class='button big' name='publish'>
	</div>
</form>
