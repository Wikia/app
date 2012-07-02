$(function() {
	var paste = {};

	$('#editor')
		.on('cut copy', function(event) {
			console.log(event);
			var range = rangy.getSelection().getRangeAt(0);
			var key = range.toString().replace(/( |\r\n|\n|\r|\t)/gm,"");

			paste = {};
			paste[key] = 'some wikidom';
			
			if (event.type == 'cut') {
				console.log('tell model to cut from: ' + range.startOffset + ' to: ' + range.endOffset);
			}
		})
		.on('beforepaste paste', function(event) {
			console.log(event);

			$('#paste').html('');
			$('#paste').focus();
			
			setTimeout(function() {
				var key = $('#paste').text().replace(/( |\r\n|\n|\r|\t)/gm,"");
				
				console.log(paste);
				
				if (paste[key]) {
					alert('you pasted from wikidom');
				} else {
					alert('i don\'t know where you pasted from');
				}
				
			}, 1);
		});
		
		
});