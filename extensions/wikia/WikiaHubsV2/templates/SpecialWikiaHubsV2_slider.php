<?php

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