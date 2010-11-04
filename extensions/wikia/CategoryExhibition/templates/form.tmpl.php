<div class="category-gallery-form">
	<?=wfMsg('category-exhibition-sorttype'); ?>
	<ul class="wikia-menu-button secondary">
		<li>
			<a href="<?=$path; ?>"><?=wfMsg('category-exhibition-'.$current); ?></a>
			<img src="http://images1.wikia.nocookie.net/__cb27571/common/skins/common/blank.gif" class="chevron">
			<ul style="min-width: 116px; ">
			<? foreach ( $sortTypes as $sortType ){?>
				<li<? if( $current==$sortType ){?> class="selected" <?}?>><a href="<?=$path; ?>?sort=<?=$sortType; ?>&display=<?=$displayType; ?>" data-id="<?=$sortType; ?>"><?=wfMsg('category-exhibition-'.$sortType); ?></a></li>
			<? } ?>
			</ul>
		</li>
	</ul>
	<a href="<?=$path; ?>?display=exhibition&sort=<?=$sortType; ?>" > new </a> | <a href="<?=$path; ?>?display=page&sort=<?=$sortType; ?>" > old </a>
</div>