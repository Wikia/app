
<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
	    <a href="?method=getObject&id=<?=$obj['id']?>">
		<?=$obj['name']?>
	    </a>
	</li>
<? } ?>
</ul>