<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Archive for <?php echo $database ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
</head>
<body>
	<ol>
<?php if( $haveXml ): ?>
		<li>
			<a href="full.xml.gz">full.xml.gz</a>
			<em>(last changed: <?php echo date("F d Y H:i:s.", filectime( "{$directory}/full.xml.gz" ) ) ?>)</em>
		</li>
<?php endif ?>
<?php if( $haveZip ): ?>
		<li>
			<a href="images.zip">images.zip</a>
			<em>(last changed: <?php echo date("F d Y H:i:s.", filectime( "{$directory}/images.zip" ) ) ?>)</em>
		</li>
<?php endif ?>
	</ol>
	<hr />
	Back to <a href="http://wikia.com/">Wikia</a>
</body>
</html>
