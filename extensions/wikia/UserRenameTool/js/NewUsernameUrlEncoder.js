var NewUsernameUrlEncoder = {

	init: function() {
		var input = $( "input[name='newusername']" );
		var output = $( "#newUsernameEncoded" );

		input.on( 'input', function() {
			var newUsername = input.val();
			var newUsernameEncoded = encodeURIComponent( newUsername );
			output.html( "URL Encoded: " + newUsernameEncoded );
		});
	}
}

$(function(){
	NewUsernameUrlEncoder.init();
});