var NewUsernameUrlEncoder = {

	init: function() {
	var input = $( "input[name='newusername']" ),
		output = $( "#newUsernameEncoded" );

		input.on( 'input', function() {
		var newUsername = input.val(),
			newUsernameEncoded = encodeURIComponent( newUsername );
			output.html( "URL Encoded: " + newUsernameEncoded );
		});
	}
}

$(function(){
	NewUsernameUrlEncoder.init();
});