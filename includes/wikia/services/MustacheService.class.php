<?php

class MustacheService {

	const REGEX_PARTIALS = '/{{>(.*?)}}/';

	const INFO_TEMPLATE = 'template';
	const INFO_DEPENDENCIES = 'dependencies';

	protected $cache = array();

	protected function __construct() {}

	protected function getTemplateInfo( $fileName ) {
		if ( !empty($this->cache[$fileName] ) ) {
			return $this->cache[$fileName];
		}

		$dirName = dirname($fileName) . '/';
		$dependencies = array();
		$template = file_get_contents($fileName);
		$template = preg_replace_callback(
			self::REGEX_PARTIALS,
			function($matches) use (&$dependencies,$dirName) {
				$relName = $matches[1];
				$depName = $dirName . $relName . '.mustache';
				$depName = realpath($depName);
				$dependencies[] = $depName;
				return "{{>{$depName}}}";
			},
			$template);

		$templateInfo = array(
			self::INFO_TEMPLATE => $template,
			self::INFO_DEPENDENCIES => $dependencies,
		);
		$this->cache[$fileName] = $templateInfo;

		return $templateInfo;
	}

	protected function addDependencies( &$partials, $fileName ) {
		if ( !empty($partials[$fileName])) {
			return true;
		}

		$templateInfo = $this->getTemplateInfo($fileName);
		if ( empty($templateInfo) ) {
			return false;
		}

		$partials[$fileName] = $templateInfo[self::INFO_TEMPLATE];
		foreach ($templateInfo[self::INFO_DEPENDENCIES] as $depFileName) {
			$this->addDependencies($partials,$depFileName);
		}
		return true;
	}

	public function render( $fileName, $data ) {
		$fileName = realpath($fileName);
		$partials = array();
		$this->addDependencies($partials,$fileName);
		$template = $partials[$fileName];

		var_dump($partials);

		$mustache = new Mustache();
		return $mustache->render($template,$data,$partials);
	}

	public static function getInstance() {
		static $instance;
		if ( empty( $instance ) ) {
			$instance = new self;
		}
		return $instance;
	}

}