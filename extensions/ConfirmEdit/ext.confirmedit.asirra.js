/*======================================================================*\
|| #################################################################### ||
|| # Asirra module for ConfirmEdit by Bachsau                         # ||
|| # ---------------------------------------------------------------- # ||
|| # This code is released into public domain, in the hope that it    # ||
|| # will be useful, but without any warranty.                        # ||
|| # ------------ YOU CAN DO WITH IT WHATEVER YOU LIKE! ------------- # ||
|| #################################################################### ||
\*======================================================================*/

jQuery( function( $ ) {
	var asirraform = $( "form#userlogin2" )
	var submitButtonClicked = document.createElement("input");
	var passThroughFormSubmit = false;

	function PrepareSubmit() {
		console.log( 'daa' );
		submitButtonClicked.type = "hidden";
		var inputFields = asirraform.find( "input" );
		for (var i=0; i<inputFields.length; i++) {
			if (inputFields[i].type === "submit") {
				inputFields[i].onclick = function(event) {
					console.log( this );
					submitButtonClicked.name = this.name;
					submitButtonClicked.value = this.value;
				}
			}
		}

		asirraform.submit( function() {
			return MySubmitForm();
		} );
	}

	function MySubmitForm() {
		if (passThroughFormSubmit) {
			return true;
		}
		Asirra_CheckIfHuman(HumanCheckComplete);
		return false;
	}

	function HumanCheckComplete(isHuman) {
		if (!isHuman) {
			alert( mw.msg( 'asirra-failed' ) );
		} else {
			asirraform.append(submitButtonClicked);
			passThroughFormSubmit = true;
			asirraform.submit();
		}
	}
	
	PrepareSubmit();
	
} );
