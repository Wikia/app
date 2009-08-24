<?php
class MyExtension extends SpecialPage
{
	function MyExtension() {
		parent::__construct("MyExtension");
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		wfLoadExtensionMessages( 'MyExtension' );

		# Get request data from, e.g.
		$param = $wgRequest->getText('param');

		# Do stuff
		# ...

		# Output
		# $wgOut->addHTML( $output );
	}
}

