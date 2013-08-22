<form class="WikiaForm" method="post">
	<div class="form-box featured-video">
		<div class="form-box-rail">
			<div class="video-thumb"></div>
		</div>
		<div class="form-box-inner">
			<div class="input-group">
				<button class="add-video-button"><?= wfMessage( 'videopagetool-button-add-video' )->text() ?></button>
				<p class="video-name alternative"><?= wfMessage( 'videopagetool-video-title-default-text' )->text() ?></p>
			</div>
			<div class="input-group">
				<label><?= wfMessage( 'videopagetool-label-display-title' )->text() ?></label>
				<input type="text">
			</div>
			<div class="input-group last">
				<label><?= wfMessage( 'videopagetool-label-video-description' )->text() ?></label>
				<textarea placeholder="<?= wfMessage( 'videopagetool-placeholder-video-description' )->text() ?>"></textarea>
				<p class="alternative char-count"><!-- TODO: add char counter here --></p>
			</div>
			<p class='tip alternative'>
				<?= wfMessage('videopagetool-html-text-tip')->parse() ?>
			</p>
		</div>
	</div>
</form>