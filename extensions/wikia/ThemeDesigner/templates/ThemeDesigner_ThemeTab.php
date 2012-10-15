<section id="ThemeTab" class="ThemeTab">
	<img src="<?= $wg->BlankImgUrl ?>" class="previous chevron disabled">
	<div class="slider">
		<ul>
		<?php
		foreach($wg->OasisThemes as $k => $v) {
		?>
			<li data-theme="<?= $k ?>">
				<label><?= ucfirst($k) ?></label>
				<img src="<?= $wg->StylePath ?>/oasis/images/themes/<?= $k ?>_preview.jpg">
			</li>
		<?php
		}
		?>
		</ul>
	</div>
	<img src="<?= $wg->BlankImgUrl ?>" class="next chevron">
</section>