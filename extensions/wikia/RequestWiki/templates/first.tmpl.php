<!-- s:<?= __FILE__ ?> -->
<?php global $wgScriptPath, $wgOut, $wgUser; ?>
<style type="text/css">/*<![CDATA[*/
#cw-form { margin: 8px 0px }
h2 { margin-top: 1em; }
.maxheight {overflow: auto; height: 190px; width: 300px}
.hidden {display: none}
#language_box {clear: both; margin-top: 20px}
#language_list {margin: 0; display: inline}
#language_list li {display: inline; margin-right: 7px;}
/*]]>*/</style>
<script type="text/javascript">/*<![CDATA[*/

YAHOO.namespace("Wikia.Request");

var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var WR = YAHOO.Wikia.Request;
var ajaxpath = "<?= "{$wgScriptPath}/index.php" ?>";

WR.WatchCallback = {
	success: function( oResponse ) {
		var Data = YAHOO.Tools.JSONParse(oResponse.responseText);
		var cwResult = document.getElementById('cw-result');
		//remove height and scroll
		YAHOO.util.Dom.removeClass(cwResult, 'maxheight');
		//hide the result
		cwResult.style.display = 'none';
		//add the result
		cwResult.innerHTML = '<div>' + Data['exact'] + Data['like'] + '<a id="viewMore" class="hidden" onclick="viewMoreWikis(); return false;" href="#"><?= addslashes(wfMsg('requestwiki-first-view-more')) ?></a>' + "</div>";
		//show only top 5 - hide rest
		var LIs = cwResult.getElementsByTagName('li');
		for (i = LIs.length; i > 4; i--) {
			YAHOO.util.Dom.addClass(LIs[i], 'hidden');
		}
		if (LIs.length > 5) {
			YAHOO.util.Dom.removeClass('viewMore', 'hidden');
		}
		//show the result
		cwResult.style.display = 'block';
		document.getElementById('cw-submit').disabled = false;
		document.getElementById('extra_message').innerHTML = Data['extra'];

		// tracking
		if (Data.exact.length > 0)
			WR.addTracker(YAHOO.util.Dom.get('cw-result-list-exact').getElementsByTagName('a'), 'click', 'Search_click');
		
		if (Data.like.length > 0)
			WR.addTracker(YAHOO.util.Dom.get('cw-result-list-like').getElementsByTagName('a'), 'click', 'Search_click');
	},
	failure: function( oResponse ) {
		YAHOO.log( "simple replace failure " + oResponse.responseText );
		document.getElementById('cw-submit').disabled = false;
	},
	timeout: 20000
};

WR.watchForm = function (e) {
	YE.preventDefault(e);
	var name = document.getElementById('cw-name').value;
	document.getElementById('cw-result').innerHTML = '. . .';
	document.getElementById('extra_message').innerHTML = '';
	document.getElementById('cw-submit').disabled = true;
	YC.asyncRequest( "GET", ajaxpath+"?action=ajax&rs=axRequestLikeOrExact&name="+name, WR.WatchCallback);
	YAHOO.Wikia.Tracker.trackByStr(null, 'RequestWiki/Search_for_wikis');
};

// macbre: #2571
WR.addTracker = function(elem, type, url) {
	YE.addListener(elem, type, function(e, url) {
		YAHOO.Wikia.Tracker.trackByStr(null, 'RequestWiki/' + url);
		YE.stopPropagation(e);
	}, url);
}

YE.addListener("cw-submit", "click", WR.watchForm, "cw-submit" );
YE.addListener("cw-form", "submit", WR.watchForm, "cw-submit" );
WR.addTracker('requestwikiform1', 'submit', 'Continue');
YE.onDOMReady( function() {WR.addTracker(YD.get('tos').getElementsByTagName('a')[0], 'click', 'Terms_of_use'); });

function viewMoreWikis() {
	var cwResult = document.getElementById('cw-result');
	//show only top 5 - hide rest
	var LIs = cwResult.getElementsByTagName('li');
	for (i = LIs.length; i > 4; i--) {
		YAHOO.util.Dom.removeClass(LIs[i], 'hidden');
	}
	YAHOO.util.Dom.addClass('viewMore', 'hidden');
	YAHOO.util.Dom.addClass(cwResult, 'maxheight');
}

