<?php

/**
 * SassService is a one and only class that you will call from Mediawiki code.
 * It's meant to be a high-level API to the rest of supporting classes.
 *
 * If there is no method here with the given functionality you need,
 * please consider adding new one here instead of using a low-level API
 * directly.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 *
 */
class SassService extends WikiaObject {

	const FILTER_IMPORT_CSS = 1;
	const FILTER_CDN_REWRITE = 2;
	const FILTER_BASE64 = 4;
	const FILTER_JANUS = 8;
	const FILTER_ALL = 255;

	const DEFAULT_ERROR_MESSAGE = 'SASS compilation failed. Check PHP error log for more information.';

	protected static $defaultContext;
	protected static $defaultCompiler;

	protected $sassVariables = null;
	protected $filters = self::FILTER_ALL;
	protected $debug = null;

	/**
	 * Creates a new SassService object based on the Sass source provided.
	 * Please use static constructors instead of calling this constructor directly.
	 *
	 * @param SassSource $source
	 */
	public function __construct( SassSource $source ) {
		parent::__construct();
		$this->source = $source;
	}

	/* METADATA ACCESSORS */

	/**
	 * Returns last modified time of a given Sass source including all its dependencies.
	 * (required by Resource Loader)
	 *
	 * @return int Unix timestamp
	 * @throws SassException
	 */
	public function getModifiedTime() {
		return $this->source->getModifiedTime();
	}

	/**
	 * Returns hash of a given Sass source and all its depenedencies
	 * (required by Assets Manager)
	 *
	 * @return string Hash value (md5)
	 * @throws SassException
	 */
	public function getHash() {
		return $this->source->getHash();
	}


	/* COMPILATION CONFIGURATION STUFF */

	/**
	 * Set custom Sass variables (used during compilation)
	 *
	 * @param $sassVariables array Array with Sass variables
	 * @return $this fluent interface
	 */
	public function setSassVariables( $sassVariables ) {
		$this->sassVariables = $sassVariables;
		return $this;
	}

	/**
	 * Get custom Sass variables (used during compilation)
	 *
	 * @return array Array with Sass variables
	 */
	public function getSassVariables() {
		return $this->sassVariables !== null ? $this->sassVariables : self::getDefaultSassVariables();
	}

	/**
	 * Set filter set that will be applied after compilation.
	 * Filters are controlled by binary flags.
	 *
	 * @param $filters int Set of flags SassService::FILTER_* (FILTER_ALL includes all possible filters)
	 * @return $this fluent interface
	 */
	public function setFilters( $filters ) {
		$this->filters = $filters;
		return $this;
	}

	/**
	 * Get filter set that will be applied after compilation.
	 * Filters are controlled by binary flags.
	 *
	 * @return int Filter set (binary flags: SassService::FILTER_*)
	 */
	public function getFilters() {
		return $this->filters;
	}

	/**
	 * Get RTL flag from custom Sass variables
	 *
	 * @return bool
	 */
	public function getRtl() {
		$sassVariables = $this->getSassVariables();
		return isset($sassVariables['rtl']) ? (bool)$sassVariables['rtl'] : false;
	}

	/**
	 * Get debug flag
	 *
	 * @return bool Debug flag
	 */
	public function getDebug() {
		return $this->debug !== null ? $this->debug : self::getDefaultDebug();
	}

	/* COMPILATION STUFF */

	/**
	 * Compute CSS stylesheet from the given Sass source.
	 * Performs compilation and applies all requested filters on top of it.
	 *
	 * Important: It doesn't use any cache.
	 *
	 * @return string CSS stylesheet
	 */
	public function getCss() {
		$start = 0;
		$afterCompilation = 0;
		$end = 0;
		try {
			/** @var $compiler SassCompiler */
			$compiler = self::getDefaultCompiler()->withOptions(array(
				'sassVariables' => $this->getSassVariables()
			));

			$start = microtime(true);
			$styles = $compiler->compile($this->source);
			$afterCompilation = microtime(true);

			$filters = $this->getFilterObjects();
			/** @var $filter SassFilter */
			foreach ($filters as $filter) {
				$styles = $filter->process($styles);
			}
			$end = microtime(true);

		} catch (Exception $e) {
			$errorId = $this->getUniqueId();
			Wikia::log(__METHOD__, false, "SASS error [{$errorId}]: ". $e->getMessage(), true /* $always */);
			$styles = $this->makeComment(
				$this->getDebug()
					? $this->makeComment($e->getMessage())
					: self::DEFAULT_ERROR_MESSAGE
			);
		}

		$styles .= "\n\n";
		$styles .= $this->makeComment(sprintf("SASS processing time (compilation/total): %.3f/%.3f",
			($afterCompilation - $start) * 1000,
			($end - $start) * 1000
		));

		return $styles;
	}

