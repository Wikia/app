<section id="ThemeTab" class="ThemeTab">
	<img src="<?= $wg->BlankImgUrl ?>" class="previous chevron disabled">
	<div class="slider">
		<ul>
			<?php
			foreach ( $wg->OasisThemes as $k => $v ) {
				?>
				<li data-theme="<?= $k ?>">
					<img width="120" height="100" src="<?= $wg->StylePath ?>/oasis/images/themes/<?= $k ?>_preview.png">
				</li>
				<?php
			}
			?>
		</ul>
	</div>
	<img src="<?= $wg->BlankImgUrl ?>" class="next chevron">
</section>
