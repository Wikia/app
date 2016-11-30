<div class="rwe-page-header-nav__dropdown rwe-page-header-nav__create wds-dropdown__content">
	<ul class="rwe-page-header-nav__dropdown-list rwe-page-header-nav__dropdown-second-level">
		<?php foreach ( $createList as $key => $item ): ?>
			<li class="rwe-page-header-nav__dropdown-second-level-item">
				<a class="rwe-page-header-nav__link" data-tracking="create-<?= $key ?>" href="<?= $item['href'] ?>">
					<?= $item['text'] ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>
</div>
