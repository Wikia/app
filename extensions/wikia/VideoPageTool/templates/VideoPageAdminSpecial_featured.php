<form class="WikiaForm vpt-form" method="post">

	<? for( $x = 1; $x <= count($videos); $x++ ): ?>

		<?
			$video = $videos[ $x ];
			$descriptionMaxLength = "200";

			// hide large image preview link if there's no large image yet.
			$previewLinkDisplayClass = empty( $video[ 'altThumbKey' ] ) ? "hidden" : "";
		?>

		<div class="form-box featured-video with-nav">
			<span class="count"><?= $x ?>.</span>

			<div class="input-group button-group">
				<button type="button" class="add-video-button media-btn">
					<?= wfMessage( 'videopagetool-button-add-video' )->escaped(); ?>
				</button>
				<p class="video-title <?= Sanitizer::encodeAttribute( $video[ 'videoTitleClass' ] ); ?>">
					<?= htmlspecialchars( $video['videoTitle' ] ); ?>
				</p>
				<input type="hidden" name="videoKey[]" class="video-key" id="video-key-<?= $x ?>"
				       value="<?= Sanitizer::encodeAttribute( $video[ 'videoKey' ] ); ?>">
			</div>

			<div class="video-thumb-wrapper">
				<div class="video-thumb">
					<?= $video[ 'videoThumb' ]; ?>
				</div>
				<a class="preview-large-link <?= $previewLinkDisplayClass ?>" href="<?= Sanitizer::encodeAttribute( $video[	'largeThumbUrl' ] ); ?>" target="_blank">
					Preview large version
				</a>
			</div>

			<div class="input-group button-group">
				<button type="button" class="media-uploader-btn media-btn">
					<?= wfMessage( 'videopagetool-button-add-thumbnail' )->escaped(); ?>
				</button>

				<p class="alt-thumb-name <?= Sanitizer::encodeAttribute( $video[ 'altThumbClass'] ); ?>">
					<? $thumbText = $video[ 'altThumbName' ] ?>
					<?= $thumbText == '' ? wfMessage('videopagetool-image-title-default-text')->escaped() : htmlspecialchars( $thumbText ); ?>
				</p>

				<input type="hidden" name="altThumbKey[]" class="alt-thumb" id="alt-thumb-<?= $x ?>" value="<?= Sanitizer::encodeAttribute( $video[ 'altThumbKey' ] ); ?>">
				<div class="hint"><?= wfMessage('videopagetool-hint-required-dimensions')->escaped(); ?></div>
			</div>

			<div class="input-group border">
				<label for="display-title-<?= $x ?>">
					<?= wfMessage( 'videopagetool-label-display-title' )->escaped() ?>
				</label>
				<input class="display-title" id="display-title-<?= $x ?>" type="text" name="displayTitle[]" value="<?= Sanitizer::encodeAttribute( $video[ 'displayTitle' ] ); ?>">
			</div>

			<div class="input-group">
				<label for="description-<?= $x ?>">
					<?= wfMessage( 'videopagetool-label-video-description' )->escaped() ?>
				</label>
				<textarea
					maxlength="<?= $descriptionMaxLength ?>"
					class="description"
					id="description-<?= $x ?>"
					placeholder="<?= wfMessage( 'videopagetool-placeholder-video-description' )->escaped() ?>"
					name="description[]"><?= $video[ 'description' ]; ?></textarea>
				<p class="hint">
					<?= wfMessage( 'videopagetool-hint-description-maxlength' )
						->numParams( $descriptionMaxLength )
						->escaped();
					?>
				</p>
			</div>

			<button type="button" class="secondary navigation nav-up">
				<img class="chevron chevron-up" src="<?= $wg->BlankImgUrl ?>">
			</button>

			<button type="button" class="secondary navigation nav-down">
				<img class="chevron chevron-down" src="<?= $wg->BlankImgUrl ?>">
			</button>
		</div>
	<? endfor; ?>

	<input type="hidden" value="<?= Sanitizer::encodeAttribute( $date ); ?>" name="date">
	<input type="hidden" value="<?= Sanitizer::encodeAttribute( $language ); ?>" name="language">

	<div class="submits">
		<button type="submit"><?= wfMessage( 'videopagetool-button-save' )->escaped() ?></button>
		<button type="button" class="secondary reset"><?= wfMessage( 'videopagetool-button-clear' )->escaped() ?></button>
	</div>

</form>

