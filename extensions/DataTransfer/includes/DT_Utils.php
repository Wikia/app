<?php

/**
 * Utility functions for the Data Transfer extension.
 *
 * @author Yaron Koren
 */
class DTUtils  {

	static function printImportingMessage() {
		return "\t" . Xml::element( 'p', null, wfMsg( 'dt_import_importing' ) ) . "\n";
	}

	static function printFileSelector( $fileType ) {
		$text = "\n\t" . Xml::element( 'p', null, wfMsg( 'dt_import_selectfile', $fileType ) ) . "\n";
		$text .= <<<END
	<p><input type="file" name="file_name" size="25" /></p>

END;
		$text .= "\t" . '<hr style="margin: 10px 0 10px 0" />' . "\n";
		return $text;
	}

	static function printExistingPagesHandling() {
		$text = "\t" . Xml::element( 'p', null, wfMsg( 'dt_import_forexisting' ) ) . "\n";
		$existingPagesText = "\n\t" .
			Xml::element( 'input',
				array(
					'type' => 'radio',
					'name' => 'pagesThatExist',
					'value' => 'overwrite',
					'checked' => 'checked'
				) ) . "\n" .
			"\t" . wfMsg( 'dt_import_overwriteexisting' ) . "<br />" . "\n" .
			"\t" . Xml::element( 'input',
				array(
					'type' => 'radio',
					'name' => 'pagesThatExist',
					'value' => 'skip',
				) ) . "\n" .
			"\t" . wfMsg( 'dt_import_skipexisting' ) . "<br />" . "\n" .
			"\t" . Xml::element( 'input',
				array(
					'type' => 'radio',
					'name' => 'pagesThatExist',
					'value' => 'append',
				) ) . "\n" .
			"\t" . wfMsg( 'dt_import_appendtoexisting' ) . "<br />" . "\n\t";
		$text .= "\t" . Xml::tags( 'p', null, $existingPagesText ) . "\n";
		$text .= "\t" .  '<hr style="margin: 10px 0 10px 0" />' . "\n";
		return $text;
	}

	static function printImportSummaryInput( $fileType ) {
		$importSummaryText = "\t" . Xml::element( 'input',
			array(
				'type' => 'text',
				'id' => 'wpSummary', // ID is necessary for CSS formatting
				'class' => 'mw-summary',
				'name' => 'import_summary',
				'value' => wfMsgForContent( 'dt_import_editsummary', $fileType )
			)
		) . "\n";
		return "\t" . Xml::tags( 'p', null,
			wfMsg( 'dt_import_summarydesc' ) . "\n" .
			$importSummaryText ) . "\n";
	}

	static function printSubmitButton() {
		$formSubmitText = Xml::element( 'input',
			array(
				'type' => 'submit',
				'name' => 'import_file',
				'value' => wfMsg( 'import-interwiki-submit' )
			)
		);
		return "\t" . Xml::tags( 'p', null, $formSubmitText ) . "\n";
	}
}
