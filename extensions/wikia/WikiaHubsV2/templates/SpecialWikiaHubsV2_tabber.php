<?php

/**
 * This needs to be generated in the template, as we have to avoid
 * assigning html output of gallery in the controller in order
 * to prevent displaying it in raw/JSON output formats
 *
 */

$app = F::app();


/*

<html>
<span class="title">
</html>
{{{1|Wikia's Picks}}}
<html>
</span>
</html>
[[File:{{{sponsoredimage}}}|right]]
<html>
</div>
</html>
{{#tag:tabber|
{{{tab-one-title}}}=<div style="padding:5px;">
[[File:{{{tab-one-image}}}|200px|right|link={{{tab-one-image-link}}}]]
{{{tab-one-content}}}
</div>
{{!}}-{{!}}
{{{tab-two-title}}}=<div style="padding:5px;">
[[File:{{{tab-two-image}}}|200px|right|link={{{tab-two-image-link}}}]]
{{{tab-two-content}}}
</div>
{{!}}-{{!}}
{{{tab-three-title}}}=<div style="padding:5px;">
[[File:{{{tab-three-image}}}|200px|right|link={{{tab-three-image-link}}}]]
{{{tab-three-content}}}
</div>
}}

 */

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