<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @author Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */
/**
 * Selenium testing for Extensions
 *
 * Extend this class
 *
 */

/**
 * extensionPath
 *
 * @var string $extensionPath
 */
$extensionPath = realpath( dirname( dirname( dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) ) ) );

// Make sure the include path is a parsed as a proper directory.
$extensionPath = is_dir( $extensionPath ) ? $extensionPath : false;

if ( $extensionPath ) {

	require_once $extensionPath . '/UnitTest/ExtensionsSeleniumSlideshow.php';

	$slideshow = new ExtensionsSeleniumSlideshow( __FILE__ );
}
else {
	
	echo 'The include path is invalid for the slideshow: ' . __FILE__;
	return;
}
?>
<html>
	<head>
		<title><?php echo $slideshow->getTitle() ?></title>
		<script type="text/javascript" src="/resources/jquery/jquery.js"></script>
		<script type="text/javascript" src="/resources/jquery/jquery.cycle.all.js"></script>
		<style type="text/css">
			ul#slideshow {width: 90%;border:solid;position:relative;overflow:hidden;height: 90%}
			ul#slideshow li {font-size:1.4em;padding:20px;opacity:0;position:absolute}
			#pagination a { border: 1px solid #ccc; background: silver; text-decoration: none; margin: 0 5px; padding: 3px 5px;	 }
			#pagination a.activeSlide { background: yellow }
			#pagination a:focus { outline: none; }
		</style>
		<script type="text/javascript">
		$(document).ready(function() {

			$('#slideshow').cycle({
				fx:		'fade',
				speed:	 300,
				timeout: 3000,
				next:	'#slideshow',
				pause:	 1,
				pager:	'#pagination',
				before: function(data) {
					var name = $(this).attr('title');
					$('#slideshow_title').html(name);
				}
			});
		});
		</script>
	</head>
	<body>

		<h1><?php echo $slideshow->getTitle() ?></h1>
		<h2>Slideshow</h2>
		<h3 id="slideshow_title"></h3>

		<p>Note: Hover over image to pause. Click to advance.</p>

		<div id="pagination"></div>

		<?php $images = $slideshow->run() ?>

		<?php if ( $slideshow->hasImages() ): ?>

			<ul id="slideshow">

				<?php foreach ( $images as $image ): ?>
				<li title="<?php echo $image ?>"><img src="<?php echo $image ?>" alt="<?php echo $image ?>" /></li>
				<?php endforeach; ?>

			</ul>

		<?php else: ?>

			<p>No screenshots were generated for the slideshow.</p>
			
		<?php endif; ?>
	</body>
</html>
