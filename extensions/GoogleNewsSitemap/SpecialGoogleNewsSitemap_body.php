<?php
if (!defined('MEDIAWIKI')) die();

/**
 * Class GoogleNewsSitemap creates Atom/RSS feeds for Wikinews
 **
 * Simple feed using Atom/RSS coupled to DynamicPageList category searching.
 *
 * To use: http://wiki.url/Special:GoogleNewsSitemap/<feedType>?[paramter=value][...]
 *
 * Implemented parameters are marked with an @
 **
 * Parameters
 *    * category = string ; default = Published
 *    * notcategory = string ; default = null
 *    * namespace = string ; default = null
 *    * count = integer ; default = $wgDPLmaxResultCount = 50
 *    * order = string ; default = descending
 *    * ordermethod = string ; default = categoryadd
 *    * redirects = string ; default = exclude
 *    * stablepages = string ; default = null
 *    * qualitypages = string ; default = null
 *    * feed = string ; default = atom
 *	usenamespace = bool ; default = false
 *	usecurid = bool ; default = false
 *	suppresserrors = bool ; default = false
 **/

class GoogleNewsSitemap extends IncludableSpecialPage {


	/**
	 * FIXME: Some of this might need a config eventually
	 * @var string
	 **/
	var $Title = '';
	var $Description = '';
	var $Url = '';
	var $Date = '';
	var $Author = '';
	var $pubDate = '';
	var $keywords = '';
	var $lastMod = '';
	var $priority = '';

	/**
	 * Script default values - correctly spelt, naming standard.
	 **/
	var $wgDPlminCategories = 1;                // Minimum number of categories to look for
	var $wgDPlmaxCategories = 6;                // Maximum number of categories to look for
	var $wgDPLminResultCount = 1;               // Minimum number of results to allow
	var $wgDPLmaxResultCount = 50;              // Maximum number of results to allow
	var $wgDPLallowUnlimitedResults = true;     // Allow unlimited results
	var $wgDPLallowUnlimitedCategories = false; // Allow unlimited categories


