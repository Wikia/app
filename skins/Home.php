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
        <?php $this->html('headscripts') ?>
    <style type="text/css" media="screen,projection">/*<![CDATA[*/@import "<?php $this->text('stylepath') ?>/home/css/main.css?<?= $wgStyleVersion ?>"; /*]]>*/</style>
	<!--[if lt IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/home/css/ie.css?<?= $wgStyleVersion ?>" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/home/css/ie7.css?<?= $wgStyleVersion ?>" /><![endif]-->

<?php /**
	<link rel="stylesheet" type="text/css" href="http://images.wikia.com/common/yui/container/assets/container.css?<?= $wgStyleVersion ?>" />
	<link rel="stylesheet" type="text/css" href="http://images.wikia.com/common/yui/logger/assets/logger.css?<?= $wgStyleVersion ?>" />

	<script type="text/javascript" src="<?php $this->text('stylepath') ?>/home/js/main.js?<?= $wgStyleVersion ?>"></script>
**/ ?>
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
<div id="mainContainer">
	<div id="header">
		<a class="headerLogo" href="http://www.wikia.com"></a>
		<div class="headerCopy">
			<?php

if($this->loggedin) {
?>
				<span><? global $wgOut; echo wfMsgExt('login_greeting', array('parseinline'), $wgUser->getName()); ?></span>&emsp;
				<span class="notYouCopy">
					<?php $this->msg('not_you'); ?> <a href="<?= Skin::makeSpecialUrl( 'Userlogout', $wgTitle->isSpecial( 'Preferences' ) ? '' : "returnto=".SpecialPage::getTitleFor('Userlogin')->getPrefixedDBkey()); ?>" id="login_as_another" onclick="<?php if ($wgEnableAjaxLogin) { echo " javascript:Login(); return false;"; } ?>"><?php $this->msg('login_as_another'); ?></a>
				</span>
<?php
} else {
?>
				<span>
<?php
        printf('<a href="%s" id="login">%s</a>',
	Skin::makeSpecialUrl( 'Userlogin', 'returnto=Wikia' ),
	wfMsg('login'));
?> or <?php
        printf('<a href="%s" id="register">%s</a>',
        Skin::makeSpecialUrl( 'Userlogin', 'type=signup' ),
        wfMsg('create_an_account') );
?>
				</span>
<?php
}
?>

		</div>
	</div>

	<div id="header-search-bar">
		<form onsubmit="return search();">
			<input type="text" value="" id="q2" class="header-search-input" name="q2"/>
			<input type="submit" value="Web Search" onclick="search();" />
		</form>

		<script type="text/javascript">/*<![CDATA[*/
                function search(){
                        window.location='http://re.search.wikia.com/search.html#' + document.getElementById('q2').value;
                        return false;
                }
		document.getElementById('q2').focus();
                /*]]>*/</script>

	</div>


	<div id="mainContent">
		<div id="leftCol">
			<div id="introSection">

				<!-- rounded box -->
					<div class="roundedDiv blacktext">
					<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
						<div class="boxContent"><?php echo $wgOut->parse( "{{Main Page}}" );?>
							<div class="joinUs">
								<table cellpadding="0" cellspacing="0">
								<tr>
									<td><?php

									printf('<a href="%s" onclick="%s" style="border: none">',
                                    Skin::makeSpecialUrl( 'Userlogin', "type=signup" ),
                                    ($wgEnableAjaxLogin) ? 'javascript:Register(); return false;' : '');

									?><img src="<?php $this->text('stylepath') ?>/home/images/button_joinus.png" style="cursor:pointer; border:none" alt="Join us" /></a></td>
									<td class="joinUsCopy"><?php echo wfMsg( 'its_easy' );?></td>
								</tr>
								</table>
							</div>
							<div class="tutorial">
								<table cellpadding="0" cellspacing="0">
								<tr>
									<td class="tutorialCopy"><?php echo wfMsg( 'or_learn' );?></td>
									<td><a href="http://www.wikia.com/wiki/Help:Tutorial_1"><img src="<?php $this->text('stylepath') ?>/home/images/button_tutorial.png" style="border:none" alt="Tutorial" /></a></td>
								</tr>
								</table>
							</div>
							<div style="clear: both;"></div>
						</div>
					<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
					</div>
				<!-- rounded box -->

			</div>

		</div>

		<div id="rightCol">
			<div id="rightNowSection">
<?php

    // define rightNowSection elements (id's, names, static pages containing data list to display)

    $rightNowSections = array
    (
        'reading'    => 'Reading',
        'editing'    => 'Editing',
        'discussing' => 'Discussing',
        'favorites'  => 'Staff Favorites',
        'starting'   => 'Starting new wikia'
    );

    $selectedSection = isset($_COOKIE['rightNow']) ? $_COOKIE['rightNow'] : 'favorites';
?>
				<!-- rounded box -->
					<div class="roundedDiv blacktext">
					<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
						<div class="boxContent clearfix">

<!--
style="height: 155px;">
							<div class="rightNowLeft">
								<div class="title"><?php echo wfMsg('right_now');?></div>
								<div id="rightNowLinks"><?php

								    foreach($rightNowSections as $id => $name)
								    {
								        echo '<div id="'.$id.'"'. ($selectedSection == $id ? ' class="selected"' : '').'><a id="'.$id.'_link" href="">'.$name.'</a></div>';
								    }

								?>

							    </div>
							</div>
							<div id="rightNowSubLinks"><?php

								    foreach($rightNowSections as $id => $name)
								    {
								        echo '<div id="'.$id.'_links" style="display: '. ($selectedSection == $id ? 'block' : 'none').'">'.$this->grabStaticData($id).'</div>';
								    }

    							?>

							</div>
							<div style="clear: both;"></div>
-->
<?php echo $wgOut->parse( "{{Toprightbox}}"); ?>
						</div>
					<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
					</div>
				<!-- rounded box -->
			</div>
			<div id="searchSection">

				<!-- rounded box -->
					<div class="roundedDiv">
					<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
						<div class="boxContent">
						    <form action="<?php $this->text('searchaction') ?>" id="searchform">
							<div class="header"><?php echo wfMsgExt('search', array( 'parseinline' ) );?></div>
							<div>
								<input type="text" name="search" value="" />
							</div>
							<?php
							    $searchLinks = $this->grabStaticData('search');
							    if( !empty( $searchLinks ) ) {
							    ?>
							    <div class="subHeader"><?php echo wfMsg('other_people');?></div>
							<div class="searchLinks"><?= $searchLinks ?></div>
							<?php } ?>
							<div id="goButton"><span><a href="" onclick="document.getElementById('searchform').submit();return false;">go</a></span></div>
							<div style="clear: both;"></div>
						    </form>
						</div>
					<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
					</div>
				<!-- rounded box -->
			</div>

		</div>

	</div>
	<div id="discoverySection">
			<!-- rounded box -->
				<div class="roundedDiv">
				<b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b>
					<div class="boxContent" style="">
						<div style="">
							<?php for( $i=1; $i<=5; $i++ ) { ?>
							<div class="discoveryLinkSection">
								<div class="discoveryHeader"><?php echo wfMsgExt("Footer_home_header_$i", array('parseinline'));?></div>
								<?php echo $wgOut->parse( "{{Footer_home_links_$i}}" );?>
							</div>
							<?php } ?>
						</div>
						<div style="clear: both;"></div>
					</div>
				<b class="xbottom"><b class="xb4"></b><b class="xb3"></b><b class="xb2"></b><b class="xb1"></b></b>
				</div>
			<!-- rounded box -->
	</div>
	<div id="footer">
		<div class="adDiv">
		    <img src="<?php $this->text('stylepath') ?>/home/images/awards/business2000.jpg" />
		    &nbsp;
		    <img src="<?php $this->text('stylepath') ?>/home/images/awards/econtent.jpg" />
		    &nbsp;
		    <img src="<?php $this->text('stylepath') ?>/home/images/awards/red_herring.jpg" />
		    &nbsp;
		    <img src="<?php $this->text('stylepath') ?>/home/images/awards/webware.jpg" />
		</div>
		<div class="adDiv">
			<img src="<?php $this->text('stylepath') ?>/home/images/gp_media.png" border="0" width="128" height="22" />
		</div>

		<div class="footerMain">
			<a class="footerLogo" href="http://www.wikia.com"></a>
			<div class="footerLinks">
				<a href="http://www.wikia.com/wiki/About_Wikia">About Us</a> ::
				<a href="http://www.wikia.com/wiki/Advertising">Advertise</a> ::
				<a href="http://www.wikia.com/wiki/Contact_us">Contact Us</a> ::
				<a href="http://www.wikia.com/wiki/Hiring">Hiring</a> ::
				<a href="http://www.wikia.com/wiki/Press">Press</a> ::
				<a href="http://www.wikia.com/wiki/Terms_of_use">Terms of Use</a>
				<div id="f-hosting"><i>Wikia</i>&reg; is a registered service mark of Wikia, Inc. All rights reserved.</div>
			</div>
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
