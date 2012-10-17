<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
		<?php if(!empty($obj['url'])): ?>
			<?php if (is_array($obj['url'])) : ?>
				<a href="/wiki/Special:StructuredData/<?=$obj['url'][0]?>">
			<?php else : ?>
				<a href="/wiki/Special:StructuredData/<?=$obj['url']?>">
			<? endif; ?>
		<?php else: ?>
			<a href="?method=showObject&id=<?=$obj['id']?>">
		<?php endif; ?>
		<?=$obj['name']?>
	    </a>
	</li>
<? } ?>
</ul>