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
	white-space: nowrap;
}
#lightbox-share-email-button {
	margin-left: 10px;
}
.lightbox-share-area input[type=text] {
	width: 100%;
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
	background-image: url('<?= $wgExtensionsPath ?>/wikia/ImageLightbox/images/share_sprite.png');
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
		<a class="wikia-button secondary" data-func="embed">
			<img width="0" height="0" class="sprite embed" src="<?= $wgBlankImgUrl ?>">
			<?= wfMsg('lightbox-share-button-embed') ?>
		</a>
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
		</table>
	</div>
 </div>
<?php
} //$showShareTools
?>