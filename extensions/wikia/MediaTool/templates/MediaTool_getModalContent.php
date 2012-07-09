<section id="mediaToolDialog">
<ul class="tabs">
	<li data-tab="find-media" class="selected">
		<a><?= wfMsg('mediatool-tab-findmedia'); ?></a>
	</li>
	<li data-tab="edit-media" class="disabled">
		<a><?= wfMsg('mediatool-tab-editmedia'); ?></a>
	</li>
</ul>

<div class="MediaToolContainer">

	<div data-tab-body="find-media" class="tabBody selected border">

		<div class="mediatool-left-bar">

			<ul class="tabs minor-tabs">
				<li data-tab="find-media-wiki" class="selected">
					<a><?= wfMsg('mediatool-tab-wiki'); ?></a>
				</li>
				<li data-tab="find-media-online">
					<a><?= wfMsg('mediatool-tab-online'); ?></a>
				</li>
				<li data-tab="find-media-computer">
					<a><?= wfMsg('mediatool-tab-computer'); ?></a>
				</li>
			</ul>

			<div data-tab-body="find-media-wiki" class="tabBody selected">
				<input type="radio" id="source-recently-added" checked="checked"> <label for="source-recently-added"><?= wfMsg('mediatool-collection-recentlyadded'); ?></label>
			</div>
			<div data-tab-body="find-media-online" class="tabBody">
				<label for="mediatool-online-url"><?= wfMsg('mediatool-addviaurl-label'); ?></label>
				<input type="text" id="mediatool-online-url" value="" />
				<button name="addviaurl"><?= wfMsg('mediatool-button-add');?></button>
			</div>
			<div data-tab-body="find-media-computer" class="tabBody">
			</div>

		</div>
		<div class="mediatool-content">
			<div class="mediatool-basket">
				{{{cart}}}
			</div>
			<div id="mediatool-thumbnail-browser" class="mediatool-thumbnail-browser">
				{{{itemsCollection}}}
			</div>
		</div>

	</div>
	<div data-tab-body="edit-media" class="tabBody border">

		<div class="mediatool-left-bar">

			<ul class="tabs minor-tabs">
				<li data-tab="edit-media-options" class="selected">
					<a><?= wfMsg('mediatool-mediaoptions'); ?></a>
				</li>
			</ul>

			<div data-tab-body="edit-media-options" class="tabBody selected">

				<div class="media-tool-thumbnail-style">
					<h4><?= wfMsg('mediatool-thumbnail-style'); ?></h4>
					<div><img data-thumb-style="border" src="<?= F::app()->wg->ExtensionsPath.'/wikia/MediaTool/images/thumbnail_with_border.png' ?>" />
						 <img data-thumb-style="no-border" src="<?= F::app()->wg->ExtensionsPath.'/wikia/MediaTool/images/thumbnail_without_border.png' ?>" />
					</div>
					<span class="thumb-style-desc" />
				</div>

				<div class="media-tool-thumbnail-size">
					<h4><?= wfMsg('mediatool-thumbnail-size'); ?></h4>
					<input type="radio" name="thumbsize" id="mediaToolLargeThumbnail"/>
					<label for="mediaToolLargeThumbnail"><?= wfMsg('mediatool-large-thumbnail', MediaToolController::THUMBNAIL_SIZE_LARGE) ?></label><br/>
					<input type="radio" name="thumbsize" id="mediaToolSmallThumbnail"/>
					<label for="mediaToolSmallThumbnail"><?= wfMsg('mediatool-small-thumbnail', MediaToolController::THUMBNAIL_SIZE_SMALL) ?></label><br/>
					<input type="radio" name="thumbsize" id="mediaToolCustomThumbnail"/>
					<label for="mediaToolCustomThumbnail"><?= wfMsg('mediatool-custom-thumbnail') ?></label><br/>
					<div id="mediaToolThumbnailSizeSlider" class="WikiaSlider"></div>
					<span id="mediaToolThumbnailSize">
						<input type="text" id="mediaToolThumbnailSizeInput" name="mediaToolThumbnailSizeInput" value="" onchange="" onkeyup="" /> px
					<span>
				</div>

				<div class="media-tool-media-location">
					<h4><?= wfMsg('mediatool-media-position'); ?></h4>
					<div><img data-media-location="left" src="<?= F::app()->wg->ExtensionsPath.'/wikia/MediaTool/images/media_location_left.png' ?>" />
						<img data-media-location="center" src="<?= F::app()->wg->ExtensionsPath.'/wikia/MediaTool/images/media_location_center.png' ?>" />
						<img data-media-location="right" src="<?= F::app()->wg->ExtensionsPath.'/wikia/MediaTool/images/media_location_right.png' ?>" />
					</div>
				</div>
			</div>

		</div>
		<div class="mediatool-content">
			<div class="mediatool-preview">

			</div>
		</div>

	</div>
</div>


<div class="MediaTool-buttons">
	<button class="secondary" name="cancel"><?= wfMsg('mediatool-button-cancel'); ?></button>
	<button  name="continue" disabled="disabled"><?= wfMsg('mediatool-button-continue'); ?></button>
	<button  name="done"><?= wfMsg('mediatool-button-done'); ?></button>
</div>
</section>