	/**
	 * @var array Parameters array
	 **/
	var $params = array();
	var $categories = array();
	var $notCategories = array();

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct( 'GoogleNewsSitemap' );
	}

	/**
	 * main()
	 **/
	public function execute( $par ) {
		global $wgUser;
		global $wgLang;
		global $wgContLang;
		global $wgRequest, $wgOut;
		global $wgSitename, $wgServer, $wgScriptPath;
		wfLoadExtensionMessages( 'GoogleNewsSitemap' );
		global $wgFeedClasses, $wgLocaltimezone;

		// Not sure how clean $wgLocaltimezone is
		// In fact, it's default setting is null...
		if ( null == $wgLocaltimezone )
		$wgLocaltimezone = date_default_timezone_get();
		date_default_timezone_set( $wgLocaltimezone );
		//$url = __FILE__;

		$this->dpl_parm( $par );


		$wgFeedClasses[] = array( 'sitemap' => 'SitemapFeed' );

		if ( 'sitemap' == $this->params['feed'] ){
			$feed = new SitemapFeed(
			$wgServer.$wgScriptPath,
			date( DATE_ATOM )
			);
		}else{
			// FIXME: These should be configurable at some point
			$feed = new $wgFeedClasses[ $this->params['feed'] ](
			$wgSitename,
			$wgSitename . ' ' . $this->params['feed'] . ' feed',
			$wgServer.$wgScriptPath,
			date( DATE_ATOM ),
			$wgSitename
			);
		}

		$feed->outHeader();

		// main routine to output items
		if ( isset( $this->param['error'] ) ){
			echo $this->param['error'];
		}else{
			$dbr = wfGetDB( DB_SLAVE );
			$sql = $this->dpl_buildSQL();
			//Debug line
			//echo "\n<p>$sql</p>\n";
			$res = $dbr->query ( $sql );

			// FIXME: figure out how to fail with no results gracefully
			if ( $dbr->numRows( $res ) == 0 ){
				$feed->outFooter();
				if ( false == $this->params['suppressErrors'] )
				return htmlspecialchars( wfMsg( 'gnsm_noresults' ) );
				else
				return '';
			}

			while ($row = $dbr->fetchObject( $res ) ) {
				$title = Title::makeTitle( $row->page_namespace, $row->page_title);

				if ( $title ){
		   //This is printing things in places it shouldn't
					// print $this->params['nameSpace'];

					$titleText = ( true == $this->params['nameSpace'] ) ? $title->getPrefixedText() : $title->getText();

					if ( 'sitemap' == $this->params['feed'] ){

						$this->pubDate = isset( $row->cl_timestamp ) ? $row->cl_timestamp : date( DATE_ATOM );
						$feedArticle = new Article( $title );

						$feedItem = new FeedSitemapItem(
						trim( $title->getFullURL() ),
						wfTimeStamp( TS_ISO_8601, $this->pubDate ),
						$this->getKeywords( $title ),
						wfTimeStamp( TS_ISO_8601, $feedArticle->getTouched() ),
						$feed->getPriority( $this->priority )
						);
							
					}elseif ( ('atom' == $this->params['feed'] ) || ( 'rss' == $this->params['feed'] ) ){
							
						$this->Date = isset( $row->cl_timestamp ) ? $row->cl_timestamp : date( DATE_ATOM );
						if ( isset( $row->comment ) ){
			    $comments = htmlspecialchars( $row->comment );
						}else{
			    $talkpage = $title->getTalkPage();
			    $comments = $talkpage->getFullURL();
						}
						$titleText = (true === $this->params['nameSpace'] ) ? $title->getPrefixedText() : $title->getText();
						$feedItem = new FeedItem(
						$titleText,
						$this->feedItemDesc( $row ),
						$title->getFullURL(),
						$this->Date,
						$this->feedItemAuthor( $row ),
						$comments);
					}
					$feed->outItem( $feedItem );
				}
			}
		}
		$feed->outFooter();
	}

	/**
	 * Build sql
	 **/
	public function dpl_buildSQL(){
		 
		$sqlSelectFrom = 'SELECT page_namespace, page_title, page_id, c1.cl_timestamp FROM ' . $this->params['dbr']->tableName( 'page' );

		if ( $this->params['nameSpace'] ){
			$sqlWhere = ' WHERE page_namespace=' . $this->params['iNameSpace'] . ' ';
		}else{
			$sqlWhere = ' WHERE 1=1 ';
		}

		// If flagged revisions is in use, check which options selected.
		// FIXME: double check the default options in function::dpl_parm; what should it default to?
		if( function_exists('efLoadFlaggedRevs') ) {
			$flaggedPages = $this->params['dbr']->tableName( 'flaggedpages' );
			$filterSet = array( 'only', 'exclude' );
			# Either involves the same JOIN here...
			if( in_array( $this->params['stable'], $filterSet ) || in_array( $this->params['quality'], $filterSet ) ) {
				$sqlSelectFrom .= " LEFT JOIN $flaggedPages ON page_id = fp_page_id";
			}
			switch( $this->params['stable'] ){
				case 'only':
					$sqlWhere .= ' AND fp_stable IS NOT NULL ';
					break;
				case 'exclude':
					$sqlWhere .= ' AND fp_stable IS NULL ';
					break;
			}
			switch( $this->params['quality'] ){
				case 'only':
					$sqlWhere .= ' AND fp_quality >= 1';
					break;
				case 'exclude':
					$sqlWhere .= ' AND fp_quality = 0';
					break;
			}
		}

		switch ( $this->params['redirects'] )
		{
			case 'only':
				$sqlWhere .= ' AND page_is_redirect = 1 ';
				break;
			case 'exclude':
				$sqlWhere .= ' AND page_is_redirect = 0 ';
				break;
		}

		$currentTableNumber = 0;

		for ( $i = 0; $i < $this->params['catCount']; $i++ ){

			$sqlSelectFrom .= ' INNER JOIN ' . $this->params['dbr']->tableName( 'categorylinks' );
			$sqlSelectFrom .= ' AS c' . ( $currentTableNumber + 1 ) . ' ON page_id = c';
			$sqlSelectFrom .= ( $currentTableNumber + 1 ) . '.cl_from AND c' . ( $currentTableNumber + 1 );

			$sqlSelectFrom .= '.cl_to=' . $this->params['dbr']->addQuotes( $this->categories[$i]->getDBkey() );

			$currentTableNumber++;
		}

		for ( $i = 0; $i < $this->params['notCatCount']; $i++ ){
			//echo "notCategory parameter $i<br />\n";
			$sqlSelectFrom .= ' LEFT OUTER JOIN ' . $this->params['dbr']->tableName( 'categorylinks' );
			$sqlSelectFrom .= ' AS c' . ( $currentTableNumber + 1 ) . ' ON page_id = c' . ( $currentTableNumber + 1 );
			$sqlSelectFrom .= '.cl_from AND c' . ( $currentTableNumber + 1 );
			$sqlSelectFrom .= '.cl_to=' . $this->params['dbr']->addQuotes( $this->notCategories[$i]->getDBkey() );

			$sqlWhere .= ' AND c' . ( $currentTableNumber + 1 ) . '.cl_to IS NULL';

			$currentTableNumber++;
		}

		if ('lastedit' == $this->params['orderMethod'] )
			$sqlWhere .= ' ORDER BY page_touched ';
		else
			$sqlWhere .= ' ORDER BY c1.cl_timestamp ';

		if ( 'descending' == $this->params['order'] )
			$sqlWhere .= 'DESC';
		else
			$sqlWhere .= 'ASC';

		// FIXME: Note: this is not a boolean type check - will also trap count = 0 which may
		// accidentally give unlimited returns
		if ( 0 < $this->params['count'] ){
			$sqlWhere .= ' LIMIT ' . $this->params['count'];
		}

		//debug line
		//echo "<p>$sqlSelectFrom$sqlWhere;</p>\n";

		return $sqlSelectFrom . $sqlWhere;
	}

	/**
	 * Parse parameters
	 **
	 * FIXME this includes a lot of DynamicPageList cruft in need of thinning.
	 **/
	public function dpl_parm( $par ){
		global $wgContLang;
		global $wgRequest;

		$params = $wgRequest->getValues();
		// FIXME: note: if ( false === $count ) then no count has ever been set
		// however, there's still no guarantee $count <> zero || NULL
		$this->params['count'] = $this->wgDPLmaxResultCount;
		 
		$this->params['orderMethod'] = 'categoryadd';
		$this->params['order'] = 'descending';
		$this->params['redirects'] = 'exclude';
		$this->params['stable'] = $this->params['quality'] = 'only';

		$this->params['nameSpace'] = false;
		$this->params['iNameSpace'] = 0;

		$this->params['useNameSpace'] = false;
		$this->params['useCurId'] = false;

		$this->params['suppressErrors'] = false;

		$this->params['feed'] = 'atom';
		$feedType = explode( '/', $par, 2);
		switch( strtolower($feedType[0])){
			case 'rss':
				$this->params['feed'] = 'rss';
				break;
			case 'sitemap':
				$this->params['feed'] = 'sitemap';
				break;
			default:
				$this->params['feed'] = 'atom';
				break;
		}				

		$parser = new Parser;
		$poptions = new ParserOptions;

		foreach ( $params as $key=>$value ){
			switch ( $key ){
				case 'category':
					$title = Title::newFromText( $parser->transformMsg( $value, $poptions ) );

					if ( is_object( $title ) ){
						$this->categories[] = $title;
					}else{
						echo "Explode on category.\n";
						continue;
					}
					break;
				case 'notcategory':
					//echo "Got notcategory $value\n";
					$title = Title::newFromText( $parser->transformMsg( $value, $poptions ) );
					if ( is_object( $title ) )
					$this->notCategories[] = $title;
					else{
						echo 'Explode on notCategory.';
						continue;
					}
					break;
				case 'namespace':
					if ( $value == intval( $value ) ){
						$this->params['iNameSpace'] = intval( $value );
						if ( 0 <= $this->params['iNameSpace'] ){
							$this->params['nameSpace'] = true;
						}else{
							$this->params['nameSpace'] = false;
						}
					}else{
						$ns = $wgContLang->getNsIndex( $value );
						if ( null !== $ns ){
			    $this->params['iNameSpace'] = $ns;
			    $this->params['nameSpace'] = true;
						}
					}
					break;
				case 'count':
					if ( ( $this->wgDPLminResultCount < $value ) && ( $value < $this->wgDPLmaxResultCount ) ){
						$this->params['count'] = intval( $value );
					}
					break;
				case 'order';
				switch ( $value ){
					case 'ascending':
						$this->params['order'] = 'ascending';
						break;
					case 'descending':
					default:
						$this->params['order'] = 'descending';
						break;
				}
				break;
				case 'ordermethod';
				switch ( $value ){
					case 'lastedit':
						$this->params['orderMethod'] = 'lastedit';
						break;
					case 'categoryadd':
					default:
						$this->params['orderMethod'] = 'categoryadd';
						break;
				}
				break;
				case 'redirects';
				switch ( $value ){
					case 'include':
						$this->params['redirects'] = 'include';
						break;
					case 'only':
						$this->params['redirects'] = 'only';
						break;
					case 'exclude':
					default:
						$this->params['redirects'] = 'exclude';
						break;
				}
				break;
				case 'stablepages':
					switch ( $value ){
						case 'include':
							$this->params['stable'] = 'include';
							break;
						case 'exclude':
							$this->params['stable'] = 'exclude';
							break;
						case 'only':
						default:
							$this->params['stable'] = 'only';
							break;
					}
					break;
				case 'qualitypages':
					switch ( $value ){
						case 'include':
							$this->params['quality'] = 'include';
							break;
						case 'only':
							$this->params['quality'] = 'only';
							break;
						case 'exclude':
						default:
							$this->params['quality'] = 'exclude';
							break;
					}
					break;
				case 'suppresserrors':
					// note: if previously set to true, remains true. malformed does not reset to false.
					if ( 'true' == $value ) $this->params['suppressErrors'] = true;
					break;
				case 'usenamespace':
					// note: if previously set to false, remains false. Malformed does not reset to true.
					if ( 'false' == $value ) $this->params['useNameSpace'] = false;
					break;
				case 'usecurid':
					// note: if previously set to true, remains true. Malformed does not reset to false.
					if ( 'true' == $value ) $this->params['useCurId'] = true;
					break;
				default:
			}
		}

		$this->params['catCount'] = count( $this->categories );
		$this->params['notCatCount'] = count( $this->notCategories );
		$totalCatCount = $this->params['catCount'] + $this->params['notCatCount'];
		 
		if (( $this->params['catCount'] < 1 && false == $this->params['nameSpace'] ) || ( $totalCatCount < $this->wgDPlminCategories )){
			//echo "Boom on catCount\n";
			$parser = new Parser;
			$poptions = new ParserOptions;
			$feed =  Title::newFromText( $parser->transformMsg( 'Published', $poptions ) );
			if ( is_object( $feed ) ){
				$this->categories[] = $feed;
				$this->params['catCount'] = count( $this->categories );
			}else{
				echo "\$feed is not an object.\n";
				continue;
			}
		}

		if ( ( $totalCatCount > $this->wgDPlmaxCategories ) && ( !$this->wgDPLallowUnlimitedCategories ) ){
			$this->params['error'] = htmlspecialchars( wfMsg( 'intersection_toomanycats' ) ); // "!!too many categories!!";
		}

		//disallow showing date if the query doesn't have an inclusion category parameter
		if ( $this->params['count'] < 1 )
		$this->params['addFirstCategoryDate'] = false;

		$this->params['dbr'] = wfGetDB( DB_SLAVE );
		return;
	}

	function feedItemAuthor( $row ) {
		return isset( $row->user_text ) ? $row->user_text : 'Wikinews';
	}

	function feedItemDesc( $row ) {
		return isset( $row->comment ) ? htmlspecialchars( $row->comment ) : '';
	}

	function getKeywords ( $title ){
		$cats = $title->getParentCategories();
		$str = '';
		#the following code is based (stolen) from r56954 of flagged revs.
		$catMap = Array();
		$catMask = Array();
		$msg = wfMsg( 'gnsm_categorymap' );
		if ( !wfEmptyMsg( 'gnsm_categorymap', $msg ) ) {
			$list = explode( "\n*", "\n$msg");
			foreach($list as $item) {
				$mapping = explode('|', $item, 2);
				if ( count( $mapping ) == 2 ) {
					if ( trim( $mapping[1] ) == '__MASK__') {
						$catMask[trim($mapping[0])] = true;
					} else {
						$catMap[trim($mapping[0])] = trim($mapping[1]);
					}
				}
			}
		}
		foreach ( $cats as $key => $val ){
			$cat = str_replace( '_', ' ', trim( substr( $key, strpos( $key, ':' ) + 1 ) ) );
			if (!isset($catMask[$cat])) {
				if (isset($catMap[$cat])) {
					$str .= ', ' . str_replace( '_', ' ', trim ( $catMap[$cat] ) );
				} else {
					$str .= ', ' . $cat;
				}
			}
		}
		$str = substr( $str, 2 ); #to remove leading ', '
		return $str;
	}

}

