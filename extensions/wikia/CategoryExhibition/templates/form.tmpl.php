<div class="category-gallery-form">
	<? if ( $displayType == 'exhibition' ) { ?>
	<?= wfMessage( 'category-exhibition-sorttype' )->escaped(); ?>
	<?
		$dropdown = array();
		foreach ($sortTypes as $sortType) {
			$el = array();
			if($current == $sortType) {
				$el["class"] = "selected";
			}
			$el["href"] = Sanitizer::encodeAttribute( "$path?sort=$sortType&display=$displayType" );
			$el["id"] = Sanitizer::escapeId( "category-exhibition-form-$sortType" );
			$el["text"] = wfMessage( "category-exhibition-$sortType" )->escaped();
			$dropdown[] = $el;
		}
	?>
	<?= F::app()->renderView('MenuButton',
			'Index',
			array(
				'action' => array( "text" => wfMessage( 'category-exhibition-' . $current )->escaped(), "id" => "category-exhibition-form-current" ),
				'class' => 'secondary',
				'dropdown' => $dropdown,
				'name' => 'sortType'
			)
		) ?>
	<? } ?>
	<a title="<?= wfMessage( 'category-exhibition-display-old' )->escaped(); ?>" id="category-exhibition-form-new" href="<?= Sanitizer::encodeAttribute( $path . '?display=page&sort=' . urlencode( $current) ); ?>" ><div id="category-exhibition-display-old" <? if ( $displayType == 'page' ){ echo ' class="active"'; }?> ></div></a> | <a title="<?= wfMessage( 'category-exhibition-display-new' )->escaped(); ?>" id="category-exhibition-form-old" href="<?= Sanitizer::encodeAttribute( $path . '?display=exhibition&sort=' . urlencode( $current ) ); ?>" ><div id="category-exhibition-display-new" <? if ( $displayType == 'exhibition' ){ echo ' class="active"'; }?> ></div></a>
</div>
