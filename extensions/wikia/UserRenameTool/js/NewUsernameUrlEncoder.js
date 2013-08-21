var NewUsernameUrlEncoder = {

	init: function() {
		this.input = $( "input[name='newusername']" ),
			this.output = $( "#newUsernameEncoded>strong" );

		this.input.on( 'input', function() {
			NewUsernameUrlEncoder.update();
		});
	},

	update: function() {
		var newUsername = this.input.val(),
			newUsernameEncoded = encodeURIComponent( newUsername );
		this.output.html( newUsernameEncoded );
	}
}

$(document).ready( function() {
	NewUsernameUrlEncoder.init();
	NewUsernameUrlEncoder.update();
});
