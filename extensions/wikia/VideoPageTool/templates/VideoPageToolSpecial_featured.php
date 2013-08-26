<form class="WikiaForm vpt-form" method="post" action="#">

	<? for( $x = 1; $x <= 5; $x++ ): ?>

		<div class="form-box featured-video with-nav">
			<span class="count"><?= $x ?>.</span>
			<div class="input-group url-group">
				<button class="add-video-button"><?= wfMessage( 'videopagetool-button-add-video' )->text() ?></button>
				<p class="video-name alternative"><?= wfMessage( 'videopagetool-video-title-default-text' )->text() ?></p>
				<input type="hidden" name="video_url" class="video_url" id="video_url_<?= $x ?>">
			</div>
			<div class="video-thumb"></div>
			<div class="input-group border">
				<label for="video_display_title_<?= $x ?>"><?= wfMessage( 'videopagetool-label-display-title' )->text() ?></label>
				<input class="video_display_title" id="video_display_title_<?= $x ?>" type="text" name="display_title[]">
			</div>
			<div class="input-group">
				<label for="video_description_<?= $x ?>"><?= wfMessage( 'videopagetool-label-video-description' )->text() ?></label>
				<textarea class="video_description" id="video_description_<?= $x ?>" placeholder="<?= wfMessage( 'videopagetool-placeholder-video-description' )->text() ?>" name="description[]"></textarea>
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

	<div class="submits">
		<button type="submit"><?= wfMessage( 'videopagetool-button-save' )->text() ?></button>
		<button class="secondary reset"><?= wfMessage( 'videopagetool-button-clear' )->text() ?></button>
	</div>

</form>