	/**
	 * Get an array of filter objects that are configured to be applied after compilation.
	 * Filter objects are initialized using default Mediawiki-specific values.
	 *
	 * @return array Array of filter objects
	 */
	protected function getFilterObjects() {
		$IP = $this->wg->get('IP');
		$filters = array();
		if ( $this->filters & self::FILTER_IMPORT_CSS ) {
			$filters[] = new SassFilterCssImports($IP);
		}
		if ( $this->filters & self::FILTER_CDN_REWRITE ) {
			$filters[] = new SassFilterCdnRewrite($this->wg->CdnStylePath);
		}
		if ( $this->filters & self::FILTER_BASE64 ) {
			$filters[] = new SassFilterBase64($IP);
		}
		if ( $this->filters & self::FILTER_JANUS ) {
			$filters[] = new SassFilterJanus($IP,$this->getRtl());
		}
		return $filters;
	}

	/* UTILITIES */

	/**
	 * Get a JS/CSS comment with the given text
	 *
	 * @param $text string Text to be put in the comment
	 * @return string Input text wrapped in the comment
	 */
	protected function makeComment( $text ) {
		$encText = str_replace( '*/', '* /', $text );
		return "/*\n$encText\n*/\n";
	}

	/**
	 * Generate a unique ID containing 16 alphanumeric characters (digits and lower letters).
	 * (used for generating an error ID)
	 *
	 * @return string Unique ID
	 */
	protected function getUniqueId() {
		$chars = '0123456789abcedfghijklmnopqrstuvwxyz';
		$maxIndex = strlen($chars) - 1;
		$s = '';
		for ($i=0;$i<16;$i++) {
			$s .= $chars[rand(0,$maxIndex)];
		}
		return $s;
	}

	/* STATIC UTILITIES */

	/**
	 * Create a new SassService instance associated with the given file inside the codebase.
	 *
	 * @param $fileName string Path to Sass file (relative to code base root)
	 * @return SassService SassService instance
	 */
	public static function newFromFile( $fileName ) {
		$context = self::getDefaultContext();
		$source = $context->getFile($fileName);
		return new self($source);
	}

	/**
	 * Create a new SassService instance associated with the Sass source in the given string
	 *
	 * @param $sourceString string Sass source code
	 * @param $modifiedTime int Last modified time (unix timestamp)
	 * @param $description string Human readable description of the content
	 * @return SassService SassService instance
	 */
	public static function newFromString( $sourceString, $modifiedTime, $description ) {
		$context = self::getDefaultContext();
		$source = new SassStringSource($context,$sourceString,$modifiedTime,$description);
		return new self($source);
	}

	/**
	 * Get a default Sass source context instance
	 *
	 * @return SassSourceContext
	 */
	public static function getDefaultContext() {
		if ( self::$defaultContext === null ) {
			$app = F::app();
			self::$defaultContext = new SassSourceContext($app->getGlobal('IP'));
		}

		return self::$defaultContext;
	}

	/**
	 * Get a default Sass compiler instance
	 *
	 * @return SassExternalRubyCompiler
	 */
	public static function getDefaultCompiler() {
		if ( self::$defaultCompiler === null ) {
			$app = F::app();
			self::$defaultCompiler = new SassExternalRubyCompiler(array(
				'rootDir' => $app->getGlobal('IP'),
				'sassExecutable' => $app->wg->SassExecutable,
//				'outputStyle' => 'expanded',
			));
		}

		return self::$defaultCompiler;
	}

	/**
	 * Get a default for custom Sass variables.
	 * Currently returns Sass variables associated with current wiki.
	 *
	 * @return array Array of Sass variables
	 */
	protected static function getDefaultSassVariables() {
		return SassUtil::getSassSettings();
	}

	/**
	 * Get a default debug flag.
	 * Currently returns true for development environment, false otherwise.
	 *
	 * @return bool Debug flag
	 */
	protected static function getDefaultDebug() {
		$app = F::app();
		return !empty($app->wg->DevelEnvironment);
	}

}