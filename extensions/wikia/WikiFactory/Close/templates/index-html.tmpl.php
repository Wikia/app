<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Archive for <?php echo $database ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<style language="text/css">
	.error{background-color: red;}
        { background: white; }
        a { color: navy; text-decoration: none; }
        a:hover { color: blue; }
        .project { border: solid 1px black; padding: 5px; width: 500px; margin: 20px; background-color: silver; }
        .projname { font-size: xx-large; color: white; }
        .site { border: dotted 1px black; padding: 3px; width: 600px; margin: 3px; background-color: white;  }
        .auxtables { font-size: small; }
        .meta { color: gray; font-size: small; }
    </style>
</head>
<body>
	<h1>Archive for <?php echo $database ?>:</h1>
	<ol>
<?php if( $haveXml ): ?>
		<li>
			<a href="full.xml.gz">full.xml.gz</a>
			<em class="meta">(last changed: <?php echo date("F d Y H:i:s.", filectime( "{$directory}/full.xml.gz" ) ) ?>)</em>
		</li>
<?php endif ?>
<?php if( $haveZip ): ?>
		<li>
			<a href="images.zip">images.zip</a>
			<em class="meta">(last changed: <?php echo date("F d Y H:i:s.", filectime( "{$directory}/images.zip" ) ) ?>)</em>
		</li>
<?php endif ?>
	</ol>
	<hr />
	Back to <a href="http://wikia.com/">Wikia</a>
</body>
</html>
