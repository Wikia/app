/*exported AdProviderEvolve*/
/*jshint maxparams: false*/
/*jshint maxlen:false*/
/*jshint quotmark:false*/

var AdProviderEvolve = function (adLogicPageLevelParamsLegacy, scriptWriter, adTracker, log, window, document, Krux, evolveHelper, slotTweaker) {
	'use strict';

	var slotMap,
		logGroup = 'AdProviderEvolve',
		ord = Math.round(Math.random() * 23456787654),
		slotForSkin = 'INVISIBLE_1',
		hoppedSlots = {},
		slotTrackers = {},
		iface,
		undef;

	slotMap = {
		'HOME_TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'tile': 2, 'size': '300x250,300x600'},
		'HUB_TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'LEFT_SKYSCRAPER_2': {'tile': 3, 'size': '160x600'},
		'TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'tile': 2, 'size': '300x250,300x600'},
		'INVISIBLE_1': {'size': '0x0'}
	};

	function hasEmbed(slot) {
		log(['hasEmbed', slot], 5, logGroup);
		var embedNo = slot.getElementsByTagName('embed').length;
		log(['hasEmbed', slot, embedNo], 5, logGroup);
		return !!embedNo;
	}

	/**
	 * Get element height like $.height. For IE get offsetHeight and subtracts margin and padding.
	 *
	 * TODO: in future we should rely entirely on offsetHeight, so the actual ad should be loaded
	 * in a div with no paddings and margins.
	 *
	 * @param {DomElement} slot
	 * @return {Number}
	 */
	function getHeight(slot) {
		var margins = 0,
			height,
			undef;

		log(['getHeight', slot], 5, logGroup);

		if (window.getComputedStyle) {
			height = parseInt(window.getComputedStyle(slot).getPropertyValue('height'), 10);
			log(['getHeight (regular browser version)', slot, height], 5, logGroup);
		}

		// IE8
		if (height === undef && slot.currentStyle) {
			margins += parseInt('0' + slot.currentStyle.marginTop, 10);
			margins += parseInt('0' + slot.currentStyle.marginBottom, 10);
			margins += parseInt('0' + slot.currentStyle.paddingTop, 10);
			margins += parseInt('0' + slot.currentStyle.paddingBottom, 10);

			height = slot.offsetHeight - margins;
			log(['getHeight (IE version)', slot, height], 5, logGroup);
		}

		return height;
	}

	function getKv(slotname) {
		var sect = evolveHelper.getSect();

		return sect + ';' +
			'sect=' + sect + ';' +
			'mtfInline=true;' +
			'pos=' + slotname + ';' +
			's1=_' + (window.wgDBname || 'wikia').replace('/[^0-9A-Z_a-z]/', '_') + ';' +
			adLogicPageLevelParamsLegacy.getCustomKeyValues() +
			adLogicPageLevelParamsLegacy.getKruxKeyValues();
	}

	function getReskinAndSilverScript(slotname) {
		log('getReskinSilverScript', 5, logGroup);

		var script = '',
			kv = getKv(slotname);

		//<!-- BEGIN TRIGGER TAG INITIALIZATION -->
		//script += '<script type="text/javascript" src="http://cdn.triggertag.gorillanation.com/js/triggertag.js"></script>' + '\n';
		//script += '<script type="text/javascript">' + '\n';
		script += "getTrigger('8057');" + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 1000x1000 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406815)=='undefined' || f406815 > 0) ) {" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/";
		script += kv + ";sz=1000x1000;tile=1;ord=" + ord + "?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 47x47 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406785)=='undefined' || f406785 > 0) ) {" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/";
		script += kv + ";sz=47x47;tile=2;ord=" + ord + "?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		log(script, 7, logGroup);
		return script;
	}

	// adapted for Evolve + simplified copy of AdConfig.DART.getUrl
	function getUrl(slotname) {
		log('getUrl ' + slotname, 5, 'AdProviderEvolve');

		var url,
			dcopt = slotMap[slotname].dcopt,
			size = slotMap[slotname].size,
			tile = slotMap[slotname].tile;

		url = 'http://' +
			'n4403ad' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'gn.wikia4.com' + '/' +
			getKv(slotname) +
			adLogicPageLevelParamsLegacy.getDomainKV() +
			adLogicPageLevelParamsLegacy.getHostnamePrefix() +
			'sz=' + size + ';' +
			(dcopt ? 'dcopt=' + dcopt + ';' : '') +
			'type=pop;type=int;' + // TODO remove?
			'tile=' + tile + ';' +
			'ord=' + ord + '?';

		log(url, 7, 'AdProviderEvolve');
		return url;
	}

	function sanitizeSlotname(slotname) {
		log('sanitizeSlotname', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		var re = new RegExp('[A-Z1-9_]+'),
			out = re.exec(slotname),
			undef;

		log(out, 8, 'AdProviderEvolve');

		if (out) {
			out = out[0];
		}

		if (slotMap[out] === undef) {
			log('error, unknown slotname', 1, 'AdProviderEvolve');
			out = '';
		}

		log(out, 7, 'AdProviderEvolve');
		return out;
	}

	function hop(slotname, method) {
		method = method || 'hop';

		log(['hop', slotname], 5, 'AdProviderEvolve');

		slotname = sanitizeSlotname(slotname);

		hoppedSlots[slotname] = true;
		slotTrackers[slotname].hop();

		window.adslots2.push([slotname, undef, 'Liftium2Dom']);
	}

	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderEvolve');
		log(slot, 5, 'AdProviderEvolve');

		var slotname = slot[0];

		slotTrackers[slotname] = adTracker.trackSlot('evolve', slotname);
		slotTrackers[slotname].init();

		if (slotname === slotForSkin) {
			scriptWriter.injectScriptByUrl(
				slot[0],
				'http://cdn.triggertag.gorillanation.com/js/triggertag.js',
				function () {
					log('(invisible triggertag) ghostwriter done', 5, logGroup);
					scriptWriter.injectScriptByText(slotname, getReskinAndSilverScript(slotname), function () {
						// gorrilla skin is suppressed by body.mediawiki !important so make it !important too
						if (document.body.style.backgroundImage.search(/http:\/\/cdn\.assets\.gorillanation\.com/) !== -1) {
							document.body.style.cssText = document.body.style.cssText.replace(document.body.style.backgroundImage, document.body.style.backgroundImage + ' !important');
							document.body.style.cssText = document.body.style.cssText.replace(document.body.style.backgroundColor, document.body.style.backgroundColor + ' !important');
						}
					});
				}
			);
		} else {
			scriptWriter.injectScriptByUrl(slotname, getUrl(slotname), function () {
				var slot = document.getElementById(slotname),
					height;

				// Don't rely completely on Evolve hop
				if (!hoppedSlots[slotname]) {
					slotTweaker.removeDefaultHeight(slotname);
					height = getHeight(slot);

					// Only assume success if > 1x1 ad is returned or there's embed
					// in the slot (it seems Evolves returns an embed that causes
					// more HTML to appear after GhostWriter calls finish callback).
					if (height === undef || height > 1 || hasEmbed(slot)) {
						// Real success
						slotTweaker.removeTopButtonIfNeeded(slotname);
					} else {
						slotTweaker.addDefaultHeight(slotname);
						log('Evolve did not hop, but returned 1x1 ad instead for slot ' + slotname, 1, 'AdProviderEvolve');
						hop(slotname, '1x1');
					}
				}
			});
		}
	}

	function canHandleSlot(slot) {
		var slotname = slot[0];

		log('canHandleSlot', 5, 'AdProviderEvolve');
		log([slotname], 5, 'AdProviderEvolve');

		if (slotMap[slotname]) {
			return true;
		}

		if (slotname === slotForSkin) {
			return true;
		}

		return false;
	}

	iface = {
		name: 'Evolve',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot,
		hop: hop
	};

	// TODO: @mech rethink
	// TODO: @rychu change tests
	if (window.wgInsideUnitTest) {
		iface.sanitizeSlotname = sanitizeSlotname;
		iface.getUrl = getUrl;
	}

	return iface;
};
