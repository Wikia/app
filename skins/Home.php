<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Home skin
 *
 * @package MediaWiki
 * @subpackage Skins
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

require_once dirname(__FILE__) . "/../extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";

class SkinHome extends SkinTemplate {
	function initPage(&$out) {
		global $wgOut;
		wfProfileIn(__METHOD__);

		SkinTemplate::initPage($out);

		$this->skinname  = 'home';
		$this->stylename = 'home';
		$this->template  = 'HomeTemplate';

		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = array($this, 'addVars');

		wfProfileOut(__METHOD__);
	}

	function addVars(&$vars) {
		$vars['search_terms'] = wfSearchPropositions();
		$vars['search_terms_extra'] = wfSearchPropositions('_extra');

		return true;
	}
}

class HomeTemplate extends QuickTemplate {

	/*
	 * Grabs and returns wiki page content
	 *
	 * @param  string  title of page to get
	 * @return string  content of page
	 * @author Maciej Brencz <macbre@wikia.com>
	 */

	function getWikiPage($name)
	{
	$page = null;

	$title = Title::newFromText ($name, NS_TEMPLATE);
	if( $title->exists() ) {
		$article = new Article( $title );
		$page = $article->getContent();
	}

		return $page;
	}

	/*
	 * Parses wiki page containing an unordered list of links
	 *
	 * @param  string  title of page to get
	 * @return mixed   array of xHTML formated links
	 * @author Maciej Brencz <macbre@wikia.com>
	 */

	function parseWikiPage($name)
	{
		$page = $this->getWikiPage($name);

		// format links grabbed from static page
		foreach(explode("\n", $page) as $line)
		{
			$line = trim($line, '* []');

			if (strpos($line, '|') !== FALSE)
			{
				list($link, $title) = explode('|', $line);
			}
			else
			{
				$link  = $line;
				$title = $line;
			}

			// make url
			$url = Title::makeTitle(0, $link)->escapeFullURL();

			// format HTML
			$links[] = '<a href="'.$url.'">'.htmlspecialchars( shortenText( $title ) ).'</a>';
		}

		// return it
		return $links;
	}

	function getSearchData()
	{
	global $wgMemc, $wgMaxSearchTextLength;

	$cnt = 9;
	$arr = array();
	$data = getData( 'wikia:searchcachedata' );
	if( $cnt > count( $data ) )
	{
		$cnt = count( $data );
	}
	if( $cnt )
	{
		$keys = array_rand( $data, $cnt );	// random keys from memcached search data
	}
	else $keys = array();
	for( $i=0; $i<$cnt; $i++ )
	{
		if( is_array( $keys ) )
		{
		$arr[] = shortenText( $data[ $keys[ $i ] ], $wgMaxSearchTextLength );
		}
		else $arr[] = shortenText( $data[ $keys ], $wgMaxSearchTextLength );
	}
	return $arr;
	}

	function getReading()
	{
	global $wgMemc, $wgOut;

	$cnt = 8;
	$arr = array();
	$data = getData( 'wikia:readingcachedata' );
	if( $cnt > count( $data ) )
	{
		$cnt = count( $data );
	}
	if( $cnt )
	{
		$keys = array_rand( $data, $cnt );	// random keys from memcached search data
	}
	else $keys = array();
	for( $i=0; $i<$cnt; $i++ )
	{
		$pos = strpos( $data [ $keys[ $i ] ], ' ');
		$url = substr( $data [ $keys[ $i ] ], 0, $pos );
		$title = trim( substr( $data[ $keys[ $i ] ], $pos+1) );
		$arr[] = '<a href="' . $url . '">' . $title  . '</a>';
		//$arr[] = $wgOut->parse( $data[ $keys[ $i ] ] );
	}
	return implode( '<br />', $arr );
	}

