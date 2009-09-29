<!-- s:<?= __FILE__ ?> -->
<div id="MagCloudCoverPreviewWrapper">
	<div class="thumbinner">
		<div id="MagCloudCoverPreview">
			<div id="MagCloudCoverPreviewTitle">
				<big><?= htmlspecialchars($magazineTitle) ?></big>
				<small><?= htmlspecialchars($magazineSubtitle) ?></small>
			</div>
			<div id="MagCloudCoverPreviewBar">&nbsp;</div>
			<div id="MagCloudCoverPreviewImage"></div>
		</div>
	</div>
</div>

<div id="MagCloudCoverEditor">
	<h3>Name your magazine</h3>

	<table id="MagCloudTitleEditor">
		<tr>
			<td><label for="MagCloudMagazineTitle">Title:</label></td>
			<td><input id="MagCloudMagazineTitle" value="<?= htmlspecialchars($magazineTitle) ?>" /></td>
		</tr>
		<tr>
			<td><label for="MagCloudMagazineSubtitle">Subtitle:</label></td>
			<td><input id="MagCloudMagazineSubtitle" value="<?= htmlspecialchars($magazineSubtitle) ?>" /></td>
		</tr>
	</table>


	<h3>Choose a color theme</h3>

	<table id="MagCloudCoverEditorTheme">
		<tr>
<?php

$i = 0;

foreach($themes as $theme => $colors) {
	$id = 'MagCloudCoverEditorTheme' . ucfirst(str_replace('_', '', $theme));
	$display = ucwords(str_replace('_', ' ', $theme));
?>
			<td><input type="radio" name="MagCloudCoverEditorTheme" id="<?= $id ?>" rel="<?= $theme ?>"<?= ($selectedTheme == $theme ? ' checked="checked"' : '') ?> /><label for="<?= $id ?>"><?= $display ?></label></td>
			<td class="MagCloudCoverEditorThemeColors">
				<label for="<?= $id ?>">
					<span style="background-color: #<?= $colors[0] ?>">&nbsp;</span>
					<span style="background-color: #<?= $colors[1] ?>">&nbsp;</span>
					<span style="background-color: #<?= $colors[2] ?>">&nbsp;</span>
				</label>
			</td>
<?php

	// start new row
	if ($i & 1) {
		echo "\t\t</tr><tr>\n";
	}

	$i++;
}
?>
		</tr>
	</table>


	<h3>Add an image</h3>
	<table id="MagCloudCoverEditorImage">
	<tr>
		<td><input type="radio" name="MagCloudCoverEditorImage" id="MagCloudCoverEditorImageNone"<?= ($image == '' ? ' checked="checked"' : '') ?> /></td>
		<td><label for="MagCloudCoverEditorImageNone">No image<label></td>
	</tr>
	<tr>
		<td><input type="radio" name="MagCloudCoverEditorImage" id="MagCloudCoverEditorImageSmall"<?= ($image != '' ? ' checked="checked"' : '') ?> /></td>
		<td>
			<label for="MagCloudCoverEditorImageSmall">Insert an image</label>

			<a id="MagCloudCoverEditorImageUpload" class="bigButton">
				<big><?= wfMsg('wmu-upload') ?></big>
				<small> </small>
			</a>

			<span id="MagCloudCoverEditorImageInfo"><?= ($image != '' ? wfMsg('magcloud-design-image-selected', $image) : '') ?></span>

			<input type="hidden" id="MagCloudCoverEditorImageName" value="<?= htmlspecialchars($image) ?>" />

			<br  />

			<span id="MagCloudLicense" class="clearfix"><?= wfMsgExt('magcloud-design-license-policy', array('parseinline')) ?></span>
		</td>
	</tr>

	</table>


	<h3>Select a cover layout</h3>
	<table id="MagCloudCoverEditorLayout">
		<tr>
<?php for($layout=1; $layout<=4; $layout++): ?>
			<td><label for="MagCloudCoverEditorLayout<?= $layout ?>">
				<img src="<?=  str_replace('$1', $layout, $layoutPreviewImage) ?>" width="130" height="160" alt="Layout #<?= $layout ?>" >
			</label></td>
<?php endfor; ?>
		</tr>
		<tr>
<?php for($layout=1; $layout<=4; $layout++): ?>
			<td><input type="radio" id="MagCloudCoverEditorLayout<?= $layout ?>" name="MagCloudCoverEditorLayout" rel="layout<?= $layout ?>"<?= ($selectedLayout == $layout ? ' checked="checked"' : '') ?> /></td>
<?php endfor; ?>

		</tr>
	</table>
</div>

<div id="SpecialMagCloudButtons" class="clearfix" style="margin-top: 30px; width: 680px">
	<a class="bigButton greyButton" href="<?= htmlspecialchars($title->getLocalUrl()) ?>" style="left: 0">
		<big>&laquo; <?= wfMsg('magcloud-design-review-list'); ?></big>
		<small> </small>
	</a>
	<a class="bigButton" href="<?= htmlspecialchars($title->getLocalUrl() . '/Preview') ?>" style="right: 0">
		<big><?= wfMsg('magcloud-design-preview'); ?> &raquo;</big>
		<small> </small>
	</a>
</div>

<script type="text/javascript">/*<![CDATA[*/
	SpecialMagCloud.setupColorTheme($('#MagCloudCoverEditorTheme'), <?= Wikia::json_encode($themes) ?>);
	SpecialMagCloud.setupLayout($('#MagCloudCoverEditorLayout'));
	SpecialMagCloud.connectTitleWithPreview();

	$('#SpecialMagCloudButtons a').click(SpecialMagCloud.saveCoverDesign);

	// image upload
	$('#MagCloudCoverEditorImageNone').click(function() {
		$('#MagCloudCoverPreviewImage').hide();
	});

	$('#MagCloudCoverEditorImageSmall').click(function() {
		$('#MagCloudCoverPreviewImage').show();
	});

	// render an image to be used on cover preview
	SpecialMagCloud.renderImageForCover($('#MagCloudCoverEditorImageName').attr('value'), 100);

	// use WMU for image upload
	$('#MagCloudCoverEditorImageUpload').click(WMU_show);

	// catch wikitext added by WMU
	function insertTags(wikitext) {
		MagCloud.log('image wikitext: ' + wikitext);

		// remove [[
		wikitext = wikitext.substring(2);

		// get image name (part of wikitext before |)
		wikitext = wikitext.substring(0, wikitext.indexOf('|'));

		// set image name
		$('#MagCloudCoverEditorImageName').attr('value', wikitext);

		// select proper option
		$('#MagCloudCoverEditorImageNone').attr('checked', false);
		$('#MagCloudCoverEditorImageSmall').attr('checked', true);

		MagCloud.log('using image: ' + wikitext);

		// render an image to be used on cover preview
		SpecialMagCloud.renderImageForCover(wikitext, 100);

		// update the info
		$('#MagCloudCoverEditorImageInfo').html( (<?= Xml::encodeJsVar(wfMsg('magcloud-design-image-selected')) ?>).replace(/\$1/, wikitext) );
	}
/*]]>*/</script>

<!-- e:<?= __FILE__ ?> -->
