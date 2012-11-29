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
			<fieldset>
				<div class='input-group required'>
					<label>TestLabel</label>
					<div class="headline-wrapper">
						<input data-min="50" data-max="200" type="text" name="title" value="" placeholder="">
						<p class="headline-character-counter"></p>
						<p class="error error-msg"></p>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</section>

<?= F::app()->renderView(
	'MarketingToolbox',
	'Footer'
) ?>