<ul class="left-menu-tabs grid-1 alpha">
	<? foreach ($menuItems as $menuItem): ?>
	<li<? if ($menuItem['selected']): ?> class="selected"<? endif ?>>
		<a href="<?= Sanitizer::encodeAttribute( $menuItem['href'] ); ?>" title="<?= Sanitizer::encodeAttribute( $menuItem['title'] ); ?>"><?= htmlspecialchars( $menuItem['anchor'] ); ?></a>
	</li>
	<? endforeach ?>
</ul>
