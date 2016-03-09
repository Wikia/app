<?php

// Build the modal's form with WikiaStyleGuideForm
$form = array(
	'inputs' => array(),
);

// cach shared html strings
$optionsHtml = '';
foreach ( $options as $label => $value ) {
	$optionsHtml .= "<option value='" . $value . "'>" . $label . "</option>";
}
$expiresLabel = '<label>' . wfMsg( 'chat-ban-modal-label-expires' ) . '</label>';

// Changing a ban
if ( $isChangeBan ) {
	$expiresRow = array(
		'type' => 'custom',
		'output' => $expiresLabel . '<p class="timeago" title="' . $isoTime . '" alt="' . $fmtTime . '">' . $fmtTime . '</p>',
	);
	$changeToRow = array(
		'type' => 'custom',
		'output' => '<label>' . wfMsg( 'chat-ban-modal-change-ban-label' ) . '</label><select name="expires"><option value="0">' . wfMsg( 'chat-ban-modal-end-ban' ) . '</option>' . $optionsHtml . '</select>',
	);
	array_push( $form['inputs'], $expiresRow, $changeToRow );

// Creating a new ban
} else {
	$expiresRow = array(
		'type' => 'custom',
		'output' => $expiresLabel . '<select name="expires">' . $optionsHtml . '</select>',
	);
	array_push( $form['inputs'], $expiresRow );
}

// Reason for creating / changing a ban
$reasonRow = array(
	'label' => wfMsg( 'chat-ban-modal-label-reason' ),
	'type' => 'text',
	'name' => 'reason',
	'attributes' => array(
		'maxlength' => 160,
		'placeholder' => $isChangeBan ? '' : wfMsg( 'chat-log-reason-banadd' ),
	),
);
array_push( $form['inputs'], $reasonRow );

// return the form HTML
echo F::app()->renderView( 'WikiaStyleGuideForm', 'index', array( 'form' => $form ) );
