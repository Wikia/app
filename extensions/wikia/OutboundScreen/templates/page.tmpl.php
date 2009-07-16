<!-- s:<?= __FILE__ ?> -->
<html>
<?php if($redirectDelay > 0): ?>
<script type="text/javascript">
<!--
function doRedirect(){
	window.location = "<?=$url;?>";
}
//-->
</script>
<body onLoad="setTimeout('doRedirect()', <?=($redirectDelay * 1000);?>)" style="margin-top: 0px;">
<?php else: ?>
<body style="margin-top: 0px;">
<?php endif; ?>
<style type="text/css">
<!--
#pageTop {
	width: 100%;
	height: 100%;
	height: 24px;
	background: #303030;
	text-align: center;
}

#exitLinkText {
	padding-top: 6px;
}

#exitLink {
	color: white;
	text-decoration: none;
	font-size: 12px;
	font-family: verdana;
}

#exitPageAd {
	text-align: center;
	padding: 5px;
}
-->
</style>
	<div>
		<div id="pageTop">
			<img src="<?=$imagesPath?>/wikia_logo_tiny.png" align="left"/>
			<span id="exitLinkText"><a href="<?=$url;?>" id="exitLink" rel="nofollow"><?=($redirectDelay > 0) ? wfMsgForContent('outbound-screen-text-with-redirect', $redirectDelay) : wfMsgForContent('outbound-screen-text');?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		</div>
		<div id="exitPageAd">
			<script type="text/javascript"><!--
			google_ad_client = "pub-4086838842346968";
			/* Exit page ad */
			google_ad_slot = "0549965769";
			google_ad_width = 336;
			google_ad_height = 280;
			google_page_url = "http://gamergear.wikia.com/wiki/GamerGear_Wiki";
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	</div>
</body>
</html>
<!-- e:<?= __FILE__ ?> -->
