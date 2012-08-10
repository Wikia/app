<section style="margin-bottom:20px" class="grid-3 alpha wikiahubs-rail">
<?php

/**
 * This needs to be generated in the template, as we have to avoid
 * assigning html output of gallery in the controller in order
 * to prevent displaying it in raw/JSON output formats
 *
 */

$app = F::app();
$galleryText = '<gallery type="slider" orientation="mosaic">';
foreach($images as $image) {
	$galleryText .= "\n" . implode('|',array(
			$image['image'],
			$image['headline'],
			'link=' . $image['anchor'],
			'linktext=' . $image['description'],
			'shorttext=' . $image['title']
		)
	);
}
$galleryText .= "\n</gallery>";

echo $app->wg->parser->parse( $galleryText, $app->wg->title, $app->wg->out->parserOptions(),true )->getText();

?>

</section>