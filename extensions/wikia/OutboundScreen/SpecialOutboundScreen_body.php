<?php

class Outbound extends UnlistedSpecialPage {
	private $redirectDelay = 8; // in seconds

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Outbound'/*class*/ );
		wfLoadExtensionMessages( 'Outbound' ); // Load internationalization messages
	}

	function execute ( $par ) {
		?>
<html>
<script type="text/javascript">
<!--
function doRedirect(){
	window.location = "<?=$par;?>";
}
//-->
</script>
<body onLoad="setTimeout('doRedirect()', <?=($this->redirectDelay * 1000);?>)">
	<div style="height: 100%; width: 100%; text-align: center">
		<div style="margin: 0 auto">
			<img src='/images/b/bc/Wiki.png' alt="Wikia logo" />
		</div>
		<div style="margin-top: 3em"><?=wfMsgForContent( 'outbound-screen-text', $par );?></div>
		<div style="vertical-align: middle;">
			<!-- begin ZEDO for channel:  EA-Site Target 4368-1 , publisher: Wikia.com , Ad Dimension: Full Page Pop Under - 1024 x 768 -->
			<iframe src="http://d3.zedo.com/jsc/d3/ff2.html?n=790;c=1509/1;s=1368;d=16;w=1024;h=768" frameborder=0 marginheight=0 marginwidth=0 scrolling="no" allowTransparency="true" width=1024 height=768></iframe>
			<!-- end ZEDO for channel:  EA-Site Target 4368-1 , publisher: Wikia.com , Ad Dimension: Full Page Pop Under - 1024 x 768 -->
		</div>
	</div>
</body>
</html>
		<?php
		exit;
	}
}
