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

		if( $( '#articles' ).attr( 'data-page' ) != undefined ) {
			$( '#selectBy' ).val( 'byTitle' );
			$( '#articlePlace' ).html( '<input id="article" type="text" value="'+ $( '#articles' ).attr( 'data-page' ) +'"/>' );
			UserPathPrediction.load();
		};
		
		$( '#relatedArticles li' ).live('click', function() {		
			$( '#showArticle' ).attr( 'src', $(this).attr( 'data-url' ) );
			$( '#articlePlace' ).html( '<input id="article" type="text" value="'+ $(this).find("#reletedItem").text() +'"/>' );
			UserPathPrediction.load();
		});
		
		$( '#navigationArticles li' ).live('click', function() {		
			$( '#showArticle' ).attr( 'src', $(this).attr( 'data-url' ) );
		});
		
	},

	load: function() {
		UserPathPrediction.loadNodes();
		UserPathPrediction.loadRelated();
		$( '#showArticle' ).attr( 'src', '/wiki/' + $( '#article' ).val() );
		return false;
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
				'count': $( '#nodeCount' ).val(),
				'format': 'json'
			},
			function( data ) {
				nodes = data.nodes;
				thumbnails = data.thumbnails;
				
				if ( data['nodes'] != "No Result" ) {
					$( "#navigationArticles" ).html( "<ul></ul>" );
					for ( var i = 0; i < nodes.length; i++ ) {
						
						if ( thumbnails[nodes[i].targetTitle.mArticleID] ) {
							$imgsrc = thumbnails[nodes[i].targetTitle.mArticleID][0]['url'];
						} else {
							$imgsrc = "http://dummyimage.com/100x67/000/bada55.gif&text=NoImage";
						}
						
						$( "#navigationArticles > ul" ).append( '<li data-url="' +
						nodes[i].targetURL + '"><div>'+ 
						nodes[i].targetTitle.mTextform + '<br /><img height="50px" width="75px" src="' + 
						$imgsrc + '"></a><span id="counts">' +
						nodes[i].count + '</span></div></li>');
					}
				} else {
					$( '#navigationArticles > ul' ).fadeOut( 'slow' );
					$( '#navigationArticles' ).html('<span class="noresult">' + $( '#noresult' ).text() + "</span>").fadeIn( 'slow' );
				}
			}

		);
		return false;
	},
	
	loadRelated: function() {
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
					$('#relatedArticles > ul ').fadeOut('slow');
					$("#relatedArticles").html("<ul></ul>");
					for ( var i = 0; i < nodes.length; i++ ) {
						
						if ( thumbnails[nodes[i].targetTitle.mArticleID] ) {
							$imgsrc = thumbnails[nodes[i].targetTitle.mArticleID][0]['url'];
						} else {
							$imgsrc = "http://dummyimage.com/75x50/000/bada55.gif&text=NoImage";
						}
						
						$( "#relatedArticles > ul" ).append( '<li data-url="' +
						nodes[i].targetURL + '"><div><span id="reletedItem">' + 
						nodes[i].targetTitle.mTextform + '<br /><img height="50px" width="75px" src="' + 
						$imgsrc + '"></span><span id="counts">' +
						nodes[i].count + '</span></div></li>');
					}
					$('#relatedArticles > ul').fadeIn( 'slow' );
				} else {
					$( '#relatedArticles > ul' ).fadeOut( 'slow' );
					$( '#relatedArticles' ).html('<span class="noresult">' + $( '#noresult' ).text() + "</span>").fadeIn( 'slow' );
				}
			}

		);
		return false;
	}
	
};