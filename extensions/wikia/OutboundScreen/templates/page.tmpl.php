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
<body onLoad="setTimeout('doRedirect()', <?=($redirectDelay * 1000);?>)">
<?php else: ?>
<body>
<?php endif; ?>
	<div style="height: 100%; width: 100%; text-align: center">
		<div style="margin-top: 3em"><?=wfMsgForContent('outbound-screen-text', $url);?></div>
		<div style="vertical-align: middle;">
			<!-- begin ZEDO for channel:  EA-Site Target 4368-1 , publisher: Wikia.com , Ad Dimension: Full Page Pop Under - 1024 x 768 -->
			<iframe src="http://d3.zedo.com/jsc/d3/ff2.html?n=790;c=1509/1;s=1368;d=16;w=1024;h=768" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=1024 height=768></iframe>
			<!-- end ZEDO for channel:  EA-Site Target 4368-1 , publisher: Wikia.com , Ad Dimension: Full Page Pop Under - 1024 x 768 -->
		</div>
	</div>
</body>
</html>
<!-- e:<?= __FILE__ ?> -->
