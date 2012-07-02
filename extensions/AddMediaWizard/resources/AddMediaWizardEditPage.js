// Bind at document ready time: 
$( function() {
	
	// Build the add-media-wizard conf: 
	var amwConf = {
		'target_textbox': '#wpTextbox1',
		// Note: selections in the textbox will take over the default query
		'default_query': mw.config.get('wgTitle'),
		'target_title': mw.config.get('wgPageName'),		
		
	};
	var didWikiEditorBind = false;
	
    $( '#wpTextbox1' ).bind( 'wikiEditor-toolbar-buildSection-main', function( event, section ) {
        if ( typeof section.groups.insert.tools.file !== 'undefined' ) {
            section.groups.insert.tools.file.action = {
                'type': 'callback',
                'execute': function( context ) {
            		// See if any text is selected ( have that replaced the default query )
            		var selectedText = context.$textarea.textSelection( 'getSelection' );
            		if( selectedText ){
            			amwConf['default_query'] = selectedText;
            		}
            		$.addMediaWizard( amwConf );
                }
            };
        }
    } );
    
} );
