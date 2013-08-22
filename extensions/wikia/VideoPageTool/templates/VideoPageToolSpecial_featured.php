<form class="WikiaForm" method="post">
	<div class="form-box featured-video with-nav">
		<div class="input-group">
			<button class="add-video-button"><?= wfMessage( 'videopagetool-button-add-video' )->text() ?></button>
			<p class="video-name alternative"><?= wfMessage( 'videopagetool-video-title-default-text' )->text() ?></p>
		</div>
		<div class="video-thumb"></div>
		<div class="input-group border">
			<label><?= wfMessage( 'videopagetool-label-display-title' )->text() ?></label>
			<input type="text" name="display_title[]">
		</div>
		<div class="input-group">
			<label><?= wfMessage( 'videopagetool-label-video-description' )->text() ?></label>
			<textarea placeholder="<?= wfMessage( 'videopagetool-placeholder-video-description' )->text() ?>"></textarea>
			<p class="alternative char-count"><!-- TODO: add char counter here --></p>
		</div>
		<button class="secondary navigation nav-up">
			<img class="chevron chevron-up" src="<?= $wg->BlankImgUrl ?>">
		</button>
		<button class="secondary navigation nav-down">
			<img class="chevron" src="<?= $wg->BlankImgUrl ?>">
		</button>
	</div>
</form>