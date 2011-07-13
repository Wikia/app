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
		
		$( '#relatedArticles #reletedItem' ).live('click', function( event ) {		
			event.stopPropagation();
			$( '#showArticle' ).attr( 'src', $(this).attr('data-url') );
			$( '#articlePlace' ).html( '<input id="article" type="text" value="'+ $(this).text() +'"/>' );
			UserPathPrediction.load();
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
			function(data) {
				nodes = data.nodes;
				thumbnails = data.thumbnails;
				
				if(data['nodes'] != "No Result") {
					$("#navigationArticles").html("<ul></ul>");
					for ( var i = 0; i < nodes.length; i++ ) {
						
						if ( thumbnails[nodes[i].targetTitle.mArticleID] ) {
							$imgsrc = thumbnails[nodes[i].targetTitle.mArticleID][0]['url'];
						} else {
							$imgsrc = "http://dummyimage.com/100x50/000/bada55.gif&text=NoImage";
						}
						
						$( "#navigationArticles > ul" ).append( '<li><div><a href="'+ 
						nodes[i].targetURL + '" target="showArticle">' + 
						nodes[i].targetTitle.mTextform + '<br /><img src="' + 
						$imgsrc + '"></a><span id="counts">' +
						nodes[i].count + '</span></div></li>');
					}
				} else {
					$( '#navigationArticles > ul' ).hide( 'fast' );
					$( '#navigationArticles' ).html('<span class="noresult">' + $( '#noresult' ).text() + "</span>").show( 'fast' );
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
					$('#relatedArticles > ul ').hide('fast');
					$("#relatedArticles").html("<ul></ul>");
					for ( var i = 0; i < nodes.length; i++ ) {
						
						if ( thumbnails[nodes[i].targetTitle.mArticleID] ) {
							$imgsrc = thumbnails[nodes[i].targetTitle.mArticleID][0]['url'];
						} else {
							$imgsrc = "http://dummyimage.com/100x50/000/bada55.gif&text=NoImage";
						}
						
						$( "#relatedArticles > ul" ).append( '<li><div><span id="reletedItem" data-url="'+ 
						nodes[i].targetURL + '">' + 
						nodes[i].targetTitle.mTextform + '<br /><img src="' + 
						$imgsrc + '"></span><span id="counts">' +
						nodes[i].count + '</span></div></li>');
					}
					$('#relatedArticles > ul').show('fast');
				} else {
					$( '#relatedArticles > ul' ).hide( 'fast' );
					$( '#relatedArticles' ).html('<span class="noresult">' + $( '#noresult' ).text() + "</span>").show( 'fast' );
				}
			}

		);
		return false;
	}
	
};