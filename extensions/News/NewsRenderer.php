<?php
/**
 * News renderer for News extension.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "Not a valid entry point.\n" );
	die( 1 );
}

define('NEWS_HEAD_LENGTH', 1024 * 2);
define('NEWS_HEAD_SCAN', 256);

#no need to include, rely on autoloader
#global $IP;
#require_once( "$IP/includes/RecentChange.php" );
#require_once( "$IP/includes/ChangeList.php" );

class NewsRenderer {
	var $parser;
	var $skin;

	var $title;

	var $prefix;
	var $postfix;

	var $usetemplate;
	var $templatetext;
	var $templateparser;
	var $templateoptions;

	var $changelist;

	var $namespaces;
	var $categories;
	var $types;

	var $nominor;
	var $noanon;
	var $nobot;
	var $notalk;

	var $onlynew;
	var $onlypatrolled;

	var $publication; //"publication" mode, as opposed to the default "updates" mode
	var $pubtrigger; //word to use in summaries to trigger publication
	var $permalinks; //wether to force permalinks in feeds, even in publication mode

	static function newFromArticle( &$article, &$parser ) {
		$title = $article->getTitle();
		$article->getContent(); 
		$text = $article->mContent;
		if (!$text) return NULL;

		$uniq_prefix = "\x07NR-UNIQ";
		$elements = array( 'nowiki', 'gallery', 'newsfeed');
		$matches = array();
		$text = Parser::extractTagsAndParams( $elements, $text, $matches, $uniq_prefix );

		foreach( $matches as $marker => $data ) {
			list( $element, $content, $params, $tag ) = $data;
			$tagName = strtolower( $element );

			if ($tagName != 'newsfeed') continue;
			#if (!is_null($id) && (!isset($params['id']) || $params['id'] != $id)) continue;
			
			return new NewsRenderer( $title, $content, $params, $parser );
		}

		return NULL;
	}

	function __construct( $title, $templatetext, $argv, &$parser ) {
		global $wgContLang, $wgUser;

		$this->title = $title;

		$this->skin = $wgUser->getSkin();
		$this->parser = $parser;
	
		$this->templatetext = $templatetext;

		if ( !is_null( $this->templatetext ) ) {
			$this->templatetext = trim( $this->templatetext );
			if ( $this->templatetext == '' ) $this->templatetext = NULL;
		}

		$this->usetemplate = !is_null( $this->templatetext );
	
		$this->templateparser = NULL;
		$this->templateoptions = NULL;
	
		#$template = @$argv['template'];
	
		#if ( $this->usetemplate ) {
			#print "<pre>$templatetitle</pre>";
	
			$this->templateparser = $parser;
			#$this->templateparser = clone $parser;
			#$this->templateparser->setOutputType( OT_HTML );
			$this->templateoptions = new ParserOptions;
			$this->templateoptions->setEditSection( false );
			$this->templateoptions->setNumberHeadings( false );
			$this->templateoptions->setRemoveComments( true );
			$this->templateoptions->setUseTeX( false );
			$this->templateoptions->setUseDynamicDates( false );
			$this->templateoptions->setInterwikiMagic( true ); //strip interlanguage-links
			$this->templateoptions->setAllowSpecialInclusion( false );

			#$this->templatetitle = Title::newFromText( $template, NS_TEMPLATE );
			#$templatetext = $templateparser->fetchTemplate( $templatetitle );
			#print "<pre>$templatetext</pre>";
		
			#$templateoptions->setRemoveComments( true );
			#$templateoptions->setMaxIncludeSize( self::MAX_INCLUDE_SIZE );
		#}

		if ( !$this->usetemplate ) {
			$this->changelist = new OldChangesList( $this->skin );
		}
	
		#$this->feedId = @$argv['id'];

		$this->prefix = @$argv['prefix'];
		$this->postfix = @$argv['postfix'];

		$this->limit = @$argv['limit'];
		if ( !$this->limit ) $this->limit = 10;
		else if ( $this->limit > 100 ) $this->limit = 100;
	
		$this->unique = @$argv['unique'];
		if ( $this->unique === 'false' || $this->unique === 'no' || $this->unique === '0' )
			$this->unique = false;

		$this->namespaces = @$argv['namespaces'];
		if ( !is_null( $this->namespaces ) ) {
			$this->namespaces = preg_split('!\s*(\|\s*)+!', trim( $this->namespaces ) );
	
			foreach ($this->namespaces as $i => $ns) {
				$ns = $wgContLang->lc($ns);
	
				if ( $ns === '-' || $ns === '0' || $ns === 'main' || $ns === 'article' ) {
					$this->namespaces[$i] = 0;
				} else {
					$this->namespaces[$i] = Namespace::getCanonicalIndex( $ns );
					if ( $this->namespaces[$i] === false || $this->namespaces[$i] === NULL )
						$this->namespaces[$i] = $wgContLang->getNsIndex( $ns );
				}
	
				if ( $this->namespaces[$i] === false || $this->namespaces[$i] === NULL ) 
					unset( $this->namespaces[$i] );
			}
		}
		
		$this->categories = @$argv['categories'];
		if ( !is_null( $this->categories ) ) {
			$this->categories = preg_split('!\s*(\|\s*)+!', trim( $this->categories ) );
	
			foreach ($this->categories as $i => $n) {
				$t = Title::makeTitleSafe(NS_CATEGORY, $n);
				$n = $t->getDBkey();
				$this->categories[$i] = $n;
			}
		}
	
		$this->pubtrigger = @$argv['trigger'];
		if ( $this->pubtrigger ) $this->publication = true;
		else  $this->publication = false;
	
		$this->permalinks = @$argv['permalinks'];
		if ( $this->permalinks === 'false' || $this->permalinks === 'no' || $this->permalinks === '0' )
			$this->permalinks = false;
	
		$this->nominor = @$argv['nominor'];
		if ( $this->nominor === 'false' || $this->nominor === 'no' || $this->nominor === '0' )
			$this->nominor = false;
	
		$this->nobot = @$argv['nobot'];
		if ( $this->nobot === 'false' || $this->nobot === 'no' || $this->nobot === '0' )
			$this->nobot = false;
	
		$this->noanon = @$argv['noanon'];
		if ( $this->noanon === 'false' || $this->noanon === 'no' || $this->noanon === '0' )
			$this->noanon = false;
	
		$this->notalk = @$argv['notalk'];
		if ( $this->notalk === 'false' || $this->notalk === 'no' || $this->notalk === '0' )
			$this->notalk = false;
	
		$this->onlypatrolled = @$argv['onlypatrolled'];
		if ( $this->onlypatrolled === 'false' || $this->onlypatrolled === 'no' || $this->onlypatrolled === '0' )
			$this->onlypatrolled = false;
	
		$this->onlynew = @$argv['onlynew'];
		if ( $this->onlynew === 'false' || $this->onlynew === 'no' || $this->onlynew === '0' )
			$this->onlynew = false;
	
		$this->types = array( RC_EDIT, RC_NEW );
	
		/* this doesn't work right
		if ( $unique ) {
			$group[] = 'rc_namespace AND rc_title';
		}
		*/
	}

	/*
	function getFeedId() {
		return $this->feedId;
	}
	*/

	/*
	function getCacheKey() {
		return '@' . get_class($this) . ':' . 
			($this->templatetext ? md5($this->templatetext) : $this->templatetext ). '|' .
			$this->namespaces . '|' .
			$this->categories . '|' .
			$this->types . '|' .
			$this->nominor . ',' .
			$this->noanon . ',' .
			$this->nobot . ',' .
			$this->notalk . ',' .
			$this->onlynew . ',' .
			$this->onlypatrolled ;
	}
	*/

	function query( $dbr, $limit, $offset = 0 ) {
		list( $trecentchanges, $tpage, $tcategorylinks ) = $dbr->tableNamesN( 'recentchanges', 'page', 'categorylinks' );
	
		$where = array();
		$group = array();
		$select = "$trecentchanges.*";
	
		$sql = "SELECT $select FROM $trecentchanges ";
		
		if ( $this->categories ) {
			$sql .= " JOIN $tpage ON page_namespace = rc_namespace AND page_title = rc_title ";
			$sql .= " JOIN $tcategorylinks ON cl_from = page_id ";

			$where[] = 'cl_to IN ( ' . $dbr->makeList( $this->categories ) . ' )';
			$group[] = 'rc_id';
		}
	
		if ( $this->nominor )  $where[] = 'rc_minor = 0';
		if ( $this->nobot )  $where[] = 'rc_bot = 0';
		if ( $this->noanon )  $where[] = 'rc_user > 0';
		if ( $this->onlypatrolled )  $where[] = 'rc_patrolled = 1';
		if ( $this->onlynew )  $where[] = 'rc_new = 1';
		if ( $this->pubtrigger )  $where[] = 'rc_comment LIKE ' . $dbr->addQuotes( '%' . $this->pubtrigger . '%' );

		if ( $this->namespaces )  $where[] = 'rc_namespace IN ( ' . $dbr->makeList( $this->namespaces ) . ' )';
		else {
			if ( $this->notalk )  $where[] = 'MOD(rc_namespace, 2) = 0';
			$where[] = 'rc_namespace >= 0'; #ignore virtual namespaces (logs, mostly)
		}
	
	
		$where[] = 'rc_type IN ( ' . $dbr->makeList( $this->types ) . ' )';
	
		if ( $where ) $sql .= ' WHERE ( ' . implode( ' ) AND ( ', $where ) . ' )';
		if ( $group ) $sql .= ' GROUP BY ' . implode( ' AND ', $group );
	
		$sql .= ' ORDER BY rc_timestamp DESC ';
	
		$sql = $dbr->limitResult( $sql, $limit, $offset );
	
		$res = $dbr->query( $sql, 'NewsRenderer::query' );
	
		return $res;
	}
	
	function fetchNews( ) {
		$dbr = wfGetDB( DB_SLAVE );
		$news = array();
	
		$remaining = $this->limit;
		$offset = 0;
		$ignore = array(); #collect stuff we already have, when in unique mode
	
		while ( $remaining > 0 ) { #chunk loop for programmatic filter
			$chunk = $this->unique ? $remaining * 2 : $remaining;
			$res = $this->query( $dbr, $chunk, $offset );
			$offset += $chunk;
		
			$has = false;
			while ( ( $remaining > 0 ) && ( $row = $dbr->fetchObject($res) ) ) {
				$has = true;
	
				if ( $this->unique && $row->rc_namespace >= 0 ) { 
					$k = $row->rc_namespace . ':' . $row->rc_title;
					if ( isset( $ignore[$k] ) ) continue;
					$ignore[$k] = true;
				}
		
				$news[] = $row;
				$remaining -= 1;
			}
	
			$dbr->freeResult( $res );
	
			if ( !$has ) break; #empty result set, stop trying 
		}
		
		return $news;
	}

	function renderNews( ) {
		global $wgTitle;

		$news = $this->fetchNews();

		$text = '';
	
		if ( $this->usetemplate ) {
			$text .= $this->prefix;
		}
		else {
			$text .= $this->changelist->beginRecentChangesList();
		}
	
		foreach ($news as $row) { 
			$t = $this->renderRow( $row );
			$text .= trim($t) . "\n"; #TODO: handle blank lines at the end sanely. Paragraphs may be desired, but not when using lists.
		}
		
		if ( $this->usetemplate ) { #it's wikitext, parse
			#$output = $this->templateparser->parse( $text, $wgTitle, $this->templateoptions, true );
			$text .= $this->postfix;
			$html = $this->templateparser->recursiveTagParse( $text );
		}
		else { #it's already html
			$text .= $this->changelist->endRecentChangesList();
			$html = $text;
		}
	
		return $html;
	}

	function renderFeed( $format, $description = '' ) {
		global $wgSitename, $wgFeedClasses;
		$date = wfTimestamp(); //XXX: use MAX(rc_timestamp) ?

		$cls = $wgFeedClasses[$format];
		if (!class_exists($cls)) return false;

		$url = $this->title->getFullUrl();
		$feed = new $cls( $this->title->getText() . ' - ' . $wgSitename , $description, $url, $date );

		$news = $this->fetchNews();

		ob_start();
		$feed->outHeader();	
		foreach ($news as $row) { 
			$t = $this->renderRow( $row, true );
			$item = $this->makeFeedItem( $row, $t, true );

			$feed->outItem( $item );
		}
		
		$feed->outFooter();
		$xml = ob_get_contents();
		ob_end_clean();

		return $xml;
	}
	
	function renderFeedPreview( ) {
		$news = $this->fetchNews();

		$html = '';
		$html .= '<div class="hfeed"> <!-- using hatom microformat, see http://microformats.org/wiki/hatom -->';
		foreach ($news as $row) { 
			$t = $this->renderRow( $row, true );
			$item = $this->makeFeedItem( $row, $t, false );
			$t = $this->renderFeedItem( $item );
			$html .= $t;
		}
		$html .= '</div>';

		return $html;
	}
	
	function renderFeedItem( $item ) {
		global $wgContLang, $wgUser;
		$sk = $wgUser->getSkin();

		$html = '';
		$html .= '<div class="newsfeed-item hentry">';
		$html .= '<div class="newsfeed-item-head">';

		$html .= '<h1><a href="'.$item->getUrl().'" class="entry-title" rel="bookmark">' . $item->getTitle() . '</a></h1>';

		$html .= '<p><small>';
		$html .= '<span class="author">' . $item->getAuthor() . '</span>';
		$html .= ', ';
		$html .= '<span class="published">' . $wgContLang->timeanddate( $item->getDate() ) . '</span>';
		$html .= '</small></p>';

		$html .= '</div>';

		$html .= '<div class="newsfeed-item-content entry-content">';
		$html .= $item->raw_text;
		$html .= '</div>';
		$html .= '<p><small>';
		if ( $item->getComments() ) {
			$html .= '(';
			$html .= '<a href="'.htmlspecialchars( $item->raw_comment ).'"/>'.htmlspecialchars($item->title_object->getTalkPage()->getPrefixedText()).'</a>';
			$html .= ')';
		}
		$html .= '</small></p>';
		$html .= '</div>';
		return $html;
	}

	function makeFeedItem( $row, $text, $standalone ) {
		global $wgNewsFeedUserPattern;

		$text = $text . ' __NOTOC__'; #XXX ugly hack!

		if ($standalone) {
			$output = $this->templateparser->parse( $text, $GLOBALS['wgTitle'], $this->templateoptions, true );
			$text = $output->mText;
		}
		else {  //FIXME: mask interwikis, categories, etc!!!!!!!!
			$text = $this->templateparser->recursiveTagParse( $text );
		}

		if ( $wgNewsFeedUserPattern ) {
			$user = str_replace('$1', $row->rc_user_text, $wgNewsFeedUserPattern);
		}
		else {
			$user = $row->rc_user_text;
		}

		$title = Title::makeTitle( $row->rc_namespace, $row->rc_title ); //XXX: this is redundant, we already have a title object in renderRow. But no good way to pass it :(

		if ( $this->publication || $row->rc_new ) {
			$name = $title->getPrefixedText();
		}
		else {
			$name = $title->getPrefixedText() . ( $row->rc_comment ? (' - ' . $row->rc_comment) : '' );
			$permaq = "oldid=" . $row->rc_this_oldid;
		}

		if (!$this->publication || $this->permalinks) {
			$url = $row->rc_this_oldid ? $title->getFullURL( $permaq ) : $title->getFullURL();
		}
		else {
			$url = $title->getFullURL();
		}

		$item = new FeedItem( $name,
					$text, 
					$url,
					$row->rc_timestamp,
					$user,
					$title->getTalkPage()->getFullURL() );

		//XXX: ugly hack - things used by preview
		$item->raw_text = $text; //needed because FeedItem holds text html-encoded internally. wtf
		$item->raw_comment = $title->getTalkPage()->getFullURL(); //needed because FeedItem holds text html-encoded internally. wtf
		$item->raw_title = $name; //needed because FeedItem holds text html-encoded internally. wtf
		$item->title_object = $title; //title object
		return $item;
	}

	function renderRow( $row, $forFeed = false ) {
		global $wgUser, $wgLang;

		$change = RecentChange::newFromRow( $row );
		$change->counter = 0; //hack

		$usetemplate = $this->usetemplate;
		$templatetext = $this->templatetext;

		if (!$templatetext && $forFeed) {
			$templatetext = '{{{head}}}';
			$usetemplate = true;
		}

		if ( !$usetemplate ) {
			#$pagelink = $this->skin->makeKnownLinkObj( $title );
		
			$this->changelist->insertDateHeader($dummy, $row->rc_timestamp); #dummy call to suppress date headers
			$html = $this->changelist->recentChangesLine( $change );

			return $html;
		}
		else {
			$params = array();

			$params['namespace'] = $row->rc_namespace;
			$params['title'] = $row->rc_title;

			$title = $change->getTitle();
			$params['pagename'] = $title->getPrefixedText();

			$params['minor'] = $row->rc_minor ? 'true' : '';
			$params['bot'] = $row->rc_bot ? 'true' : '';
			$params['patrolled'] = $row->rc_patrolled ? 'true' : '';
			$params['anon'] = ( $row->rc_user <= 0 ) ? 'true' : ''; #XXX: perhaps use (rc_user == rc_ip) instead? That would take care of entries from importing.
			$params['new'] = ( $row->rc_type == RC_NEW ) ? 'true' : '';

			$params['type'] = $row->rc_type;
			$params['user'] = $row->rc_user_text;
			
			$params['rawtime'] = $row->rc_timestamp;
			$params['time'] = $wgLang->time( $row->rc_timestamp, true, true );
			$params['date'] = $wgLang->date( $row->rc_timestamp, true, true );
			$params['timeanddate'] = $wgLang->timeanddate( $row->rc_timestamp, true, true );

			$params['old_len'] = $row->rc_old_len;
			$params['new_len'] = $row->rc_new_len;

			$params['old_rev'] = $row->rc_last_oldid;
			$params['new_rev'] = $row->rc_this_oldid;

			$diffq = $change->diffLinkTrail( false );
			$params['diff'] = $diffq ? $title->getFullURL( $diffq ) : '';

			$permaq = "oldid=" . $row->rc_this_oldid;
			$params['permalink'] = $permaq ? $title->getFullURL( $permaq ) : '';

			$params['comment'] = str_replace( array( '{{', '}}', '|', '\'' ), array( '&#123;&#123;', '&#125;&#125;', '&#124;', '$#39;' ), wfEscapeWikiText( $row->rc_comment ) );
			
			if ( stripos($templatetext, '{{{content}}}')!==false || stripos($templatetext, '{{{head}}}')!==false ) {
				$article = new Article( $title, $row->rc_this_oldid );
				$t = $article->getContent(); 

				//TODO: expand variables & templates first, so cut-off applies to effective content, 
				//      and extension tags from templates are stripped properly
				//      this doesn't work though: $t = $this->templateparser->preprocess( $t, $this->title, new ParserOptions() );
				//TODO: avoid magic categories, interwiki-links, etc
				$params['content'] = NewsRenderer::sanitizeWikiText( $t, $this->templateparser );

				if ( stripos($templatetext, '{{{head}}}')!==false ) {
					$params['head'] = NewsRenderer::extractHead( $params['content'], $title );
				}
			}

			$text = NewsRenderer::replaceVariables( $this->templateparser, $templatetext, $params, $this->title );
			return $text;
		}
	}

	static function replaceVariables($parser, $text, $params = NULL, $title = NULL) {
		global $wgVersion;

		if ( $params === NULL ) $params = array();
		$text = $parser->replaceVariables( $text, $params );

		/*
		if ( version_compare( $wgVersion, "1.12", '<' ) ) {
		}
		else {
			$parser = $GLOBALS['wgParser'];

			$frame = $parser->getPreprocessor()->newCustomFrame($params);
			$text = $parser->replaceVariables( $text, $frame );
		}
		*/

		return $text;
	}

	/*
	function renderFeedMetaLink( $format ) {
		$format = strtolower(trim($format));

		$name = $format;
		if ($name == 'rss') $name = 'RSS 2.0';
		else if ($name == 'atom') $name = 'Atom 1.0';

		$mime = "application/$format+xml"; //hack
		$url = NewsRenderer::getFeedURL($this->title, $format);
		#$id = $this->feedId ? htmlspecialchars($this->feedId) : NULL;

		$html = '<link rel="alternate" type="'.$mime.'" title="'.($id?"$id - ":'').$name.'" href="'.htmlspecialchars($url).'">';
		return $html;
	}
	*/

	static function getFeedURL( $title, $format ) {
		global $wgNewsFeedURLPattern;

		if ( $wgNewsFeedURLPattern ) {
			$params = array(
				'$1' => urlencode( $title->getPrefixedDBKey() ),
				'$2' => urlencode( $format ),
				#'$3' => urlencode( $feedId ),
			);

			$url = str_replace(array_keys($params), array_values($params), $wgNewsFeedURLPattern);
		}
		else {
			$q = 'feed=' . urlencode( $format );
			#if ($feedId) $q .= '&feed=' . urlencode( $feedId );
	
			$url = $title->getFullUrl($q);
		}

		return $url;
	}

	static function renderFeedLink( $text, $argv, &$parser ) {
		$t = @$argv['feed'];
		if ($t) $t = NewsRenderer::replaceVariables( $parser, $t );

		$title = $t === NULL ? NULL : Title::newFromText($t);
		if (!$title) $title = $GLOBALS['wgTitle'];

		#$id = @$argv['id'];
		$format = @$argv['format'];
		if (!$format) $format = 'rss';
		else $format = strtolower(trim($format));

		$icon = @$argv['icon'];
		$iconright = false;
		if (preg_match('/^(.+)\|(\w+)$/', $icon, $m)) {
			$icon = $m[1];
			$iconright = ( strtolower(trim($m[2])) === 'right' );
		}
		
		$ticon = $icon ? Title::newFromText($icon, NS_IMAGE) : NULL;
		if ( $ticon ) {
			$image = Image::newFromTitle( $ticon );
			if ( !$image->exists() ) {
				$image = false;
			}
		} else {
			$image = false;
		}

		$thumb = $image ? $image->getThumbnail(80, 16) : NULL;
		if ($image && !$thumb) $thumb = $image;
		$iconurl = $thumb ? $thumb->getUrl() : NULL;

		$url = NewsRenderer::getFeedURL($title, $format); 

		$ttl = @$argv['title'];
		if ($ttl) $ttl = NewsRenderer::replaceVariables( $parser, $ttl );

		$s = '';
		if ($text) {
			$s .= $parser->recursiveTagParse($text);
			if (!$ttl) $ttl = $text . ' (' . $format . ')';
		}
		else {
			if (!$ttl) $ttl = $format;
		}

		if ($iconurl) {
			$ic = '<img border="0" src="'.htmlspecialchars($iconurl).'" alt="'.htmlspecialchars($ttl).'" title="'.htmlspecialchars($ttl).'"/>';
			if ($s === '') $s = $ic;
			else if ($iconright) $s = "$s&nbsp;$ic";
			else $s = "$ic&nbsp;$s";
		}

		$html = '<a href="'.htmlspecialchars($url).'" title="'.htmlspecialchars($ttl).'">'.$s.'</a>';
		return $html;
	}

	static function getLastChangeTime( ) {
		$dbr = wfGetDB( DB_SLAVE );
		list( $trecentchanges ) = $dbr->tableNamesN( 'recentchanges' );

		$sql = 'select max(rc_timestamp) from ' . $trecentchanges;
		$res = $dbr->query( $sql, 'NewsRenderer::getLastChangeTime' );
		if (!$res) return false;

		$row = $dbr->fetchRow($res);
		if (!$row) return false;

		return $row[0];
	}

	static function sanitizeWikiText( $text, $parser = NULL ) {
		if ( !$parser ) $parser = $GLOBALS['wgParser'];

		$elements = array_keys( $parser->mTagHooks );
		$uniq_prefix = "\x07NR-UNIQ";

		$matches = array();
		$text = $parser->extractTagsAndParams( $elements, $text, $matches, $uniq_prefix );

		foreach( $matches as $marker => $data ) {
			list( $element, $content, $params, $tag ) = $data;
			$tagName = strtolower( $element );

			$output = '';
			if ($tagName == '!--') $output = $tag; //keep comments for now, may be stripped later

			#print "* $marker => " . htmlspecialchars($output) . "<br />\n";
			$text = str_replace($marker, $output, $text);
		}

		return $text;
	}

	private static function cutHead( $text, $separators, $suffix ) {
		$i = NEWS_HEAD_LENGTH - 1;
		while ($i > NEWS_HEAD_LENGTH - NEWS_HEAD_SCAN) {
			$ch = substr($text, $i, 1);
			if (in_array($ch, $separators)) {
				$text = substr($text, 0, $i);
				return trim($text) . $suffix;
			}

			$i -= 1;
		}

		return false;
	}

	static function extractHead( $text, $title = NULL ) {
		$text = trim($text);

		if ( strlen($text) < NEWS_HEAD_LENGTH ) return $text;

		$suffix = ' &#091;...[[' . $title->getPrefixedText() . ']]...&#093;';

		$t = preg_replace('/^(.*?)<!--\s*summary\s+end\s*-->.*$/si', '\1', $text);
		if ($t != $text) return trim($t) . $suffix;

		if ( $t = NewsRenderer::cutHead($text, array("\r", "\n"), $suffix) ) return $t;
		if ( $t = NewsRenderer::cutHead($text, array("."), $suffix) ) return $t;
		if ( $t = NewsRenderer::cutHead($text, array(" ", "\t"), $suffix) ) return $t;
		
		$text = substr($text, 0, 512) . $suffix;
		return $text;
	}
}

