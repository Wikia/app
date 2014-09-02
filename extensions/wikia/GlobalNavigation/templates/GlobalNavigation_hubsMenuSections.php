<? foreach( $menuSections as $sections ): ?>
<section class="<?= $sections['specialAttr'] ?>-links active">
	<? foreach( $sections['children'] as $category ): ?>
		<h2><?=$category['text']?></h2>
		<? foreach( $category['children'] as $node ): ?>
			<a href="<?=$node['href']?>"><?=$node['text']?></a>
		<? endforeach ?>
	<? endforeach ?>
</section>
<? endforeach ?>
