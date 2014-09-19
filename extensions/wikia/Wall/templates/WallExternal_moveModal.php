<section id="WallMoveModal">
	<h1><?= wfMsg('wall-action-move-thread-heading') ?></h1>
<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'select',
				'name' => 'destinationBoardId',
				'class' => 'destinationBoardId',
				'isRequired' => true,
				'label' => wfMsg('wall-action-move-board-label'),
				'options' => $destinationBoards,
			),
		),
		'method' => 'post',
		'action' => '',
	);

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
</section>