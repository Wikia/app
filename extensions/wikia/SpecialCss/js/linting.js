$(function () {
	$('#lintButton').click(function(){
		var start = new Date().getTime();


		var result = CSSLint.verify($(".css-editor-textarea").val());
		var out = '';

		messages = result.messages;
		for (i=0, len=messages.length; i < len; i++) {
			out += messages[i].message + " (line " + messages[i].line + ", col " + messages[i].col + ")" + messages[i].type + "\n";
		}



		var end = new Date().getTime();
		var time = end - start;
		console.log('Execution time: ' + time);
		alert(out);
	});
});