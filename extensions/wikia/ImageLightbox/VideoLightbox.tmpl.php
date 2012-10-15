<?php if(!empty($subHeaderText )): ?>
<h2 id="lightbox-subheader">
	<?= $subHeaderText ?><?php if(!empty($subHeaderLinkAnchor)): ?> <a href='<?= $subHeaderLinkAnchor; ?>'><?= $subHeaderLinkText; ?></a><?php endif; ?>
</h2>
<?php endif; ?>
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
#lightbox-subheader {
	position: absolute;
	top: 45px;
	font-size:12px;
}
</style>
<div id="lightbox-share">
	<?php if(!$showEmbedCodeInstantly): ?>
	<div id="lightbox-share-buttons" class="neutral modalToolbar clearfix">
		<a class="wikia-button secondary" data-func="embed">
			<img width="0" height="0" class="sprite embed" src="<?= $wgBlankImgUrl ?>">
			<?= wfMsg('lightbox-share-button-embed') ?>
		</a>
	</div>
	<?php endif; ?>
	<div class="lightbox-share-area" data-func="embed" <?php if(!$showEmbedCodeInstantly): ?>style="display:none"<?php endif; ?>>
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
