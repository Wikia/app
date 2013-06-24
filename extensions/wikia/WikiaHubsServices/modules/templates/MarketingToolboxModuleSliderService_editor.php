<? for ($i = 1; $i <= $slidesCount; $i++): ?>
	<div class="module-box">
		<h3 class="alternative"><?= $i?>.</h3>
		<div class="module-right-box">
			<div class="module-input-box">
				<input type="button" class="wmu-show" value="<?= wfMessage('marketing-toolbox-edithub-add-file-button')->text() ?>" />
				<span class="alternative filename-placeholder">
					<?$photo = $form->getField('photo' . $i); ?>
					<? if (!empty($photo['value'])): ?>
						<?= $photo['value']; ?>
					<? else: ?>
						<?= wfMessage('marketing-toolbox-edithub-file-name')->text() ?>
					<? endif ?>
				</span>
				<p class="alternative">
					<?= wfMessage('marketing-toolbox-hub-module-slider-image-tip')->parse() ?>
				</p>

				<?=$form->renderField('photo' . $i); ?>
				<?=$form->renderField('strapline' . $i); ?>
				<?=$form->renderField('shortDesc' . $i); ?>
				<?=$form->renderField('longDesc' . $i); ?>
				<?=$form->renderField('url' . $i); ?>

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