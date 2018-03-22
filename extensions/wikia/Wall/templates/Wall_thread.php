<? 
if ($wg->EnableMiniEditorExtForWall) {
	echo $app->renderView('MiniEditorController', 'Setup');
}
?>
	
<div class="Wall <?= $type ?>" id="Wall">
	<ul class="comments">
		<?=
		/**
		 * @var bool $condenseMessage
		 * @var WallThread $thread
		 * @var WallMessage|null $threadMainMsg
		 */
		$app->renderView( 'WallController', 'message', [
			'isThreadPage' => true,
			'condense' => $condenseMessage,
			'replies' => $thread->getRepliesWallMessages(),
			'comment' => $threadMainMsg,
			'isreply' => false,
		] ); ?>
	</ul>
	<?= $app->renderPartial('Wall', 'TooltipMeta' ); ?>
</div>
