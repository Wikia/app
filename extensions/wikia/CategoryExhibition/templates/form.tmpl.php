<div class="category-gallery-form">
	<?=wfMsg('category-exhibition-sorttype'); ?>
	<ul class="wikia-menu-button secondary">
		<li>
			<a id="category-exhibition-form-current" href="<?=$path; ?>"><?=wfMsg('category-exhibition-'.$current); ?></a>
			<img src="http://images1.wikia.nocookie.net/__cb27571/common/skins/common/blank.gif" class="chevron">
			<ul style="min-width: 116px; ">
			<? foreach ( $sortTypes as $sortType ){?>
				<li<? if( $current==$sortType ){?> class="selected" <?}?>><a href="<?=$path; ?>?sort=<?=$sortType; ?>&display=<?=$displayType; ?>" id="category-exhibition-form-<?=$sortType; ?>"><?=wfMsg('category-exhibition-'.$sortType); ?></a></li>
			<? } ?>
			</ul>
		</li>
	</ul>
	<a title="<?=wfMsg('category-exhibition-display-old'); ?>" id="category-exhibition-form-new" href="<?=$path; ?>?display=page&sort=<?=$sortType; ?>" ><div id="category-exhibition-display-old" <? if ( $displayType == 'page' ){ echo ' class="active"'; }?> ></div></a> | <a title="<?=wfMsg('category-exhibition-display-new'); ?>" id="category-exhibition-form-old" href="<?=$path; ?>?display=exhibition&sort=<?=$sortType; ?>" ><div id="category-exhibition-display-new" <? if ( $displayType == 'exhibition' ){ echo ' class="active"'; }?> ></div></a>
</div>