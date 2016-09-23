<section id="WallMoveModal">
	<h1><?= wfMsg('wall-action-move-thread-heading') ?></h1>
<?
	$form = [
		'inputs' => [
			[
				'type' => 'select',
				'name' => 'destinationBoardId',
				'class' => 'destinationBoardId',
				'isRequired' => true,
				'label' => wfMsg('wall-action-move-board-label'),
				'options' => $destinationBoards,
			],
		],
		'method' => 'post',
		'action' => '',
	];

	echo $app->renderView('WikiaStyleGuideForm', 'index', [ 'form' => $form ] );
?>
</section>