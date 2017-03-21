<div id="<?= Sanitizer::encodeAttribute( $mapId ); ?>" class="places-map" style="width:100%; height:<?= Sanitizer::encodeAttribute( $height ); ?>px"></div>
<?=  JSSnippets::addToStack(
		array( 'places_css', 'places_js' ),
		array( '$.loadGoogleMaps' ),
		'Places.renderMap',
		array_merge(array(
			'mapId' => $mapId,
			'markers' => $markers,
			'center' => $center
		), $options)
	);
