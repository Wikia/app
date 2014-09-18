<a class="hubs-entry-point global-navigation-link"></a>
<nav id="hubs" class="hubs-menu">
	<div class="hub-list">
		<? foreach( $menuNodes as $index => $hub ): ?>
			<nav data-vertical="<?=$hub['specialAttr']; ?>" class="<?=$hub['specialAttr']; ?><? if ( $activeNodeIndex == $index ):?> active<? endif ?>">
				<span class="icon"></span>
				<span class="label"><?=$hub['text']; ?></span>
			</nav>
		<? endforeach ?>
	</div>
	<div class="hub-links">
		<?= $app->renderView('GlobalNavigation', 'hubsMenuSections', ['menuSections' => [$menuNodes[$activeNodeIndex]]]); ?>
	</div>
	<ul class="hub-more">
		<? foreach( $menuNodes as $index => $hub ): ?>
			<li class="<?=$hub['specialAttr']; ?>-more <? if ( $activeNodeIndex == $index ):?> active<? endif ?>">
				<a href="<?=$hub['href'];?>"><?= wfMessage('global-navigation-hubs-menu-more-of', $hub['text'])->parse(); ?></a>
			</li>
		<? endforeach ?>
	</ul>
</nav>
