<!-- s:<?= __FILE__ ?> -->
<?php if (!$success): ?>
<div>You must log in to MagCloud and authorize Wikia to publish a magazine on your behalf.</div>
<?php endif; ?>

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
<?php if ($success): ?>
	<div id="SpecialMagCloudStatusMask"></div>

	<div id="SpecialMagCloudStatusPopup" class="modalWrapper reset SpecialMagCloudPublishStatusPopup">
		<h1 class="modalTitle color1"><?= wfMsg('magcloud-publish-status-title') ?></h1>
		<div id="SpecialMagCloudPublishStatus"><?= wfMsg('magcloud-publish-status') ?></div>
	</div>
<?php endif; ?>
</div>

<script type="text/javascript">/*<![CDATA[*/
<?php if ($breakMe): ?>
	var wgMagCloudPublishBreakMe = true;
<?php endif; ?>
<?php if (!empty($success)): ?>
	// upload PDF to MagCloud
	$(function() {
		SpecialMagCloud.publish("<?=$collectionHash?>", <?=$collectionTimestamp?>, "<?=$token?>", $("#SpecialMagCloudPublishStatus"));
	});
<?php endif; ?>
/*]]>*/</script>
<!-- e:<?= __FILE__ ?> -->
