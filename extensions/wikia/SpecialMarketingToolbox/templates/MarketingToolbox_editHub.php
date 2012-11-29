<?= F::app()->renderView(
	'MarketingToolbox',
	'Header',
	$headerData
) ?>

<section class="MarketingToolboxMain WikiaGrid">
	<div class="grid-2">
		<?= F::app()->renderView('LeftMenu',
			'Index',
			array('menuItems' => $leftMenuItems)
		) ?>
	</div>
	<div class="grid-4 alpha">
		<input type="button" class="wmu-show" value="WMU test" />
		<form method="post" name="upload-tool" class="WikiaForm" enctype="multipart/form-data">
			<div class="grid-4 alpha">
				<div class='input-group required url-and-topic'>
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-wikiurl'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-topic'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
				</div>
			</div>
			<div class="grid-2 alpha">
				<div class="input-group">
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-stat1'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-stat2'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-stat3'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
				</div>
			</div>
			<div class="grid-2 alpha">
				<div class="input-group">
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-number1'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-number2'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
					<label>
						<?= wfMsg('marketing-toolbox-hub-module-pulse-number3'); ?>
					</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>

<?= F::app()->renderView(
	'MarketingToolbox',
	'Footer'
) ?>