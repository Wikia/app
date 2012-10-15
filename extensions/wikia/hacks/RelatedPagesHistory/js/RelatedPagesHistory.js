var RelatedPagesHistory = {

	STORAGE_NAME: 'RelatedPagesHistor3',
	STORAGE_COUNTER: 'RelatedPagesCounter',
	historyData: [],
	counter: 0,
	
	init: function(){
		RelatedPagesHistory.loadCounter();
		if ( $('section.WikiaActivityModule').length > 0 ){
			$().log( '1' );
			$( 'nav.RelatedPagesModule li').each( function( idx, item ) {
				var relatedPage = {};
				var aMore = $( item ).find( 'a.more' );
				var imageData = '';

//				if ( $( item ).find( 'img' ).length > 0 ){
//					imageData = $( item ).find( 'img' ).attr('data-src');
//					if ( imageData.length > 0 ){
//						imageData = imageData.replace( "200px-0%2C600%2C34%2C334", "130px-0%2C399%2C0%2C353" )
//					}
//				}

				relatedPage = {
					'link': aMore.attr('href'),
					'name': aMore.html(),
			///		'img':	imageData,
					'position' : 0.6,
					'id':	RelatedPagesHistory.counter
				}

				RelatedPagesHistory.addPage( relatedPage );
			});
		}
		
		if ( $('#WikiaArticle a').length > 0 ){
			$( '#WikiaArticle a').each( function( idx, item ) {
				var relatedPage = {};
				var aMore = $( item );
				var aMoreText =  aMore.text();
				if ( aMoreText.length > 5 ){
					relatedPage = {
						'link': aMore.attr('href'),
						'name': aMoreText,
				///		'img':	imageData,
						'position' : 0.1,
						'id':	RelatedPagesHistory.counter
					}
					
					RelatedPagesHistory.addPage( relatedPage );
				}
			});
		}
		
		RelatedPagesHistory.saveCounter();
		RelatedPagesHistory.saveData();
		$().log( RelatedPagesHistory.getData(), 'currentlyInStorage' );

		$( 'section.WikiaActivityModule' ).html( 
			RelatedPagesHistory.createTemplate()
		);

	},

	createTemplate: function(){
		var currentData = RelatedPagesHistory.getData();
		
		currentData.sort( function( a, b ){ return a.position - b.position });
		currentData = currentData.reverse();

		var returnHTML = '<h1 class="activity-heading">Recomended Pages</h1><ul>';
		var localCounter = 0;
		$.each( currentData, function( index, value ) {

			returnHTML = returnHTML + '<li style="padding-left:10px">';
//			if ( value.img != '' ){
//				returnHTML = returnHTML + '<img style="margin: 0 20px 0 -20px; width:130px; height:115px; float:left; le" src="' + value.img + '">';
//			}
			returnHTML = returnHTML + '<em><a href="' + value.link + '">' + value.name + '</a> <a style="font-size:9px">' + Math.round( value.position*100 )/100 + '</a></em></li>';
		localCounter++;
		if ( localCounter > 10 ) return false
	});

		$().log( returnHTML );
		return returnHTML;
	},
	
	getData: function(){
		var resultArray = [];
		try {
			resultArray = $.storage.get( RelatedPagesHistory.STORAGE_NAME );
		} catch( e ){
			return resultArray;
		}
		return resultArray;
	},

	loadCounter: function(){
		RelatedPagesHistory.counter = $.storage.get( RelatedPagesHistory.STORAGE_COUNTER );
		if ( RelatedPagesHistory.counter == null || RelatedPagesHistory.counter.length == 0 ){
			RelatedPagesHistory.counter = 0;
		}
		return RelatedPagesHistory.counter;
	},

	addPage: function( page ){

		var currentData = RelatedPagesHistory.getData();

		if ( currentData == null || currentData.length == 0 ){
			currentData = [];
		}

		var finalPages = [];

		$.each( currentData, function( index, value ) {			
			if ( value.name != page.name && ( '/wiki/' + wgPageName ) != value.link ){
				finalPages.push( value );

			} else {
				if (  page.position < 1 ){

					if ( ( page.position + value.position ) > 1 ){
						page.position = 1;
					} else {
						page.position = page.position + value.position;
					}
				}
			}
		});

		RelatedPagesHistory.dataToDisplay = finalPages;
		finalPages.push( page );
		RelatedPagesHistory.counter++;
		$.storage.set( RelatedPagesHistory.STORAGE_NAME, finalPages );

	},

	saveData: function (){
		var currentData = RelatedPagesHistory.getData();
		var finalTable = [];
		$.each( currentData, function( index, value ){
			if ( value.position > 0.5 ){
				value.position = value.position - 0.1;
			}
			finalTable.push( value );
		});
		$.storage.set( RelatedPagesHistory.STORAGE_NAME, finalTable );
	},

	saveCounter: function(){
		$.storage.set( RelatedPagesHistory.STORAGE_COUNTER, RelatedPagesHistory.counter );
	}
}

$( function() {
	RelatedPagesHistory.init();
} );