class NewsFeedPage extends Article {
	var $mFeedFormat;

	function __construct($title, $format) {
		Article::__construct( $title );
		$this->mFeedFormat = $format;
	}

	function getCacheKey( ) {
		//global $wgLang;
		//NOTE: per-language caching might be needed at some point.
		//      right now, caching is done for anon users only 
		//      (the content language might be set individually however, 
		//      using an extension like LanguageSelector)
		
		return "@newsfeed:" . urlencode($this->mTitle->getPrefixedDBKey()) . '|' . urlencode($this->mFeedFormat);
	}
	
	function view( $usecache = true ) {
		global $wgUser, $wgOut;

		$fname = 'NewsFeedPage::view';
		wfDebug("$fname: start\n");

		$note = '';	

		$ims = @$_SERVER['HTTP_IF_MODIFIED_SINCE'];

		//TODO: cache control!

		if ( $ims && $usecache ) {
			$lastchange = wfTimestamp(TS_UNIX, NewsRenderer::getLastChangeTime());

			wfDebug( wfMsg( 'newsextension-checkok1', $fname, $ims, $lastchange ) );
			if ( $wgOut->checkLastModified( $lastchange ) ) {
				wfDebug( wfMsg( 'newsextension-checkok' , $fname) );
				return; // done, 304 header sent.
			}
		}

		//NOTE: do caching for anon users only, because of user-specific 
		//      rendering of textual content
		if ($wgUser->isAnon() && $usecache) {
			$cachekey = $this->getCacheKey();
			$ocache = wfGetParserCacheStorage();
			$e = $ocache ? $ocache->get( $cachekey ) : NULL;
			$note .= ' anon;';
			wfDebug( wfMsg( 'newsextension-gotcached', $fname, $e) );
		}
		else {
			if (!$usecache) {
				wfDebug( wfMsg( 'newsextension-purge', $fname ) );
				$note .= ' purged;';
			}
			else {
				wfDebug( wfMsg( 'newsextension-loggin', $fname ) );
				$note .= ' user;';
			}
			
			$cachekey = NULL;
			$ocache = NULL;
			$e = NULL;
			$note .= ' user;';
		}
		
		$wgOut->disable();

		if ( $e ) {
			if (!isset($lastchange)) $lastchange = wfTimestamp(TS_UNIX, NewsRenderer::getLastChangeTime());
			$last = wfTimestamp(TS_UNIX, $lastchange);

			if ($last < $e['timestamp']) {
				wfDebug( wfMsg( 'newsextension-outputting', $fname, $cachekey, $last, $e['timestamp'] ) );
				header('Content-Type: application/' . $this->mFeedFormat . '+xml; charset=UTF-8');

				print $e['xml'];
				print "\n<!-- cached: $note -->\n";

				return; //done
			}
			else {
				wfDebug( wfMsg('newsextension-stale', $fname, $cachekey, $last, $e['timestamp'] ) );
				$note .= " stale: $last >= {$e['timestamp']};";
			}
		}

		//TODO: fetch actual news data and check the newest item. re-apply cache checks.
		//      this would still save the cost of rendering if the data didn't change
		global $wgParser; //evil global
		
		if (!$wgParser->mOptions) { //XXX: ugly hack :(
			$wgParser->mOptions = new ParserOptions; 
			$wgParser->setOutputType( OT_HTML );
			$wgParser->clearState();
			$wgParser->mTitle = $this->mTitle;
		}

		//FIXME: an EXTREMELY ugly hack to force generation of absolute links.
		//       this is needed because Title::getLocalUrl check wgRequest to see
		//       if absolute urls are requested, instead of it being a parser option.
		$_REQUEST['action'] = 'render';
		
		$renderer = NewsRenderer::newFromArticle( $this, $wgParser );
		if (!$renderer) {
			wfDebug( wfMsg( 'newsextension-nofoundonpage', $fname, $this->mTitle->getPrefixedText() ) );
			wfHttpError(404, "Not Found", "no feed found on page: " . $this->mTitle->getPrefixedText() ); //TODO: better code & text
			return;
		}
		
		$description = ''; //TODO: grab from article content... but what? and how?
		$ts = time();
		
		//this also sends the right headers
		$xml = $renderer->renderFeed( $this->mFeedFormat, $description );
		wfDebug( wfMsg( 'newsextension-renderedfeed', $fname ) );
	
		$e = array( 'xml' => $xml, 'timestamp' => $ts );
		if ($ocache) {
			wfDebug( wfMsg( 'newsextension-cachingfeed', $fname, $cachekey ) );
			$ocache->set( $cachekey, $e, $ts + 24 * 60 * 60 ); //cache for max 24 hours; cached record is discarded when anything turns up in RC anyway.
			$note .= ' updated;';
		}

		wfDebug( wfMsg( 'newsextension-freshfeed', $fname ) );
		header('Content-Type: application/' . $this->mFeedFormat . '+xml; charset=UTF-8');
		print $xml;
		print "\n<!-- fresh: $note -->\n";
	}

	function purge() {
		$this->view( false );
	}
}

