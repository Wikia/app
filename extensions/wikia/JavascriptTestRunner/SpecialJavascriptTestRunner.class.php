<?php

class SpecialJavascriptTestRunner extends SpecialPage {

	function __construct() {
		parent::__construct( 'JavascriptTestRunner', 'javascripttestrunner', false );
	}

	static public function createJavascriptList( $string ) {
		$items = explode(',',$string);
		foreach ($items as $k => $v) {
			if (empty($v)) {
				unset($items[$k]);
			} else {
				$items[$k] = "'$v'";
			}
		}
		return '[' . implode(',',$items) . ']';
	}

	function execute() {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgServer, $wgScriptPath;

		$this->setHeaders();

		if( !$wgUser->isAllowed( 'javascripttestrunner' ) ) {
			$wgOut->permissionRequired( 'javascripttestrunner' );
			return;
		}

		$testSuiteFile = $wgRequest->getVal('test','');
		$autoRun = $wgRequest->getVal('autorun',true);

		if ( !empty($testSuiteFile) ) {
			$basePath = $wgServer . $wgScriptPath;
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/jsunity-0.6.js\"></script>");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/Xml.js\"></script>");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/JavascriptTestRunner.js\"></script>");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/{$testSuiteFile}\"></script>");


			$script = "\n";
			$filters = $wgRequest->getVal('filter','');
			$script .= "window.jtr_filters = ".self::createJavascriptList($filters).";\n";
			$outputs = $wgRequest->getVal('output','');
			$script .= "window.jtr_outputs = ".self::createJavascriptList($outputs).";\n";
			$script .= "window.WikiaJavascriptTestRunner.autorun();\n";
			$wgOut->addInlineScript($script);

		} else {
			$wgOut->addHTML("No test given to run.");
		}

    }

}
