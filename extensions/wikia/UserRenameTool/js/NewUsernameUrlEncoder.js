var NewUsernameUrlEncoder = {

	init: function() {
	var input = $( "input[name='newusername']" ),
		output = $( "#newUsernameEncoded>strong" );

		input.on( 'input', function() {
		var newUsername = input.val(),
			newUsernameEncoded = encodeURIComponent( newUsername );
			output.html( newUsernameEncoded );
		});
	}
}

$(function(){
	NewUsernameUrlEncoder.init();
});
