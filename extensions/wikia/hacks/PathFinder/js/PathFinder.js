//beware: a lot of hacks you don't want to know anything about ahead! do not trespass!
var PathFinder = {
	
	init: function() {
		
		$('#selectBy').change(function() {

			if ($(this).val() == "byId") {
				$('#articlePlace').html('<input id="article" type="number" min="0"/>');
			} else {
				$('#articlePlace').html('<input id="article" type="text" />');
			}
		});

		if( $( '#articles' ).attr( 'data-page' ) != undefined ) {
			$( '#selectBy' ).val( 'byTitle' );
			$( '#articlePlace' ).html( '<input id="article" type="text" value="'+ $( '#articles' ).attr( 'data-page' ) +'"/>' );
			PathFinder.load();
		};
		
		$( '#relatedArticles > ul > li' ).live('click', function() {		
			$( '#showArticle' ).attr( 'src', $(this).attr( 'data-url' ) );
			$( '#articlePlace' ).html( '<input id="article" type="text" value="'+ $(this).find("#reletedItem").text() +'"/>' );
			PathFinder.load();
		});
		
		$('#showArticle').load(function() {	
			PathFinder.stealRelatedFromIFrame();
		});
		
	},

	load: function() {
		if( $( '#showArticle' ).attr( 'src') !== '/wiki/' + $( '#article' ).val() ) {
			$( '#showArticle' ).attr( 'src', '/wiki/' + $( '#article' ).val() );
		}
		PathFinder.loadNodes();
		PathFinder.loadRelated();
		return false;
	},
	
	loadNodes: function() {
		$.get(
			'/wikia.php',
			{
				'controller': 'PathFinderSpecialController',
				'method': 'getNodes',
				'selectby': $( '#selectBy' ).val(),
				'article': $( '#article' ).val(),
				'datespan': $( '#dateSpan' ).val(),
				'pathsNumber': $( '#howManyPaths' ).val(),
				'count': $( '#nodeCount' ).val(),
				'minCount': $( '#minCount' ).val(),
				'format': 'json'
			},
			function( data ) {
				paths = data.paths;
				
				if ( paths != "No Result" ) {
					$( "#navigationArticles" ).html("");
					thumbnails = data.thumbnails;
					
					for ( var i = 0; i < paths.length; i++ ) {
					
						$( "#navigationArticles" ).append( "<span class=\"pathHeader\">Path #" + (i+1) + "</span><ul id=\"path" + i + "\"></ul>" );	
						path = paths[i];
						
						for (var j = 0; j < path.length; j++) {
							
							node = path[j];
							
							if ( thumbnails[node.targetTitle.mArticleID] ) {
								$imgsrc = thumbnails[node.targetTitle.mArticleID][0]['url'];
							} else {
								$imgsrc = "http://dummyimage.com/100x67/000/bada55.gif&text=" + node.targetTitle.mTextform;
							}
							
							$( "#navigationArticles > ul#path" + i ).append( '<li data-url="' +
							node.targetURL + '"><div>'+ 
							node.targetTitle.mTextform + '<br /><img height="50px" width="75px" src="' + 
							$imgsrc + '"></a><span id="counts">' +
							
							node.count + '</span></div></li>');
						}
					}
				} else {
					$( '#navigationArticles > ul' ).show();
					$( '#navigationArticles' ).html('<span class="noresult">' + $( '#noresult' ).text() + "</span>").show();
				}
			}

		);
		return false;
	},
	
	loadRelated: function() {
		$.get(
			'/wikia.php',
			{
				'controller': 'PathFinderSpecialController',
				'method': 'getRelated',
				'selectby': $( '#selectBy' ).val(),
				'article': $( '#article' ).val(),
				'datespan': $( '#dateSpan' ).val(),
				'userHaveSeenNumber': $( '#userHaveSeenNumber' ).val(),
				'minCount': $( '#minCount' ).val(),
				'format': 'json'
			},
			function( data ) {
				nodes = data.nodes;
				
				if ( nodes != "No Result" ) {
					thumbnails = data.thumbnails;
					$("#relatedArticles").html( "<ul></ul>" );

					for ( var i = 0; i < nodes.length; i++ ) {
						
						if ( thumbnails[nodes[i].targetTitle.mArticleID] ) {
							$imgsrc = thumbnails[nodes[i].targetTitle.mArticleID][0]['url'];
						} else {
							$imgsrc = "http://dummyimage.com/75x50/000/bada55.gif&text=" + nodes[i].targetTitle.mTextform;
						}
						
						$( "#relatedArticles > ul" ).append( '<li data-url="' +
						nodes[i].targetURL + '"><div><span id="reletedItem">' + 
						nodes[i].targetTitle.mTextform + '<br /><img height="50px" width="75px" src="' + 
						$imgsrc + '"></span><span id="counts">' +
						nodes[i].count + '</span></div></li>');
					}
					PathFinder.stealRelatedFromIFrame();
				} else {
					$( '#relatedArticles' ).hide().html( '<span class="noresult">' + $( '#noresult' ).text() + "</span>").show();
				}
				
			}

		);
		return false;
	},
	
	stealRelatedFromIFrame: function() {
		
		var myFrame = $('#showArticle'),
			stolenContent;
		
		$( "#relatedArticles" ).append("<div id=\"stolenPages\"></div>");

		myFrame.ready(function(){
			stolenContent = myFrame.contents().find('nav.RelatedPagesModule').html();
			
			$( '#stolenPages' ).html(stolenContent);
		});
	}
};

$(function() {
	PathFinder.init();

});