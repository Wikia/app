<? foreach($subNavMenuItems as $subNavIndex): ?>
	<? $subNavItem = $menuNodes[$subNavIndex] ?>
	<li>
		<a href="<?= $subNavItem['href'] ?>"><?= $subNavItem['text'] ?></a>
		<? if (!empty($subNavItem['children'])): ?>
			<ul class="catnav">
				<? foreach($subNavItem['children'] as $catNavIndex): ?>
					<? $catNavItem = $menuNodes[$catNavIndex] ?>
					<li><a href="<?= $catNavItem['href'] ?>"><?= $catNavItem['text'] ?></a></li>
				<? endforeach ?>
			</ul>
		<? endif ?>
	</li>
<? endforeach ?>