
<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
		<?php if(!empty($obj['url'])): ?>
			<a href="/wiki/Special:StructuredData/<?=$obj['url']?>">
		<?php else: ?>
			<a href="?method=showObject&id=<?=$obj['id']?>">
		<?php endif; ?>
		<?=$obj['name']?>
	    </a>
	</li>
<? } ?>
</ul>