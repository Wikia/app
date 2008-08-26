<?php
	$currentDir = readlink( '/a/static/downloads/current' );
	$currentBase = basename( $currentDir );
	$currentText = htmlspecialchars( date( 'F Y', strtotime( $currentBase . '-01' ) ) );
	$encCurrentBase = htmlspecialchars( urlencode( $currentBase ) );
	$inProgressDir = @readlink( '/a/static/downloads/in_progress' );
	$inProgressText = $inProgressDir ? 
		htmlspecialchars( date( 'F Y', strtotime( basename( $inProgressDir ) . '-01' ) ) ) : false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Wikipedia Static HTML Dumps</title>
		<style type="text/css" media="screen,projection">/*<![CDATA[*/
body {
	font: x-small sans-serif;
	background: #f9f9f9 url(http://en.wikipedia.org/skins-1.5/monobook/headbg.jpg) 0 0 no-repeat;
	color: black;
	margin: 0;
	padding: 0;
}
/* scale back up to a sane default */
#globalWrapper {
	font-size: 127%;
	width: 100%;
	margin: 0;
	padding: 0;
}
#content {
	margin: 2em 2em 0 2em;
	padding: 0 1em 1.5em 1em;
	background: white;
	color: black;
	border: 1px solid #aaa;
	line-height: 1.5em;
	position: relative;
	z-index: 2;
}
h1, h2, h3, h4, h5, h6 {
	color: black;
	background: none;
	font-weight: normal;
	margin: 0;
	padding-top: .5em;
	padding-bottom: .17em;
	border-bottom: 1px solid #aaa;
}
h1 { 
	font-size: 188%; 
	margin-bottom: .6em;
}
h2 { 
	font-size: 150%; 
	margin-bottom: .6em;
}
h3, h4, h5, h6 {
	border-bottom: none;
	font-weight: bold;
	margin-bottom: .3em;
}

ul {
	line-height: 1.5em;
	list-style-type: square;
	margin: .3em 0 0 1.5em;
	padding: 0;
	list-style-image: url(bullet.gif);
}
ol {
	line-height: 1.5em;
	margin: .3em 0 0 3.2em;
	padding: 0;
	list-style-image: none;
}
li {
	margin-bottom: .1em;
}
dt {
	font-weight: bold;
	margin-bottom: .05em;
}
dl {
	margin-top: .2em;
	margin-bottom: .5em;
}
dd {
	line-height: 1.5em;
	margin-left: 2em;
	margin-bottom: .5em;
}
a {
	text-decoration: none;
	color: #002bb8;
	background: none;
}
a:visited {
	color: #5a3696;
}
a:active {
	color: #faa700;
}
a:hover {
	text-decoration: underline;
}

.visualClear {
	clear: both;
}

/*]]>*/</style>

</head>
<body>
	<div id="globalWrapper">
		<div id="content">
			<h1>Wikipedia Static HTML Dumps</h1>
<p>This is a set of static HTML dumps of Wikipedia. Note that putting one of these dumps on the web unmodified will constitute a trademark violation. They are intended for private viewing in an intranet or desktop installation.</p>

<p>The current dump is the <?php echo $currentText; ?> edition. This dump has no image snapshot, it's just HTML. Due to performance problems when compressing millions of files with <a href="http://7-zip.org">7-zip</a>, the archives are now packaged as a 7-zipped tar file.</p>

<?php if ( $inProgressText ): ?>
<p>A <?php echo $inProgressText; ?> dump is in progress.</p>
<?php endif; ?>

<ul>
	<li><strong><a href="/downloads/<?php echo $encCurrentBase; ?>">Downloads</a></strong></li>
</ul>
<h2>Browse</h2>
<p>Try before you download, click on a language code below.</p>

<p>
<?php
$wikipedias = array_map( 'trim', file( '/home/wikipedia/common/wikipedia.dblist' ) );
$private = array_map( 'trim', file( '/home/wikipedia/common/private.dblist' ) );
$wikipedias = array_diff( $wikipedias, $private );
$first = true;
foreach ( $wikipedias as $db ) {
	$db = trim( $db );
	$langWithUnderscores = substr( $db, 0, strlen( $db ) - 4 );
	$lang = str_replace( '_', '-', $langWithUnderscores );
	if ( $first ) {
		$first = false;
	} else {
		echo " - ";
	}
	echo "<a href=\"new/wikipedia/$langWithUnderscores/index.html\">$lang</a>\n";
}
?>
</p>
		<div class="visualClear"></div>
	</div>
</div>
</body></html>
