window.AdProviderEvolveRS = function (WikiaTracker, log, window, ghostwriter, document) {
	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderEvolveRS');
		log(slot, 5, 'AdProviderEvolveRS');

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'evolve'}, 'ga');

		var url = 'http://cdn.triggertag.gorillanation.com/js/triggertag.js';
		ghostwriter(
			document.getElementById(slot[0]),
			{
				insertType:"append",
				script:{ src:url },
				done:function () {
					log('(invisible triggertag) ghostwriter done', 5, 'AdProviderEvolveRS');
					log([slot[0], url], 5, 'AdProviderEvolveRS');
					ghostwriter.flushloadhandlers();

					var script = "getTrigger('8057');";
					ghostwriter(
						document.getElementById(slot[0]),
						{
							insertType:"append",
							script:{text:script},
							done:function () {
								log('(invisible getTrigger) ghostwriter done', 5, 'AdProviderEvolveRS');
								log([slot[0], script], 5, 'AdProviderEvolveRS');
								ghostwriter.flushloadhandlers();

								var script2 = getReskinAndSilverScript();
								ghostwriter(
									document.getElementById(slot[0]),
									{
										insertType:"append",
										script:{text:script2},
										done:function () {
											log('(invisible reskin/silver) ghostwriter done', 5, 'AdProviderEvolveRS');
											log([slot[0], script2], 5, 'AdProviderEvolveRS');
											ghostwriter.flushloadhandlers();
										}
									}
								);

							}
						}
					);

				}
			}
		);
	}

	var slotMap = {
		'INVISIBLE_1':{}
	};

	function getReskinAndSilverScript() {
		log('getReskinSilverScript', 5, 'AdProviderEvolveRS');

		var script = '';

		//<!-- BEGIN GN Ad Tag for Wikia 1000x1000 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406815)=='undefined' || f406815 > 0) ) {" + '\n';
		script += "if(typeof(gnm_ord)=='undefined') gnm_ord=Math.random()*10000000000000000; if(typeof(gnm_tile) == 'undefined') gnm_tile=1;" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/entertainment;sect=entertainment;mtfInline=true;sz=1000x1000;tile='+(gnm_tile++)+';ord='+gnm_ord+'?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 47x47 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406785)=='undefined' || f406785 > 0) ) {" + '\n';
		script += "if(typeof(gnm_ord)=='undefined') gnm_ord=Math.random()*10000000000000000; if(typeof(gnm_tile) == 'undefined') gnm_tile=1;" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/entertainment;sect=entertainment;mtfInline=true;sz=47x47;tile='+(gnm_tile++)+';ord='+gnm_ord+'?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		log(script, 7, 'AdProviderEvolveRS');
		return script;
	}

	var iface = {
		name: 'EvolveRS',
		fillInSlot: fillInSlot
	};

	// TODO: @mech rethink
	// TODO: @rychu change tests
	if (window.wgInsideUnitTest) {
	}

	return iface;
};