	function getEditing()
	{
	global $wgMemc, $wgOut;

	$cnt = 8;
	$arr = array();
	$data = getData( 'wikia:editingcachedata' );
	if( $cnt > count( $data ) )
	{
		$cnt = count( $data );
	}
	if( $cnt )
	{
		$keys = array_rand( $data, $cnt );	// random keys from memcached search data
	}
	else $keys = array();
	for( $i=0; $i<$cnt; $i++ )
	{
		$pos = strpos( $data [ $keys[ $i ] ], ' ');
		$url = substr( $data [ $keys[ $i ] ], 0, $pos );
		$title = trim( substr( $data[ $keys[ $i ] ], $pos+1) );
		$arr[] = '<a href="' . $url . '">' . $title  . '</a>';
		//$arr[] = $wgOut->parse( $data[ $keys[ $i ] ] );
	}
	return implode( '<br />', $arr );
	}

	function getDiscussing()
	{
	global $wgMemc, $wgOut;

	$cnt = 8;
	$arr = array();
	$data = getData( 'wikia:discusscachedata' );
	if( $cnt > count( $data ) )
	{
		$cnt = count( $data );
	}
	if( $cnt )
	{
		$keys = array_rand( $data, $cnt );	// random keys from memcached search data
	}
	else $keys = array();
	for( $i=0; $i<$cnt; $i++ )
	{
		$pos = strpos( $data [ $keys[ $i ] ], ' ');
		$url = substr( $data [ $keys[ $i ] ], 0, $pos );
		$title = trim( substr( $data[ $keys[ $i ] ], $pos+1) );
		$arr[] = '<a href="' . $url . '">' . $title  . '</a>';
	}
	return implode( '<br />', $arr );
	}

	function getStarting()
	{
	global $wgMemc;
	$cnt = 8;
	$arr = array();
	$data = getData( 'wikia:newwikiscachedata' );
	if( $cnt > count( $data ) )
	{
		$cnt = count( $data );
	}
	if( $cnt )
	{
		$keys = array_rand( $data, $cnt );	// random keys from memcached search data
	}
	else $keys = array();
	for( $i=0; $i<$cnt; $i++ )
	{
		$pos = strpos( $data [ $keys[ $i ] ], ' ');
		$url = substr( $data [ $keys[ $i ] ], 0, $pos );
		$title = trim( substr( $data[ $keys[ $i ] ], $pos+1) );
		$arr[] = '<a href="' . $url . '">' . $title  . '</a>';
	}
	return implode( '<br />', $arr );
	}

	function grabStaticData($id)
	{
	global $wgOut;

		switch($id)
		{
			case 'editing':
				//$data = $this->parseWikiPage('Editing');
				//return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';
		return '<p>'.$this->getEditing().'</p>';

			case 'reading':
				//$data = $this->parseWikiPage('Reading');
				//return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';
		return '<p>'.$this->getReading().'</p>';

			case 'discussing':
				//$data = $this->parseWikiPage('Discussing');
				//return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';
		return '<p>'.$this->getDiscussing().'</p>';

		case 'favorites':
		return $wgOut->parse( '{{Favorites}}' );
			case 'starting':
				//$data = $this->parseWikiPage('Starting');
				//return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';
		return '<p>'.$this->getStarting().'</p>';

			// format searching stats
			//
			case 'search':
				//$data  = $this->getWikiPage('Searching');
		$data = $this->getSearchData();

		if( empty( $data ) )	return '';

				// three columns data
				$columns = array();

				// grab words
				foreach( $data as $word) $words[] = trim($word, ' *');

				// sort them
				//sort($words);

				// format three columns of words
				$c=0;
				foreach($words as $word) $columns[$c++ % 3][] = $word;

				$html = '';

				foreach ($columns as $column)
				{
					$html .= "\n\t\t\t\t\t\t\t\t".'<div class="linkSection">';

					foreach($column as $word)
						$html .= "\n\t\t\t\t\t\t\t\t\t".
						'<div><a href="'.Title::makeTitle(NS_SPECIAL, 'Search')->escapeFullURL().'?search='.urlencode($word).'&amp;fulltext=go'.'">'.
						htmlspecialchars($word).'</a></div>';

					$html .= "\n\t\t\t\t\t\t\t\t".'</div>';
				}

				return $html;

			case 'whats_new':
				$data = $this->parseWikiPage("What's new");
				return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';

			case 'featured':
				$data = $this->parseWikiPage('Featured');
				return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';

			case 'interest_areas':
				$data = $this->parseWikiPage('Interest areas');
				return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';

			case 'all_wikia':
				$data = $this->parseWikiPage('All the wikia');
				return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';

			case 'help':
				$data = $this->parseWikiPage('Help');
				return "\n\t\t\t\t\t\t\t\t\t".'<div>'.implode("</div>\n\t\t\t\t\t\t\t\t\t<div>", $data).'</div>';

			default:
				return FALSE;
		}
	}

