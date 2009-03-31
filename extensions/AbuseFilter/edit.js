function doSyntaxCheck()
{
	var filter = document.getElementById('wpFilterRules').value;
	injectSpinner( document.getElementById( 'mw-abusefilter-syntaxcheck' ), 'abusefilter-syntaxcheck' );
	sajax_do_call( 'AbuseFilter::ajaxCheckSyntax', [filter], processSyntaxResult );
}
function processSyntaxResult( request ) {
	var response = request.responseText;
	
	removeSpinner( 'abusefilter-syntaxcheck' );
	
	if (response.match( /OK/ )) {
		// Successful
		jsMsg( 'No syntax errors.', 'mw-abusefilter-syntaxresult' );
	} else {
		var error = response.substr(4);
		jsMsg( 'Syntax error: '+error, 'mw-abusefilter-syntaxresult' );
	}
}
function addText() {
	if (document.getElementById('wpFilterBuilder').selectedIndex == 0) {
		return;
	}
	
	insertAtCursor(document.getElementById('wpFilterRules'), document.getElementById('wpFilterBuilder').value);
	document.getElementById('wpFilterBuilder').selectedIndex = 0;
}

//From http://clipmarks.com/clipmark/CEFC94CB-94D6-4495-A7AA-791B7355E284/
function insertAtCursor(myField, myValue) {
	//IE support
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
	}
	//MOZILLA/NETSCAPE support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		myField.value = myField.value.substring(0, startPos)
		+ myValue
		+ myField.value.substring(endPos, myField.value.length);
	} else {
		myField.value += myValue;
	}
}