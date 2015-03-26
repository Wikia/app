/*jshint maxparams: false*/
/*jshint maxlen:false*/
/*jshint quotmark:false*/
/*global define*/
define('ext.wikia.adEngine.provider.evolve', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'wikia.scriptwriter',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.evolveHelper',
	'ext.wikia.adEngine.evolveSlotConfig'
], function (log, window, document, scriptWriter, slotTweaker, evolveHelper, evolveSlotConfig) {
	'use strict';

	var slotMap,
		logGroup = 'ext.wikia.adEngine.provider.evolve',
		ord = Math.round(Math.random() * 23456787654),
		tile = 0,
		slotForSkin = 'INVISIBLE_SKIN',
		hoppedSlots = {},
		iface;

	slotMap = evolveSlotConfig.getConfig();

	function getTileKv() {
		tile += 1;
		return 'tile=' + tile + ';';
	}

	function hasEmbed(slot) {
		log(['hasEmbed', slot], 5, logGroup);
		var embedNo = slot.getElementsByTagName('embed').length || slot.getElementsByTagName('object').length;
		log(['hasEmbed', slot, embedNo], 5, logGroup);
		return !!embedNo;
	}

	function getKv(slotname) {
		var sect = evolveHelper.getSect();

		return sect + ';' +
			'sect=' + sect + ';' +
			'mtfInline=true;' +
			'pos=' + slotname + ';' +
			evolveHelper.getTargeting();
	}

	function getReskinAndSilverScript(slotname) {
		log('getReskinSilverScript', 5, logGroup);

		var script = '',
			kv = getKv(slotname);

		//<!-- BEGIN TRIGGER TAG INITIALIZATION -->
		//script += '<script type="text/javascript" src="http://cdn.triggertag.gorillanation.com/js/triggertag.js"></script>' + '\n';
		//script += '<script type="text/javascript">' + '\n';
		script += "getTrigger('8057');" + '\n';
		script += 'var evolve_called=false;';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 1000x1000 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406815)=='undefined' || f406815 > 0) ) {" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/";
		script += kv + "sz=1000x1000;" + getTileKv() + "ord=" + ord + "?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += 'evolve_called=true;';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 47x47 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406785)=='undefined' || f406785 > 0) && !evolve_called ) {" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/";
		script += kv + "sz=47x47;" + getTileKv() + "ord=" + ord + "?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		log(script, 7, logGroup);
		return script;
	}

	// adapted for Evolve + simplified copy of AdConfig.DART.getUrl
	function getUrl(slotname) {
		log('getUrl ' + slotname, 5, logGroup);

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
			'sz=' + size + ';' +
			(dcopt ? 'dcopt=' + dcopt + ';' : '') +
			'type=pop;type=int;' + // TODO remove?
			getTileKv() +
			'ord=' + ord + '?';

		log(url, 7, logGroup);
		return url;
	}

	function sanitizeSlotname(slotname) {
		log('sanitizeSlotname', 5, logGroup);
		log(slotname, 5, logGroup);

		var re = new RegExp('[A-Z1-9_]+'),
			out = re.exec(slotname),
			undef;

		log(out, 8, logGroup);

		if (out) {
			out = out[0];
		}

		if (slotMap[out] === undef) {
			log('error, unknown slotname', 1, logGroup);
			out = '';
		}

		log(out, 7, logGroup);
		return out;
	}

	function hop(slotname) {
		log(['hop', slotname], 5, logGroup);
		hoppedSlots[sanitizeSlotname(slotname)] = true;
	}

	function fillInSlot(slotname, pSuccess, pHop) {
		log('fillInSlot', 5, logGroup);
		log(slotname, 5, logGroup);

		if (slotname === slotForSkin) {
			scriptWriter.injectScriptByUrl(
				slotname,
				'http://cdn.triggertag.gorillanation.com/js/triggertag.js',
				function () {
					log('(invisible triggertag) ghostwriter done', 5, logGroup);
					scriptWriter.injectScriptByText(slotname, getReskinAndSilverScript(slotname), function () {
						// gorrilla skin is suppressed by body.mediawiki !important so make it !important too
						if (document.body.style.backgroundImage.search(/http:\/\/cdn\.assets\.gorillanation\.com/) !== -1) {
							document.body.style.cssText = document.body.style.cssText.replace(document.body.style.backgroundImage, document.body.style.backgroundImage + ' !important');
							document.body.style.cssText = document.body.style.cssText.replace(document.body.style.backgroundColor, document.body.style.backgroundColor + ' !important');
						}
						pSuccess();
					});
				}
			);
		} else {
			scriptWriter.injectScriptByUrl(slotname, getUrl(slotname), function () {
				if (hoppedSlots[slotname]) {
					pHop({method: 'hop'});
					return;
				}

				// Success
				// TODO: find a better place for operation below
				slotTweaker.removeDefaultHeight(slotname);
				slotTweaker.removeTopButtonIfNeeded(slotname);
				slotTweaker.adjustLeaderboardSize(slotname);

				pSuccess();
			});
		}
	}

	function canHandleSlot(slotname) {
		log(['canHandleSlot', slotname], 5, logGroup);

		return evolveSlotConfig.canHandleSlot(slotname);
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
});
