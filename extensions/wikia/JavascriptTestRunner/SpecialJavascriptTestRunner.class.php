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

	protected $definedModules = array(
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
						if (isset($this->definedModules[$value])) {
							$list = array_merge($list,$this->definedModules[$value]);
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

		$testSuite = null;
		$testFile = $wgRequest->getVal('test','');

		if ($testFile) {
			global $IP;
			$testSuite = new JavascriptTestRunner_TestSuite($IP,$testFile);
		}

		$autoRun = $wgRequest->getVal('autorun',true);

		if ( $testSuite && $testSuite->getStatus() ) {
			$basePath = $wgServer . $wgScriptPath;

			// Include testing framework
			foreach ($testSuite->getFrameworkFiles() as $filePath) {
				$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/{$filePath}\"></script>");
			}

			// Include test runner
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/Xml.js\"></script>");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/extensions/wikia/JavascriptTestRunner/js/JavascriptTestRunner.js\"></script>");

			// Include all required libraries
			foreach ($testSuite->getRequiredFiles() as $filePath) {
				if (substr($filePath,0,4) != 'http')
					$filePath = $basePath . '/' . $filePath;
				$wgOut->addScript("<script type=\"text/javascript\" src=\"{$filePath}\"></script>");
			}

//			var_dump($testSuite->getFrameworkFiles());
//			var_dump($testSuite->getRequiredFiles());

			// Include the test itself
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/{$testFile}\"></script>");


			$script = "\n";
			$script .= "window.jtr_framework = '".$testSuite->getFrameworkName()."';\n";
			$filters = $wgRequest->getVal('filter','');
			$script .= "window.jtr_filters = ".self::createJavascriptList($filters).";\n";
			$outputs = $wgRequest->getVal('output','');
			$script .= "window.jtr_outputs = ".self::createJavascriptList($outputs).";\n";
			$script .= "window.WikiaAutostartDisabled = true;\n";
			if ($autoRun)
				$script .= "window.WikiaJavascriptTestRunner.autorun();\n";
			$wgOut->addInlineScript($script);

		} else {
			$wgOut->addHTML("No test given to run.");
		}

    }

}

class JavascriptTestRunner_TestSuite {

	protected $baseDir = '';
	protected $testFile = '';

	protected $frameworkName = false;
	protected $requiredFiles = array();

	protected $status = false;

	public function __construct( $baseDir, $testFile ) {
		$this->baseDir = $baseDir;
		$this->testFile = $testFile;
		$this->load();
	}

	protected function isPathSafe( $path ) {
		$base = realpath($this->baseDir);
		$current = realpath($this->baseDir . '/' . $path);

		return substr($current,0,strlen($base)) === $base;
	}

	protected function getModuleFiles( $moduleName ) {
		return (array)JavascriptTestRunner_Contants::$modules[$moduleName];
	}

	protected function loadFile( $fileName ) {
		$contents = file_get_contents( $this->baseDir . '/' . $fileName );
		if ($contents === false)
			return false;

		$lines = split("\r?\n",$contents);
		foreach ($lines as $line) {
			$matches = array();
			if (preg_match("/^@test-([^ \t]+)[ \t]+(.*)\$/",trim($line),$matches)) {
				@list( , $command, $value ) = $matches;
				switch ($command) {
					case 'require-group':
						if (class_exists('AssetsManager')) {
							$srcs = AssetsManager::getInstance()->getGroupLocalURL($value);
							$this->requiredFiles = array_merge($this->requiredFiles,$srcs);
						}
						break;
					case 'require-module':
						if (isset($this->definedModules[$value])) {
							$this->requiredFiles = array_merge($this->requiredFiles,$this->getModuleFiles($value));
						}
						break;
					case 'require-file':
						$this->requiredFiles[] = $value;
						break;
					case 'framework':
						$this->frameworkName = $value;
						break;
				}
			}
		}
		return true;
	}

	protected function load() {
		if (!$this->isPathSafe($this->testFile))
			return;

		if (!$this->loadFile($this->testFile))
			return;

		if (!$this->frameworkName || !$this->getFrameworkFiles())
			return;

		$this->status = true;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getRequiredFiles() {
		return $this->requiredFiles;
	}

	public function getFrameworkFiles() {
		return (array)JavascriptTestRunner_Constants::$frameworks[$this->frameworkName];
	}

	public function getFrameworkName() {
		return $this->frameworkName;
	}

}


class JavascriptTestRunner_Constants {

	static public $modules = array(
		'rte-prod' => array(
			'extensions/wikia/RTE/ckeditor/ckeditor.js',
		),
		'rte-test' => array(
			'extensions/wikia/RTE/ckeditor/ckeditor_source.js',
			'extensions/wikia/RTE/js/RTE.js'
		),
	);

	static public $frameworks = array(
		'jsUnity' => array(
			'extensions/wikia/JavascriptTestRunner/js/jsunity-0.6.js'
		),
		'QUnit' => array(
			'extensions/wikia/JavascriptTestRunner/js/qunit.js'
		)
	);

}
