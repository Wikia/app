/*global console: true, opera: true */
/**
 * Logging utility extracted from Liftium's library and further modified
 *
 * @author Przemek Piotrowski (Nef) <ppiotr(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
(function(){
	function logger(){
		/** @private **/

		var levels = {
				user: 1,
				feedback: 2,
				info: 3,
				system: 4,
				warning: 5,
				error: 6,
				debug: 7,
				trace: 8,
				trace_l2:9,
				trace_l3:10
			},
			outputLevel = 0,
			groups = {},
			groupsString = '',
			groupsCount = 0,
			enabled = false,
			levelsMap = [];

		for(var p in levels){
			var v = levels[p];

			if(v)
				levelsMap[v] = p;
		}

		function logMessage(msg, level, group){
			level = level || 'trace';

			if(typeof level == 'number'){
				if(level < 1)
					level = 1;
				else if(level > levelsMap.length - 1)
					level = levelsMap.length - 1;

				level = levelsMap[level];
			}

			level = level.toLowerCase();
			levelID = levels[level];
			group = group || 'Unknown source';

			if(
				!enabled ||
				(typeof msg == "undefined") ||
				(levelID > outputLevel) ||
				(groupsCount > 0 && !(group in groups))
			)
				return false;

			printMessage(msg, level, group);
			return true;
		}

		function printMessage(msg, level, group){
			if(typeof console != 'undefined')
				console.log((typeof msg != 'object' ? '%s: %s' : '%s: %o'), group, msg);
			else if(typeof opera != 'undefined')
				opera.postError(group + ': ' + msg);
		}

		function init(querystring, cookies){
			var qs = new querystring(),
				selectedGroups,
				x;

			outputLevel = qs.getVal('log_level') || cookies.get('log_level') || outputLevel;

			if(typeof outputLevel == 'string' && parseInt(outputLevel) != outputLevel)
				outputLevel = levels[outputLevel];

			selectedGroups = (qs.getVal('log_group') || cookies.get('log_group') || '').replace(' ', '').replace('|', ',').split(',');
			groupsString = selectedGroups.join(', ');

			for(x = 0; x < selectedGroups.length; x++){
				var g = selectedGroups[x];

				if(g !== ''){
					groups[g] = '';
					groupsCount++;
				}
			}

			if (outputLevel > 0) {
				printMessage('initialized at level ' + outputLevel + ((groupsCount > 0) ? ' for ' + groupsString : ''), 'info', 'Wikia.log');
				enabled = true;
			}
		}

		//init
		if(context.require){
			context.require(['querystring', 'cookies'], init);
		}else{
			init(context.Wikia.Querystring, context.Wikia.Cookies);
		}

		/** @public **/

		return logMessage;
	}

	//UMD
	//this module needs to be also available via a
	//namespace for access early in the process
	if(!context.Wikia) context.Wikia = {};//namespace
	context.Wikia.log = logger();//late binding

	if(context.define && context.define.amd){
		//AMD
		context.define('log', function(){
			return context.Wikia.log;
		});
	}
}(this));