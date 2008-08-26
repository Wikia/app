<?php

if ( empty( $wgCurse ) ) {
	return;
}

$wgHooks['SpecialFooter'][] = 'CurseFooter';

function CurseFooter()
{
	$footer = <<<ENF
        <!-- curse footer -->
        <div id="curse_footer" class="noprint">
        <ul class="nav horizontal">
                <li class="first"><a href="http://www.curse.com">Curse Home</a></li>
                <li><a href="http://about.curse.com/" rel="nofollow">About Us</a></li>
                <li><a href="http://about.curse.com/advertise/" rel="nofollow">Advertising</a></li>
                <li><a href="http://about.curse.com/terms-of-use/" rel="nofollow">Terms of Use</a></li>
                <li><a href="http://about.curse.com/privacy-policy/" rel="nofollow">Privacy Policy</a></li>
                <li><a href="http://about.curse.com/technology/" rel="nofollow">Technology</a></li>
                <li class="last"><a href="http://blogs.curse.com/25/" rel="nofollow">Dev Blog</a></li>
        </ul>
        <p><a href="http://www.wowdb.com/">World of Warcraft Database</a></p>
        <p class="last">&copy; 2006-2008 <a href="http://about.curse.com/">Curse Inc.</a></p>
        </div>
        <!-- curse footer -->
ENF;

	echo $footer;
	return false;
}

$wgHooks['GetHTMLAfterBody'][] = 'CurseHeader';

function CurseHeader()
{
	global $wgStylePath, $wgStyleVersion;

	echo '<link rel="stylesheet" type="text/css" href="' . $wgStylePath . '/monaco/curse/monaco.css?' . $wgStyleVersion . '" />';
	echo '<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="' . $wgStylePath . '/monaco/curse/ie6.css?' . $wgStyleVersion . '" /><![endif]-->';
	echo '<!--[if IE 7]><link rel="stylesheet" type="text/css" href="' . $wgStylePath . '/monaco/curse/ie7.css?' . $wgStyleVersion . '" /><![endif]-->';

	echo <<<END
<!-- curse header -->

<div id="curse_header" class="noprint">
    <div class="hdbox">
        <a href="http://www.curse.com/" id="logo" title="Go to Curse.com Homepage">&nbsp;</a>
        <div id="user-goodies">
            <ul class="plain horizontal">
                <li class="last language dropdown"
			onmouseover="this.className='last language dropdown hover'"
                        onmouseout="this.className='last language dropdown'">
				<a href="/set-language/" class="flag-en"><img src="http://static.curse.com/v5/images/pixel.gif" alt="" /></a><ul>
					<li class="flag-fr"><a href="http://www.curse.fr/"><img src="http://static.curse.com/v5/images/pixel.gif" alt="" /></a></li>
                    <li class="flag-en selected"><a href="http://www.curse.com/"><img src="http://static.curse.com/v5/images/pixel.gif" alt="" /></a></li>
                    <li class="flag-de"><a href="http://www.de.curse.com/"><img src="http://static.curse.com/v5/images/pixel.gif" alt="" /></a></li>
                    <li class="flag-es"><a href="http://www.curse.es/"><img src="http://static.curse.com/v5/images/pixel.gif" alt="" /></a></li>
                </ul></li>
            </ul>
        </div>

        <ul id="nav-node" class="clear">
                <li class="selected "><a href="http://www.curse.com/"><span>All Games</span></a></li>
                <li class=""><a href="http://my.curse.com/" rel="nofollow"><span><em>my</em> Curse</span></a></li>
                <li class="last  dropdown"
			onmouseover="this.className='last dropdown hover'"
			onmouseout="this.className='last dropdown'">
			<a href="http://www.curse.com/set-portal/"><span>Select a Portal</span></a>

                    <ul>
                        <li class=""><a href="http://aoc.curse.com/">Age of Conan</a></li>
                        <li class=""><a href="http://aion.curse.com/">Aion</a></li>
                        <li class=""><a href="http://df.curse.com/">Darkfall</a></li>
                        <li class=""><a href="http://eve.curse.com/">EVE Online</a></li>
                        <li class=""><a href="http://f2p.curse.com/">Free to Play</a></li>
                        <li class=""><a href="http://gw.curse.com/">Guild Wars</a></li>
                        <li class=""><a href="http://lotro.curse.com/">Lord of the Rings Online</a></li>
                        <li class=""><a href="http://sc2.curse.com/">Starcraft 2</a></li>
                        <li class=""><a href="http://tr.curse.com/">Tabula Rasa</a></li>
                        <li class=""><a href="http://uo.curse.com/">Ultima Online</a></li>
                        <li class=""><a href="http://vg.curse.com/">Vanguard</a></li>
                        <li class=""><a href="http://war.curse.com/">Warhammer Online</a></li>
                        <li class="last "><a href="http://wow.curse.com/">World of Warcraft</a></li>
                    </ul>
                </li>
            
        </ul>

        <div id="curse_navigation" class="clear">
            <ul id="nav-main" class="clear">
                <li class="first"><a href="/"><span>Curse</span></a></li>
				<li class=""><a href="http://www.curse.com/"><span>Home</span></a></li>
				<li class=""><a href="http://www.curse.com/games/"><span>Game List</span></a></li>
                
                    <li class=""><a href="http://news.curse.com/"><span>News</span></a></li>
                
                    <li class=""><a href="http://events.curse.com/"><span>Events</span></a></li>
                
                    <li class=""><a href="http://forums.curse.com/"><span>Forums</span></a></li>

                
                    <li class=""><a href="http://wow.curse.com/downloads/addons/"><span>WoW Addons</span></a></li>
                
                    <li class=""><a href="http://downloads.curse.com/"><span>Downloads</span></a></li>
                
                    <li class=""><a href="http://blogs.curse.com/"><span>Blogs</span></a></li>
                
                    <li class=""><a href="http://videos.curse.com/"><span>Videos</span></a></li>
                
                    <li class=""><a href="http://images.curse.com/"><span>Images</span></a></li>
                
                    <li class="last selected "><a href="http://www.curse.com/wikia/"><span>Wikia</span></a></li>

                
            </ul>
            <form id="formSearch" name="formSearch" class="clear" method="GET" action="http://search.curse.com">
                
                <label for="input-search">Search:</label>
                <div class="input clear">
                    
                    <span class="icon www">&nbsp;</span>
                    <input type="input" class="text" name="q" id="id_gsearch" />
                </div>
                <input type="image" class="image" src="http://images.wikia.com/skins/monaco/curse/btn-search-go.png" alt="Search World of Warcraft" />

                
            </form>
        </div>
    </div>
</div>
<!-- curse header -->
END;

	return true;
}


