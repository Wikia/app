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

	
	loadNodes: function() {
		$.get(
			'/wikia.php',
			{
				'controller': 'UserPathPredictionSpecialController',
				'method': 'getNodes',
				'selectby': $( '#selectBy' ).val(),
				'article': $( '#article' ).val(),
				'datespan': $( '#dateSpan' ).val(),
				'format': 'json'
			},
			function(data) {
				nodes = data.nodes;
				if(data['nodes'] != "No Result") {
					$('#noresult').hide('fast');
					$('#articleTable').hide('fast');
					$("#relatedArticles").html("<ul></ul>");
					for ( var i = 0; i < nodes.length; i++ ) {
						$("#relatedArticles > ul").append('<li><a href="'+ 
						nodes[i].referrerURL +'" target="showArticle">'+ 
						nodes[i].referrerTitle.mTextform +'</a><a href="'+ 
						nodes[i].targetURL + '" target="showArticle">' + 
						nodes[i].targetTitle.mTextform + '</a>' +
						nodes[i].count + '</li>');
						//$('#showArticle').attr('src',nodes[i].targetURL);
					}
					$('#articleTable').show('fast');
				} else {
					$('#relatedArticles > ul').hide('fast');
					$('#noresult').show('fast');
				}
			}

		);
		return false;
	},
	
	load: function() {
		$.get(
			'/wikia.php',
			{
				'controller': 'UserPathPredictionSpecialController',
				'method': 'getRelated',
				'selectby': $( '#selectBy' ).val(),
				'article': $( '#article' ).val(),
				'datespan': $( '#dateSpan' ).val(),
				'format': 'json'
			},
			function( data ) {
				nodes = data.nodes;
				thumbnails = data.thumbnails;
				
				if ( data['nodes'] != "No Result" ) {
					$('#noresult').hide('fast');
					$('#relatedArticles > ul ').hide('fast');
					$("#relatedArticles").html("<ul></ul>");
					for ( var i = 0; i < nodes.length; i++ ) {
						
						if ( thumbnails[nodes[i].targetTitle.mArticleID] ) {
							$imgsrc = thumbnails[nodes[i].targetTitle.mArticleID][0]['url'];
						} else {
							$imgsrc = "http://dummyimage.com/100x50/000/bada55.gif&text=Thumbs";
						}
						
						$( "#relatedArticles > ul" ).append( '<li><div><a href="'+ 
						nodes[i].targetURL + '" target="showArticle">' + 
						nodes[i].targetTitle.mTextform + '<br /><img src="' + 
						$imgsrc + '"></a>' +
						nodes[i].count + '</div></li>');
					}
					$('#relatedArticles > ul').show('fast');
				} else {
					$( '#relatedArticles > ul' ).hide( 'fast' );
					$( '#noresult' ).show( 'fast' );
				}
			}

		);
		return false;
	}
	
};