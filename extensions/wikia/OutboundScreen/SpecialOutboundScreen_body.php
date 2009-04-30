<?php

class Outbound extends UnlistedSpecialPage {
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
<body>
<div style="height: 100%; width: 100%; text-align: center">
	<div style="margin: 0 auto">
		<img src='http://staff.wikia-inc.com/images/2/25/Wordmark_wikia_gradient.png' alt="Wikia logo" />
	</div>
	<div style="margin-top: 3em">
		<p>You are leaving Wikia for another page on the Internet.</p>

		<p>Watch out. There be dragons! Seriously.</p>

		<p><a href="<?= $par ?>">Click here to continue...</a></p>
	</div>
	<div style="width: 728px; height: 90px; border: 1px solid black; margin: 0 auto; vertical-align: middle; font-size: 24pt">Your ad here</div>
</div>
</body>
</html>
		<?php
		exit;
	}
}
