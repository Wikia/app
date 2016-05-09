/*global define*/
define('ext.wikia.adEngine.provider.revcontent', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.revcontent',
		slotMap = {
			REVCONTENT_ABOVE_ARTICLE: { rslotId: 'rcjsload_wikiaaa', widgetId: 30217 },
			REVCONTENT_RIGHT_RAIL:	  { rslotId: 'rcjsload_wikiarr', widgetId: 30231 },
			REVCONTENT_BELOW_ARTICLE: { rslotId: 'rcjsload_wikiaba', widgetId: 30229 }
		};

	function canHandleSlot(slotName) {
		var res = !!slotMap[slotName];
		log(['canHandleSlot', slotName, res], 'debug', logGroup);
		return res;
	}

	function genSrc(slotId, widgetId) {
		var referer = doc.referrer || doc.location.href || doc.URL;
		referer = referer.substr(0,700);

		return 'http://trends.revcontent.com/serve.js.php' +
			'?w=' + widgetId +
			'&t=' + slotId +
			'&c=' + (new Date()).getTime() +
			'&width=' + (win.outerWidth || doc.documentElement.clientWidth) +
			'&referer=' + referer +
			'&is_blocked=true';
	}

	function addWidget(widgetId, rslotId, slotName) {
		var rparent,
			rslot,
			rscript;

		rslot = doc.createElement('div');
		rslot.id = rslotId;

		rscript = doc.createElement('script');
		rscript.type = 'text/javascript';
		rscript.id = 'rc_' + Math.floor(Math.random() * 1000);
		rscript.src = genSrc(rscript.id, widgetId);
		rscript.async = true;
		rslot.appendChild(rscript);

		rparent = doc.getElementById('Revcontent_' + slotName);
		rparent.appendChild(rslot);
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot.name], 'debug', logGroup);

		var slotInfo = slotMap[slot.name];
		addWidget(slotInfo.widgetId, slotInfo.rslotId, slot.name);

		log(['fillInSlot', slot.name, 'done'], 'debug', logGroup);
	}

	return {
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot,
		name: 'Revcontent'
	};
});
