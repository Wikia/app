<section id="ThemeTab" class="ThemeTab">
	<img src="<?= $wgBlankImgUrl ?>" class="previous chevron disabled">
	<div class="slider">
		<ul>
		<?php
		foreach($wgOasisThemes as $k => $v) {
		?>
			<li data-theme="<?= $k ?>">
				<label><?= ucfirst($k) ?></label>
				<img src="<?= $wgStylePath ?>/oasis/images/themes/<?= $k ?>_preview.jpg">
			</li>
		<?php
		}
		?>
		</ul>
	</div>
	<img src="<?= $wgBlankImgUrl ?>" class="next chevron">
</section>