<?php

/**
 * MustacheService is a wrapper for actual Mustache implementation
 * that automatically searches for all required partials and prefetches them
 * in order to supply Mustache engine (either in PHP or JS) with all necessary
 * dependencies.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class MustacheService {

	const REGEX_PARTIALS = '/{{>\s*([^{}]*?)}}/';

	const TEMPLATE = 'template';
	const DEPENDENCIES = 'dependencies';

	private $cache = array();

	/**
	 * Singleton - use MustacheService::getInstance() instead
	 */
	private function __construct() {}

	/**
	 * Get a converted template contents and its dependency list
	 *
	 * @param $fileName string File path (absolute)
	 * @return array Array containing requested data, keys are:
	 * - MustacheService::TEMPLATE - contains template contents
	 * - MustacheService::DEPENDENCIES - list of all partials that may be included
	 * @throws Exception Thrown if any partial cannot be found
	 */
	private function getTemplateInfo( $fileName ) {
		if ( !empty($this->cache[$fileName] ) ) {
			return $this->cache[$fileName];
		}

		$dirName = dirname($fileName) . '/';
		$dependencies = array();
		$template = file_get_contents($fileName);
		$template = preg_replace_callback(
			self::REGEX_PARTIALS,
			function($matches) use (&$dependencies,$fileName,$dirName) {
				$relName = $matches[1];
				$depName = $dirName . $relName . '.mustache';
				$depName = realpath($depName);
				if ( empty( $depName ) ) { // partial doesn't exist
					throw new Exception("Template \"{$fileName}\" references partial \"{$matches[1]}\" that was not found.");
				}
				$dependencies[] = $depName;
				return "{{>{$depName}}}";
			},
			$template);

		$templateInfo = array(
			self::TEMPLATE => $template,
			self::DEPENDENCIES => $dependencies,
		);
		$this->cache[$fileName] = $templateInfo;

		return $templateInfo;
	}

	/**
	 * Recursively adds all partials that may be required to render the following
	 * Mustache template
	 *
	 * @param $partials array Partials list (out reference)
	 * @param $fileName string File path (absolute)
	 * @return bool
	 * @throws Exception Thrown if any partial cannot be found
	 */
	private function addDependencies( &$partials, $fileName ) {
		if ( !empty($partials[$fileName])) {
			return true;
		}

		$templateInfo = $this->getTemplateInfo($fileName);
		if ( empty($templateInfo) ) {
			return false;
		}

		$partials[$fileName] = $templateInfo[self::TEMPLATE];
		foreach ($templateInfo[self::DEPENDENCIES] as $depFileName) {
			$this->addDependencies($partials,$depFileName);
		}

		return true;
	}

	/**
	 * Get a parsed data that is compatible with Mustache PHP extension
	 * (it literally means resolving all objects and resources).
	 *
	 * All objects are converted to theirs string representatives except
	 * instances of stdClass that get enumerated.
	 *
	 * All resources are converted to theirs string representatives.
	 *
	 * @param $data mixed Input data
	 * @return mixed Parsed data that is safe to be submitted to Mustache PHP extension
	 */
	public function parseData( $data ) {
		if ( is_array( $data )
			|| is_object( $data ) && strtolower(get_class($data)) == 'stdclass'
		) {
			$res = array();
			foreach ($data as $k => $v) {
				$res[$k] = $this->parseData($v);
			}
		} else if ( is_bool($data) || is_int($data) || is_float($data) ) {
			$res = $data;
		} else {
			$res = (string)$data;
		}
		return $res;
	}

	/**
	 * Get a full list of partials that are required to correctly render given template
	 *
	 * @param $fileName string File path (absolute)
	 * @return array List of partials
	 * @throws Exception Thrown if any partial cannot be found
	 */
	public function getDependencies( $fileName ) {
		$fileName = realpath($fileName);
		$partials = array();
		$this->addDependencies($partials,$fileName);

		return $partials;
	}

	/**
	 * Render given template using supplied data
	 *
	 * @param $fileName string Template file path (absolute)
	 * @param $data array Data to be rendered
	 * @return string Template output
	 * @throws Exception Thrown if any partial cannot be found
	 */
	public function render( $fileName, $data ) {
		list( $template, $partials ) = $this->getTemplateAndPartials( $fileName );

		// Note: php-mustache segfaults when objects are present in data
		// so pre-process them before sending to renderer
		$data = $this->parseData($data);

		if( class_exists('Mustache') ) {
			$mustache = new Mustache();
		} else {
			$mustache = new MustachePHP();
		}

		return $mustache->render($template,$data,$partials);
	}

	/**
	 * Get a template along with all partials used for use anywhere
	 *
	 * @param $fileName string
	 * @return array [ $template, $partials ]
	 * @throws Exception
	 */
	public function getTemplateAndPartials( $fileName ) {
		$realFileName = realpath( $fileName );
		if ( empty( $realFileName ) ) {
			throw new Exception( "Template \"{$fileName}\" was not found." );
		}
		$partials = $this->getDependencies( $realFileName );
		$template = $partials[$realFileName];

		return array( $template, $partials );
	}

	/**
	 * Get a singleton instance of MustacheService
	 *
	 * @return MustacheService Singleton
	 */
	public static function getInstance() {
		static $instance;
		if ( empty( $instance ) ) {
			$instance = new self;
		}
		return $instance;
	}

}
