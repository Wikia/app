<script type="text/javascript">/*<![CDATA[*/
	function doRedirect() {
		if((typeof WET != "undefined") && pageType){
			WET.byStr(pageType + "/waitedThroughAd");
		}
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