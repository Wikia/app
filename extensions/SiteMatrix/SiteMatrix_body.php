<?php

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "SiteMatrix extension\n";
    exit( 1 );
}


global $IP;
require_once( $IP.'/languages/Names.php' );

class SiteMatrix {
	protected $langlist, $sites, $names, $hosts, $private, $fishbowl;
	protected $specials, $matrix, $count, $countPerSite;

	public function __construct(){
		global $wgSiteMatrixFile, $wgSiteMatrixSites;
		global $wgLocalDatabases, $IP, $wgConf;

		if( file_exists( "$IP/InitialiseSettings.php" ) ) {
			require_once "$IP/InitialiseSettings.php";
		}

		if( file_exists( $wgSiteMatrixFile ) ){
			$this->langlist = array_map( 'trim', file( $wgSiteMatrixFile ) );
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
		$this->private = array();
		$this->fishbowl = array();

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
		
		wfRunHooks( 'SiteMatrixGetPrivateAndFishbowlWikis', array( &$this->private, &$this->fishbowl ) );
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
		return 'http://' . $this->hosts[$site] . '/';
	}

	public function getUrl( $minor, $major ){
		global $wgConf;
		$dbname = $minor . $major;
		$minor = str_replace( '_', '-', $minor );
		return $wgConf->get( 'wgServer', $dbname, $major,
			array( 'lang' => $minor, 'site' => $major ) );
	}

	public function exist( $minor, $major ){
		return !empty( $this->matrix[$major][$minor] );
	}

	public function isClosed( $minor, $major ) {
		global $wgConf;

		$dbname = $minor . $major;
		if( $wgConf->get( 'wgReadOnly', $dbname, $major, array( 'site' => $major, 'lang' => $minor ) ) )
			return true;
		$readOnlyFile = $wgConf->get( 'wgReadOnlyFile', $dbname, $major, array( 'site' => $major, 'lang' => $minor ) );
		if( $readOnlyFile && file_exists( $readOnlyFile ) )
			return true;
		return false;
	}

	public function isPrivate( $dbname ) {
		return in_array( $dbname, $this->private );
	}

	public function isFishbowl( $dbname ) {
		return in_array( $dbname, $this->fishbowl );
	}
}

class SiteMatrixPage extends SpecialPage {

