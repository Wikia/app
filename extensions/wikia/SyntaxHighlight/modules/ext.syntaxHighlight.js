require(['jquery', 'wikia.window'], function ($, context) {
	$(function () {
		weppy = context.Weppy('ext.syntaxHighlight');

		weppy.timer.start('highlight');
		$('pre.source').each(function (i, codeBlock) {
			context.hljs.highlightBlock(codeBlock);
		});
		weppy.timer.stop('highlight');
	});
});
