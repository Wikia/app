<script type="text/javascript">/*<![CDATA[*/
	function doRedirect() {
		window.location = <?php print Xml::encodeJSvar( htmlspecialchars_decode( $url ) ); ?>;
	}
	var redirectDelay = <?=$redirectDelay?>;
	if (redirectDelay > 0) {
		setTimeout(doRedirect, redirectDelay * 1000);
	}
/*]]>*/</script>
<?php print (empty($athenaInitStuff)?"":$athenaInitStuff); ?>
<div class='interstitial_fg_body'>
	<?php print $adCode ?>
</div>
<!-- Begin Analytics -->
<?php
global $IP;
include_once("$IP/extensions/wikia/AnalyticsEngine/AnalyticsEngine.php");
echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
?>
<!-- End Analytics -->
<?php print AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW); ?>