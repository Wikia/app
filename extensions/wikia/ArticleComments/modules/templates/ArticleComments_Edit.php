<div class="article-comments clearfix">
<?php if ( $canEdit ): ?>
	<div class="article-comm-input reset clearfix">
		<? if ( $wg->EnableMiniEditorExtForArticleComments ):
			echo $app->getView( 'MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render();
		endif; ?>
		<form action="<?php echo $articleFullUrl; ?>" method="post" id="article-comm-form-<?=$articleId?>">
			<input type="hidden" name="wpArticleId" value="<?=$articleId?>" />
			<div class="article-comm-input-text">
				<? if ( $wg->EnableMiniEditorExtForArticleComments ):
					echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render(); 
				endif; ?>
				<textarea name="wpArticleComment" id="article-comm-textfield-<?=$articleId?>"><?=$comment?></textarea><br />
				<? if ( $wg->EnableMiniEditorExtForArticleComments ):
					echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render(); 
				endif; ?>
				<? if (!$isReadOnly) { ?>
					<div class="buttons">
						<input type="submit" class="actionButton" name="wpArticleSubmit" id="article-comm-submit-<?=$articleId?>" value="<? echo wfMsg('article-comments-post') ?>" />
						<input type="submit" class="actionButton" name="wpArticleCancel" id="article-comm-edit-cancel-<?=$articleId?>" class="wikia-button secondary" value="<? echo wfMsg('article-comments-cancel') ?>" />
						<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" />
					</div>
				<? } ?>
			</div>
		</form>
		<? if ( $wg->EnableMiniEditorExtForArticleComments ):
			echo $app->getView( 'MiniEditorController', 'Footer' )->render(); 
		endif; ?>
	</div>
<?php else: echo $comment; endif; ?>
</div>