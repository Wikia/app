<div class="clearfix article-comm-edit-box">
	<div class="article-comm-input reset clearfix">
		<? if ( $wg->EnableMiniEditorExtForArticleComments ):
			echo $app->getView( 'MiniEditorController', 'Header', array(
				'attributes' => array(
					'data-min-height' => 100,
					'data-max-height' => 400
				)
			))->render();
		endif; ?>
		<form action="#" method="post" id="article-comm-reply-form-<?= $commentId ?>">
			<input type="hidden" name="wpParentId" value="<?= $commentId ?>" />
			<div class="article-comm-input-text">
				<? if ( $wg->EnableMiniEditorExtForArticleComments ):
					echo $app->getView( 'MiniEditorController', 'Editor_Header' )->render(); 
				endif; ?>
				<textarea name="wpArticleReply" id="article-comm-reply-textfield-<?= $commentId ?>"></textarea>
				<? if ( $wg->EnableMiniEditorExtForArticleComments ):
					echo $app->getView( 'MiniEditorController', 'Editor_Footer' )->render(); 
				endif; ?>
				<div class="buttons" data-space-type="buttons">
					<input type="submit" name="wpArticleSubmit" id="article-comm-reply-submit-<?= $commentId ?>" value="<? echo wfMsg('article-comments-post') ?>" />
					<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" />
				</div>
			</div>
		</form>
		<? if ( $wg->EnableMiniEditorExtForArticleComments ):
			echo $app->getView( 'MiniEditorController', 'Footer' )->render(); 
		endif; ?>
	</div>
</div>