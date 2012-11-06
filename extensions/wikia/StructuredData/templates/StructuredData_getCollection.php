<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
		<a href="<?=SDElement::generateSpecialPageUrl($obj)?>">
		<?=$obj['name']?>
	    </a>
	</li>
<? } ?>
</ul>