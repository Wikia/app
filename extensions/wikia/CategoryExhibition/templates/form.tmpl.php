<div class="category-gallery-form">
	<? if ( $displayType == 'exhibition' ) { ?>
	<?=wfMsg('category-exhibition-sorttype'); ?>
	<?
		$dropdown = array();
		foreach ($sortTypes as $sortType) {
			$el = array();
			if($current == $sortType) {
				$el["class"] = "selected";
			}
			$el["href"] = "$path?sort=$sortType&display=$displayType";
			$el["id"] = "category-exhibition-form-$sortType";
			$el["text"] = wfMsg("category-exhibition-$sortType");
			$dropdown[] = $el;
		}
	?>
	<?= F::app()->renderView('MenuButton',
			'Index',
			array(
				'action' => array( "href" => $path, "text" => wfMsg('category-exhibition-'.$current), "id" => "category-exhibition-form-current" ),
				'class' => 'secondary',
				'dropdown' => $dropdown,
				'name' => 'sortType'
			)
		) ?>
	<? } ?>
	<a title="<?=wfMsg('category-exhibition-display-old'); ?>" id="category-exhibition-form-new" href="<?=$path; ?>?display=page&sort=<?=$current; ?>" ><div id="category-exhibition-display-old" <? if ( $displayType == 'page' ){ echo ' class="active"'; }?> ></div></a> | <a title="<?=wfMsg('category-exhibition-display-new'); ?>" id="category-exhibition-form-old" href="<?=$path; ?>?display=exhibition&sort=<?=$current; ?>" ><div id="category-exhibition-display-new" <? if ( $displayType == 'exhibition' ){ echo ' class="active"'; }?> ></div></a>
</div>
