$(function () {
	$('#lintButton').click(function(){
		var start = new Date().getTime();


		var result = CSSLint.verify($(".css-editor-textarea").val());
		var out = '';

		var end = new Date().getTime();
		var time = end - start;
		$().log('Execution time: ' + time, 'CSS Linting');

		messages = result.messages;
		for (i=0, len=messages.length; i < len; i++) {
			out += messages[i].message + " (line " + messages[i].line + ", col " + messages[i].col + ")" + messages[i].type + "\n";
		}



		alert(out);
	});
});
