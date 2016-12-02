<div class="rwe-page-header-nav__dropdown rwe-page-header-nav__create wds-dropdown__content">
	<ul class="rwe-page-header-nav__dropdown-list rwe-page-header-nav__dropdown-second-level">
		<?php foreach ( $createList as $key => $item ): ?>
			<li class="rwe-page-header-nav__dropdown-item rwe-page-header-nav__dropdown-second-level-item">
				<div class="rwe-page-header-nav__dropdown-link-wrapper">
					<a class="rwe-page-header-nav__link <?php if ( isset( $item['class'] ) ): echo $item['class'];  endif ?>" data-tracking="create-<?= $key ?>" href="<?= $item['href'] ?>">
						<?= $item['text'] ?>
					</a>
				</div>
			</li>
		<?php endforeach ?>
	</ul>
</div>
