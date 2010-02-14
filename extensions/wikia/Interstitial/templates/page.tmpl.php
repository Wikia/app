<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xml:lang="en" lang="en" dir="ltr">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php print $css ?>

		<script type="text/javascript">/*<![CDATA[*/
			function doRedirect() {
				window.location = <?php print Xml::encodeJSvar( htmlspecialchars_decode( $url ) ); ?>;
			}
		/*]]>*/</script>
	</head>
	<body class="color2"<?php if($redirectDelay > 0): ?> onLoad="setTimeout(doRedirect, <?php print ($redirectDelay * 1000);?>)"<?php endif?>>
		<?php print (empty($athenaInitStuff)?"":$athenaInitStuff); ?>
		<div id="wikia_header" class="color2">
			<div class="monaco_shinkwrap">
				<?php print (empty($loginMsg)?"":"<div id='userData'>$loginMsg</div>"); ?>
				<div id="wikiaBranding">
					<div id="wikia_logo">Wikia</div>
				</div>
			</div>
		</div>
		<div id='background_strip'>
			&nbsp;
		</div>
		<div id="wikia_page">
			<div class='interstitial_fg_top color1' id="page_bar">
				<?php print (empty($pageBarMsg)?"":"<div class='left'>$pageBarMsg</div>"); ?>
				<a href = "<?php print $url; ?>" class='wikia_button'><span><?php
					print $skip
				?></span></a>
			</div>
			<div class='interstitial_fg_body'>
				<?php print $adCode ?>
			</div>
		</div>
	</body>
</html>
