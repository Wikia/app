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
			<span id="exitLinkText"><a href="<?=$url;?>" id="exitLink"><?=($redirectDelay > 0) ? wfMsgForContent('outbound-screen-text-with-redirect', $redirectDelay) : wfMsgForContent('outbound-screen-text');?></a></span>
		</div>
		<div id="exitPageAd">
			<!-- begin ZEDO for channel:  EA-Site Target 4368-1 , publisher: Wikia.com , Ad Dimension: Full Page Pop Under - 1024 x 768 -->
			<iframe src="http://d3.zedo.com/jsc/d3/ff2.html?n=790;c=1509/1;s=1368;d=16;w=1024;h=768" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=1024 height=768></iframe>
			<!-- end ZEDO for channel:  EA-Site Target 4368-1 , publisher: Wikia.com , Ad Dimension: Full Page Pop Under - 1024 x 768 -->
		</div>
	</div>
</body>
</html>
<!-- e:<?= __FILE__ ?> -->
