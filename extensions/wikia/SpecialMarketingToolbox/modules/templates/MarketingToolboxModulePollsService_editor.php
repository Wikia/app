<div class="module-polls">
    <div class="grid-4 alpha">
		<?= $app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['pollsTitle'])
			);
		?>
	</div>
    <div class="grid-4 alpha wide">
		<?= $app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['pollsQuestion'])
			);
		?>
    </div>

    <div class="grid-3 alpha wide">
		<? for ($i = 1; $i <= $optionsLimit; $i++): ?>
		<?= $app->renderView(
			'MarketingToolbox',
			'FormField',
			array('inputData' => $fields['pollsOption' . $i])
		);
		?>
		<? endfor; ?>
    </div>
</div>
