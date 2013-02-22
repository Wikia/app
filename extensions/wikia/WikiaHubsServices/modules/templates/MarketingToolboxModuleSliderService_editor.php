<? for ($i = 1; $i <= $slidesCount; $i++): ?>
	<div class="module-box">
		<h3 class="alternative"><?= $i?>.</h3>
		<div class="module-right-box">
			<div class="module-input-box">
				<input type="button" class="wmu-show" value="<?= $wf->msg('marketing-toolbox-edithub-add-file-button')?>" />
				<span class="alternative filename-placeholder">
					<? if (!empty($fields['photo' . $i]['value'])): ?>
						<?= $fields['photo' . $i]['value']; ?>
					<? else: ?>
						<?= $wf->msg('marketing-toolbox-edithub-file-name') ?>
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
				array('inputData' => $fields['strapline' . $i])
			);
				?>
				<?=$app->renderView(
				'MarketingToolbox',
				'FormField',
				array('inputData' => $fields['shortDesc' . $i])
			);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['longDesc' . $i])
				);
				?>
				<?=$app->renderView(
					'MarketingToolbox',
					'FormField',
					array('inputData' => $fields['url' . $i])
				);
				?>


				<input class="secondary clear" type="button" value="<?= $wf->msg('marketing-toolbox-edithub-clear-button')?>" />
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