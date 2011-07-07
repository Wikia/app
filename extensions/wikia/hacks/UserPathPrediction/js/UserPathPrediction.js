$(function() {
	UserPathPrediction.init();
})

var UserPathPrediction = {
	
	init: function() {

		// Bind click to button
		$('#selectWiki').change(function() {

		});
		
		$('#selectArticle').change(function() {
			//load graph or actually draw it
		});
		
		$("#articleTable").tablesorter(); 
	},
	
	drawGraph: function() {
		var canvas = document.getElementById("usersPath");

		if( canvas.getContext() ) {
			var ctx = canvas.getContext("2d");

		} else {
			
			//TODO:canvas not supported
		}
		
	},
	
	load: function() {
		$.get(
			'/wikia.php',
			{
				'controller': 'UserPathPredictionSpecialController',
				'method': 'getNodes',
				'wikiid': $( '#selectWiki' ).val(),
				'articleid': $( '#articleId' ).val(),
				'count': 10,
				'format': 'json'
			},
			function(data) {
				
				$("#nodes").html(data.nodes);
			}
		);
		return false;
	}
	
};