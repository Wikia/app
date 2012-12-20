<?php ?>
<form id="toplist-editor" name="toplist<?= $mode ;?>" method="POST" action="">
	<div class="ImageBrowser">
		<div class="frame">
			<div class="NoPicture"
				<?= ( !empty( $selectedImage ) ) ? 'style="display: none;"' : null ;?>
			     title="<?= wfMsg( 'toplits-image-browser-no-picture-selected' ) ;?>">
				<span>
					<?= wfMsg( 'toplists-editor-image-browser-tooltip' ) ;?>
				</span>
			</div>

			<? if ( !empty( $selectedImage ) ) :?>
				<img src="<?= $selectedImage[ 'url' ] ;?>"
				     alt="<?= $selectedImage[ 'name' ] ;?>"
				     title="<?= $selectedImage[ 'name' ] ;?>" />
			<? endif ;?>
		</div>

		<a class="wikia-chiclet-button" title="<?= wfMsg( 'toplists-editor-image-browser-tooltip' ); ?>" rel="nofollow">
			<img class="sprite photo" alt="<?= wfMsg( 'toplists-editor-image-browser-tooltip' ); ?>" src="<?= wfBlankImgUrl() ;?>">
		</a>

		<input type="hidden" name="selected_picture_name" value="<?= ( !empty( $selectedImage ) ) ? $selectedImage[ 'name' ] : null ;?>" />

		<? if ( !empty( $errors[ 'selected_picture_name' ] ) ) :?>
			<? foreach( $errors[ 'selected_picture_name' ] as $errorMessage ) :?>
				<p class="error"><?= $errorMessage ;?></p>
			<? endforeach ;?>
		<? endif ;?>
	</div>
	
	<div class="InputSet">
		<label for="list_name"><?= wfMsg( 'toplists-editor-title-label' ) ;?></label>
		<? if ( $mode == 'create' ) :?>
			<input type="text" name="list_name" id="list_name" placeholder="<?= wfMsg( 'toplists-editor-title-placeholder' ) ;?>"
				value="<?= $listName ;?>"<?= ( !empty( $errors[ 'list_name' ] ) ) ? ' class="error"' : null ;?> />
			<? if ( !empty( $errors[ 'list_name' ] ) ) :?>
				<? foreach( $errors[ 'list_name' ] as $errorMessage ) :?>
					<p class="error"><?= $errorMessage ;?></p>
				<? endforeach ;?>
			<? endif ;?>
		<? else :?>
			<big><strong><?= htmlspecialchars($listName) ;?></strong></big>
		<? endif ;?>
	</div>

	<div class="InputSet AutoCompleteWrapper">
		<label for="related_article_name">
			<?= wfMsg( 'toplists-editor-related-article-label' ) ;?>
		</label>

		<input type="text" id="related_article_name" name="related_article_name" placeholder="<?= wfMsg( 'toplists-editor-related-article-placeholder' ) ;?>"
			autocomplete="off" value="<?= $relatedArticleName ;?>"
			<?= ( !empty( $errors[ 'related_article_name' ] ) ) ? ' class="error"' : null ;?> />

		<? if ( !empty( $errors[ 'related_article_name' ] ) ) :?>
			<? foreach( $errors[ 'related_article_name' ] as $errorMessage ) :?>
				<p class="error"><?= $errorMessage ;?></p>
			<? endforeach ;?>
		<? endif ;?>
	</div>

    <div class="InputSet AutoCompleteWrapper">
        <label for="description">
            <?= wfMsg( 'toplists-editor-description-label' ) ;?>
        </label>

        <input type="text" id="description" name="description" placeholder="<?= wfMsg( 'toplists-editor-description-placeholder' ) ;?>"
               autocomplete="off" value="<?= htmlspecialchars( $description ); ?>"
            <?= ( !empty( $errors[ 'description' ] ) ) ? ' class="error"' : null ;?> />

        <? if ( !empty( $errors[ 'description' ] ) ) :?>
        <? foreach( $errors[ 'description' ] as $errorMessage ) :?>
            <p class="error"><?= $errorMessage ;?></p>
            <? endforeach ;?>
        <? endif ;?>
    </div>

	<ul class="ItemsList">
		<? foreach( $items as $position => $item ): ?>
			<?$isDraggable = $isDeletable = $isEditable = ( in_array( $item['type'], array( 'new', 'template' ) ) ) ;?>
			<li class="ListItem<?= ( $isDraggable )  ? ' NewItem' : null ;?><?= ( $item['type'] == 'template' ) ? ' ItemTemplate' : null ;?>">
				<? if ( $item['type'] == 'existing' && isset( $item['index'] ) ) :?>
					<input type="hidden" value="<?= $item['index'] ;?>" />
				<? endif ;?>
				
				<div class="ItemNumber">#<?= ( $item['type'] != 'template' ) ? $position : null ;?></div>

				<div class="ItemName">
					<? if ( $userCanEditItems || $isEditable ) :?>
						<input type="text" name="items_names[]" value="<?= htmlspecialchars($item['value']) ;?>"
							<?= ( $item['type'] == 'template' ) ? ' disabled' : null ;?>
							<?= ( !empty( $errors[ "item_{$position}" ] ) ) ? ' class="error"' : null ;?> />
					<? else :?>
						<div class="InputDisabled"><?= htmlspecialchars($item['value']) ;?></div>
						<input type="hidden" name="items_names[]" value="<?= htmlspecialchars($item['value']) ;?>" />
					<? endif ;?>
					
				</div>
				
				<? if ( $userCanDeleteItems || $isDeletable ) :?>
					<div class="ItemRemove">
						<a title="<?= wfMsg( 'toplists-editor-remove-item-tooltip' ) ;?>" rel="nofollow">
							<img class="sprite remove"
							     alt="<?= wfMsg( 'toplists-editor-remove-item-tooltip' ) ;?>"
							     src="<?= wfBlankImgUrl() ;?>" />
						</a>
					</div>
				<? endif ;?>

				<? if ( $isDraggable ) :?>
					<div class="ItemDrag">
						<a title="<?= wfMsg( 'toplists-editor-drag-item-tooltip' ) ;?>" rel="nofollow">
							<img class="sprite drag"
							     alt="<?= wfMsg( 'toplists-editor-drag-item-tooltip' ) ;?>"
							     src="<?= wfBlankImgUrl() ;?>" />
						</a>
					</div>
				<? endif ;?>

				<? if ( !empty( $errors[ "item_{$position}" ] ) ) :?>
					<? foreach( $errors[ "item_{$position}" ] as $errorMessage ) :?>
						<p class="error"><?= $errorMessage ;?></p>
					<? endforeach ;?>
				<? endif ;?>
			</li>
		<? endforeach ;?>
	</ul>

	<div class="AddControls">
		<a id="toplist-add-item" class="wikia-chiclet-button" title="<?= wfMsg( 'toplists-editor-add-item-tooltip' ) ;?>" rel="nofollow">
			<img class="sprite new" alt="<?= wfMsg( 'toplists-editor-add-item-tooltip' ) ;?>" src="<?= wfBlankImgUrl() ;?>">
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
