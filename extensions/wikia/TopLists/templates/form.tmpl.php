<?php ?>
<form id="toplist-editor" name="toplist<?= $mode ;?>" method="POST" action="">
	<div class="ImageBrowser">
		<div class="frame">
			<div class="wrapper"><?= wfMsg( 'toplists-editor-image-browser-tooltip' ) ;?></div>
		</div>

		<a class="editsection wikia-chiclet-button" title="<?= wfMsg( 'toplists-editor-image-browser-tooltip' ); ?>" rel="nofollow">
			<img alt="<?= wfMsg( 'toplists-editor-image-browser-tooltip' ); ?>" src="<?= wfBlankImgUrl() ;?>">
		</a>

		<input type="hidden" name="selected_picture_name" value="<?= $selectedPictureName ;?>" />

		<? if ( !empty( $errors[ 'selected_picture_name' ] ) ) :?>
			<? foreach( $errors[ 'selected_picture_name' ] as $errorMessage ) :?>
				<p class="error"><?= $errorMessage ;?></p>
			<? endforeach ;?>
		<? endif ;?>
	</div>
	
	<div class="InputSet">
		<label for="list_name"><?= wfMsg( 'toplists-editor-title-label' ) ;?></label>
		<? if ( $mode == 'create' ) :?>
			<input type="text" name="list_name" placeholder="<?= wfMsg( 'toplists-editor-title-placeholder' ) ;?>"
				value="<?= $listName ;?>"<?= ( !empty( $errors[ 'list_name' ] ) ) ? ' class="error"' : null ;?> />
			<? if ( !empty( $errors[ 'list_name' ] ) ) :?>
				<? foreach( $errors[ 'list_name' ] as $errorMessage ) :?>
					<p class="error"><?= $errorMessage ;?></p>
				<? endforeach ;?>
			<? endif ;?>
		<? else :?>
			<big><strong><?= $listName ;?></strong></big>
		<? endif ;?>
	</div>

	<div class="InputSet AutoCompleteWrapper">
		<label for="related_article_name">
			<?= wfMsg( 'toplists-editor-related-article-label' ) ;?>
			&nbsp;
			<small>(<?= wfMsg( 'toplists-editor-related-article-optional-label' ) ;?>)</small>
		</label>

		<input type="text" name="related_article_name" placeholder="<?= wfMsg( 'toplists-editor-related-article-placeholder' ) ;?>"
			autocomplete="off" value="<?= $relatedArticleName ;?>"
			<?= ( !empty( $errors[ 'related_article_name' ] ) ) ? ' class="error"' : null ;?> />

		<? if ( !empty( $errors[ 'related_article_name' ] ) ) :?>
			<? foreach( $errors[ 'related_article_name' ] as $errorMessage ) :?>
				<p class="error"><?= $errorMessage ;?></p>
			<? endforeach ;?>
		<? endif ;?>
	</div>

	<ul class="ItemsList">
		<? foreach( $items as $position => $item ): ?>
			<? $isDraggable = ( in_array( $item['type'], array( 'new', 'template' ) ) ) ;?>
			<li class="ListItem<?= ( $isDraggable )  ? ' NewItem' : null ;?><?= ( $item['type'] == 'template' ) ? ' ItemTemplate' : null ;?>">
				<? if ( $item['type'] == 'existing' ) :?>
					<input type="hidden" value="<?= $item['index'] ;?>" />
				<? endif ;?>
				
				<div class="ItemNumber">#<?= ( $item['type'] != 'template' ) ? $position : null ;?></div>

				<div class="ItemName">
					<input type="text" name="items_names[]" value="<?= $item['value'] ;?>"
						<?= ( $item['type'] == 'template' ) ? ' disabled' : null ;?>
						<?= ( !empty( $errors[ "item_{$position}" ] ) ) ? ' class="error"' : null ;?> />
				</div>

				<div class="ItemRemove">
					<a title="<?= wfMsg( 'toplists-editor-remove-item-tooltip' ) ;?>" rel="nofollow">
						<img alt="<?= wfMsg( 'toplists-editor-remove-item-tooltip' ) ;?>" src="<?= wfBlankImgUrl() ;?>">
					</a>
				</div>

				<? if ( $isDraggable ) :?>
					<div class="ItemDrag">
						<a title="<?= wfMsg( 'toplists-editor-drag-item-tooltip' ) ;?>" rel="nofollow">
							<img alt="<?= wfMsg( 'toplists-editor-drag-item-tooltip' ) ;?>"
							     src="<?= wfBlankImgUrl() ;?>">
						</a>
					</div>
				<? endif ;?>

				<? if ( !empty( $errors[ "item_{$position}" ] ) ) :?>
					<? foreach( $errors[ "item_{$position}" ] as $errorMessage ) :?>
						<p class="error"><?=$errorMessage ;?></p>
					<? endforeach ;?>
				<? endif ;?>
			</li>
		<? endforeach ;?>
	</ul>

	<div class="AddControls">
		<a id="toplist-add-item" class="wikia-chiclet-button" title="<?= wfMsg( 'toplists-editor-add-item-tooltip' ) ;?>" rel="nofollow">
			<img alt="<?= wfMsg( 'toplists-editor-add-item-tooltip' ) ;?>" src="<?= wfBlankImgUrl() ;?>">
		</a>
		<label><?= wfMsg( 'toplists-editor-add-item-label' ) ;?></label>
	</div>

	<div class="FormButtons">
		<? if ( $mode == 'update' ) :?>
			<a class="wikia-button secondary" href="<?= $listUrl ;?>"><?= wfMsg( "toplists-cancel-button" ) ;?></a>
		<? endif ;?>
		
		<input type="Submit" value="<?= wfMsg( "toplists-{$mode}-button" ) ;?>"/>
	</div>

	<? if ( $mode == 'update' && !empty( $removedItems ) ) :?>
		<? foreach ( $removedItems as $item ) :?>
			<input type="hidden" name="removed_items[]" value="<?= $item ;?>" />
		<? endforeach ;?>
	<? endif ;?>
</form>