<form method='post' name='upload-tool' class='WikiaForm UploadTool' enctype="multipart/form-data">
	<? if(!empty($wikiStatus)): ?>
		<div class="status-bar plainlinks">
			<div class="status-wrapper">
				<span class="status-icon">
					<?= wfMessage('promote-statusbar-icon')->text() ?>
				</span>
				<span class="status-arrow"></span>
			</div>
			<?= $wikiStatus ?>
		</div>
	<? endif; ?>
	<p class='introduction plainlinks'>
		<strong>
			<? if ($isCorpLang) : ?>
				<?= wfMessage('promote-introduction-header')->text(); ?>
			<? else: ?>
				<?= wfMessage('promote-nocorp-introduction-header', $wg->Sitename)->text(); ?>
			<? endif ?>
		</strong><br/>
		<? if ($isCorpLang) : ?>
			<?= wfMessage('promote-introduction-copy')->parse(); ?>
		<? else: ?>
			<?= wfMessage('promote-nocorp-introduction-copy')->parse(); ?>
		<? endif ?>
	</p>
	<fieldset>
		<legend><?= wfMessage('promote-description')->text(); ?></legend>

		<div class='input-group required'>
			<label><?= wfMessage('promote-description-header')->text(); ?></label>
			<div class="headline-wrapper">
				<input data-min='<?= $minHeaderLength; ?>' data-max='<?= $maxHeaderLength; ?>' type='text' name='title'
					   value="<?= htmlspecialchars($wikiHeadline); ?>"
					   placeholder='<?= wfMessage('promote-description-header')->text(); ?>'>
				<p class="headline-character-counter"></p>
				<p class="error error-msg"></p>
			</div>
			<span class='explanatory-copy'><?= wfMessage('promote-description-header-explanation')->text(); ?></span>
		</div>
		<div class='input-group required'>
			<label><?= wfMessage('promote-description-about')->text(); ?></label>
			<div class="description-wrapper">
				<textarea data-min='<?= $minDescriptionLength; ?>' data-max='<?= $maxDescriptionLength; ?>' type='text'
						  name='description'
						  placeholder="<?= wfMessage('promote-description-about')->text(); ?>"><?= htmlspecialchars($wikiDesc); ?></textarea>
				<p class="character-counter"></p>
				<p class="error error-msg"></p>
			</div>
			<span class='explanatory-copy'><?= wfMessage('promote-description-about-explanation')->text(); ?></span>
		</div>
	</fieldset>

	<fieldset>
		<legend><?= wfMessage('promote-upload')->text(); ?></legend>

		<div class='input-group main-image required'>
			<label><?= wfMessage('promote-upload-main-photo-header')->text(); ?></label>
			<a href="#" data-image-type="main" class="wikia-button upload-button" title="<?= wfMessage('promote-add-photo')->text(); ?>">
				<img src="<?= $wg->BlankImgUrl; ?>" class="sprite photo" />
				<?= wfMessage('promote-add-photo')->text(); ?>
			</a>
			<br class="clear" />
			<div class='large-photo'>
				<div class="modify-remove">
					<a class="modify" href="#"><?= wfMessage('promote-modify-photo')->text(); ?></a>
				</div>
				<?php if (!empty($mainImage)): ?>
					<div class="status">
						<div class="rejected<?= ($mainImage['review_status'] == ImageReviewStatuses::STATE_REJECTED) ? '' : ' hidden' ?>">
							<p><span>
								<?= wfMessage('promote-image-rejected')->text();?> <img src="<?= $wg->BlankImgUrl ?>" class="error">
							</span></p>
						</div>
						<div class="accepted<?= ($mainImage['review_status'] == ImageReviewStatuses::STATE_APPROVED) ? '' : ' hidden' ?>">
							<p><span>
								<?= wfMessage('promote-image-accepted')->text();?> <img src="<?= $wg->BlankImgUrl ?>" class="ok">
							</span></p>
						</div>
						<div class="reviewed<?=
							in_array($mainImage['review_status'],array(
								ImageReviewStatuses::STATE_UNREVIEWED,
								ImageReviewStatuses::STATE_IN_REVIEW,
								ImageReviewStatuses::STATE_QUESTIONABLE,
								ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW
							)) ? '' : ' hidden'
							?>">
							<p><span>
								<?= wfMessage('promote-image-in-review')->text();?>
							</span></p>
						</div>
					</div>
					<img
						id="curMainImageName"
						src="<?= $mainImage['image_url']; ?>"
						data-filename="<?= $mainImage['image_filename']; ?>"
						data-image-type="main" />
				<? endif; ?>
			</div>
			<span class='explanatory-copy'>
				<? if ($isCorpLang) : ?>
					<?= wfMessage('promote-upload-main-photo-explanation')->text(); ?>
				<? else: ?>
					<?= wfMessage('promote-nocorp-upload-main-photo-explanation')->text(); ?>
				<? endif ?>
			</span>
		</div>
		<div class='input-group more-images required'>
			<label><?= wfMessage('promote-upload-additional-photos-header')->text(); ?></label>
			<a href="#" data-image-type="additional" class="wikia-button upload-button" title="<?= wfMessage('promote-add-photo')->text(); ?>">
				<img src="<?= $wg->BlankImgUrl; ?>" class="sprite photo" />
				<?= wfMessage('promote-add-photo')->text(); ?>
			</a>
			<br class="clear" />
			<div class='small-photos'>
				<? if (!empty($additionalImages)): ?>
					<? $i=1; foreach ($additionalImages as $image): ?>
						<div class="small-photos-wrapper">
							<div class="modify-remove">
								<a class="modify" href="#"><?= wfMessage('promote-modify-photo')->text() ?></a>
								<a class="remove" href="#"><?= wfMessage('promote-remove-photo')->text() ?></a>
							</div>
							<div class="status">
								<div class="rejected<?= ($image['review_status'] == ImageReviewStatuses::STATE_REJECTED) ? '' : ' hidden' ?>">
									<p><span>
										<?= wfMessage('promote-image-rejected')->text();?> <img src="<?= $wg->BlankImgUrl ?>" class="error">
									</span></p>
								</div>
								<div class="accepted<?= ($image['review_status'] == ImageReviewStatuses::STATE_APPROVED) ? '' : ' hidden' ?>">
									<p><span>
										<?= wfMessage('promote-image-accepted')->text();?> <img src="<?= $wg->BlankImgUrl ?>" class="ok">
									</span></p>
								</div>
								<div class="reviewed<?=
									in_array($image['review_status'],array(
										ImageReviewStatuses::STATE_UNREVIEWED,
										ImageReviewStatuses::STATE_IN_REVIEW,
										ImageReviewStatuses::STATE_QUESTIONABLE,
										ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW
									)) ? '' : ' hidden'
									?>">
									<p><span>
										<?= wfMessage('promote-image-in-review')->text();?>
									</span></p>
								</div>
							</div>
							<img
								src="<?= $image['image_url']; ?>"
								class="additionalImage"
								data-filename="<?= $image['image_filename']; ?>"
								data-image-index="<?= $i ?>"
								data-image-type="additional"
							/>
						</div>
					<? $i++; endforeach; ?>
				<? endif; ?>
			</div>
			<span class='explanatory-copy'><?= wfMessage('promote-upload-additional-photos-explanation')->text(); ?></span>
			<p class="error error-msg"></p>
		</div>
	</fieldset>

	<div class='submits'>
		<input type='submit' value='<?= wfMessage('promote-publish')->text(); ?>' class='button big' name='publish'>
	</div>
</form>
