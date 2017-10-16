<? if ( !empty ( $items ) ): ?>
	<div id="<?= $sectionId; ?>">
		<h2><?= $headerMessage->escaped(); ?></h2>
		<div class="category-gallery">
			<div class="category-gallery-holder">
				<div class="category-gallery-room1">
					<?= $items; ?>
				</div>
				<div class="category-gallery-room2"></div>
			</div>
		</div>
		<div class="category-gallery-paginator">
			<?= $paginator; ?>
		</div>
	</div>
<? endif; ?>
