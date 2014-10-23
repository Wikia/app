<?php
/* @var $wikiData WikiDataModel */
?>

<header class="MainPageHeroHeader <?php if (isset($wikiData->imagePath)) :?>filled-state<? else : ?>zero-state<?php endif; ?>">
		<div id="MainPageHero" class="MainPageHero">
			<div class="upload-wrap">
				<div class="upload">
					<div class="upload-group">
						<div class="upload-btn">
							<img class="upload-icon" src="/extensions/wikia/NjordPrototype/images/addImage.svg">
							<span class="upload-text sg-main">add an cover image</span>
						</div>
						<div class="update-btn">
							<img class="upload-icon" src="/extensions/wikia/NjordPrototype/images/addImage.svg">
							<span class="update-text sg-main">update image</span>
						</div>
						<input name="file" type="file" hidden/>
						<span class="upload-desc sg-sub">or, drop an image here (1600x600px minimum)</span>
					</div>
					<div class="upload-mask"></div>
				</div>
				<div class="overlay">
					<div class="overlay-flex upload">
						<span class="overlay-text sg-sub-title">drop an image here</span></div>
				</div>
			</div>
			<picture>
				<img class="hero-image" data-cropposition="<?= $wikiData->cropPosition ?>"
					 data-fullpath="<?= $wikiData->originalImagePath ?>" src="<?= $wikiData->imagePath ?>"
					 alt="<?= $wikiData->title ?>">
			</picture>

			<!--		<div class="edit-area">-->
			<!--			<div class="overlay">-->
			<!--				<div class="upload">-->
			<!--					<div class="upload-mask"></div>-->
			<!--					<input name="file" type="file" hidden/>-->
			<!---->
			<!--					<div class="upload-group">-->
			<!--						<div class="upload-text">Drag&drop image</div>-->
			<!--						<div class="upload-btn new-btn">Upload image</div>-->
			<!--					</div>-->
			<!--					<div class="btn-group-top">-->
			<!--						<div class="close-upload-btn new-btn">X</div>-->
			<!--					</div>-->
			<!--				</div>-->
			<!--			</div>-->
			<!--			<div class="btn-group-top toggle-btn">-->
			<!--				<div class="toggle-upload-btn new-btn">Upload</div>-->
			<!--			</div>-->
			<!--			<div class="btn-group-bottom">-->
			<!--				<div class="discard-btn new-btn">Discard</div>-->
			<!--				<div class="save-btn new-btn">Publish</div>-->
			<!--			</div>-->
			<!--		</div>-->
			<h1 class="title-wrap sg-title">
				<div class="edit-box">
					<span class="hero-title" contenteditable="true"></span>
					<div class="btn-bar">
						<div class="new-btn discard-btn sg-sub">Discard</div>
						<div class="new-btn save-btn sg-sub">Publish</div>
					</div>
				</div>
				<span class="title-text"><?= $wikiData->title ?></span>
				<span class="title-default-text">Wikia name can goes three lines (50 characters max)</span>
				<img class="title-edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil.svg">
			</h1>

			<!--		<div class="edit-btn new-btn">edit</div>-->
		</div>
		<div class="hero-description sg-main"><?= $wikiData->description ?><span class="desc-default-text">Add a summary that will be used to
			promote your page in search results and on other promotional areas. (160 characters maximum)</span>
			<img class="title-edit-btn" src="/extensions/wikia/NjordPrototype/images/pencil_b.svg">
		</div>
</header>

