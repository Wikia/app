<ul>
<?php foreach ( $list as $obj ) { ?>
	<li>
		<?php echo gettype($obj);?>
		<a href="<?=SDElement::generateSpecialPageUrl($obj)?>">
		<?=$obj['name']?>
	    </a>
	</li>
<? } ?>
</ul>