require(['jquery', 'wikia.window'],
	function ($, window) {
		'use strict';

		$(function() {
			console.log("CP load editor");

			var plugins = [];
			var config = {
				body: $('<div/>'),
				element: $('<div/>'),
				mode: 'source'
			}

			window.WikiaEditor.create(plugins,config);

		});

		function init(window) {
			console.log("CP init and do something");

			var url = window.wgContributionPrototypeExternalHost + '/wikia/' + window.wgDBname + '/wiki/' + window.wgTitle;
			$.get( url, null, function(result) {
				$("#editarea").html(result);
			});

		};

		init(window);
	}
);
