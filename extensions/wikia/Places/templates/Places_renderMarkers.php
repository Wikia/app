<div id="<?= $mapId ?>" class="places-map" style="width:100%; height:<?= $height; ?>px"></div>
<?
	$am = F::build( 'AssetsManager', array(), 'getInstance' );

	echo F::build('JSSnippets')->addToStack(
		array_merge( $am->getURL( 'places_css' ), $am->getURL( 'places_js' ) ),
		array('$.loadGoogleMaps'),
		'Places.renderMap',
		array_merge(array(
			'mapId' => $mapId,
			'markers' => $markers,
			'center' => $center
		), $options)
	);
?>