	function __construct() {
		parent::__construct( 'SiteMatrix' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgLanguageNames;
		wfLoadExtensionMessages( 'SiteMatrix' );
		
		$this->setHeaders();
		$this->outputHeader();

		$matrix = new SiteMatrix();

		if( $wgRequest->getVal( 'action' ) == 'raw' ){
			$wgOut->disable();
			$count = $matrix->getCount();
			header( 'Content-Type: text/xml; charset=utf-8' );
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			echo "<sitematrix>\n";
			echo "\t<matrix size=\"{$count}\">\n";
			foreach ( $matrix->getLangList() as $lang ) {
				$langhost = str_replace( '_', '-', $lang );
				echo "\t\t<language code=\"{$langhost}\" name=\"".htmlspecialchars( $wgLanguageNames[$lang] )."\">\n";
				foreach ( $matrix->getSites() as $site ) {
					if ( $matrix->exist( $lang, $site ) ) {
						$url = $matrix->getUrl( $lang, $site );
						echo "\t\t\t<site code=\"{$site}\" url=\"{$url}\" />\n";
					}
				}
				echo "\t\t</language>\n";
			}
			echo "\t</matrix>\n";
			echo "\t<specials>\n";
			foreach ( $matrix->getSpecials() as $special ) {
				list( $lang, $site ) = $special;
				$langhost = str_replace( '_', '-', $lang );
				if( $site != 'wiki' ) $langhost .= $site;
				$url = $matrix->getUrl( $lang, $site );

				echo "\t\t<special code=\"{$langhost}\" url=\"{$url}\" />\n";
			}
			echo "\t</specials>\n";
			echo "</sitematrix>";
			return;
		}

		# Construct the HTML

		# Header row
		$s = Xml::openElement( 'table', array( 'id' => 'mw-sitematrix-table' ) ) .
			"<tr>" .
				Xml::element( 'th', null, wfMsg( 'sitematrix-language' ) ) .
				Xml::element( 'th', array( 'colspan' => count( $matrix->getSites() ) ), wfMsg( 'sitematrix-project' ) ) .
			"</tr>
			<tr>
				<th>&nbsp;</th>";
				foreach ( $matrix->getNames() as $id => $name ) {
					$url = $matrix->getSiteUrl( $id );
					$s .= Xml::tags( 'th', null, "<a href=\"{$url}\">{$name}</a>" );
 				}
		$s .= "</tr>\n";

		# Bulk of table
		foreach ( $matrix->getLangList() as $lang ) {
			$anchor = strtolower( '<a id="' . htmlspecialchars( $lang ) . '" name="' . htmlspecialchars( $lang ) . '"></a>' );
			$s .= '<tr>';
			$s .= '<td>' . $anchor . '<strong>' . $wgLanguageNames[$lang] . '</strong></td>';
			$langhost = str_replace( '_', '-', $lang );
			foreach ( $matrix->getNames() as $site => $name ) {
				$url = $matrix->getUrl( $lang, $site );
				if ( $matrix->exist( $lang, $site ) ) {
					# Wiki exists
					$closed = $matrix->isClosed( $lang, $site );
					$s .= "<td>" . ($closed ? "<s>" : '') . "<a href=\"{$url}\">{$lang}</a>" . ($closed ? "</s>" : '') . '</td>';
				} else {
					# Non-existent wiki
					$s .= "<td><a href=\"{$url}\" class=\"new\">{$lang}</a></td>";
				}
			}
			$s .= "</tr>\n";
		}

		# Total
		$s .= '<tr style="font-weight: bold"><td><a id="total" name="total"></a>' . wfMsgHtml( 'sitematrix-sitetotal' ) . '</td>';
		foreach( $matrix->getNames() as $site => $name ) {
			$url = $matrix->getSiteUrl( $site );
			$count = $matrix->getCountPerSite( $site );
			$s .= "<td><a href=\"{$url}\">{$count}</a></td>";
		}
		$s .= '</tr>';
		$s .= Xml::closeElement( 'table' ) . "\n";

		# Specials
		$s .= '<h2 id="mw-sitematrix-others">' . wfMsg( 'sitematrix-others' ) . '</h2>';
		$s .= '<ul>';
		foreach ( $matrix->getSpecials() as $special ) {
			list( $lang, $site ) = $special;
			$langhost = str_replace( '_', '-', $lang );
			$url = $matrix->getUrl( $lang, $site );
			
			# Handle options
			$flags = array();
			if( $matrix->isPrivate( $lang . $site ) )
				$flags[] = wfMsgHtml( 'sitematrix-private' );
			if( $matrix->isFishbowl( $lang . $site ) )
				$flags[] = wfMsgHtml( 'sitematrix-fishbowl' );
			$flagsStr = implode( ', ', $flags );
			if( $site != 'wiki' ) $langhost .= $site;
			$s .= '<li>' . wfSpecialList( '<a href="' . $url . '/">' . $langhost . "</a>", $flagsStr ) . "</li>\n";
		}
		$s .= '</ul>';
		$wgOut->addHTML( $s );
		$wgOut->addHTML( wfMsgWikiHtml( 'sitematrix-total', $matrix->getCount() ) );
	}
}

/**
 * Query module to get site matrix
 * @addtogroup API
 */
class ApiQuerySiteMatrix extends ApiQueryBase {

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName, 'sm');
	}

	public function execute() {
		global $wgLanguageNames;
		$params = $this->extractRequestParams();
		$result = $this->getResult();
		$matrix = new SiteMatrix();

		$matrix_out = array(
			'count' => $matrix->getCount(),
		);
		foreach ( $matrix->getLangList() as $lang ) {
			$langhost = str_replace( '_', '-', $lang );
			$language = array(
				'code' => $langhost,
				'name' => $wgLanguageNames[$lang],
				'site' => array(),
			);

			foreach ( $matrix->getSites() as $site ) {
				if ( $matrix->exist( $lang, $site ) ) {
					$url = $matrix->getUrl( $lang, $site );
					$site_out = array(
						'url' => $url,
						'code' => $site,
					);
					$language['site'][] = $site_out;
				}
			}

			$result->setIndexedTagName($language['site'], 'site');
			$matrix_out[] = $language;
		}
		$result->setIndexedTagName($matrix_out, 'language');
		$result->addValue(null, "sitematrix", $matrix_out);

		$specials = array();
		foreach ( $matrix->getSpecials() as $special ){
			list( $lang, $site ) = $special;
			$url = $matrix->getUrl( $lang, $site );

			$wiki = array();
			$wiki['url'] = $url;
			$wiki['code'] = str_replace( '_', '-', $lang ) . ( $site != 'wiki' ? $site : '' );
			$specials[] = $wiki;
		}

		$result->setIndexedTagName($specials, 'special');
		$result->addValue("sitematrix", "specials", $specials);
	}

	protected function getAllowedParams() {
		return array (
		);
	}

	protected function getParamDescription() {
		return array (
		);
	}

	protected function getDescription() {
		return 'Get Wikimedia sites list';
	}

	protected function getExamples() {
		return array (
			'api.php?action=sitematrix',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: SiteMatrix_body.php 37923 2008-07-22 20:53:43Z ialex $';
	}
}
