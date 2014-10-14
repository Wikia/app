<section id="EditBoardModal" class="EditBoardModal">
	<h1>
		<?= wfMessage( 'forum-admin-edit-board-modal-heading', $boardTitle )->escaped() ?>
	</h1>

<?
	$form = array(
		'inputs' => array(
			array(
				'type' => 'text',
				'name' => 'boardTitle',
				'value' => htmlspecialchars($boardTitle),
				'isRequired' => true,
				'label' => wfMessage( 'forum-admin-edit-board-title' )->escaped(),
				'attributes' => array(
					'maxlength' => '40'
				),
			),
			array(
				'type' => 'text',
				'name' => 'boardDescription',
				'value' => htmlspecialchars($boardDescription),
				'isRequired' => true,
				'label' => wfMessage( 'forum-admin-edit-board-description' )->escaped(),
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

	<div class="neutral modalToolbar">
		<button class="secondary cancel">
			<?= wfMessage( 'cancel' )->escaped() ?>
		</button>
		<button class="submit">
			<?= wfMessage( 'save' )->escaped() ?>
		</button>
	</div>
</section>
