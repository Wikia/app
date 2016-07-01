var NewUsernameUrlEncoder = {

	init: function() {
		this.input = $( "input[name='newusername']" ),
		this.output = $( "#newUsernameEncoded>strong" ),
		this.newUsername = this.input.val(),

		this.warningsRow = $( "tr#mw-warnings-row" ),
		this.warningsList = { 'characters' : false, 'maxlength' : false }

		NewUsernameUrlEncoder.bindEvent();
		NewUsernameUrlEncoder.validate();
	},

	bindEvent: function() {
		this.input.on( 'input', function() {
			NewUsernameUrlEncoder.newUsername = NewUsernameUrlEncoder.input.val();
			NewUsernameUrlEncoder.validate();
		});
	},

	validate: function() {
		var newUsernameEncoded = encodeURIComponent( this.newUsername );
		this.output.html( newUsernameEncoded );

		var forbiddenCharacters = /[@\/\xC2\xA0]/i;
		this.warningsList[ 'characters' ] = Array.isArray ( this.newUsername.match( forbiddenCharacters ) );

		if ( newUsernameEncoded.length > 255 ) {
			this.warningsList[ 'maxlength' ] = true;
		} else {
			this.warningsList[ 'maxlength' ] = false;
		}

		this.warnings = 0;

		$.each( this.warningsList, function ( key, value ) {
			if ( value == true ) {
				++NewUsernameUrlEncoder.warnings;
				$( 'li#mw-warnings-list-' + key ).show();
			} else {
				$( 'li#mw-warnings-list-' + key ).hide();
			}
		});

		if ( this.warnings > 0 ) {
			this.warningsRow.show();
		} else {
			this.warningsRow.hide();
		}
	}
};

$(document).ready( function() {
	NewUsernameUrlEncoder.init();
});
