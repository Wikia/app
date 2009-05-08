<?php

class Outbound extends UnlistedSpecialPage {
	private $redirectDelay = 5; // in seconds

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
			<img src='http://staff.wikia-inc.com/images/2/25/Wordmark_wikia_gradient.png' alt="Wikia logo" />
		</div>
		<div style="margin-top: 3em"><?=wfMsgForContent( 'outbound-screen-text', $par );?></div>
		<div style="vertical-align: middle;">
			<!-- Begin: AdBrite, Generated: 2009-05-04 17:07:52  -->
			<script type="text/javascript" src="http://ads.adbrite.com/mb/text_group.php?sid=1157756&br=1"></script>
			<!-- End: AdBrite -->
		</div>
	</div>
</body>
</html>
		<?php
		exit;
	}
}
