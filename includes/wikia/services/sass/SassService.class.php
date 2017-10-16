<?php

use Wikia\Sass\Source\Context;
use Wikia\Sass\Source\Source;
use Wikia\Sass\Source\StringSource;
use Wikia\Sass\Filter\Filter;
use Wikia\Sass\Filter\CssImportsFilter;
use Wikia\Sass\Filter\CdnRewriteFilter;
use Wikia\Sass\Filter\InlineImageFilter;
use Wikia\Sass\Filter\JanusFilter;
use Wikia\Sass\Filter\MinifyFilter;
use Wikia\Sass\Compiler\Compiler;
use Wikia\Sass\Compiler\LibSassCompiler;

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
class SassService {

	use Wikia\Logger\Loggable;

	const CACHE_VERSION = 7; # SASS caching does not depend on $wgStyleVersion, use this constant to bust SASS cache

	const FILTER_IMPORT_CSS = 1;
	const FILTER_CDN_REWRITE = 2;
	const FILTER_BASE64 = 4;
	const FILTER_JANUS = 8;
	const FILTER_MINIFY = 16;

	const DEFAULT_ERROR_MESSAGE = 'SASS compilation failed. Check PHP error log for more information. Error ID: ';

	protected static $defaultContext;
	protected static $defaultCompiler;

	protected $sassVariables = null;
	protected $filters = 0;
	protected $cacheVariant = '';
	protected $debug = null;
	protected $useSourceMaps = false;

	protected $app;

	/**
	 * Creates a new SassService object based on the Sass source provided.
	 * Please use static constructors instead of calling this constructor directly.
	 *
	 * @param Source $source
	 */
	private function __construct( Source $source ) {
		$this->app = F::app();
		$this->source = $source;

		// vary caching for devboxes
		if (!empty($this->wg->DevelEnvironment)) {
			$this->setCacheVariant("dev-{$this->wg->DevelEnvironmentName}");
		}
	}

	/* METADATA ACCESSORS */

	/**
	 * Returns last modified time of a given Sass source including all its dependencies.
	 * (required by Resource Loader)
	 *
	 * @return int Unix timestamp
	 * @throws \Wikia\Sass\Exception
	 */
	public function getModifiedTime() {
		return $this->source->getModifiedTime();
	}

	/**
	 * Returns hash of a given Sass source and all its depenedencies
	 * (required by Assets Manager)
	 *
	 * @return string Hash value (md5)
	 * @throws \Wikia\Sass\Exception
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
	 * Set cache variant name
	 *
	 * @param $cacheVariant string Cache variant name
	 * @return $this fluent interface
	 */
	public function setCacheVariant( $cacheVariant ) {
		$this->cacheVariant = $cacheVariant;
		return $this;
	}

