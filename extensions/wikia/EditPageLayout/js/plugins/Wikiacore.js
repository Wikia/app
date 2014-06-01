(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Shortcut to automatically add all Wikia specific plugins
	 */
	WE.plugins.wikiacore = $.createClass(WE.plugin,{

		requires: ['core', 'noticearea', 'loadingstatus','pagecontrols', /*'restoreedit',*/ 'autoresizer','edittools',
			'widemodemanager', 'railminimumheight', 'tracker', 'cssloadcheck', 'preloads',
			'leaveconfirm', 'addfile']

	});

})(this,jQuery);
