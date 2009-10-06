<!-- s:<?= __FILE__ ?> -->
<div id="SpecialMagCloudPdfProcess">&nbsp;</div>

<div id="SpecialMagCloudPreviews" class="clearfix">
	<a id="SpecialMagCloudPreviewPrev" class="bigButton">
		<big>&laquo;</big>
		<small> </small>
	</a>
	<div class="SpecialMagCloudPreviewPage"></div>
	<div class="SpecialMagCloudPreviewPage"></div>
	<a id="SpecialMagCloudPreviewNext" class="bigButton">
		<big>&raquo;</big>
		<small> </small>
	</a>
	<div id="SpecialMagCloudStatusMask"></div>

	<div id="SpecialMagCloudStatusPopup" class="modalWrapper reset SpecialMagCloudPreviewStatusPopup">
		<h1 class="modalTitle color1">Creating your magazine</h1>
		<div id="SpecialMagCloudPublishStatus"><?= wfMsg('magcloud-preview-generating-pdf') ?></div>
	</div>
</div>

<div id="SpecialMagCloudButtons" style="margin-left: auto; margin-right: auto; text-align: center; width: 550px">
	<a class="wikia_button secondary_back" href="<?= htmlspecialchars($title->getLocalUrl() . '/Design_Cover') ?>" style="float: left">
		<span><?= wfMsg('magcloud-preview-back-to-cover') ?></span>
	</a>

	<a class="wikia_button forward" href="https://magcloud.com/apps/authorizeask/<?= $publicApiKey ?>?ud=<?= $server ?>" style="float: right; visibility: hidden">
		<span><?= wfMsg('magcloud-preview-publish') ?> &raquo;</span>
	</a>

	<a id="MagCloudSaveMagazine" class="wikia_button secondary">
		<span><?= wfMsg('magcloud-preview-save-magazine') ?></span>
	</a>
</div>
<script type="text/javascript">/*<![CDATA[*/
	$('#MagCloudSaveMagazine').click(SpecialMagCloud.saveCollection);

	// generate PDF and get preview of 1st and 2nd page
	SpecialMagCloud.renderPdf('<?= $collectionHash ?>', <?= $collectionTimestamp ?>, $('#SpecialMagCloudPdfProcess'));
/*]]>*/</script>
<!-- e:<?= __FILE__ ?> -->
