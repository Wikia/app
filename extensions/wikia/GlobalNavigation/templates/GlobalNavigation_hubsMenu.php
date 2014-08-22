<a class="hubs-entry-point global-navigation-link"></a>
<nav id="hubs" class="hubs-menu">
	<div class="hubs">
		<? foreach($menuNodes as $index => $hub): ?>
			<nav data-vertical="<?=$hub['specialAttr']; ?>" class="<?=$hub['specialAttr']; ?><? if ( $activeNodeIndex == $index ):?> active<? endif ?>">
				<span class="icon"></span>
				<span class="label"><?=$hub['text']; ?></span>
			</nav>
		<? endforeach ?>
	</div>
	<div class="hub-links">
		<section class="<?= $menuNodes[$activeNodeIndex]['specialAttr'] ?>-links active">
			<? foreach($menuNodes[$activeNodeIndex]['children'] as $category): ?>
				<h2><?=$category['text']?></h2>
				<? foreach($category['children'] as $node): ?>
					<a href="<?=$node['href']?>"><?=$node['text']?></a>
				<? endforeach ?>
			<? endforeach ?>
		</section>
	</div>
</nav>
