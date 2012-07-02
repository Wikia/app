<?php

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "SiteMatrix extension\n";
    exit( 1 );
}

global $IP;
require_once( $IP.'/languages/Names.php' );

class SiteMatrix {
	protected $langlist, $sites, $names, $hosts;
	protected $private = null, $fishbowl = null, $closed = null;
	protected $specials, $matrix, $count, $countPerSite;

	public function __construct(){
		global $wgSiteMatrixFile, $wgSiteMatrixSites;
		global $wgLocalDatabases, $wgConf;

		$wgConf->loadFullData();

		if( file_exists( $wgSiteMatrixFile ) ){
			$this->langlist = $this->extractFile( $wgSiteMatrixFile );
			$hideEmpty = false;
		} else {
			$this->langlist = array_keys( Language::getLanguageNames( false ) );
			$hideEmpty = true;
		}

		sort( $this->langlist );
		$xLanglist = array_flip( $this->langlist );

		$this->sites = array();
		$this->names = array();
		$this->hosts = array();

		foreach( $wgSiteMatrixSites as $site => $conf ){
			$this->sites[] = $site;
			$this->names[$site] = $conf['name'] . ( isset( $conf['prefix'] ) ?
				'<br />' . $conf['prefix'] : '' );
			$this->hosts[$site] = $conf['host'];
		}

		# Initialize $countPerSite
		$this->countPerSite = array();
		foreach( $this->sites as $site ) {
			$this->countPerSite[$site] = 0;
		}

		# Tabulate the matrix
		$this->specials = array();
		$this->matrix = array();
		foreach( $wgLocalDatabases as $db ) {
			# Find suffix
			$found = false;
			foreach ( $this->sites as $site ) {
				$m = array();
				if ( preg_match( "/(.*)$site\$/", $db, $m ) ) {
					$lang = $m[1];
					$langhost = str_replace( '_', '-', $lang);
					if( isset( $xLanglist[$langhost] ) ) {
						$this->matrix[$site][$langhost] = 1;
						$this->countPerSite[$site]++;
					} else {
						$this->specials[] = array( $lang, $site );
					}
					$found = true;
					break;
				}
			}
			if( !$found ){
				list( $major, $minor ) = $wgConf->siteFromDB( $db );
				$this->specials[] = array( str_replace( '-', '_', $minor ), $major );
			}
		}

		uasort( $this->specials, array( __CLASS__, 'sortSpecial' ) );

		if( $hideEmpty ){
			foreach( $xLanglist as $lang => $unused ){
				$empty = true;
				foreach ( $this->sites as $site ) {
					if( !empty( $this->matrix[$site][$lang] ) ){
						$empty = false;
					}
				}
				if( $empty ){
					unset( $xLanglist[$lang] );
				}
			}
			$this->langlist = array_keys( $xLanglist );
		}

		$this->count = count( $wgLocalDatabases );
	}

	public static function sortSpecial( $a1, $a2 ){
		return strcmp( $a1[0], $a2[0] );
	}

	public function getLangList(){
		return $this->langlist;
	}

	public function getNames(){
		return $this->names;
	}

	public function getSites(){
		return $this->sites;
	}

	public function getSpecials(){
		return $this->specials;
	}

	public function getCount(){
		return $this->count;
	}

	public function getCountPerSite( $site ){
		return $this->countPerSite[$site];
	}

	public function getSiteUrl( $site ){
		return '//' . $this->hosts[$site] . '/';
	}

	/**
	 * @param string $minor Language
	 * @param string $major Site
	 * @param bool $canonical: use getCanonicalUrl()
	 * @return Mixed
	 */
	public function getUrl( $minor, $major, $canonical = false ) {
		global $wgConf;
		$dbname = $this->getDBName( $minor, $major );
		$minor = str_replace( '_', '-', $minor );
		return $wgConf->get( $canonical ? 'wgCanonicalServer' : 'wgServer',
			$dbname, $major, array( 'lang' => $minor, 'site' => $major )
		);
	}

	/**
	 * @param string $minor Language
	 * @param string $major Site
	 * @return Mixed
	 */
	public function getCanonicalUrl( $minor, $major ) {
		return $this->getUrl( $minor, $major, true );
	}

	/**
	 * @param $minor string
	 * @param $major string
	 * @return string
	 */
	public function getDBName( $minor, $major ) {
		return str_replace( '-', '_', $minor ) . $major;
	}

	/**
	 * @param string $minor Language
	 * @param string $major Site
	 * @return bool
	 */
	public function exist( $minor, $major ){
		return !empty( $this->matrix[$major][$minor] );
	}

