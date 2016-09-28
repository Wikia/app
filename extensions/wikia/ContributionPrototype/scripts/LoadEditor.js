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

			loadHTML().then(injectHTMLAndLoadVendor).then(loadApp);

//			var url = window.wgContributionPrototypeExternalHost + '/wiki/' + window.wgDBname + '/wiki/' + window.wgTitle;
//			$.ajax({
//				url: window.wgContributionPrototypeExternalHost + '/wiki/' + window.wgTitle,
//				type: "GET",
//				beforeSend: function(xhr) {
//					xhr.setRequestHeader('x-wikia-community', window.wgDBname);
//				},
//				success: function(result) {
//					console.log(result);
//					$("#editarea").html(result);
//				}
//			});
//			$.get( url, null, function(result) {
//				$("#editarea").html(result);
//			});
		};

		function loadHTML() {
			return $.ajax({
                                url: window.wgContributionPrototypeExternalHost + '/wiki/' + window.wgTitle,
                                type: 'GET',
                                beforeSend: function(xhr) {
                                        xhr.setRequestHeader('x-wikia-community', window.wgDBname);
                                }
                        });
		}

		function injectHTMLAndLoadVendor(data) {
			$("#editarea").html(data);

			return $.ajax({
				url: window.wgContributionPrototypeExternalHost + '/public/assets/vendor.dll.js', 
                                type: 'GET',
				dataType: 'script'
			});
		}

		function loadApp() {
			return $.ajax({
                                url: window.wgContributionPrototypeExternalHost + '/public/assets/app.js',
                                type: 'GET',
                                dataType: 'script'
			});
		}

		init(window);
	}
);
