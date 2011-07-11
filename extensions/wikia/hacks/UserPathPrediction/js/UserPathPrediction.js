$(function() {
	UserPathPrediction.init();

})

var UserPathPrediction = {
	
	init: function() {
		
		$('#selectBy').change(function() {

			if ($(this).val() == "byId") {
				$('#articlePlace').html('<input id="article" type="number" />');
			} else {
				$('#articlePlace').html('<input id="article" type="text" />');
			}
		});
		
		$("#articleTable").tablesorter();
		$('#articleTable').hide();
		$('#noresult').hide();

		if( $( '#table' ).attr( 'data-page' ) != undefined ) {
			$( '#selectBy' ).val( 'byTitle' );
			$( '#articlePlace' ).html( '<input id="article" type="text" value="'+ $( '#table' ).attr( 'data-page' ) +'"/>' );
			$(this).load();
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
				nodes = data.nodes;
				if(data['nodes'] != "No Result") {
					$('#noresult').hide('fast');
					$('#articleTable').hide('fast');
					$("#nodes").html("");
					for ( var i = 0; i < nodes.length; i++ ) {
						$("#nodes").append('<tr><td><a href="'+ 
						nodes[i].referrerURL +'" target="_BLANK">'+ 
						nodes[i].referrerTitle.mTextform +'</a><td><a href="'+ 
						nodes[i].targetURL + '" target="_BLANK">' + 
						nodes[i].targetTitle.mTextform + '</td><td>' +
						nodes[i].count + '</td></tr>');
					}
					$('#articleTable').show('fast');
				} else {
					$('#articleTable').hide('fast');
					$('#noresult').show('fast');
				}
			}

		);
		return false;
	}
	
};