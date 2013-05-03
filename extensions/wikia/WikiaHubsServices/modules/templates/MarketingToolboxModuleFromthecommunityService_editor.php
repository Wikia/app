<? for ($i = 1; $i <= $boxesCount; $i++): ?>
<div class="module-box">
	<h3 class="alternative"><?= $i?>.</h3>
	<div class="module-right-box">
		<div class="module-input-box">
			<input type="button" class="wmu-show" value="<?= wfMessage('marketing-toolbox-edithub-add-file-button')->text() ?>" />
				<span class="alternative filename-placeholder">
					<? if (!empty($fields['photo' . $i]['value'])): ?>
					<?= $fields['photo' . $i]['value']; ?>
					<? else: ?>
					<?= wfMessage('marketing-toolbox-edithub-file-name')->text() ?>
					<? endif ?>
				</span>
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['photo' . $i])
			);
			?>
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['title' . $i])
			);
			?>
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['usersUrl' . $i])
			);
			?>
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['quote' . $i])
			);
			?>
			<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['url' . $i])
			);
			?>


			<input class="secondary clear" type="button" value="<?= wfMessage('marketing-toolbox-edithub-clear-button')->text() ?>" />
		</div>
		<div class="module-image-box">
			<div class="image-placeholder">
				<? if (!empty($photos[$i])): ?>
				<img width="<?= $photos[$i]['imageWidth']; ?>" height="<?= $photos[$i]['imageHeight']; ?>" src="<?= $photos[$i]['url']; ?>" />
				<? else: ?>
				<img src="<?= $wg->BlankImgUrl; ?>" />
				<? endif ?>
			</div>
		</div>

		<button type="button" class="secondary navigation nav-up"><img class="chevron chevron-up" src="<?= $wg->BlankImgUrl; ?>"></button>
		<button type="button" class="secondary navigation nav-down"><img class="chevron chevron-down" src="<?= $wg->BlankImgUrl; ?>"></span></button>
	</div>
</div>
<? endfor ?>