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

<div id="SpecialMagCloudButtons" style="margin-left: auto; margin-right: auto; width: 550px">
	<a class="bigButton greyButton" href="<?= htmlspecialchars($title->getLocalUrl() . '/Design_Cover') ?>" style="left: 0">
		<big>&laquo; <?= wfMsg('magcloud-preview-back-to-cover') ?></big>
		<small> </small>
	</a>

	<a id="MagCloudSaveMagazine" class="bigButton greyButton" style="margin-left: 190px">
		<big><?= wfMsg('magcloud-preview-save-magazine') ?></big>
		<small> </small>
	</a>
	<a class="bigButton" href="https://magcloud.com/apps/authorizeask/<?= $publicApiKey ?>?ud=<?= $server ?>" style="display: none; padding-right: 10px; right: 0">
		<big><?= wfMsg('magcloud-preview-publish') ?> &raquo;</big>
		<small> </small>
	</a>
</div>
<script type="text/javascript">/*<![CDATA[*/
	$('#MagCloudSaveMagazine').click(SpecialMagCloud.saveCollection);

	// generate PDF and get preview of 1st and 2nd page
	SpecialMagCloud.renderPdf('<?= $collectionHash ?>', <?= $collectionTimestamp ?>, $('#SpecialMagCloudPdfProcess'));
/*]]>*/</script>
<!-- e:<?= __FILE__ ?> -->