	/**
	 * @param string $minor Language
	 * @param string $major Site
	 * @return bool
	 */
	public function isClosed( $minor, $major ) {
		global $wgSiteMatrixClosedSites;

		$dbname = $this->getDBName( $minor, $major );

		if ( $wgSiteMatrixClosedSites === null ) {
			// Fallback to old behavior checking read-only settings;
			// not very reliable.
			global $wgConf;

			if( $wgConf->get( 'wgReadOnly', $dbname, $major, array( 'site' => $major, 'lang' => $minor ) ) ) {
				return true;
			}
			$readOnlyFile = $wgConf->get( 'wgReadOnlyFile', $dbname, $major, array( 'site' => $major, 'lang' => $minor ) );
			if( $readOnlyFile && file_exists( $readOnlyFile ) ) {
				return true;
			}
			return false;
		}

		if( $this->closed == null ) {
			$this->closed = $this->extractDbList( $wgSiteMatrixClosedSites );
		}
		return in_array( $dbname, $this->closed );
	}

	/**
	 * @param string $dbname DatabaseName
	 * @return bool
	 */
	public function isPrivate( $dbname ) {
		global $wgSiteMatrixPrivateSites;

		if ( $this->private == null ) {
			$this->private = $this->extractDbList( $wgSiteMatrixPrivateSites );
		}

		return in_array( $dbname, $this->private );
	}

	/**
	 * @param string $dbname DatabaseName
	 * @return bool
	 */
	public function isFishbowl( $dbname ) {
		global $wgSiteMatrixFishbowlSites;

		if ( $this->fishbowl == null ) {
			$this->fishbowl = $this->extractDbList( $wgSiteMatrixFishbowlSites );
		}

		return in_array( $dbname, $this->fishbowl );
	}

	/**
	 * @param string $dbname DatabaseName
	 * @return bool
	 */
	public function isSpecial( $dbname ) {
		return in_array( $dbname, $this->specials );
	}

	/**
	 * Pull a list of dbnames from a given text file, or pass through an array.
	 * Used for the DB list configuration settings.
	 *
	 * @param mixed $listOrFilename array of strings, or string with a filename
	 * @return array
	 */
	private function extractDbList( $listOrFilename ) {
		if ( is_string( $listOrFilename ) ) {
			return $this->extractFile( $listOrFilename );
		} elseif ( is_array( $listOrFilename ) ) {
			return $listOrFilename;
		} else {
			return array();
		}
	}

	/**
	 * Pull a list of dbnames from a given text file.
	 *
	 * @param string $filename
	 * @return array
	 */
	private function extractFile( $filename ) {
		return array_map( 'trim', file( $filename ) );
	}

	/**
	 * Handler method for the APISiteInfoGeneralInfo hook
	 *
	 * @static
	 * @param ApiQuerySiteinfo $module
	 * @param array $results
	 * @return bool
	 */
	public static function APIQuerySiteInfoGeneralInfo( $module, &$results ) {
		global $wgDBname, $wgConf;

		$matrix = new SiteMatrix();

		list( $site, $lang ) = $wgConf->siteFromDB( $wgDBname );

		if ( $matrix->isClosed( $lang, $site ) )  {
			$results['closed'] = '';
		}

		if ( $matrix->isSpecial( $wgDBname ) )  {
			$results['special'] = '';
		}

		if ( $matrix->isPrivate( $wgDBname ) )  {
			$results['private'] = '';
		}

		if ( $matrix->isFishbowl( $wgDBname ) )  {
			$results['fishbowl'] = '';
		}

		return true;
	}
}

class SiteMatrixPage extends SpecialPage {

	function __construct() {
		parent::__construct( 'SiteMatrix' );
	}

	/**
	 * @return array
	 */
	public static function getLocalLanguageNames() {
		if( class_exists( 'LanguageNames' ) ) {
			global $wgLang;
			return LanguageNames::getNames( $wgLang->getCode() );
		}
		return array();
	}

