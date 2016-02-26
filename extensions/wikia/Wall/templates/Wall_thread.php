<? 
if ($wg->EnableMiniEditorExtForWall) {
	echo $app->renderView('MiniEditorController', 'Setup');
}
?>

<?= $app->renderView('WallController', 'brickHeader', [ 'id' => ${WallConst::title}->getText() ] ); ?>
	
<div class="Wall <?= ${WallConst::type} ?>" id="Wall">
	<ul class="comments">
		<? foreach(${WallConst::threads} as $value): ?>
			<?= $app->renderView( 'WallController', 'message', [ 'isThreadPage' => true, 'condense' => ${WallConst::condenseMessage}, 'title' => ${WallConst::title}, 'replies' => $value->getRepliesWallMessages(), 'comment' => $value->getThreadMainMsg(), 'isreply' => false ] ); ?>
		<? endforeach; ?>
	</ul>
	<?= $app->renderPartial('Wall', 'TooltipMeta' ); ?>
</div>