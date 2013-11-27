<div id="WikiWelcome" class="WikiWelcome">
	<h1><?= wfMessage( 'cnw-welcome-headline', $wg->Sitename )->text() ?></h1>
	<p><?= wfMessage( 'cnw-welcome-instruction1' )->text() ?></p>
	<?php
		$buttonParams = [
			'type' => 'button',
			'vars' => [
				'type' => 'button',
				'classes' => [ 'wikia-button',  'big', 'createpage' ],
				'value' => wfMessage( 'button-createpage' )->text(),
				'imageClass' => 'new',
				'data' => [
					'key' => 'event',
					'value' => 'createpage'
				]
			]
		];

		echo \Wikia\UI\Factory::getInstance()->init('button')->render($buttonParams);
	?>

	<p><?= wfMessage( 'cnw-welcome-instruction2' )->text() ?></p>
	<p class="help"><?= wfMessage( 'cnw-welcome-help' )->text() ?></p>
</div>