$wgHooks['SkinAfterBottomScripts'][] = 'CurseBottomScript';

function CurseBottomScript( $skin, & $bottomScripts ) {

	$bottomScripts .= <<<ENE

<!-- Curse JS fix -->
<script type="text/javascript">

	function wikiaFixCurseFooter() {
		 // fix footer positioning on short pages
                curseFooter = YAHOO.util.Dom.get('curse_footer');
                sidebar = YAHOO.util.Dom.get('widget_sidebar');

                pageHeight = document.body.parentNode.scrollHeight;
                footerPos = YAHOO.util.Dom.getY(curseFooter);

                // console.log('Curse footer fix: page height = ' + pageHeight + '; curse_footer = ' + footerPos);

                // apply fix
                if (pageHeight - footerPos > 140) {
                        YAHOO.util.Dom.setY(curseFooter, pageHeight + 50);
                }

		// really dirty hack: every 2 sec. check for DOM changes and apply this fix again
		//setTimeout('wikiaFixCurseFooter()', 2000);
	}

	YAHOO.util.Event.onDOMReady( wikiaFixCurseFooter  );
</script>

ENE;

	return true;
}


for( $i=0; $i<16; $i++ ) {
	$wgNamespaceRobotPolicies[$i] = "noindex,nofollow";
}
$wgNamespaceRobotPolicies[110] = "noindex,nofollow";
$wgNamespaceRobotPolicies[111] = "noindex,nofollow";

