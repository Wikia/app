jQuery( function( $ ) {
	var languages = { isset: false };
	
	//Replace fake "add language" link with real one and add it
	var paragraph = $( '<p id="mw-translatesvg-newtrans"></p>' ).text( mw.msg( 'translatesvg-add' ) );
	var match = paragraph.html().match( /\[\[#addlanguage\|(.*?)\]\]/ );
	paragraph.html( paragraph.html().replace( match[0], '<a id="mw-translatesvg-newtranslink" href="#">' + match[1] + '</a>' ) );
	$( 'div.mw-specialpage-summary' ).append( paragraph );
	
	//Add in "remove" links
	$( 'legend' ).each( function(){ 
		var langcode = $(this).parent().attr('id').substr( 25 ); //Trim "mw-translatesvg-fieldset-"
		if( langcode !== 'qqq' && langcode !== 'fallback' ){
			$(this).append( '&#160;' ).append( getRemoveLink() );
		}
	} );
	
	
	$( '#mw-translatesvg-newtranslink' )
		.click( function() {
		var langcode = prompt( mw.msg( 'translatesvg-specify' ) );
		if( langcode !== null ){
			if( !langcode.match( /^[a-z]+(?:-[a-z]+)?/ ) ){
				//Not valid language code
				return false; //TODO: more helpful?
			}
			if( $( '#mw-translatesvg-fieldset-'+langcode ).length !== 0 ){
				//Already exists
				return false; //TODO: more helpful?
			}
			if( languages.isset ){
				if( !( langcode in languages ) ){
					//Have already loaded valid languages and this ain't one of them
					return false; //TODO: more helpful?
				}
				$( '#specialtranslatesvg' ).prepend( getNewFieldset( langcode, languages[langcode] ) );
			} else {
				var temp = $( '<fieldset><br /></fieldset>' ).append( $.createSpinner( 'translatesvg-temp') );
				$( '#specialtranslatesvg' ).prepend( temp );
				jQuery.getJSON( 
				  mw.util.wikiScript( 'api' ), {
					'format': 'json',
					'action': 'query',
					'meta': 'siteinfo',
					'siprop': 'languages'
				  }, function( data ) {
					var length = data.query.languages.length;
					for( var i = 0; i < length; i++ ){
						languages[ data.query.languages[i]['code'] ] = data.query.languages[i]['*'];
					}
					if( ( langcode in languages ) ){
						$( '#specialtranslatesvg' ).prepend( getNewFieldset( langcode, languages[langcode] ) );
					} else {
						//Have now loaded valid languages and this ain't one of them
						//TODO: more helpful?
					}
					temp.remove();
					languages.isset = true;
				  }
				 );
			}
		}
		return false;
	} );
} );

function getNewFieldset( langcode, langname ){
	var newfieldset = $( 'fieldset#mw-translatesvg-fieldset-fallback' ).clone();
	newfieldset.find( 'input' ).each( function (){
		$( this ).attr( 'id', $( this ).attr( 'id' ).toString().replace( 'fallback', langcode ) );
		$( this ).attr( 'name', $( this ).attr( 'name' ).toString().replace( 'fallback', langcode ) );
		$( this ).attr( 'value', getExisting( $( this ).attr( 'value' ) ) );
	} );	
	newfieldset.find( 'label' ).each( function (){
		$( this ).attr( 'for', $( this ).attr( 'for' ).toString().replace( 'fallback', langcode ) );
	} );
	newfieldset.attr( 'id', "mw-translatesvg-fieldset-" + langcode );
	newfieldset.find( 'legend' ).each( function (){
		$( this ).text( langname );
		$( this ).append( '&#160;' ).append( getRemoveLink() );
	} );
	newfieldset.find( 'div.mw-collapsible.mw-made-collapsible' ).first().each( function(){ 
		$(this).find( '.mw-collapsible-toggle' ).first().remove();
		$(this).removeClass().addClass( 'mw-collapsible mw-collapsed' ).makeCollapsible();
	} );
	return newfieldset;
}

function getRemoveLink(){
	var removelink = $( '<a href="#"><abbr title="'
				+ mw.message('translatesvg-remove').escaped()
				+ '"><small>[x]</small></abbr></a>' );
	removelink.click( function(){ $(this).parent().parent().remove(); } );
	return removelink;
}

function getExisting( fallback ){
	//No need to check for an existing translation since we're creating a new language box
	if( fallback.match( /^[0-9 .,-]+$/ ) ){
		return fallback;
	} else {
		return '';
	}
}