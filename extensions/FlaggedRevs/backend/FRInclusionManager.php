<?php
/**
 * Class containing template/file version usage requirements for
 * Parser based on the source text (being parsed) revision ID.
 *
 * Parser hooks check this to determine what template/file version to use.
 * If no requirements are set, the page is parsed as normal.
 */
class FRInclusionManager {
	protected $reviewedVersions = null; // files/templates at review time
	protected $stableVersions = array(); // stable versions of files/templates

	protected static $instance = null;

	public static function singleton() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	protected function __clone() { }

	protected function __construct() {
		$this->stableVersions['templates'] = array();
		$this->stableVersions['files'] = array();
	}

	/**
	 * Reset all template/image version data
	 * @return void
	 */
	public function clear() {
		$this->reviewedVersions = null;
		$this->stableVersions['templates'] = array();
		$this->stableVersions['files'] = array();
	}

	/**
	 * (a) Stabilize inclusions in Parser output
	 * (b) Set the template/image versions used in the flagged version of a revision
	 * @param array $tmpParams (ns => dbKey => revId )
	 * @param array $imgParams (dbKey => array('time' => MW timestamp,'sha1' => sha1) )
	 */
	public function setReviewedVersions( array $tmpParams, array $imgParams ) {
		$this->reviewedVersions = array();
		$this->reviewedVersions['templates'] = self::formatTemplateArray( $tmpParams );
		$this->reviewedVersions['files'] = self::formatFileArray( $imgParams );
	}

	/**
	 * Set the stable versions of some template/images
	 * @param array $tmpParams (ns => dbKey => revId )
	 * @param array $imgParams (dbKey => array('time' => MW timestamp,'sha1' => sha1) )
	 */
	public function setStableVersionCache( array $tmpParams, array $imgParams ) {
		$this->stableVersions['templates'] = self::formatTemplateArray( $tmpParams );
		$this->stableVersions['files'] = self::formatFileArray( $imgParams );
	}

	/**
	 * Clean up a template version array
	 * @param array $tmpParams (ns => dbKey => revId )
	 * @return array
	 */	
	protected function formatTemplateArray( array $params ) {
		$res = array();
		foreach ( $params as $ns => $templates ) {
			$res[$ns] = array();
			foreach ( $templates as $dbKey => $revId ) {
				$res[$ns][$dbKey] = (int)$revId;
			}
		}
		return $res;
	}

	/**
	 * Clean up a file version array
	 * @param array $imgParams (dbKey => array('time' => MW timestamp,'sha1' => sha1) )
	 * @return array
	 */	
	protected function formatFileArray( array $params ) {
		$res = array();
		foreach ( $params as $dbKey => $timeKey ) {
			$time = '0'; // missing
			$sha1 = false;
			if ( $timeKey['time'] ) {
				$time = $timeKey['time'];
				$sha1 = strval( $timeKey['sha1'] );
			}
			$res[$dbKey] = array( 'time' => $time, 'sha1' => $sha1 );
		}
		return $res;
	}

	/**
	 * (a) Stabilize inclusions in Parser output
	 * (b) Load all of the "review time" versions of template/files from $frev
	 * (c) Load their stable version counterparts (avoids DB hits)
	 * Note: Used when calling FlaggedRevs::parseStableText().
	 * @param FlaggedRevision $frev
	 * @return void
	 */
	public function stabilizeParserOutput( FlaggedRevision $frev ) {
		$tStbVersions = $fStbVersions = array(); // stable versions
		$tRevVersions = $frev->getTemplateVersions();
		$fRevVersions = $frev->getFileVersions();
		# We can preload *most* of the stable version IDs the parser will need...
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE ) {
			$tStbVersions = $frev->getStableTemplateVersions();
			$fStbVersions = $frev->getStableFileVersions();
		}
		$this->setReviewedVersions( $tRevVersions, $fRevVersions );
		$this->setStableVersionCache( $tStbVersions, $fStbVersions );
	}

	/**
	 * Should Parser stabilize includes?
	 * @return bool
	 */
	public function parserOutputIsStabilized() {
		return is_array( $this->reviewedVersions );
	}

	/**
	 * Get the "review time" template version for parser
	 * @param Title $title
	 * @return mixed (int/null)
	 */
	public function getReviewedTemplateVersion( Title $title ) {
		if ( !is_array( $this->reviewedVersions ) ) {
			throw new MWException( "prepareForParse() nor setReviewedVersions() called yet" );
		}
		$dbKey = $title->getDBkey();
		$namespace = $title->getNamespace();
		if ( isset( $this->reviewedVersions['templates'][$namespace][$dbKey] ) ) {
			return $this->reviewedVersions['templates'][$namespace][$dbKey];
		}
		return null; // missing version
	}

	/**
	 * Get the "review time" file version for parser
	 * @param Title $title
	 * @return array (MW timestamp/'0'/null, sha1/''/null )
	 */
	public function getReviewedFileVersion( Title $title ) {
		if ( !is_array( $this->reviewedVersions ) ) {
			throw new MWException( "prepareForParse() nor setReviewedVersions() called yet" );
		}
		$dbKey = $title->getDBkey();
		# All NS_FILE, no need to check namespace
		if ( isset( $this->reviewedVersions['files'][$dbKey] ) ) {
			$time = $this->reviewedVersions['files'][$dbKey]['time'];
			$sha1 = $this->reviewedVersions['files'][$dbKey]['sha1'];
			return array( $time, $sha1 );
		}
		return array( null, null ); // missing version
	}

	/**
	 * Get the stable version of a template
	 * @param Title $title
	 * @return int
	 */
	public function getStableTemplateVersion( Title $title ) {
		$dbKey = $title->getDBkey();
		$namespace = $title->getNamespace();
		$id = null;
		if ( isset( $this->stableVersions['templates'][$namespace][$dbKey] ) ) {
			$id = $this->stableVersions['templates'][$namespace][$dbKey];
		}
		if ( $id === null ) { // cache miss
			$id = FlaggedRevision::getStableRevId( $title );
		}
		$this->stableVersions['templates'][$namespace][$dbKey] = $id; // cache
		return $id;
	}

	/**
	 * Get the stable version of a file
	 * @param Title $title
	 * @return array (MW timestamp/'0', sha1/'')
	 */
	public function getStableFileVersion( Title $title ) {
		$dbKey = $title->getDBkey();
		$time = '0'; // missing
		$sha1 = false;
		# All NS_FILE, no need to check namespace
		if ( isset( $this->stableVersions['files'][$dbKey] ) ) {
			$time = $this->stableVersions['files'][$dbKey]['time'];
			$sha1 = $this->stableVersions['files'][$dbKey]['sha1'];
			return array( $time, $sha1 );
		}
		$srev = FlaggedRevision::newFromStable( $title );
		if ( $srev && $srev->getFileTimestamp() ) {
			$time = $srev->getFileTimestamp();
			$sha1 = $srev->getFileSha1();
		}
		$this->stableVersions['files'][$dbKey] = array();
		$this->stableVersions['files'][$dbKey]['time'] = $time;
		$this->stableVersions['files'][$dbKey]['sha1'] = $sha1;
		return array( $time, $sha1 );
	}
}
