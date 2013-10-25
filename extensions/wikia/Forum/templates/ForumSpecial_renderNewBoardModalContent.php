<div id="EditBoardModal" class="EditBoardModal">
<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-create-new-board-title'),
				'attributes' => array(
					'maxlength' => '40'
				),
			),
			array(
				'type' => 'text',
				'name' => 'boardDescription',
				'isRequired' => true,
				'label' => wfMsg('forum-admin-create-new-board-description'),
				'attributes' => array(
					'maxlength' => '255'
				),
			),
		),
		'method' => 'post',
		'action' => '',
	);

	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));
?>
</section>