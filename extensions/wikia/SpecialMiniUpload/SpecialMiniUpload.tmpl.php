<?php
global $wgServer, $wgScript, $wgStylePath, $wgContLang, $wgUseAjax, $wgAjaxUploadDestCheck, $wgAjaxLicensePreview;
$useAjaxDestCheck = $wgUseAjax && $wgAjaxUploadDestCheck;
$useAjaxLicensePreview = $wgUseAjax && $wgAjaxLicensePreview;
$adc = wfBoolToStr( $useAjaxDestCheck );
$alp = wfBoolToStr( $useAjaxLicensePreview );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<style type="text/css" media="screen,projection">/*<![CDATA[*/@import "http://images.wikia.com/common/skins/monobook/main.css?20071123145455"; /*]]>*/</style>
		<style type="text/css" >@import "<?= $wgStylePath ?>/../extensions/wikia/SpecialMiniUpload/img.css";</style>
		<script type="text/javascript">/*<![CDATA[*/
			var stylepath = "<?= $wgStylePath ?>";
			var wgServer = "<?= $wgServer ?>";
			var wgScript = "<?= $wgScript ?>";
			var wgContentLanguage = "<?= $wgContLang->getCode() ?>";
			var wgAjaxUploadDestCheck = <?= $adc ?>;
			var wgAjaxLicensePreview = <?= $alp ?>;
		/*]]>*/</script>
		<script type="text/javascript" src="<?= $wgStylePath ?>/common/wikibits.js"></script>
		<script type="text/javascript" src="<?= $wgStylePath ?>/common/upload.js"></script>
		<script type="text/javascript" src="<?= $wgStylePath ?>/common/ajax.js"></script>
		<script type="text/javascript" src="<?= $wgStylePath ?>/common/yui/2.4.0/utilities/utilities.js"></script>
		<script type="text/javascript" src="<?= $wgStylePath ?>/../extensions/wikia/SpecialMiniUpload/img.js"></script>
	</head>
	<body class="mediawiki ns-0 ltr" style="margin: 10px">
		<div id="container">
			<div id="globalWrapper">
			<?= $body ?>
			</div>
		</div>
	</body>
</html>