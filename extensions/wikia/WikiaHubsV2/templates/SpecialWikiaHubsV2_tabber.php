<h2><?= $headline ?></h2>
<?php
$app = F::app();
echo $app->wg->parser->parse(
	$tabs,
	$app->wg->title,
	$app->wg->out->parserOptions(),
	true
)->getText();
