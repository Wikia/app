<div id="places-dynamic-map" style="width:100%; height:500px"></div>
<?
	echo F::build('JSSnippets')->addToStack(
		array( 
			'/extensions/wikia/Places/js/Places.js',
			'http://maps.googleapis.com/maps/api/js?sensor=false&callback=$.noop'
		),
		array(),
		'Places.displayDynamic'
	);
?>
