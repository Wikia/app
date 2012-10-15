<?php
$app = F::app();
echo $app->wg->parser->parse(
	$slider,
	$app->wg->title,
	$app->wg->out->parserOptions(),
	true
)->getText();