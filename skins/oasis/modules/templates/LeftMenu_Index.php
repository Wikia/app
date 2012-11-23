<ul class="left-menu-tabs grid-1 alpha">
	<? foreach ($menuItems as $menuItem): ?>
	<li<? if ($menuItem['selected']): ?> class="selected"<? endif ?>>
		<a href="<?=$menuItem['href']?>" title="<?=$menuItem['title']?>"><?=$menuItem['anchor']?></a>
	</li>
	<? endforeach ?>
</ul>