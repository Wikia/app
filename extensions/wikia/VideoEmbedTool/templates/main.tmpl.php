<?php
	global $wgStylePath, $wgUser, $wgScript, $wgExtensionsPath;
?>

<h1 id="VideoEmbedTitle"><?= wfMsg( 'vet-title' ) ?></h1>
<section>
	<form action="<?= $wgScript ?>?action=ajax&rs=VET&method=insertVideo" id="VideoEmbedForm" class="WikiaForm" method="POST">
	<?php if( !$wgUser->isAllowed( 'upload' ) ) {
		if( !$wgUser->isLoggedIn() ) {
			echo '<a id="VideoEmbedLoginMsg">' .wfMsg( 'vet-notlogged' ) . '</a>';
		} else {
			echo wfMsg( 'vet-notallowed' );
		}
	} else {
		if ($error) { ?>
		<span id="VET_error_box" class="VET_error_box"><?= $error ?></span>
		<?php } ?>
		<div class="input-group">
			<label for="VideoEmbedUrl" class="with-info-p"><?= wfMsg('vet-url-label') ?></label>
			<div>
				<p><?= wfMessage('vet-description')->parse(); ?></p>
				<input id="VideoEmbedUrl" class="VideoEmbedUrl" name="wpVideoEmbedUrl" type="text" />
			</div>
		</div>
	<?php } ?>
		<a id="VideoEmbedUrlSubmit" class="wikia-button VideoEmbedUrlSubmit" style="display: block; "><?= wfMsg('vet-upload-btn') ?></a>
	</form>
	<form action="" class="WikiaForm VET-search" id="VET-search-form">
		<div class="input-group">
			<label for="VET-search-field"><?= wfMsg( 'vet-search-label' ) ?></label>
			<input type="text" class="VET-search-field" id="VET-search-field" name="VET-search-field" placeholder="<?= wfMsg( 'vet-search-placeholder' ) ?>" />
			<input type="submit" id="VET-search-submit" class="wikia-button VET-search-submit" value="<?= wfMsg( 'vet-search-label' ) ?>" />
		</div>
		<div class="VET-search-filter">

			<div class="WikiaDropdown MultiSelect VET-search-dropdown" id="VET-search-dropdown" data-selected="<?php echo($vet_premium_videos_search_enabled) ? 'premium' : 'local';  ?>"> <? // <- VET.js takes value from here ?>
				<div class="selected-items">
					<?php if ($vet_premium_videos_search_enabled) : ?>
						<span class="selected-items-list" data-sort="premium"><?=wfMsg( 'vet-video-wiki' ) ?></span>
					<?php else : ?>
						<span class="selected-items-list" data-sort="local"><?=wfMsg( 'vet-thiswiki' ) ?></span>
					<?php endif; ?>
					<img class="arrow" src="<?=wfBlankImgUrl();?>" />
				</div>
				<div class="dropdown">
					<ul class="dropdown-list">
						<?php if ($vet_premium_videos_search_enabled) : ?>
							<li class="dropdown-item">
								<label data-sort="premium"><?=wfMsg( 'vet-video-wiki' ) ?></label>
							</li>
						<?php endif; ?>
						<li class="dropdown-item">
							<label data-sort="local"><?=wfMsg( 'vet-thiswiki' ) ?></label>
						</li>
					</ul>
				</div>
			</div>
			<label class="dropdown-label"><?=wfMsg( 'vet-search-filter-caption' )?></label>
		</div>
	</form>
	<div id="VET-carousel-wrapper" class="VET-carousel-wrapper">
		<p class="results suggestions-results show"><strong><?= wfMsg( 'vet-suggestions' ) ?></strong></p>
		<a class="back-link"><?= wfMsg( 'vet-back-to-suggestions' ) ?></a>
		<div id="VET-preview" class="VET-preview">
			<div id="VET-preview-close" class="VET-preview-close">
				<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="sprite close" alt="Close">
			</div>
			<!-- add video button -->
			<?php if($showAddVideoBtn): ?>
				<a id="VET-add-from-preview" href="" class="wikia-button VET-add-from-preview"><?= wfMessage('vet-add-from-preview')->text() ?></a>
			<?php endif; ?>
			<div id="VET-video-wrapper" class="VET-video-wrapper"></div>
		</div>
		<div class="VET-suggestions-wrapper" id="VET-suggestions-wrapper">
			<div class="button vertical secondary scrollleft" >
				<img src="<?=wfBlankImgUrl();?>" class="chevron" />
			</div>
			<div id="VET-suggestions" class="VET-suggestions">
				<div>
					<p><?= wfMsg('vet-no-results-found') ?></p>
					<ul class="carousel"></ul>
				</div>
			</div>
			<div class="button vertical secondary scrollright">
				<img src="<?=wfBlankImgUrl();?>" class="chevron" />
			</div>
		</div>
	</div>
</section>
<a href="" class="bottom-close-button wikia-button secondary vet-close"><?= wfMsg('vet-close') ?></a>
