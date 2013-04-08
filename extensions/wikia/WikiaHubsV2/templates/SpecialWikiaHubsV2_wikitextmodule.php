<h2><?= $wikitextmoduledata['headline'] ?></h2>

<div class="modulecontent">
	<?php

	/**
	 * This needs to be generated in the template, as we have to avoid
	 * assigning html output of gallery in the controller in order
	 * to prevent displaying it in raw/JSON output formats
	 *
	 */

	$app = F::app();
	echo $app->wg->parser->parse($wikitextmoduledata['wikitext'], $app->wg->title, $app->wg->out->parserOptions(), true)->getText();

	?>
</div>
