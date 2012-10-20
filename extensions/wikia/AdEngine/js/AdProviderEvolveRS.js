// TODO: remove

var AdProviderEvolveRS = function(ScriptWriter, WikiaTracker, log, window, document, evolveHelper) {
	var logGroup = 'AdProviderEvolveRS'
		, canHandleSlot
		, fillInSlot
		, getReskinAndSilverScript
	;

	canHandleSlot = function(slot) {
		var slotname = slot[0];

		log('canHandleSlot', 5, logGroup);
		log([slotname], 5, logGroup);

		return (slotname === 'INVISIBLE_1');
	}

	fillInSlot = function(slot) {
		log('fillInSlot', 5, logGroup);
		log(slot, 5, logGroup);

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category' : 'slot2/' + slot[1], 'ga_action' : slot[0], 'ga_label' : 'evolve'}, 'ga');

		var url = 'http://cdn.triggertag.gorillanation.com/js/triggertag.js';
		ScriptWriter.injectScriptByUrl(
			slot[0], url,
			function() {
				log('(invisible triggertag) ghostwriter done', 5, logGroup);
				log([slot[0], url], 5, logGroup);

				ScriptWriter.injectScriptByText(slot[0], getReskinAndSilverScript());
			}
		);
	}

	getReskinAndSilverScript = function() {
		log('getReskinSilverScript', 5, logGroup);

		var sect = evolveHelper.getSect()
			, script = ''
		;

		//<!-- BEGIN TRIGGER TAG INITIALIZATION -->
		//script += '<script type="text/javascript" src="http://cdn.triggertag.gorillanation.com/js/triggertag.js"></script>' + '\n';
		//script += '<script type="text/javascript">' + '\n';
		script += "getTrigger('8057');" + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 1000x1000 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406815)=='undefined' || f406815 > 0) ) {" + '\n';
		script += "if(typeof(gnm_ord)=='undefined') gnm_ord=Math.random()*10000000000000000; if(typeof(gnm_tile) == 'undefined') gnm_tile=1;" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/" + sect + ";sect=" + sect + ";mtfInline=true;sz=1000x1000;tile='+(gnm_tile++)+';ord='+gnm_ord+'?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 47x47 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406785)=='undefined' || f406785 > 0) ) {" + '\n';
		script += "if(typeof(gnm_ord)=='undefined') gnm_ord=Math.random()*10000000000000000; if(typeof(gnm_tile) == 'undefined') gnm_tile=1;" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/" + sect + ";sect=" + sect + ";mtfInline=true;sz=47x47;tile='+(gnm_tile++)+';ord='+gnm_ord+'?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		log(script, 7, logGroup);
		return script;
	}

	return {
		name : 'EvolveRS',
		fillInSlot : fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
