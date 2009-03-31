<?php
class MyExtension extends SpecialPage
{
	function MyExtension() {
		parent::__construct("MyExtension");
		wfLoadExtensionMessages( 'MyExtension' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		# Get request data from, e.g.
		$param = $wgRequest->getText('param');

		# Do stuff
		# ...

		# Output
		# $wgOut->addHTML( $output );
	}
}

