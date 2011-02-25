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

	protected function isPathSafe( $fileName ) {
		global $IP;
		$base = realpath($IP);
		$current = realpath($IP.'/'.$fileName);
		if (substr($current,0,strlen($base)) !== $base) {
			return false;
		}
		return true;
	}

	protected $includeModules = array(
		'rte-prod' => array(
			'extensions/wikia/RTE/ckeditor/ckeditor.js',
		),
		'rte-test' => array(
			'extensions/wikia/RTE/ckeditor/ckeditor_source.js',
			'extensions/wikia/RTE/js/RTE.js'
		),
	);

	protected function getIncludedFiles( $contents ) {
		$list = array();
		$lines = split("\r?\n",$contents);
		foreach ($lines as $line) {
			$matches = array();
			if (preg_match("/^@test-([^ \t]+)[ \t]+(.*)\$/",trim($line),$matches)) {
				@list( , $command, $value ) = $matches;
				switch ($command) {
					case 'require-module':
						if (isset($this->includeModules[$value])) {
							$list = array_merge($list,$this->includeModules[$value]);
						}
						break;
					case 'require-file':
						$list[] = $value;
						break;
				}
			}
		}
		return $list;
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
		$realSuiteFile = '';

		if ($this->isPathSafe($testSuiteFile)) {
			global $IP;
			$realSuiteFile = $IP.'/'.$testSuiteFile;
		} else {
			$testSuiteFile = '';
		}

		if ( !empty($realSuiteFile) && file_exists($realSuiteFile)) {
			$basePath = $wgServer . $wgScriptPath;

			$contents = file_get_contents($realSuiteFile);
			$includes = $this->getIncludedFiles($contents);

			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/jsunity-0.6.js\"></script>");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/Xml.js\"></script>");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/JavascriptTestRunner.js\"></script>");
			foreach ($includes as $filePath) {
				if (substr($filePath,0,4) != 'http')
					$filePath = $basePath . '/' . $filePath;
				$wgOut->addScript("<script type=\"text/javascript\" src=\"{$filePath}\"></script>");
			}
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
