<script type="text/javascript">
/*<![CDATA[*/                                                                                                           

// data = [ div, link ]
WR.toggle = function(e, data) {
	YE.preventDefault(e);

	var display = '';
	var text    = '';

	if ('none' != YD.getStyle(data[0], 'display')) {
		display = 'none';
		text    = <?= Xml::encodeJsVar( wfMsg('me_show') ) ?>;
		opacity =  0;

		onFadeEnd = function() {
			YD.setStyle(data[0], 'display', display);
			YD.get(data[1]).innerHTML = text;
		}

		var fade = new YAHOO.util.Anim(YD.get(data[0]), {opacity: {to: opacity}}, 0.5);
		fade.onComplete.subscribe(onFadeEnd);
		fade.animate();
	} else {
		display = 'block';
		text    = <?= Xml::encodeJsVar( wfMsg('me_hide') ) ?>;
		opacity =  1;

		YD.setStyle(data[0], 'opacity', 0);

		YD.setStyle(data[0], 'display', display);
		YD.get(data[1]).innerHTML = text;

		var fade = new YAHOO.util.Anim(YD.get(data[0]), {opacity: {to: opacity}}, 0.5);
		fade.animate();
	}

};

YE.addListener('cp-chooser-toggle', 'click', WR.toggle, ['cp-chooser', 'cp-chooser-toggle']);

// FIXME onAvailable?
var listeners = YE.getListeners ('cp-infobox-toggle') ; 
if (listeners) {
	for (var i=0; i<listeners.length; ++i) { 
		var listener = listeners[i]; 
		if (listener.type != 'click') {
			YE.addListener('cp-infobox-toggle', 'click', WR.toggle, ['cp-infobox', 'cp-infobox-toggle']);
		}
	} 
} else {
	YE.addListener('cp-infobox-toggle', 'click', WR.toggle, ['cp-infobox', 'cp-infobox-toggle']);
}

/*]]>*/
</script>
