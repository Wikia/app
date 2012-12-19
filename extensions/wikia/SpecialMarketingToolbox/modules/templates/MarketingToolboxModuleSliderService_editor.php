<? for ($i = 1; $i <= $slidesCount; $i++): ?>
	<div class="module-box">
		<h3 class="alternative"><?= $i?>.</h3>
		<div class="module-right-box">
			<div class="module-input-box">
				<input type="button" class="wmu-show" value="<?= $wf->msg('marketing-toolbox-edithub-add-file-button')?>" />
				<span class="alternative filename-placeholder wmu-file-name">
					<?= $wf->msg('marketing-toolbox-edithub-file-name') ?>
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
				<div class="image-placeholder placeholder">
					<img src="<?= $wg->BlankImgUrl; ?>" />
				</div>
			</div>

			<button class="secondary navigation nav-up"><img class="chevron chevron-up" src="<?= $wg->BlankImgUrl; ?>"></button>
			<button class="secondary navigation nav-down"><img class="chevron chevron-down" src="<?= $wg->BlankImgUrl; ?>"></span></button>
		</div>
	</div>
<? endfor ?>