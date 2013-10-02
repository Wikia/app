<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>VisualEditor Examples</title>
{{VE-LOAD-HEAD}}
		<script>
			function loadInlineExample(code, options, callback) {
				try {
					eval(code);
					callback && callback(true);
				} catch (e) {
					document.body.appendChild(document.createTextNode(e));
					callback && callback(false, e);
				}
			}
		</script>
		<style>
		body {
			margin: 0;
			padding: 0;
			overflow-y: scroll;
			background: #fff;
			font: normal 1em/1.5 sans-serif;
		}
		</style>
	</head>
	<body>
{{VE-LOAD-BODY}}
	</body>
</html>
