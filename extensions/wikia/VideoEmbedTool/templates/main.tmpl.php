<?php
	$uploadmesg = wfMsgExt( 'vet-uploadtext', 'parse' );
	$uploadmesg = preg_replace( '/(<a[^>]+)/', '$1 target="_blank" ', $uploadmesg );
?>

<?php
	global $wgStylePath, $wgUser, $wgScript, $wgExtensionsPath;
?>

<h1 id="VideoEmbedTitle"><?= wfMsg( 'vet-title' ) ?></h1>
<section class="modalContent">
	<img src="<?= $wgStylePath; ?>/common/images/ajax.gif" id="VideoEmbedProgress2" style="display: none;"/>
	<form action="<?= $wgScript ?>?action=ajax&rs=VET&method=insertVideo" id="VideoEmbedForm" class="WikiaForm" method="POST">
	<?php if( !$wgUser->isAllowed( 'upload' ) ) {
		if( !$wgUser->isLoggedIn() ) {
			echo '<a id="VideoEmbedLoginMsg">' .wfMsg( 'vet-notlogged' ) . '</a>';
		} else {
			echo wfMsg( 'vet-notallowed' );
		}
	} else {
		if ($error) { ?>
		<span id="VET_error_box"><?= $error ?></span>
		<?php } ?>		
		<div class="input-group">
			<label for="VideoEmbedUrl" class="with-info-p"><?= wfMsg('vet-url-label') ?></label>
			<div>
				<p><?= wfMsg( 'vet-description' ) ?> <a href="http://help.wikia.com/wiki/Help:Video_Embed_Tool" target="_blank"><?= wfMsg( 'vet-see-all' ) ?></a></p>
				<input id="VideoEmbedUrl" name="wpVideoEmbedUrl" type="text" onkeypress="VET_onVideoEmbedUrlKeypress(event);" />
			</div>
		</div>
	<?php } ?>
		<a id="VideoEmbedUrlSubmit" class="wikia-button" style="display: block; " onclick="return VET_preQuery(event);" ><?= wfMsg('vet-upload-btn') ?></a>
	</form>
	<form action="" class="WikiaForm VET-search" id="VET-search-form">
		<div class="input-group">
			<label for="VET-search-field"><?= wfMsg( 'vet-search-label' ) ?></label>
			<input type="text" class="VET-search-field" id="VET-search-field" name="VET-search-field" placeholder="<?= wfMsg( 'vet-search-placeholder' ) ?>" />
			<input type="submit" id="VET-search-submit" class="wikia-button" value="<?= wfMsg( 'vet-search-label' ) ?>" />
		</div>
		<div id="VET-search-filter">

			<div class="WikiaDropdown MultiSelect" id="VET-search-dropdown" data-selected="<?php echo($vet_premium_videos_search_enabled) ? 'premium' : 'local';  ?>"> <? // <- VET.js takes value from here ?>
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
			<a id="VET-add-from-preview" href="" class="wikia-button VET-add-from-preview"><?= wfMsg('vet-add-from-preview') ?></a>
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
<a href="" id="bottom-close-button" class="wikia-button secondary"><?= wfMsg('vet-close') ?></a>
<div id="VET_results_0">
	<?= $result ?>
</div>

<div id="VET_results_1" style="display: none;">
<br/><br/><br/><br/><br/>
	<div style="text-align: center;">
		<img src="<?= $wgExtensionsPath ?>/wikia/VideoEmbedTool/images/flickr_logo.gif" />
		<div class="VideoEmbedSourceNote"><?= wfMsg('vet-flickr-inf') ?></div>
	</div>
</div>