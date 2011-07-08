$(function() {
	UserPathPrediction.init();
})

var UserPathPrediction = {
	
	init: function() {

		// Bind click to button
		$('#selectWiki').change(function() {

		});
		
		$('#selectBy').change(function() {

			if ($(this).val() == "byId") {
				$('#articlePlace').html('<input id="article" type="number" value="202575" />')
			} else {
				$('#articlePlace').html('<input id="article" type="text" placeholder="Article name" />')
			}
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
				'selectby': $( '#selectBy' ).val(),
				'article': $( '#article' ).val(),
				'datespan': $( '#dateSpan' ).val(),
				'count': $( '#nodeCount' ).val(),
				'format': 'json'
			},
			function(data) {
				$("#nodes").html("");
				nodes = data.nodes;
				for (var i = 0; i < nodes.length; i++){
					$("#nodes").append('<tr><td><a href="'+ 
					nodes[i].referrerURL +'" target="_BLANK">'+ 
					nodes[i].referrerTitle.mTextform +'</a><td><a href="'+ 
					nodes[i].targetURL + '" target="_BLANK">' + 
					nodes[i].targetTitle.mTextform + '</td><td>' +
					nodes[i].count + '</td></tr>');
				};


			}
		);
		return false;
	}
	
};