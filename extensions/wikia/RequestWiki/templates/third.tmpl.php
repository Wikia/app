<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">/*<![CDATA[*/

YAHOO.namespace("Wikia.Request");

var YE = YAHOO.util.Event;
var WR = YAHOO.Wikia.Request;

// macbre: #2571
WR.addTracker = function(elem, type) {
	YE.addListener(elem, type, function(e) {
		elem = YE.getTarget(e);

		if (elem.nodeName != 'A')
			return;

		url = elem.innerHTML.replace(/ /g, '_');
		YAHOO.Wikia.Tracker.trackByStr(e, 'RequestWiki/' + url);
		YE.stopPropagation(e);
	});
}

WR.addTracker('rw-msg', 'click');

/*]]>*/</script>

<div id="rw-msg">
    <?= sprintf(wfMsg('requestwiki-third-header'), $link_view, $link_edit, 'http://wikia.com') ?>
</div>
<div>
    <?= wfMsg('requestwiki-third-footer') ?>
</div>
<!-- e:<?= __FILE__ ?> -->
