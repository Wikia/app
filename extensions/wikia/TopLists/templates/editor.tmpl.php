<?php ?>
<form id="toplist-editor" name="toplist<?= $mode ;?>" method="POST" action="">
	<div class="ImageBrowser">
		<div class="frame">
			<div class="NoPicture"
				<?= ( !empty( $selectedImage ) ) ? 'style="display: none;"' : null ;?>
				title="<?= wfMessage( 'toplits-image-browser-no-picture-selected' )->escaped(); ?>">
				<span>
					<?= wfMessage( 'toplists-editor-image-browser-tooltip' )->escaped(); ?>
				</span>
			</div>

			<? if ( !empty( $selectedImage ) ) :?>
				<img src="<?= Sanitizer::encodeAttribute( $selectedImage[ 'url' ] ); ?>"
				     alt="<?= Sanitizer::encodeAttribute( $selectedImage[ 'name' ] ); ?>"
				     title="<?= Sanitizer::encodeAttribute( $selectedImage[ 'name' ] ); ?>" />
			<? endif ;?>
		</div>

		<a class="wikia-chiclet-button" title="<?= wfMessage( 'toplists-editor-image-browser-tooltip' )->escaped(); ?>" rel="nofollow">
			<img class="sprite photo" alt="<?= wfMessage( 'toplists-editor-image-browser-tooltip' )->escaped(); ?>" src="<?= wfBlankImgUrl() ;?>">
		</a>

		<input type="hidden" name="selected_picture_name" value="<?= !empty( $selectedImage ) ? Sanitizer::encodeAttribute( $selectedImage[ 'name' ] ) : '' ;?>" />

		<? if ( !empty( $errors[ 'selected_picture_name' ] ) ) :?>
			<? foreach( $errors[ 'selected_picture_name' ] as $errorMessage ) :?>
				<p class="error"><?= $errorMessage ;?></p>
			<? endforeach ;?>
		<? endif ;?>
	</div>

	<div class="InputSet">
		<label for="list_name"><?= wfMessage( 'toplists-editor-title-label' )->escaped(); ?></label>
		<? if ( $mode == 'create' ) :?>
			<input type="text" name="list_name" id="list_name" placeholder="<?= wfMessage( 'toplists-editor-title-placeholder' )->escaped(); ?>"
				value="<?= Sanitizer::encodeAttribute( $listName ); ?>"<?= ( !empty( $errors[ 'list_name' ] ) ) ? ' class="error"' : '' ;?> />
			<? if ( !empty( $errors[ 'list_name' ] ) ) :?>
				<? foreach( $errors[ 'list_name' ] as $errorMessage ) :?>
					<p class="error"><?= $errorMessage ;?></p>
				<? endforeach ;?>
			<? endif ;?>
		<? else :?>
			<big><strong><?= htmlspecialchars( $listName ); ?></strong></big>
		<? endif ;?>
	</div>

	<div class="InputSet AutoCompleteWrapper">
		<label for="related_article_name">
			<?= wfMessage( 'toplists-editor-related-article-label' )->parse(); ?>
		</label>

		<input type="text" id="related_article_name" name="related_article_name" placeholder="<?= wfMessage( 'toplists-editor-related-article-placeholder' )->escaped(); ?>"
			autocomplete="off" value="<?= Sanitizer::encodeAttribute( $relatedArticleName ); ?>"
			<?= ( !empty( $errors[ 'related_article_name' ] ) ) ? ' class="error"' : '' ;?> />

		<? if ( !empty( $errors[ 'related_article_name' ] ) ) :?>
			<? foreach( $errors[ 'related_article_name' ] as $errorMessage ) :?>
				<p class="error"><?= $errorMessage ;?></p>
			<? endforeach ;?>
		<? endif ;?>
	</div>

    <div class="InputSet AutoCompleteWrapper">
        <label for="description">
            <?= wfMessage( 'toplists-editor-description-label' )->escaped(); ?>
        </label>

        <input type="text" id="description" name="description" placeholder="<?= wfMessage( 'toplists-editor-description-placeholder' )->escaped(); ?>"
               autocomplete="off" value="<?= Sanitizer::encodeAttribute( $description ); ?>"
            <?= ( !empty( $errors[ 'description' ] ) ) ? ' class="error"' : '' ;?> />

        <? if ( !empty( $errors[ 'description' ] ) ) :?>
        <? foreach( $errors[ 'description' ] as $errorMessage ) :?>
            <p class="error"><?= $errorMessage ;?></p>
            <? endforeach ;?>
        <? endif ;?>
    </div>

	<ul class="ItemsList">
		<? foreach( $items as $position => $item ): ?>
			<?$isDraggable = $isDeletable = $isEditable = ( in_array( $item['type'], array( 'new', 'template' ) ) ) ;?>
			<li class="ListItem<?= ( $isDraggable )  ? ' NewItem' : '' ;?><?= ( $item['type'] == 'template' ) ? ' ItemTemplate' : '' ;?>">
				<? if ( $item['type'] == 'existing' && isset( $item['index'] ) ) :?>
					<input type="hidden" value="<?= Sanitizer::encodeAttribute( $item['index'] ); ?>" />
				<? endif ;?>

				<div class="ItemNumber">#<?= ( $item['type'] != 'template' ) ? $position : '' ;?></div>

				<div class="ItemName">
					<? if ( $userCanEditItems || $isEditable ) :?>
						<input type="text" name="items_names[]" value="<?= Sanitizer::encodeAttribute( $item['value'] ); ?>"
							<?= ( $item['type'] == 'template' ) ? ' disabled' : '' ;?>
							<?= ( !empty( $errors[ "item_{$position}" ] ) ) ? ' class="error"' : '' ;?> />
					<? else :?>
						<div class="InputDisabled"><?= htmlspecialchars( $item['value'] ); ?></div>
						<input type="hidden" name="items_names[]" value="<?= Sanitizer::encodeAttribute( $item['value'] );?>" />
					<? endif ;?>

				</div>

				<? if ( $userCanDeleteItems || $isDeletable ) :?>
					<div class="ItemRemove">
						<a title="<?= wfMessage( 'toplists-editor-remove-item-tooltip' )->escaped(); ?>" rel="nofollow">
							<img class="sprite remove"
							     alt="<?= wfMessage( 'toplists-editor-remove-item-tooltip' )->escaped(); ?>"
							     src="<?= wfBlankImgUrl() ;?>" />
						</a>
					</div>
				<? endif ;?>

				<? if ( $isDraggable ) :?>
					<div class="ItemDrag">
						<a title="<?= wfMessage( 'toplists-editor-drag-item-tooltip' )->escaped(); ?>" rel="nofollow">
							<img class="sprite drag"
							     alt="<?= wfMessage( 'toplists-editor-drag-item-tooltip' )->escaped(); ?>"
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
		<a id="toplist-add-item" class="wikia-chiclet-button" title="<?= wfMessage( 'toplists-editor-add-item-tooltip' )->escaped(); ?>" rel="nofollow">
			<img class="sprite new" alt="<?= wfMessage( 'toplists-editor-add-item-tooltip' )->escaped(); ?>" src="<?= wfBlankImgUrl() ;?>">
		</a>
		<label><?= wfMessage( 'toplists-editor-add-item-label' )->escaped(); ?></label>
	</div>

	<div class="FormButtons">
		<? if ( $mode == 'update' ) :?>
			<a class="wikia-button secondary" href="<?= Sanitizer::encodeAttribute( $listUrl ); ?>"><?= wfMessage( 'toplists-cancel-button' )->escaped(); ?></a>
		<? endif ;?>

		<input type="Submit" value="<?= wfMessage( "toplists-{$mode}-button" )->escaped(); ?>"/>
	</div>

	<? if ( $mode == 'update' && !empty( $removedItems ) ) :?>
		<? foreach ( $removedItems as $item ) :?>
			<input type="hidden" name="removed_items[]" value="<?= Sanitizer::encodeAttribute( $item ); ?>" />
		<? endforeach ;?>
	<? endif ;?>
	<input type="hidden" name="wpEditToken" value="<?= Sanitizer::encodeAttribute( $token ); ?>" />
</form>
