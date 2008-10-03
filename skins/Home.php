<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Home skin
 *
 * @package MediaWiki
 * @subpackage Skins
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @copyright Copyright (C) 2008 Maciej Brencz, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SkinHome extends SkinTemplate {

	function initPage(&$out) {

		wfProfileIn(__METHOD__);

		SkinTemplate::initPage($out);

		$this->skinname  = 'home';
		$this->stylename = 'home';
		$this->template  = 'HomeTemplate';

		wfProfileOut(__METHOD__);
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

 	function choose_featured_hub() {
		global $featured_hub, $non_featured_hub, $wgStyleVersion;

		$gaming_featured = '<h1>Wikia Gaming is home to over 500,000 pages of content on more than 1,500 wiki fansites built by millions of Xbox, PS3, Wii, PC and handheld gamers.</h1>
				<table cellspacing="0">
				<tr>
					<td style="vertical-align: middle;"><a href="http://gaming.wikia.com"><img src="'. $this->data['stylepath'] .'/home/images/featured_wikia_gaming.gif?'. $wgStyleVersion .'" alt="Wikia Gaming" /></a></td>
					<td>
						<h2>Console</h2>
						<ul>
							<li><a href="http://super-smash-bros.wikia.com">Super Smash Bros.</a></li>
							<li><a href="http://fallout.wikia.com">Fallout</a></li>
							<li><a href="http://littlebigplanet.wikia.com">Little Big Planet</a></li>
							<li><a href="http://finalfantasy.wikia.com">Final Fantasy</a></li>
							<li><a href="http://residentevil.wikia.com">Resident Evil</a></li>
						</ul>
						more <a href="http://gaming.wikia.com">console wikis</a>
					</td>
					<td>
						<h2>PC</h2>
						<ul>
							<li><a href="http://www.wowwiki.com">World of Warcraft</a></li>
							<li><a href="http://warhammeronline.wikia.com">Warhammer Online</a></li>
							<li><a href="http://spore.wikia.com">Spore</a></li>
							<li><a href="http://diablo.wikia.com">Diablo</a></li>
							<li><a href="http://wiki.ffxiclopedia.org">Final Fantasy XI</a></li>
						</ul>
						more <a href="http://gaming.wikia.com">PC wikis</a>
					</td>
				</tr>
				</table>';
		
		$entertainment_featured = '<h1>Wikia Entertainment is home to over 1,000 wiki fansites built by millions of Movies, TV, Comics and Anime addicts.</h1>
				<table cellspacing="0">
				<tr>
					<td style="vertical-align: middle;"><a href="http://entertainment.wikia.com"><img src="'. $this->data['stylepath'] .'/home/images/featured_wikia_entertainment.gif?'. $wgStyleVersion .'" alt="Wikia Gaming" /></a></td>
					<td>
						<h2>Movies &amp; TV</h2>
						<ul>
							<li><a href="http://starwars.wikia.com">Star Wars</a></li>
							<li><a href="http://fringe.wikia.com">Fringe</a></li>
							<li><a href="http://harrypotter.wikia.com">Harry Potter</a></li>
							<li><a href="http://24.wikia.com">24</a></li>
							<li><a href="http://muppet.wikia.com">Muppets</a></li>
						</ul>
						more <a href="http://entertainment.wikia.com/wiki/Movies">movies</a> &amp <a href="http://entertainment.wikia.com/wiki/TV">TV wikis</a>
					</td>
					<td>
						<h2>Comics &amp; Anime</h2>
						<ul>
							<li><a href="http://en.marveldatabase.com">Marvel Comics</a></li>
							<li><a href="http://bleach.wikia.com">Bleach</a></li>
							<li><a href="http://naruto.wikia.com">Naruto</a></li>
							<li><a href="http://watchmen.wikia.com">Watchmen</a></li>
							<li><a href="http://southpark.wikia.com">South Park</a></li>
						</ul>
						more <a href="http://entertainment.wikia.com/wiki/Comics">comics</a> &amp; <a href="http://entertainment.wikia.com/wiki/Anime">anime wikis</a>
					</td>
				</tr>
				</table>';
		
		$gaming_non_featured = '<h1><a href="http://gaming.wikia.com">Gaming</a></h1>
					Everything from MMO and RPGs to Fighters and Shooters... 
					<ul>
						<li><a href="http://www.wowwiki.com">World of Warcraft</a></li>
						<li><a href="http://fallout.wikia.com">Fallout</a></li>
						<li><a href="http://warhammeronline.wikia.com">Warhammer Online</a></li>
						<li><a href="http://super-smash-bros.wikia.com">Super Smash Bros.</a></li>
						<li><a href="http://halo.wikia.com">Halo</a></li>
					</ul>
					more <a href="http://gaming.wikia.com">gaming wikis</a>';

		$entertainment_non_featured = '<h1><a href="http://entertainment.wikia.com">Entertainment</a></h1>
					Movies, TV, Comics, Anime, Books, and more.
					<ul>
						<li><a href="http://starwars.wikia.com">Star Wars</a></li>
						<li><a href="http://en.marveldatabase.com">Marvel Comics</a></li>
						<li><a href="http://harrypotter.wikia.com">Harry Potter</a></li>
						<li><a href="http://muppet.wikia.com">Muppet</a></li>
						<li><a href="http://watchmen.wikia.com">Watchmen</a></li>
					</ul>
					more <a href="http://entertainment.wikia.com">entertainment wikis</a>';



		$choice = rand(0, 1);
		if ($choice == 0) {
			$featured_hub = $gaming_featured;
			$non_featured_hub = $entertainment_non_featured;
		} else if ($choice == 1) {
			$featured_hub = $entertainment_featured;
			$non_featured_hub = $gaming_non_featured;
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
		global $featured_hub, $non_featured_hub;

		$this->mTitle = &$this->data['skin']->mTitle;
		$this->memc = &wfGetCache(CACHE_MEMCACHED);  // is this still needed?
		$this->dbname = $wgDBname;  // is this still needed?
		$this->loggedin = &$this->data['loggedin'];
		$this->width = isset($_COOKIE['width']) && is_numeric($_COOKIE['width']) ? $_COOKIE['width'] : 1280;
		$this->action = $wgRequest->getText('action', 'view');
		$this->cachetime = 300;
		$this->choose_featured_hub();

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


<?php /**
<!-- YUI -->
<script type="text/javascript" src="http://images.wikia.com/common/yui/utilities/utilities.js?<?= $wgStyleVersion ?>"></script>
<script type="text/javascript" src="http://images.wikia.com/common/yui/container/container-min.js?<?= $wgStyleVersion ?>"></script>
<script type="text/javascript" src="http://images.wikia.com/common/yui/autocomplete/autocomplete-min.js?<?= $wgStyleVersion ?>"></script>
<script type="text/javascript" src="http://images.wikia.com/common/yui/logger/logger-min.js?<?= $wgStyleVersion ?>"></script>
<script type="text/javascript" src="http://images.wikia.com/common/yui/3rdpart/yui-cookie.js?<?= $wgStyleVersion ?>"></script>
<script type="text/javascript" src="http://images.wikia.com/common/yui/3rdpart/tools-min.js?<?= $wgStyleVersion ?>"></script>
**/ ?>
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

<?php /**
	<link rel="stylesheet" type="text/css" href="http://images.wikia.com/common/yui/container/assets/container.css?<?= $wgStyleVersion ?>" />
	<link rel="stylesheet" type="text/css" href="http://images.wikia.com/common/yui/logger/assets/logger.css?<?= $wgStyleVersion ?>" />

**/ ?>
	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/home/js/main.js?<?= $wgStyleVersion ?>"></script>
</head>

<body class="mediawiki <?php $this->text('nsclass') ?> <?php $this->text('dir') ?> <?php $this->text('pageclass') ?>">

<?php
		if ( $wgTitle->getText() != 'Userlogin' ) {
			global  $wgEnableEmail, $wgAuth;

			$titleObj = SpecialPage::getTitleFor( 'Userlogin' );

			$link = '<a id="registerFromAjaxLogin" href="' . htmlspecialchars ( $titleObj->getLocalUrl( 'type=signup' ) ) . '">';
			$link .= wfMsgHtml( 'nologinlink' );
			$link .= '</a>';
?>
	<div id="userloginRound" class="wikiaDialog roundedDiv" style="display:none; background:none; border:none" >
		<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
		<div class="r_boxContent boxContent">
			<form action="index.php" method="post" name="userlogin" id="userlogin" style="margin:5px">
				<table class="loginText">
					<tr>
						<td id="AjaxLoginReason" colspan="2" style="padding: 0px 5px 5px 0px"></td>
					</tr>
					<tr>
						<td align="right">
							<label for="wpName1"><?php $this->msg("yourname") ?>:</label>
						</td>
						<td align="left">
							<input type="text" class="loginText" name="wpName" id="wpName1" tabindex="1" size="20" style="width:100%"/>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="wpPassword1"><?php $this->msg("yourpassword") ?>:</label>
						</td>
						<td align="left">
							<input type="password" class="loginPassword" name="wpPassword" id="wpPassword1" tabindex="2" size="20" style="width:100%"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="left">
							<input type="checkbox" name="wpRemember" tabindex="4" value="1" id="wpRemember" <?php if( $wgUser->getOption( 'rememberpassword' ) ) { ?>checked="checked"<?php } ?> />
							<label for="wpRemember"><?php $this->msg('remembermypassword') ?></label>
						</td>
					</tr>
					<tr>
						<td align="center">
							<img src="http://images.wikia.com/common/indicator_square.gif" alt="Wait" id="ajaxLoginWait" style="visibility: hidden" />
						</td>
						<td align="left" style="white-space:nowrap">
							<input style="margin:0;padding:0 .25em;width:auto;overflow:visible;" type="submit" name="wpLoginattempt" id="wpLoginattempt" tabindex="5" value="<?php $this->msg("login") ?>" />
<?php if( $wgEnableEmail && $wgAuth->allowPasswordChange() ) { ?>
							<input style="margin:0;padding:0 .25em;width:auto;overflow:visible;" type="submit" name="wpMailmypassword" id="wpMailmypassword" tabindex="6" value="<?php $this->msg('mailmypassword') ?>" />
<?php } ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><?=$link?></td>
					</tr>
				</table>
			</form>
		</div>
		<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
	</div>
<?php
		}
?>


<div id="header">
	<div class="shrinkwrap">
		<div id="logo">
			<a href="http://www.wikia.com"><img src="<?php $this->text('stylepath') ?>/home/images/logo.gif?<?= $wgStyleVersion ?>" alt="Wikia - Find and collaborate with people who love what you love."/></a>
		</div>
		<div id="love">
			<form action="javascript: perform_search()">
				<span style="float: left;">
					What do you love?
					<input type="text" id="search_field" />
				</span>
				<a id="search_button" class="big_button"><big>Find a Wiki</big><small></small></a>
				<input type="submit" value="submit" style="display: none;" />
			</form>
		</div>
		<ul id="navigation">
			<li class="first">
				<a href="http://www.wikia.com/wiki/Category:Hubs">Content Hubs</a>
			</li>
			<li>
				<a href="http://www.wikia.com/wiki/Big_wikis">Biggest Wikis</a>
			</li>
			<li>
				<a href="http://www.wikia.com/wiki/Wikia_languages">Wikis by Language</a>
			</li>
			<li>
				<a href="http://help.wikia.com/wiki/Help:Video_demos">What is a Wiki?</a>
			</li>
			<li>
				<a href="http://help.wikia.com">Wikia Help</a>
			</li>
		</ul>
	</div>
</div>


<div class="shrinkwrap clearfix">
	<div id="homepage_left_outside">
		<div id="homepage_left_inside">
		
			<div id="featured_box">
				<?php
					echo $featured_hub;
				?>
			</div>

			<ul id="featured_hubs_header">
				<li>
					<div>Featured Hubs</div>
				</li>
			</ul>
			<table cellspacing="0" id="featured_hubs">
			<tr>
				<td class="first">
					<?php
						echo $non_featured_hub;
					?>
				</td>
				<td>
					<h1><a href="http://www.wikia.com/wiki/Sports">Sports</a></h1>
					Football, Basketball, Racing, Wrestling, Snooker, and more.
					<ul>
						<li><a href="http://www.armchairgm.com">Armchair GM</a></li>
						<li><a href="http://prowrestling.wikia.com">Pro Wrestling</a></li>
						<li><a href="http://mma.wikia.com">Mixed Martial Arts</a></li>
						<li><a href="http://thirdturn.wikia.com">NASCAR</a></li>
						<li><a href="http://baseball.wikia.com">Baseball</a></li>
					</ul>
					more <a href="http://www.wikia.com/wiki/Sports">sports wikis</a>
				</td>
				<td>
					<h1><a href="http://www.wikia.com/wiki/Toys">Toys</a></h1>
					For collectors, customizers, and kids of all ages.
					<ul>
						<li><a href="http://hotwheels.wikia.com">Hot Wheels</a></li>
						<li><a href="http://bionicle.wikia.com">Bionicle</a></li>
						<li><a href="http://americangirl.wikia.com">American Girl</a></li>
						<li><a href="http://gijoe.wikia.com">GI Joe</a></li>
						<li><a href="http://lego.wikia.com">Lego</a></li>
					</ul>
					more <a href="http://www.wikia.com/wiki/Toys">toys wikis</a>
				</td>
			</tr>
			</table>
			<div id="all_hubs">
				See more content hubs: <a href="http://www.wikia.com/wiki/Humor">Humor</a>, <a href="http://www.wikia.com/wiki/Auto">Auto</a>, <a href="http://www.wikia.com/wiki/Technology">Technology</a>, <a href="http://www.wikia.com/wiki/Finance">Finance</a>... <a href="http://www.wikia.com/wiki/Category:Hubs">See All</a>
			</div>

		</div>
	</div>
	<div id="homepage_right">
		<div style="position: absolute; top: 15px; left: 50%;"><a href="http://requests.wikia.com" class="big_button orange" style="margin-left: -50%;"><big>Create a Wiki</big><small></small></a></div>
		<div class="box yellow" style="background-image: url(<?php $this->text('stylepath') ?>/home/images/new_to_wikis_accent.gif); background-position: 240px 100%; background-repeat: no-repeat; padding-right: 70px;">
			<h1>New to Wikis?</h1> 
			"Wiki" comes from the Hawaiian word for fast. Wikia's wikis are websites where editing is simple and quick.<br />
			<a href="http://help.wikia.com/wiki/Help:Video_demos">Take a video tour</a> to learn more.
		</div>
		<div class="box blue">
			<h1>Adding Pictures just got easier</h1>
			<img src="<?php $this->text('stylepath') ?>/home/images/adding_pictures_accent.gif?<?= $wgStyleVersion ?>" alt="Flickr" style="float: right; margin-left: 10px;" />
			Now you can search for images on Flickr, Wikia, or your desktop and add them directly to any article from the edit toolbar. Read the <a href="http://help.wikia.com/wiki/Help:Add_Images">help page</a> to learn more.
		</div>
		<div class="box green">
			<img src="<?php $this->text('stylepath') ?>/home/images/wikia_search.gif?<?= $wgStyleVersion ?>" alt="Wikia Search" style="float: right; margin-left: 10px;" />
			<b>Wikia</b> is working to fix web searching in a collaborative and open way. Try searching the web with Wikia and help us improve our results.<br />
			<form action="javascript: wikia_search();" style="margin-top: 3px;">
				<input type="text" id="wikia_search_field" />
				<input type="submit" value="go" />
			</form>
		</div>
	</div>
</div>

<div id="feature_footer">
	<div class="shrinkwrap">
		<table cellspacing="0">
		<tr>
			<th class="first">Most Horrifying Characters</th>
			<th>Wikia's Top Robots</th>
			<th>WoW's Most Wanted Items</th>
			<th class="last">Harry Potter's Spells</th>
		</tr>
		<tr>
			<td class="first gaming">
				<ol>
					<li><a href="http://residentevil.wikia.com/wiki/Nemesis">Nemesis</a> (<a href="http://residentevil.wikia.com" class="secondary" >Resident Evil</a>)</li>
					<li><a href="http://silenthill.wikia.com/wiki/The_One_Truth">The One Truth</a> (<a href="http://silenthill.wikia.com" class="secondary">Silent Hill</a>)</li>
					<li><a href="http://bioshock.wikia.com/wiki/Little_Sisters">Little Sisters</a> (<a href="http://bioshock.wikia.com" class="secondary">BioShock</a>)</li>
					<li><a href="http://doom.wikia.com/wiki/Vulgar">The Vulgar</a> (<a href="http://doom.wikia.com" class="secondary">Doom</a>)</li>
					<li><a href="http://animalcrossing.wikia.com/wiki/Agent_S">Agent S</a> (<a href="http://animalcrossing.wikia.com" class="secondary">Animal Crossing</a>)</li>
				</ol>
			</td>
			<td class="entertainment">
				<ul>
					<li><a href="http://starwars.wikia.com/wiki/R2-D2">R2-D2</a> (<a href="http://starwars.wikia.com" class="secondary">Wookieepedia</a>)</li>
					<li><a href="http://terminator.wikia.com/wiki/T-800">T-800</a> (<a href="http://terminator.wikia.com" class="secondary">Terminator Wiki</a>)</li>
					<li><a href="http://futurama.wikia.com/wiki/Bender_Bending_Rodr%C3%ADguez">Bender</a> (<a href="http://futurama.wikia.com" class="secondary">Futurama Wiki</a>)</li>
					<li><a href="http://memory-alpha.org/en/wiki/Data">Data</a> (<a href="http://memory-alpha.org" class="secondary">Memory Alpha</a>)</li>
					<li><a href="http://pixar.wikia.com/wiki/WALL%E2%80%A2E_(character)">WALL-E</a> (<a href="http://pixar.wikia.com" class="secondary">Pixar Wiki</a>)</li>
				</ul>
			</td>
			<td class="gaming">
				<ul>
			    		<li><a href="http://www.wowwiki.com/The_Skull_of_Gul%27dan">Skull of Gul'dan</a></li>
			        	<li><a href="http://www.wowwiki.com/Frostmourne">Frostmourne</a></li>
					<li><a href="http://www.wowwiki.com/Ashbringer">Ashbringer</a></li>
					<li><a href="http://www.wowwiki.com/The_1_Ring">The 1 Ring</a></li>
					<li><a href="http://www.wowwiki.com/Atiesh%2C_Greatstaff_of_the_Guardian">Atiesh</a></li>
				</ul>
			</td>
			<td class="last entertainment">
				<ul>
					<li><a href="http://harrypotter.wikia.com/wiki/Patronus">Patronus</a></li>
					<li><a href="http://harrypotter.wikia.com/wiki/Cruciatus_Curse">Cruciatus Curse</a></li>
					<li><a href="http://harrypotter.wikia.com/wiki/Expelliarmus">Expelliarmus</a></li>
					<li><a href="http://harrypotter.wikia.com/wiki/Imperius_Curse">Imperius Curse</a></li>
					<li><a href="http://harrypotter.wikia.com/wiki/Avada_Kedavra">Avada Kedavra</a></li>
				</ul>
			</td>
		</tr>
		</table>
	</div>
</div>
<div id="footer">
	<div class="shrinkwrap">
		<ul>
			<li><a href="http://www.wikia.com/wiki/About_Wikia">About Us</a></li>
			<li><a href="http://www.wikia.com/wiki/Advertising">Advertise</a></li>
			<li><a href="http://www.wikia.com/wiki/Contact_us">Contact Us</a></li>
			<li><a href="http://www.wikia.com/wiki/Hiring">Hiring</a></li>
			<li><a href="http://www.wikia.com/wiki/Press">Press</a></li>
			<li><a href="http://www.wikia.com/wiki/Terms_of_use">Terms of Use</a></li>
		</ul>
		<div id="copyright">
			<img src="<?php $this->text('stylepath') ?>/home/images/footer_logo.gif?<?= $wgStyleVersion ?>" alt="Wikia" /><br />
			Wikia&reg; is a registered service mark of Wikia, Inc.<br />
			All rights reserved.
		</div>
	</div>
</div>

<!-- analytics (start) -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<?php
    global $wgServer;
    if ( !empty($this->data['adserver_ads']) ) {
        echo "<!-- adserver on, injecting bottom JS.. " . count($this->data['adserver_ads']) . "-->\n";
        echo $this->data['adserver_ads'][ADSERVER_POS_JS_BOT1];
        echo $this->data['adserver_ads'][ADSERVER_POS_JS_BOT2];
        echo $this->data['adserver_ads'][ADSERVER_POS_JS_BOT3];
    }
    //Emil - display GoogleAnalytics for wikis that don't use adserver
    elseif ( preg_match("/wikia.com/",$wgServer) ) {
?>
<script src="http://www.google-analytics.com/urchin.js"  type="text/javascript"></script>
<script type="text/javascript">
_udn = "none";_uff = 0;_uacct="UA-288915-1"; urchinTracker();
_udn = "none";_uff = 0;_uacct="UA-288915-3"; urchinTracker();
</script>
<?php
    }
	$this->html('bottomscripts');
?>

<!-- Start Quantcast tag -->
<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>
<script type="text/javascript">_qacct="p-8bG6eLqkH6Avk";quantserve();</script>
<noscript>
<a href="http://www.quantcast.com/p-8bG6eLqkH6Avk" target="_blank"><img src="http://pixel.quantserve.com/pixel/p-8bG6eLqkH6Avk.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/></a>
</noscript>
<!-- End Quantcast tag -->
<!-- analytics (end) -->
</body>
</html>
<?
		echo wfReportTime();

		wfProfileOut( __METHOD__ );
	}
}
