(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable()),
		requires = ['core', 'noticearea', 'loadingstatus','pagecontrols', /*'restoreedit',*/ 'autoresizer','edittools',
			'widemodemanager', 'railminimumheight', 'tracker', 'cssloadcheck', 'preloads',
			'leaveconfirm', 'addfile', 'editorsurvey'];

	if (window.enableWikitextSyntaxHighlighting === true) {
		requires.push('syntaxhighlighterqueueinit');
	}

	/**
	 * Shortcut to automatically add all Wikia specific plugins
	 */
	WE.plugins.wikiacore = $.createClass(WE.plugin,{

		requires: requires

	});

})(this,jQuery);
