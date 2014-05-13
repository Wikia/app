<h2><?= $headline; ?></h2>

<div class="polls-content">
	<?=  $app->wg->parser->parse($wikitextpolls, $app->wg->title, $app->wg->out->parserOptions(), true)->getText(); ?>
</div>