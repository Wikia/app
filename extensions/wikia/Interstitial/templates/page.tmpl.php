<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xml:lang="en" lang="en" dir="ltr">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php print $css ?>
		<?php print $jsGlobals; ?>
		<script type="text/javascript">/*<![CDATA[*/
			function doRedirect() {
				if((typeof WET != "undefined") && pageType){
					WET.byStr(pageType + "/waitedThroughAd");
				}
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
				<a href = "<?php print htmlspecialchars( $url ); ?>" class='wikia-button' id='skip_ad'><?php print $skip; ?></a>
			</div>
			<div class='interstitial_fg_body'>
				<?php print $adCode ?>
			</div>
		</div>
		<!-- Begin Analytics -->
		<?php
		global $IP;
		include_once("$IP/extensions/wikia/AnalyticsEngine/AnalyticsEngine.php");
		echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
		?>
		<!-- End Analytics -->
		<?php print "$jsIncludes\n"; ?>
		<script type='text/javascript'>
			var pageType = '<?php print $pageType; ?>';
			$(document).ready(function(){
				WET.byStr(pageType + "/init");
				$('#skip_ad').click(function(){WET.byStr(pageType + "/skipAd");});
				$('#userData a').each(function(index){
					if(index == 0){
						$(this).click(function(){WET.byStr(pageType + "/signUp");});
					} else if(index == 1){
						$(this).click(function(){WET.byStr(pageType + "/logIn");});
					}
				});
			});
		</script>
		<?php print AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW); ?>
	</body>
</html>
