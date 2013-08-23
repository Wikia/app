<form class="WikiaForm vpt-form" method="post" action="#">

	<? for( $x = 1; $x <= 5; $x++ ): ?>

		<div class="form-box featured-video with-nav">
			<span class="count"><?= $x ?>.</span>
			<div class="input-group">
				<button class="add-video-button"><?= wfMessage( 'videopagetool-button-add-video' )->text() ?></button>
				<p class="video-name alternative"><?= wfMessage( 'videopagetool-video-title-default-text' )->text() ?></p>
			</div>
			<div class="video-thumb"></div>
			<div class="input-group border">
				<label for="video_display_title"><?= wfMessage( 'videopagetool-label-display-title' )->text() ?></label>
				<input class="required" id="video_display_title" type="text" name="display_title[]">
			</div>
			<div class="input-group">
				<label for="video_description"><?= wfMessage( 'videopagetool-label-video-description' )->text() ?></label>
				<textarea id="video_description" placeholder="<?= wfMessage( 'videopagetool-placeholder-video-description' )->text() ?>" name="description[]"></textarea>
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
		<button><?= wfMessage( 'videopagetool-button-save' )->text() ?></button>
		<button class="secondary"><?= wfMessage( 'videopagetool-button-clear' )->text() ?></button>
	</div>

</form>

