<a class="hubs-entry-point global-navigation-link"></a>
<nav id="hubs" class="hubs-menu">
	<div class="hub-list">
		<? foreach( $menuNodes as $index => $hub ): ?>
			<a data-vertical="<?=$hub['specialAttr']; ?>" href="<?= $hub['href']; ?>" class="<?=$hub['specialAttr']; ?> hub-link <? if ( $activeNodeIndex == $index ):?> active<? endif ?>">
				<span class="icon"></span>
				<span class="label"><?=$hub['text']; ?></span>
			</a>
		<? endforeach ?>
	</div>
	<div class="hub-links">
		<?= $app->renderView('GlobalNavigation', 'hubsMenuSections', ['menuSections' => [$menuNodes[$activeNodeIndex]]]); ?>
	</div>
</nav>
