<section id="ThemeTab" class="ThemeTab">
	<img src="<?= $wgStylePath ?>/common/blank.gif" class="previous chevron disabled">
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
	<img src="<?= $wgStylePath ?>/common/blank.gif" class="next chevron">
</section>