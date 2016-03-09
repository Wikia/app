<? 
if ($wg->EnableMiniEditorExtForWall) {
	echo $app->renderView('MiniEditorController', 'Setup');
}
?>

<?= $app->renderView('WallController', 'brickHeader', [ 'id' => $title->getText() ] ); ?>
	
<div class="Wall <?= $type ?>" id="Wall">
	<ul class="comments">
		<? foreach($threads as $value): ?>
			<?= $app->renderView( 'WallController', 'message', [ 'isThreadPage' => true, 'condense' => $condenseMessage, 'title' => $title, 'replies' => $value->getRepliesWallMessages(), 'comment' => $value->getThreadMainMsg(), 'isreply' => false ] ); ?>
		<? endforeach; ?>
	</ul>
	<?= $app->renderPartial('Wall', 'TooltipMeta' ); ?>
</div>