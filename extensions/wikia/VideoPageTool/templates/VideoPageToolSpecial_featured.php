<form class="WikiaForm vpt-form" method="post" action="#">

	<? for( $x = 1; $x <= 5; $x++ ): ?>

		<?
		// TODO: there's probably still some work to sync this up with the controller properly
		$video = $videos[ $x ];
		$videoTitle = $video[ 'videoTitle' ];
		$displayTitle = $video[ 'displayTitle' ]; // TODO: if there's no display title, make sure we send the default text (videopagetool-video-title-default-text)
		$displayTitleClass = 'alternative'; // TODO: make sure this logic is in the controller too
		$videoDescription = $video[ 'description' ];
		$videoKey = $video[ 'videoKey' ];
		$videoThumb = $video[ 'videoThumb' ];

		?>

		<div class="form-box featured-video with-nav">
			<span class="count"><?= $x ?>.</span>
			<div class="input-group url-group">
				<button class="add-video-button"><?= wfMessage( 'videopagetool-button-add-video' )->text() ?></button>
				<p class="video-name <?= $displayTitleClass ?>"><?= $displayTitle  ?></p>
				<input type="hidden" name="video_url" class="video_url" id="video_url_<?= $x ?>" value="<?= $videoKey ?>">
			</div>
			<div class="video-thumb"><?= $videoThumb ?></div>
			<div class="input-group border">
				<label for="video_display_title_<?= $x ?>"><?= wfMessage( 'videopagetool-label-display-title' )->text() ?></label>
				<input class="video_display_title" id="video_display_title_<?= $x ?>" type="text" name="display_title[]" value="<?= $videoTitle ?>">
			</div>
			<div class="input-group">
				<label for="video_description_<?= $x ?>"><?= wfMessage( 'videopagetool-label-video-description' )->text() ?></label>
				<textarea class="video_description" id="video_description_<?= $x ?>" placeholder="<?= wfMessage( 'videopagetool-placeholder-video-description' )->text() ?>" name="description[]"><?= $videoDescription ?></textarea>
				<p class="alternative char-count"><!-- TODO: add char counter here --></p>
			</div>
			<button class="secondary navigation nav-up">
				<img class="chevron chevron-up" src="<?= $wg->BlankImgUrl ?>">
			</button>
			<button class="secondary navigation nav-down">
				<img class="chevron chevron-down" src="<?= $wg->BlankImgUrl ?>">
			</button>
		</div>

	<? endfor; ?>

	<input type="hidden" value="<?= $date ?>" name="date">
	<input type="hidden" value="<?= $language ?>" name="language">

	<div class="submits">
		<button type="submit"><?= wfMessage( 'videopagetool-button-save' )->text() ?></button>
		<button class="secondary reset"><?= wfMessage( 'videopagetool-button-clear' )->text() ?></button>
	</div>

</form>