	/**
	 * Get cache variant name
	 *
	 * @return string Cache variant name
	 */
	public function getCacheVariant() {
		return $this->cacheVariant;
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

	/**
	 * Enable / disable source maps
	 *
	 * @see http://bricss.net/post/33788072565/using-sass-source-maps-in-webkit-inspector
	 *
	 * @param $enable bool enable?
	 */
	public function enableSourceMaps($enable) {
		$this->useSourceMaps = $enable === true;
	}

	/* COMPILATION STUFF */

	/**
	 * Compute CSS stylesheet from the given Sass source.
	 * Performs compilation and applies all requested filters on top of it.
	 *
	 * @param $useCache bool Use cache?
	 * @return string CSS stylesheet
	 * @throws \Wikia\Sass\Exception
	 */
	public function getCss( $useCache = true ) {
		// first try cache
		$memc = self::getMemcached();
		$cacheKey = null;
		if ( $useCache ) {
			$cacheKey = wfSharedMemcKey( __CLASS__, $this->getCacheKey() );
			$cachedStyles = $memc->get( $cacheKey );
			if ( is_string( $cachedStyles ) ) {
				return $cachedStyles;
			}
		}

		// otherwise generate it from the scratch
		$ok = false;
		$start = 0;
		$afterCompilation = 0;
		$end = 0;
		try {
			/** @var $compiler LibSassCompiler */
			$compiler = self::getDefaultCompiler()->withOptions(array(
				'sassVariables' => $this->getSassVariables(),
				'useSourceMaps' => $this->useSourceMaps
			));

			$start = microtime(true);
			$styles = $compiler->compile($this->source);
			$afterCompilation = microtime(true);

			$filters = $this->getFilterObjects();
			/** @var $filter Filter */
			foreach ($filters as $filter) {
				$styles = $filter->process($styles);
			}
			$styles = trim($styles);
			$end = microtime(true);

			if (empty($styles)) {
				throw new \Wikia\Sass\Exception('Empty style');
			}

			$ok = true;

		} catch (\Exception $e) {
			if ( empty( $afterCompilation ) ) $afterCompilation = microtime(true);
			if ( empty( $end ) ) $end = microtime(true);

			$fileName = $this->source->getHumanName();
			$errorId = $this->getUniqueId();

			$errorMessage = $this->getDebug()
				? ("SASS error [{$errorId}]: " . $e->getMessage())
				: (self::DEFAULT_ERROR_MESSAGE . $errorId);
			$ex = new \Wikia\Sass\Exception( $errorMessage, 0, $e );

			$this->error( __METHOD__, [
				'exception' => $ex,
				'error_id' => $errorId,
				'file_name' => $fileName,
			] );
			throw $ex;
		}

		$styles .= "\n\n";
		$styles .= $this->makeComment(sprintf("SASS processing time (compilation/total): %.3fms/%.3fms [using %s]",
			($afterCompilation - $start) * 1000,
			($end - $start) * 1000,
			get_class( self::getDefaultCompiler() )
		));

		// save it to the cache if everything went correct
		if ( $useCache && $ok ) {
			$memc->set( $cacheKey, $styles, WikiaResponse::CACHE_LONG );
		}

		return $styles;
	}

	public function getCacheKey() {
		return sprintf("%s%s%s",
			$this->getCacheVariant() ? $this->getCacheVariant() . '-' : '',
			md5(serialize([
				$this->getHash(),
				$this->getSassVariables(),
				$this->getFilters(),
				self::CACHE_VERSION
			])),
			$this->useSourceMaps ? '-with-source-maps' : ''
		);
	}

	/**
	 * Get an array of filter objects that are configured to be applied after compilation.
	 * Filter objects are initialized using default Mediawiki-specific values.
	 *
	 * @return array Array of filter objects
	 */
	protected function getFilterObjects() {
		$IP = $this->app->getGlobal('IP');
		$filters = array();
		if ( $this->filters & self::FILTER_IMPORT_CSS ) {
			$filters[] = new CssImportsFilter($IP);
		}
		if ( $this->filters & self::FILTER_CDN_REWRITE ) {
			$filters[] = new CdnRewriteFilter($this->app->wg->CdnStylePath);
		}
		if ( $this->filters & self::FILTER_BASE64 ) {
			$filters[] = new InlineImageFilter($IP);
		}
		if ( $this->filters & self::FILTER_JANUS ) {
			$filters[] = new JanusFilter($IP,$this->getRtl());
		}
		if ( $this->filters & self::FILTER_MINIFY ) {
			$filters[] = new MinifyFilter();
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
	 * Get a default Sass source context instance
	 *
	 * @return Context
	 */
	public static function getDefaultContext() {
		if ( self::$defaultContext === null ) {
			$app = F::app();
			self::$defaultContext = new Context($app->getGlobal('IP'));
		}

		return self::$defaultContext;
	}

	/**
	 * Get a default Sass compiler instance
	 *
	 * @return LibSassCompiler
	 */
	public static function getDefaultCompiler() {
		if ( self::$defaultCompiler === null ) {
			$app = F::app();
			self::$defaultCompiler = new LibSassCompiler( [
				'rootDir' => $app->getGlobal('IP'),
			] );
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

	protected static function getMemcached() {
		$app = F::app();
		return $app->wg->Memc;
	}

	/* STATIC CONSTRUCTORS */

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
		$source = new StringSource($context,$sourceString,$modifiedTime,$description);
		return new self($source);
	}

}
