<a class="hubs-entry-point global-navigation-link"></a>
<nav id="hubs" class="hubs-menu">
	<ul class="hub-list">
		<? foreach( $menuNodes as $index => $hub ): ?>
			<li>
				<a data-vertical="<?=$hub['specialAttr']; ?>" href="<?= $hub['href']; ?>" class="<?=$hub['specialAttr']; ?> hub-link <? if ( $activeNodeIndex == $index ):?> active<? endif ?>">
					<span class="icon"></span>
					<span class="label"><?=$hub['text']; ?></span>
				</a>
			</li>
		<? endforeach ?>
	</ul>
	<div class="hub-links">
		<?= $app->renderView('GlobalNavigation', 'hubsMenuSections', ['menuSections' => [$menuNodes[$activeNodeIndex]]]); ?>
	</div>
</nav>
