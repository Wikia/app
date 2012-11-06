<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
		<a href="<?=SDElement::createSpecialPageUrl($obj)?>">
		<?=$obj['name']?>
	    </a>
	</li>
<? } ?>
</ul>