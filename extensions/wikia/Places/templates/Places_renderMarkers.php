<div id="<?= $mapId ?>" class="places-map" style="width:100%; height:<?= $height; ?>px"></div>
<?
	echo F::build('JSSnippets')->addToStack(
		array(
			'/extensions/wikia/Places/js/Places.js',
		),
		array('$.loadGoogleMaps'),
		'Places.renderMap',
		array_merge(array(
			'mapId' => $mapId,
			'markers' => $markers,
			'center' => $center
		), $options)
	);
?>