	function execute()
	{
		wfProfileIn( __METHOD__ );

		global $wgRequest, $wgUser, $wgTitle, $wgDBname, $wgUseAjax, $wgOut;
		global $wgEnableAjaxLogin, $wgShowAds, $wgUseAdServer, $wgDotDisplay, $wgAdServerUrl;
		global $wgAdServerTest, $wgWikiaUniqueBrowserId;
		global $wgNoWideAd;
		global $wgStyleVersion;

		$this->mTitle = &$this->data['skin']->mTitle;
		$this->memc = &wfGetCache(CACHE_MEMCACHED);  // is this still needed?
		$this->dbname = $wgDBname;  // is this still needed?
		$this->loggedin = &$this->data['loggedin'];
		$this->width = isset($_COOKIE['width']) && is_numeric($_COOKIE['width']) ? $_COOKIE['width'] : 1280;
		$this->action = $wgRequest->getText('action', 'view');
		$this->cachetime = 300;

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<?php $this->html('headlinks') ?>
		<title><?php $this->text('pagetitle') ?></title>

		<meta http-equiv="imagetoolbar" content="no" />

		<?= Skin::makeGlobalVariablesScript( $this->data ); ?>

		<!-- Dependency -->
		<script type="text/javascript" src="http://yui.yahooapis.com/2.5.2/build/yahoo/yahoo-min.js" ></script>

		<!-- Event source file -->
		<script type="text/javascript" src="http://yui.yahooapis.com/2.5.2/build/event/event-min.js" ></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.5.2/build/dom/dom-min.js" ></script>

		<script type="text/javascript" src="http://images.wikia.com/common/yui/logger/logger-min.js?<?= $wgStyleVersion ?>"></script>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/urchin.js?<?= $wgStyleVersion ?>"></script>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?= $wgStyleVersion ?>"><!-- wikibits js --></script>
<?php	if($this->data['jsvarurl'  ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss'   ]) { ?>
		<style type="text/css"><?php $this->html('pagecss'   ) ?></style>
<?php	}
		if($this->data['usercss'   ]) { ?>
		<style type="text/css"><?php $this->html('usercss'   ) ?></style>
<?php	}
		if($this->data['userjs'    ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	}
		if($this->data['trackbackhtml']) echo $this->data['trackbackhtml']; ?>
		<style type="text/css" media="screen,projection">/*<![CDATA[*/@import "<?php $this->text('stylepath') ?>/common/yui_2.5.2/reset/reset-min.css?<?= $wgStyleVersion ?>"; /*]]>*/</style>
<?php $this->html('headscripts') ?>
		<style type="text/css" media="screen,projection">/*<![CDATA[*/@import "<?php $this->text('stylepath') ?>/home/css/main.css?<?= $wgStyleVersion ?>"; /*]]>*/</style>
		<style type="text/css" media="screen,projection">/*<![CDATA[*/@import "<?php $this->text('stylepath') ?>/home/css/main.css?<?= $wgStyleVersion ?>"; /*]]>*/</style>
		<!--[if lt IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/home/css/ie.css?<?= $wgStyleVersion ?>" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/home/css/ie7.css?<?= $wgStyleVersion ?>" /><![endif]-->

		<script type="text/javascript" src="<?php $this->text('stylepath') ?>/home/js/main.js?<?= $wgStyleVersion ?>"></script>
		<script type="text/javascript" src="<?php $this->text('stylepath') ?>/common/tracker.js?<?= $wgStyleVersion ?>"></script>
	</head>

<body class="mediawiki <?php $this->text('dir') ?> <?php $this->text('pageclass') ?>">

<div id="header">
	<div class="shrinkwrap">
		<div id="logo">
			<a href="http://www.wikia.com"><img src="<?php $this->text('stylepath') ?>/home/images/logo.gif?<?= $wgStyleVersion ?>" alt="Wikia - Find and collaborate with people who love what you love."/></a>
		</div>
		<div id="love">
			<form onsubmit="return perform_search()" id="find_form">
				<span style="float: left;">
					What do you love?
					<input type="text" id="search_field" />
				</span>
				<a id="search_button" class="big_button"><big>Find a Wiki</big><small></small></a>
				<input type="submit" value="submit" style="display: none;" />
			</form>
		</div>
		<?= HomeDataProvider::getContentForBox('nav-bar') ?>
	</div>
</div>


<div class="shrinkwrap clearfix">
	<div id="homepage_left_outside">
		<div id="homepage_left_inside">

			<div id="featured_box">
				<?= HomeDataProvider::getContentForBox('main-hub') ?>
			</div>

			<ul id="featured_hubs_header">
				<li>
					<div>Featured Hubs</div>
				</li>
			</ul>
			<table cellspacing="0" id="featured_hubs">
			<tr>
				<td class="first">
					<?= HomeDataProvider::getContentForBox('featured-hubs-column-1') ?>
				</td>
				<td>
					<?= HomeDataProvider::getContentForBox('featured-hubs-column-2') ?>
				</td>
				<td>
					<?= HomeDataProvider::getContentForBox('featured-hubs-column-3') ?>
				</td>
			</tr>
			</table>
			<div id="all_hubs">
				<?= HomeDataProvider::getContentForBox('hubs-footer') ?>
			</div>

		</div>
	</div>
	<div id="homepage_right">
		<div style="position: absolute; top: 15px; left: 50%;"><a href="http://www.wikia.com/wiki/Special:CreateWiki" class="big_button orange" style="margin-left: -50%;" id="create-a-wiki"><big>Create a Wiki</big><small></small></a></div>
<?php
global $wgUser; 
if ( $wgUser->isAnon() ) {
?>
	<div class="box">
		<div style="width: 230px; margin: 0 auto; text-align: center">
<a href="http://www.wikia.com/wiki/Special:Signup&type=login" id="login" class="ajaxLogin">Log in</a> or 
<a href="http://www.wikia.com/wiki/Special:Signup" id="register" class="ajaxRegister">Create an account</a>
		</div>
 	</div>
<?php
}
?>
		<div class="box yellow" style="padding: 0">
                        <?= HomeDataProvider::getContentForBox('promoted-feature-1') ?>
		</div>
		<div class="box blue" style="padding: 0">
			<?= HomeDataProvider::getContentForBox('promoted-feature-2') ?>
		</div>
		<div class="box blue" style="padding: 0">
			<?= HomeDataProvider::getContentForBox('promoted-feature-3') ?>
		</div>
	</div>
</div>

<div id="feature_footer">
	<div class="shrinkwrap">
		<?= HomeDataProvider::getContentForBox('footer-columns') ?>
	</div>
</div>
<div id="footer">
	<div class="shrinkwrap">
		<ul>
			<li><a href="http://www.wikia.com/wiki/Wikia:About">About Us</a></li>
			<li><a href="http://www.wikia.com/wiki/Wikia:Advertising">Advertise</a></li>
			<li><a href="http://www.wikia.com/wiki/Special:Contact">Contact Us</a></li>
			<li><a href="http://www.wikia.com/wiki/Wikia:Hiring">Hiring</a></li>
			<li><a href="http://www.wikia.com/wiki/Wikia:Press">Press</a></li>
			<li><a href="http://www.wikia.com/wiki/Wikia:Terms_of_use">Terms of Use</a></li>
		</ul>
		<div id="copyright">
			<img src="<?php $this->text('stylepath') ?>/home/images/footer_logo.gif?<?= $wgStyleVersion ?>" alt="Wikia" /><br />
			Wikia&reg; is a registered service mark of Wikia, Inc.<br />
			All rights reserved.
		</div>
	</div>
</div>

<!-- analytics (start) -->
<?php
echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
global $wgCityId;
echo AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));
echo AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);

$this->html('bottomscripts');
?>

<!-- analytics (end) -->
</body>
</html>
<?
		echo wfReportTime();

		wfProfileOut( __METHOD__ );
	}
}

