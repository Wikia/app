<? foreach( $menuSections as $sections ): ?>
<section class="<?= $sections['specialAttr'] ?>-links active">
	<? foreach( $sections['children'] as $category ): ?>
		<h2><?=$category['text']?></h2>
		<? foreach( $category['children'] as $node ): ?>
			<a href="<?=$node['href']?>"><?=$node['text']?></a>
		<? endforeach ?>
	<? endforeach ?>
	<a class="more" href="<?= $sections['href']; ?>"><?= wfMessage('global-navigation-hubs-menu-more-of', $sections['text'])->parse(); ?></a>
</section>
<? endforeach ?>
