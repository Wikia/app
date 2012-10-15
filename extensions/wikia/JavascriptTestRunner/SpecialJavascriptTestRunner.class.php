<?php

class SpecialJavascriptTestRunner extends SpecialPage {

	function __construct() {
		parent::__construct( 'JavascriptTestRunner', 'javascripttestrunner', false );
	}

	static public function createJavascriptList( $string, $excludes = array() ) {
		$items = explode(',',$string);
		foreach ($items as $k => $v) {
			if (empty($v) || in_array( $v, $excludes )) {
				unset($items[$k]);
			} else {
				$items[$k] = "'$v'";
			}
		}
		return '[' . implode(',',$items) . ']';
	}

	function execute() {
		global $wgRequest, $wgOut, $wgUser, $wgServer, $wgScriptPath, $IP;

		$this->setHeaders();

		if( !$wgUser->isAllowed( 'javascripttestrunner' ) ) {
			$wgOut->permissionRequired( 'javascripttestrunner' );
			return;
		}

		$testSuite = null;
		$testFile = $wgRequest->getVal('test','');

		if ($testFile) {
			$testSuite = new JavascriptTestRunner_TestSuite($IP,$testFile);
		}

		$autoRun = $wgRequest->getVal('autorun',true);

		if ( $testSuite && $testSuite->getStatus() ) {
			$basePath = $wgServer . $wgScriptPath;

			// Include testing framework
			foreach ($testSuite->getFrameworkFiles() as $filePath) {
				$wgOut->addScript("<script type=\"text/javascript\" src=\"{$basePath}/{$filePath}\"></script>");
			}

			foreach ($testSuite->getFrameworkStyles() as $filePath) {
				$wgOut->addStyle("{$basePath}/{$filePath}");
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
			$script .= "window.jtr_testname = ".json_encode((string)$testSuite->getTestName()).";\n";
			$script .= "window.jtr_framework = ".json_encode((string)$testSuite->getFrameworkName()).";\n";
			$filters = $wgRequest->getVal('filter','');
			$script .= "window.jtr_filters = ".self::createJavascriptList($filters).";\n";
			$outputs = $wgRequest->getVal('output','');
			$script .= "window.jtr_outputs = ".self::createJavascriptList($outputs,$testSuite->getFrameworkForbiddenOutputs()).";\n";
			$script .= "window.WikiaAutostartDisabled = true;\n";
			if ($autoRun)
				$script .= "window.WikiaJavascriptTestRunner.autorun();\n";
			$wgOut->addInlineScript($script);

			$wgOut->addHtml($testSuite->getFrameworkHtml());

		} else {
			$wgOut->addHTML("No test given to run.");
		}

    }

}

class JavascriptTestRunner_TestSuite {

	protected $baseDir = '';
	protected $testFile = '';

	protected $frameworkName = false;
	/**
	 * @var JavascriptTestFramework
	 */
	protected $framework = null;
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
		return (array)JavascriptTestRunner_Constants::$modules[$moduleName];
	}

	protected function loadFile( $fileName ) {
		$contents = file_get_contents( $this->baseDir . '/' . $fileName );
		if ($contents === false)
			return false;

		$lines = preg_split("/\r?\n/",$contents);
		foreach ($lines as $line) {
			$matches = array();
			if (preg_match("/^@test-([^ \t]+)[ \t]+(.*)\$/",trim($line),$matches)) {
				@list( , $command, $value ) = $matches;
				switch ($command) {
					case 'require-group':
						if (class_exists('AssetsManager')) {
							$srcs = AssetsManager::getInstance()->getGroupLocalURL($value);
							if (!is_array($srcs)) $srcs = array( $srcs );
							$this->requiredFiles = array_merge($this->requiredFiles,$srcs);
						}
						break;
					case 'require-module':
						if (isset(JavascriptTestRunner_Constants::$modules[$value])) {
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
		$this->framework = JavascriptTestFramework::newFromName($this->frameworkName);
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

	public function getTestName() {
		return preg_replace("/[^-a-zA-Z0-9]/",'_',$this->testFile);
	}

	public function getFrameworkFiles() {
		if ($this->framework) {
			return $this->framework->javascriptFiles;
		}
		return array();
	}

	public function getFrameworkStyles() {
		if ($this->framework) {
			return $this->framework->styleFiles;
		}
		return array();
	}

	public function getFrameworkHtml() {
		if ($this->framework) {
			return $this->framework->html;
		}
		return '';
	}

	public function getFrameworkForbiddenOutputs() {
		if ($this->framework) {
			return $this->framework->forbiddenOutputs;
		}
		return array();
	}

	public function getFrameworkName() {
		return $this->frameworkName;
	}

}


class JavascriptTestRunner_Constants {

	static public $modules = array(
		'mockjax' => array(
			'resources/jquery/jquery.mockjax.js',
		),
		'rte-prod' => array(
			'extensions/wikia/RTE/ckeditor/ckeditor.js',
		),
		'rte-test' => array(
			'extensions/wikia/RTE/ckeditor/ckeditor_source.js',
			'extensions/wikia/RTE/js/RTE.js'
		),
	);

}