	function execute( $par ) {
		global $wgOut;
		$langNames = Language::getLanguageNames();

		$this->setHeaders();
		$this->outputHeader();

		$matrix = new SiteMatrix();

		$localLanguageNames = self::getLocalLanguageNames();

		# Construct the HTML

		# Header row
		$s = Xml::openElement( 'table', array( 'class' => 'wikitable', 'id' => 'mw-sitematrix-table' ) ) .
			"<tr>" .
				Xml::element( 'th', array( 'rowspan' => 2 ), wfMsg( 'sitematrix-language' ) ) .
				Xml::element( 'th', array( 'colspan' => count( $matrix->getSites() ) ), wfMsg( 'sitematrix-project' ) ) .
			"</tr>
			<tr>";
		foreach ( $matrix->getNames() as $id => $name ) {
			$url = $matrix->getSiteUrl( $id );
			$s .= Xml::tags( 'th', null, "<a href=\"{$url}\">{$name}</a>" );
		}
		$s .= "</tr>\n";

		# Bulk of table
		foreach ( $matrix->getLangList() as $lang ) {
			$anchor = strtolower( '<a id="' . htmlspecialchars( $lang ) . '" name="' . htmlspecialchars( $lang ) . '"></a>' );
			$s .= '<tr>';
			$attribs = array();
			if( isset( $localLanguageNames[$lang] ) ) {
				$attribs['title'] = $localLanguageNames[$lang];
			}

			$langDisplay = ( isset( $langNames[$lang] ) ? $langNames[$lang] : '' );
			if ( isset( $localLanguageNames[$lang] ) && strlen( $localLanguageNames[$lang] ) && $langDisplay != $localLanguageNames[$lang] ) {
				$langDisplay .= ' (' . $localLanguageNames[$lang] . ')';
			}
			$s .= '<td>' . $anchor . Xml::element( 'strong', $attribs, $langDisplay ) . '</td>';

			foreach ( $matrix->getNames() as $site => $name ) {
				$url = $matrix->getUrl( $lang, $site );
				if ( $matrix->exist( $lang, $site ) ) {
					# Wiki exists
					$closed = $matrix->isClosed( $lang, $site );
					$s .= "<td>" . ($closed ? "<del>" : '') . "<a href=\"{$url}\">{$lang}</a>" . ($closed ? "</del>" : '') . '</td>';
				} else {
					# Non-existent wiki
					$s .= "<td><a href=\"{$url}\" class=\"new\">{$lang}</a></td>";
				}
			}
			$s .= "</tr>\n";
		}

		$language = $this->getLanguage();
		# Total
		$totalCount = 0;
		$s .= '<tr><th rowspan="2"><a id="total" name="total"></a>' . wfMsgHtml( 'sitematrix-sitetotal' ) . '</th>';
		foreach( $matrix->getNames() as $site => $name ) {
			$url = $matrix->getSiteUrl( $site );
			$count = $matrix->getCountPerSite( $site );
			$totalCount += $count;
			$count = $language->formatNum( $count );
			$s .= "<th><a href=\"{$url}\">{$count}</a></th>";
		}
		$s .= '</tr>';

		$s .= '<tr>';
		$noProjects = count( $matrix->getNames() );
		$totalCount = $language->formatNum( $totalCount );
		$s .= "<th colspan=\"{$noProjects }\">{$totalCount}</th>";
		$s .= '</tr>';

		$s .= Xml::closeElement( 'table' ) . "\n";

		# Specials
		$s .= '<h2 id="mw-sitematrix-others">' . wfMsg( 'sitematrix-others' ) . '</h2>';

		$s .= Xml::openElement( 'table', array( 'class' => 'wikitable', 'id' => 'mw-sitematrix-other-table' ) ) .
			"<tr>" .
				Xml::element( 'th', null, wfMsg( 'sitematrix-other-projects' ) ) .
			"</tr>";

		foreach ( $matrix->getSpecials() as $special ) {
			list( $lang, $site ) = $special;
			$langhost = str_replace( '_', '-', $lang );
			$url = $matrix->getUrl( $lang, $site );

			# Handle options
			$flags = array();
			if( $matrix->isPrivate( $lang . $site ) ) {
				$flags[] = wfMsgHtml( 'sitematrix-private' );
			}
			if( $matrix->isFishbowl( $lang . $site ) ) {
				$flags[] = wfMsgHtml( 'sitematrix-fishbowl' );
			}
			$flagsStr = implode( ', ', $flags );
			if( $site != 'wiki' ) {
				$langhost .= $site;
			}
			$closed = $matrix->isClosed( $lang, $site );
			$s .= '<tr><td>' . ( $closed ? '<del>' : '' ) .
				$language->specialList( '<a href="' . $url . '/">' . $langhost . "</a>", $flagsStr ) .
				( $closed ? '</del>' : '' ) . "</td></tr>\n";
		}

		$s .= Xml::closeElement( 'table' ) . "\n";

		$wgOut->addHTML( $s );
		$wgOut->addWikiMsg( 'sitematrix-total', $language->formatNum( $matrix->getCount() ) );
	}
}