class HomeDataProvider {
	static $data;
	static function getContentForBox($boxname) {
		global $wgStyleVersion, $wgStylePath, $wgMemc;

		$prefix = 'Main-page-';

		if(self::$data==null) {
			$key = 'wikia:main_page:data';
			self::$data = $wgMemc->get($key);
			if(!self::$data) {
				//begin: main hub
				//consists of: main-hub-header, main-hub-column-1, main-hub-column-2

				//header + image
				//line no. 1: header
				//line no. 2: url | image | alt
				$msgKey = 'main-hub-header';
				if (!wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
					$msg = explode("\n", $msg);
					if(count($msg) >= 2) {
						$header = ltrim($msg[0], '* ');
						$image = parseItem($msg[1]);
						if ($title = Title::newFromText($image['text'])) {
							$image['src'] = Image::newFromTitle($title)->getUrl();
						}
					}
				}

				//columns
				//line no. 1: header
				//line no. 2: 'more' link
				//line no. 3+: items
				$colsArr = array();
				for($i=1; $i<=2; $i++) {
					$msgKey = "main-hub-column-$i";
					if (wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
						continue;
					}
					$tmp = explode("\n", $msg, 3);
					if(count($tmp) == 3) {
						$tmp[2] = explode("\n", $tmp[2]);
						$items = '';
						$no = 1;
						foreach($tmp[2] as $item) {
							if (strpos($item, '*') !== 0) {
								break;
							}
							$item = parseItem($item);
							$items .= "<li><a id=\"$msgKey/$no\" href=\"{$item['href']}\">{$item['text']}</a></li>";
							$no++;
						}
						if ($items != '') {
							$items = "<ul>$items</ul>";
						}
						$colHeader = parseItem($tmp[0]);
						$more = parseItem($tmp[1]);
						$colsArr[$msgKey] = "
							<h2>{$colHeader['text']}</h2>
							{$items}
							more <a id=\"$msgKey/$no\" href=\"{$more['href']}\">{$more['text']}</a>";
					}
				}
				self::$data['main-hub'] = "<h1>$header</h1>
				<table cellspacing=\"0\">
				<tr>
					<td style=\"vertical-align: middle;\"><a id=\"$msgKey/image\" href=\"{$image['href']}\"><img src=\"{$image['src']}\" alt=\"{$image['desc']}\" /></a></td>
					<td>
						{$colsArr['main-hub-column-1']}
					</td>
					<td>
						{$colsArr['main-hub-column-2']}
					</td>
				</tr>
				</table>";
				//end: main hub

				//begin: featured hubs
				//line no. 1: header
				//line no. 2: subtitle
				//line no. 3: 'more' link
				//line no. 4+: items
				for($i=1; $i<=3; $i++) {
					$msgKey = "featured-hubs-column-$i";
					if (wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
						continue;
					}
					$tmp = explode("\n", $msg, 4);
					if(count($tmp) == 4) {
						$tmp[3] = explode("\n", $tmp[3]);
						$items = '';
						$no = 1;
						foreach($tmp[3] as $item) {
							if (strpos($item, '*') !== 0) {
								break;
							}
							$item = parseItem($item);
							$items .= "<li><a id=\"$msgKey/$no\" href=\"{$item['href']}\">{$item['text']}</a></li>";
							$no++;
						}
						if ($items != '') {
							$items = "<ul>$items</ul>";
						}
						$header = parseItem($tmp[0]);
						$subtitle = parseItem($tmp[1]);
						$more = parseItem($tmp[2]);
						self::$data[$msgKey] = "
							<h1><a href=\"{$header['href']}\">{$header['text']}</a></h1>
							{$subtitle['text']}
							{$items}
							more <a id=\"$msgKey/$no\" href=\"{$more['href']}\">{$more['text']}</a>";
					}
				}
				//end: featured hubs

				//begin: footer with 4 columns
				//consists of: footer-column-1 .. 4

				//line no. 1: header
				//line no. 2: css class
				//line no. 3+: items
				$footerArr = array();
				for($i=1; $i<=4; $i++) {
					$msgKey = "footer-column-$i";
					if (wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
						continue;
					}
					$tmp = explode("\n", $msg, 3);
					if(count($tmp) == 3) {
						$tmp[2] = explode("\n", $tmp[2]);
						$items = '';
						$no = 1;
						foreach($tmp[2] as $item) {
							if (strpos($item, '*') !== 0) {
								break;
							}
							$item = parseItem($item);
							$sublink = '';
							if ($item['desc'] != '') {
								$sublinkA = explode('|', $item['desc'], 2);
								if (count($sublinkA) == 2) {
									$sublink = " (<a id=\"$msgKey/subitem/$no\" href=\"{$sublinkA[0]}\" class=\"secondary\">{$sublinkA[1]}</a>)";
								}
							}
							$items .= "<li><a id=\"$msgKey/$no\" href=\"{$item['href']}\">{$item['text']}</a>$sublink</li>";
							$no++;
						}
						if ($items != '') {
							$items = "<ul>$items</ul>";
						}
						$image = parseItem($tmp[1]);
						if ($title = Title::newFromText($image['org'])) {
							$image['src'] = Image::newFromTitle($title)->getUrl();
						}
						$footerArr[$msgKey] = array('header' => parseItem($tmp[0]), 'image' => $image['src'], 'items' => $items);
					}
				}
				self::$data['footer-columns'] = "
					<table cellspacing=\"0\">
					<tr>
						<th class=\"first\">{$footerArr['footer-column-1']['header']['text']}</th>
						<th>{$footerArr['footer-column-2']['header']['text']}</th>
						<th>{$footerArr['footer-column-3']['header']['text']}</th>
						<th class=\"last\">{$footerArr['footer-column-4']['header']['text']}</th>
					</tr>
					<tr>
						<td class=\"first\" style=\"background: transparent url({$footerArr['footer-column-1']['image']}) no-repeat scroll 95% 95%\">
							{$footerArr['footer-column-1']['items']}
						</td>
						<td style=\"background: transparent url({$footerArr['footer-column-2']['image']}) no-repeat scroll 95% 95%\">
							{$footerArr['footer-column-2']['items']}
						</td>
						<td style=\"background: transparent url({$footerArr['footer-column-3']['image']}) no-repeat scroll 95% 95%\">
							{$footerArr['footer-column-3']['items']}
						</td>
						<td class=\"last\" style=\"background: transparent url({$footerArr['footer-column-4']['image']}) no-repeat scroll 95% 95%\">
							{$footerArr['footer-column-4']['items']}
						</td>
					</tr>
					</table>";
				//end: footer with 4 columns

				//begin: nav bar
				//line no. 1+: items
				$msgKey = 'nav-bar';
				if (!wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
					$msg = explode("\n", $msg);
					$items = '';
					$first = ' class="first"';
					$no = 1;
					foreach($msg as $item) {
						if (strpos($item, '*') !== 0) {
							break;
						}
						$item = parseItem($item);
						$items .= "<li$first><a id=\"$msgKey/$no\" href=\"{$item['href']}\">{$item['text']}</a></li>";
						$first = '';
						$no++;
					}
					if ($items != '') {
						$items = "<ul id=\"navigation\">$items</ul>";
					}
					self::$data[$msgKey] = $items;
				}
				//end: nav bar

				//begin: hubs footer
				//line no. 1: header
				//line no. 2+: items
				$msgKey = 'hubs-footer';
				if (!wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
					$msg = explode("\n", $msg);
					$header = ltrim(array_shift($msg), '* ');
					$items = array();
					$no = 1;
					foreach($msg as $item) {
						if (strpos($item, '*') !== 0) {
							break;
						}
						$item = parseItem($item);
						$items[] = "<a id=\"$msgKey/$no\" href=\"{$item['href']}\">{$item['text']}</a>";
						$no++;
					}
					if (count($items)) {
						$lastItem = array_pop($items);
						$items = $header . ' ' . implode(', ', $items) . "... $lastItem";
						self::$data[$msgKey] = $items;
					}
				}
				//end: hubs footer

                                //begin: promoted feature
                                //line no. 1: header
                                //line no. 2: image | alt
                                //line no. 3: HTML text
                                $msgKey = 'promoted-feature-1';
                                if (!wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
                                        $msg = explode("\n", $msg);
                                        $header = ltrim($msg[0], '* ');
                                        $image = parseItem($msg[1]);
                                        if ($title = Title::newFromText($image['org'])) {
                                                $image['src'] = Image::newFromTitle($title)->getUrl();
                                        }
                                        $text = ltrim($msg[2], '* ');
                                        self::$data[$msgKey] = '';
                                        if ( $header ) {
                                                self::$data[$msgKey] = '<h1>' . htmlspecialchars( $header ) . '</h1>';
                                        }
                                        if ( $image && !empty($image['src']) ) {
                                                self::$data[$msgKey] .= "<img id=\"promoted_feature_img\" src=\"{$image['src']}\" alt=\"{$image['text']}\" style=\"float: right; margin-left: 10px;\" />";
                                        }
                                
                                        self::$data[$msgKey] .= $text;
                                }
                                //end: promoted feature

				//begin: promoted feature 2
				//line no. 1: header
				//line no. 2: image | alt
				//line no. 3: HTML text
				$msgKey = 'promoted-feature-2';
				if (!wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
					$msg = explode("\n", $msg);
					$header = ltrim($msg[0], '* ');
					$image = parseItem($msg[1]);
					if ($title = Title::newFromText($image['org'])) {
						$image['src'] = Image::newFromTitle($title)->getUrl();
					}
					$text = ltrim($msg[2], '* ');
					self::$data[$msgKey] = '';
					if ( $header ) {
						self::$data[$msgKey] = '<h1>' . htmlspecialchars( $header ) . '</h1>';
					}
					if ( $image && !empty($image['src']) ) {
						self::$data[$msgKey] .= "<img id=\"promoted_feature_img\" src=\"{$image['src']}\" alt=\"{$image['text']}\" style=\"float: right; margin-left: 10px;\" />";
					}

					self::$data[$msgKey] .= $text;
				}
				//end: promoted feature

				//begin: promoted feature 3
                                //line no. 1: header
                                //line no. 2: image | alt
                                //line no. 3: HTML text
                                $msgKey = 'promoted-feature-3';
                                if (!wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
                                        $msg = explode("\n", $msg);
                                        $header = ltrim($msg[0], '* ');
                                        $image = parseItem($msg[1]);
                                        if ($title = Title::newFromText($image['org'])) {
                                                $image['src'] = Image::newFromTitle($title)->getUrl();
                                        }
                                        $text = ltrim($msg[2], '* ');
                                        self::$data[$msgKey] = '';
                                        if ( $header ) {
                                                self::$data[$msgKey] = '<h1>' . htmlspecialchars( $header ) . '</h1>';
                                        }
                                        if ( $image && !empty($image['src']) ) {
                                                self::$data[$msgKey] .= "<img id=\"promoted_feature_img\" src=\"{$image['src']}\" alt=\"{$image['text']}\" style=\"float: right; margin-left: 10px;\" />";
                                        }

                                        self::$data[$msgKey] .= $text;
                                }

				$wgMemc->set($key, self::$data, 300);
			}
		}
		return isset(self::$data[$boxname]) ? self::$data[$boxname] : "&lt;$prefix$boxname&gt;";
	}
}

function wfSearchPropositions($extra='') {
	global $wgMemc;
	$key = 'wikia:main_page:search_terms' . $extra . ':1';
	$items = $wgMemc->get($key);
	if(!$items) {
		$prefix = 'Main-page-';
		$msgKey = 'search-terms' . $extra;
		if (!wfEmptyMsg($prefix . $msgKey, $msg = wfMsg($prefix . $msgKey))) {
			$msg = explode("\n", $msg);
			$items = array();
			foreach($msg as $item) {
				if (strpos($item, '*') !== 0) {
					break;
				}
				$items[] = explode('|', ltrim($item, '* '));
			}
		}
		$wgMemc->set($key, $items, 300);
	}
	return $items;
}
