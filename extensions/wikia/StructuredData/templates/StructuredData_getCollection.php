
<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
	    <a href="?method=showObject&id=<?=$obj['id']?>">
		<?=$obj['name']?>
	    </a>
	</li>
<? } ?>
</ul>