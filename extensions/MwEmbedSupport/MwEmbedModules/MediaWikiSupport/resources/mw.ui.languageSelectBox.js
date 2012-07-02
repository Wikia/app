/**
 * Simple language selection uses. 
 * 
 * @dependency
 */

if( ! mw.ui ){
	mw.ui = {};
}
/**
 * Get the language box 
 * should probably be something like: mw.widget( 'ui.languageSelectBox', { } ); 
 * or maybe we just directly extend jquery ui ? but would be nice to have a concept of a 
 * functions for reusable interface components
 */
mw.ui.languageSelectBox = function( options ){
	// Build a select object 
	// TODO test string construction instead of jQuery build out for performance  
	var $langSelect = $('<select />')
	if( options.id )
		$langSelect.attr( 'id',  options.id );
	
	if( options['class'] )
		$langSelect.addClass(options['class'] );
	
	var selectedLanguageKey = ( options.selectedLanguageKey )? options.selectedLanguageKey : 'en';
	
	// For every language ( mw.Language.names is a dependency of mw.LanguageSelect ) 
	for( var langKey in mw.Language.names ){
		var optionAttr = {
			'value': langKey
		};
		if( langKey == selectedLanguageKey ){
			optionAttr['selected'] = 'true';
		}
		$langSelect.append(
			$('<option />')
				.attr( optionAttr )
				.text( langKey + ', ' + mw.Language.names[langKey] )
		);
	}
	/*var $comboboxContainer = 
		$('<div />')
		.css({
			'position': 'relative',
			'overflow': 'auto'
		})
		.addClass('ui-widget')
		.append( $langSelect );
	$comboboxContainer.find('select').combobox();
	return $comboboxContainer;
	*/
	// note there are some problems with the autocomplete css and performance issues
	return $langSelect;
};