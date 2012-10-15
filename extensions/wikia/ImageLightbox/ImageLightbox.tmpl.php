<div id="lightbox-image" title="<?= htmlspecialchars($name) ?>" style="text-align: center">
	<div style="line-height: <?= $wrapperHeight ?>px">
		<img alt="<?= htmlspecialchars($name) ?>" height="<?= $thumbHeight ?>" width="<?= $thumbWidth ?>" src="<?= $thumbUrl ?>" style="vertical-align: middle" />
	</div>
	<div id="lightbox-caption" class="neutral clearfix" style="padding: 8px">
		<a id="lightbox-link" href="<?= htmlspecialchars($href) ?>" title="<?= wfMsg('lightbox_details_tooltip') ?>" style="float: right"><img class="sprite details" width="16" height="16" src="<?= $wgBlankImgUrl ?>" alt="" /></a>
		<div id="lightbox-caption-content" style="line-height: 18px; margin-right: 25px; text-align: left"></div>
	</div>
	<input id="lightbox-image-link" type="hidden" value="<?= $linkMail; ?>" />
</div>
<?php if ($showShareTools) { ?>
<style type="text/css">
#lightbox-share-buttons a {
	margin-right: 10px;
}
#lightbox-share-buttons img {
	vertical-align: middle;
}
.lightbox-share-area {
	border-top: 1px solid #D9D9D9;
	border-width: 1px 0 0 0;
	line-height: 30px;
	margin-top: 10px;
	padding-top: 10px;
	*width: 300px; /* IE7 */
}
.lightbox-share-area label {
	font-weight: bold;
}
#lightbox-share-email-button {
	margin-left: 10px;
}
.lightbox-share-area input[type=text] {
	width: 60%;
}
#lightbox-caption-content {
	*zoom: 1; /* IE7 */
}
#lightbox .fb_iframe_widget {
	display: block;
}
.share-links li {
	display: inline;
}
.share-links img {
	background-image: url(<?= $wgExtensionsPath ?>/wikia/ImageLightbox/images/share_sprite.png);
	margin-left: 2px;
}
.share-stumbleupon {
	background-position: -80px 0;
}
.share-twitter {
	background-position: 0 0;
}
.share-facebook {
	background-position: -64px 0;
}
.share-reddit {
	background-position: -48px 0;
}
.share-code {
	width: 100%;
}
.share-code label {
	display: block;
	padding-right: 10px;
	text-align: right;
	white-space: nowrap;
}
.share-code input {
	width: 100% !important;
	*width: auto !important;
}
</style>
<div id="lightbox-share">
	<div id="lightbox-share-buttons" class="neutral modalToolbar clearfix">
		<a class="wikia-button secondary" data-func="email">
			<img width="0" height="0" class="sprite email" src="<?= $wgBlankImgUrl ?>">
			<?= wfMsg('lightbox-share-button-email') ?>
		</a>
		<a class="wikia-button secondary" data-func="www">
			<img width="0" height="0" class="sprite share2" src="<?= $wgBlankImgUrl ?>">
			<?= wfMsg('lightbox-share-button-www') ?>
		</a>
		<a class="wikia-button secondary" data-func="embed">
			<img width="0" height="0" class="sprite embed" src="<?= $wgBlankImgUrl ?>">
			<?= wfMsg('lightbox-share-button-embed') ?>
		</a>
	</div>
	<div class="lightbox-share-area" data-func="email" style="display:none">
		<label><?= wfMsg('lightbox-share-email-label') ?><br/>
			<input type="text" id="lightbox-share-email-text" /><input type="button" value="<?= wfMsg('lightbox-send') ?>" id="lightbox-share-email-button" />
			<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" style="display:none" />
		</label>
	</div>
	<div class="lightbox-share-area" data-func="www" style="display:none">
		<fb:like colorscheme="<?= $likeTheme ?>" layout="button_count" href="<?= htmlspecialchars($likeHref) ?>"></fb:like>
		<ul class="share-links">
		<?php foreach ($shareButtons as $button) { ?>
			<li><a class="wikia-button secondary " href="<?= $button['url'] ?>" target="_blank" data-func="<?= $button['type'] ?>">
				<img width="16" height="16" class="<?= $button['class'] ?>" src="<?= $wgBlankImgUrl ?>">
				<?= $button['text'] ?>
			</a></li>
		<?php } ?>
	</div>
	<div class="lightbox-share-area" data-func="embed" style="display:none">
		<table class="share-code">
			<colspan>
				<col width="*" />
				<col width="100%" />
			</colspan>
			<tr>
				<td>
					<label for="lightbox-share-embed-standard"><?= wfMsg('lightbox-standard-link') ?></label>
				</td>
				<td>
					<input type="text" id="lightbox-share-embed-standard" value="<?= $linkStd ?>" data-func="standard" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="lightbox-share-embed-blog"><?= wfMsg('lightbox-blog-link') ?></label>
				</td>
				<td>
					<input type="text" id="lightbox-share-embed-blog" value="<?= htmlspecialchars($linkWWW) ?>" data-func="blog" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="lightbox-share-embed-forum"><?= wfMsg('lightbox-forum' ) ?></label>
				</td>
				<td>
					<input type="text" id="lightbox-share-embed-forum" value="<?= $linkBBcode ?>" data-func="forum" />
				</td>
			</tr>
		</table>
	</div>
 </div>
<?php
}
