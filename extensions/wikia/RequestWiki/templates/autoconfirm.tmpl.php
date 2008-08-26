<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">/*<![CDATA[*/

YAHOO.namespace("Wikia.Request");

var YE = YAHOO.util.Event;
var YD = YAHOO.util.Dom;
var WR = YAHOO.Wikia.Request;

// macbre: #2571
WR.addTracker = function(elem, type, url) {
        YE.addListener(elem, type, function(e, url) {
		YAHOO.Wikia.Tracker.trackByStr(e, 'RequestWiki/' + url);
	}, url);
}

YE.onDOMReady( function() {WR.addTracker(YD.get('rw-confirm').getElementsByTagName('a')[0], 'click', 'Confirm_email'); });

/*]]>*/</script>

<div id="rw-confirm">
<? if ($is_logged): ?>
    <?= wfMsg('requestwiki-extra-autoconfirmed-info', array(1 => $confirm->getLocalUrl())) ?>
<? else: ?>
    <?= wfMsg('requestwiki-extra-login-info', array(1 => $login->getLocalUrl())) ?>
<? endif ?>
</div>
<!-- e:<?= __FILE__ ?> -->