/**
 * FeedSitemapItem Class
 **
 * Base class for basic SiteMap support, for building url containers.
 **/
class FeedSitemapItem{
	/**
	 * Var string
	 **/
	var $url = '';
	var $pubDate = '';
	var $keywords = '';
	var $lastMod = '';
	var $priority = '';

	function __construct( $url, $pubDate, $keywords = '', $lastMod = '', $priority = ''){
		$this->url = $url;
		$this->pubDate = $pubDate;
		$this->keywords = $keywords;
		$this->lastMod = $lastMod;
		$this->priority = $priority;
	}

	public function xmlEncode( $string ){
		$string = str_replace( "\r\n", "\n", $string );
		$string = preg_replace( '/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $string );
		return htmlspecialchars( $string );
	}

	public function getUrl(){
		return $this->url;
	}

	public function getPriority(){
		return $this->priority;
	}

	public function getLastMod(){
		return $this->lastMod;
	}

	public function getKeywords (){
		return $this->xmlEncode( $this->keywords );
	}

	public function getPubDate(){
		return $this->pubDate;
	}

	function formatTime( $ts ) {
		// need to use RFC 822 time format at least for rss2.0
		return gmdate( 'Y-m-d\TH:i:s', wfTimestamp( TS_UNIX, $ts ) );
	}

	/**
	 * Setup and send HTTP headers. Don't send any content;
	 * content might end up being cached and re-sent with
	 * these same headers later.
	 *
	 * This should be called from the outHeader() method,
	 * but can also be called separately.
	 *
	 * @public
	 **/
	function httpHeaders() {
		global $wgOut;
		# We take over from $wgOut, excepting its cache header info
		$wgOut->disable();
		$mimetype = $this->contentType();
		header( "Content-type: $mimetype; charset=UTF-8" );
		$wgOut->sendCacheControl();

	}

	function outXmlHeader(){
		global $wgStylePath, $wgStyleVersion;

		$this->httpHeaders();
		echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	}

	/**
	 * Return an internet media type to be sent in the headers.
	 *
	 * @return string
	 * @private
	 **/
	function contentType() {
		global $wgRequest;
		$ctype = $wgRequest->getVal('ctype','application/xml');
		$allowedctypes = array('application/xml','text/xml','application/rss+xml','application/atom+xml');
		return (in_array($ctype, $allowedctypes) ? $ctype : 'application/xml');
	}

}

class SitemapFeed extends FeedSitemapItem{
	/**
	 * Output feed headers
	 **/
	function outHeader(){
		$this->outXmlHeader();
		?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
		<?php
	}
	/**
	 * Output a SiteMap 0.9 item
	 * @param FeedSitemapItem item to be output
	 **/
	function outItem( $item ) {
		?>
<url>
<loc>
		<?php print $item->getUrl() ?>
</loc>
<news:news>
	<news:publication_date>
	<?php print $item->getPubDate() ?>
	</news:publication_date>
	<?php if( $item->getKeywords() ){
		echo '<news:keywords>' . $item->getKeywords() . "</news:keywords>\n";
	}
	?>
</news:news>
	<?php	 if( $item->getLastMod() ){ ?>
<lastmod>
	<?php print $item->getLastMod(); ?>
</lastmod>
	<?php }?>
	<?php	 if( $item->getPriority() ){ ?>
<priority>
	<? print $item->getPriority(); ?>
</priority>
	<?php }?>
</url>
	<?php
	}

	/**
	 * Output SiteMap 0.9 footer
	 **/
	function outFooter(){
		echo '</urlset>';
	}

}
