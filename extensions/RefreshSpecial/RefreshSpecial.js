/**
 * JavaScript helper function for RefreshSpecial extension
 */
function refreshSpecialCheck( form ) {
	pattern = document.getElementById( 'refreshSpecialCheckAll' ).checked;
	for( i = 0; i < form.elements.length; i++ ) {
		if( form.elements[i].type == 'checkbox' && form.elements[i].name != 'check_all' ) {
			form.elements[i].checked = pattern;
		}
	}
}