if( !YAHOO.lang.isUndefined(YAHOO.wikia.AjaxLogin) && !YAHOO.lang.isUndefined(YAHOO.wikia.AjaxLogin.showLoginPanel) ) {
	if(wgUserName == null) {
		YE.addListener('pSubmit', 'click', YAHOO.wikia.AjaxLogin.showLoginPanel);
		WR.addTracker('pSubmit', 'click', 'Log_in');
		WR.addTracker('login', 'click', 'Log_in');
	}
}

// macbre: fixes #2634 (should only be applied for IE6)
YAHOO.util.Event.onDOMReady( function() {

	var browser = YAHOO.Tools.getBrowserEngine();

	if (browser.msie && browser.version == 6) {

		YD = YAHOO.util.Dom;

		var fixMeDiv = YD.get('rw-info-top');

		if (fixMeDiv) {
			var images = fixMeDiv.getElementsByTagName('img');

			for (i=0; i<images.length; i++) {
				YD.setStyle(images[i], 'width', images[i].width + 'px');
				YD.setStyle(images[i], 'height', images[i].height + 'px');
				YD.setStyle(images[i], 'filter', 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + images[i].src + '\', sizingMethod=\'crop\')');
				images[i].src = '/skins/common/dot.gif';
			}
		}
	}
});
// macbre: end of fix

/*]]>*/</script>
<?php
if (!empty($is_staff)) { ?>
<div>
	[<a href="<?= $title->getLocalUrl('action=list') ?>">list of requests</a>]
</div>
<?php
}
?>
<div id="rw-info-top">
	<?= $wgOut->parse(wfMsg('requestwiki-first-page-top')) ?>
</div>

<form id="cw-form">
	<table>
	<tr><td>
		<label><?= wfMsg('requestwiki-first-wiki-name') ?></label>
	</td><td>
		<input type="text" name="name" size="24" id="cw-name" />
		<button name="submit" size="24" id="cw-submit"><?= wfMsg('requestwiki-first-button-submit') ?></button>
	</td></tr>
	<tr><td/><td>
		<?= $wgOut->parse(wfMsg("requestwiki-first-search-tip")) ?>
	</td></tr>
	</table>
	<div id="cw-result"></div>
	<div id="extra_message"></div>
</form>

<div style="text-align: center">
	<form id="requestwikiform1" action="<?= $title->getLocalUrl('action=second') ?>" method="POST">
		<div id="tos"><?= wfMsg('requestwiki-first-tos') ?></div>
		<div class="info" id="tos_agree_error"><?= (!empty($errors['requestwiki-first-tos-agree'])) ? $errors['requestwiki-first-tos-agree'] : "&nbsp;" ?></div>
		<input type="submit" name="wiki-submit" id="pSubmit" value="<?= $wgUser->isLoggedIn() ? wfMsg('requestwiki-first-button-agree') : wfMsg('requestwiki-first-button-login') ?>" />
		<div id="login-register"><?= wfMsg('requestwiki-first-login') ?></div>
	</form>
</div>

<?php
$langMsg = trim(wfMsg('requestwiki-first-language-page-list'));
$languages = array_filter(explode("\n", $langMsg));
//set '-' as a content of this message to remove lang list (empty content will force wfMsg to get default content from extension which is not desired)
if ($langMsg != '-' && count($languages)) {
?>
<div id="language_box">
	<span><?= wfMsg('requestwiki-first-language-page-header') ?></span>
	<ul id="language_list">
	<?php
	$thisUrl = $thisUrl . ((strpos($thisUrl, '?') === false) ? '?' : '&') . 'uselang=';
	foreach ($languages as $language) {
		$language = explode('|', $language);
		echo "\t<li>&bull; <a href=\"{$thisUrl}{$language[0]}\">{$language[1]}</a></li>\n";
	}
	unset($languages);
	?>
	</ul>
</div>
<?php
}
?>

<!-- e:<?= __FILE__ ?> -->
