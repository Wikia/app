<?php
/**
 * A special page holding a form that allows the user to create a data-entry
 * form.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFCreateForm extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFCreateForm() {
		SpecialPage::SpecialPage( 'CreateForm' );
		wfLoadExtensionMessages( 'SemanticForms' );
	}

	function execute( $query ) {
		$this->setHeaders();
		doSpecialCreateForm();
	}
}

function doSpecialCreateForm() {
	global $wgOut, $wgRequest, $wgUser, $sfgScriptPath, $wgContLang;
	$db = wfGetDB( DB_SLAVE );

	wfLoadExtensionMessages( 'SemanticForms' );

	# get the names of all templates on this site
	$all_templates = array();
	$res = $db->select( 'page', 'page_title',
		array( 'page_namespace' => NS_TEMPLATE, 'page_is_redirect' => 0 ),
		array( 'ORDER BY' => 'page_title' ) );
	if ( $db->numRows( $res ) > 0 ) {
		while ( $row = $db->fetchRow( $res ) ) {
			$template_name = str_replace( '_', ' ', $row[0] );
			$all_templates[] = $template_name;
		}
	}

	$form_templates = array();
	$i = 1;
	$deleted_template_loc = null;

	# handle inputs
	$form_name = $wgRequest->getVal( 'form_name' );
	foreach ( $wgRequest->getValues() as $var => $val ) {
		# ignore variables that are not of the right form
		if ( strpos( $var, "_" ) != false ) {
			# get the template declarations and work from there
			list ( $action, $id ) = explode( "_", $var, 2 );
			if ( $action == "template" ) {
				# if the button was pressed to remove this
				# template, just don't add it to the array
				if ( $wgRequest->getVal( "del_$id" ) != null ) {
					$deleted_template_loc = $id;
				} else {
					$form_template = SFTemplateInForm::create( $val,
						$wgRequest->getVal( "label_$id" ),
						$wgRequest->getVal( "allow_multiple_$id" ) );
					$form_templates[] = $form_template;
				}
			}
		}
	}
	if ( $wgRequest->getVal( 'add_field' ) != null ) {
		$form_template = SFTemplateInForm::create( $wgRequest->getVal( 'new_template' ), "", false );
		$new_template_loc = $wgRequest->getVal( 'before_template' );
		if ( $new_template_loc === null ) { $new_template_loc = 0; }
		# hack - array_splice() doesn't work for objects, so we have to
		# first insert a stub element into the array, then replace that
		# with the actual object
		array_splice( $form_templates, $new_template_loc, 0, "stub" );
		$form_templates[$new_template_loc] = $form_template;
	} else {
		$new_template_loc = null;
	}

	# now cycle through the templates and fields, modifying each one
	# per the query variables
	foreach ( $form_templates as $i => $ft ) {
		foreach ( $ft->fields as $j => $field ) {
			// handle the change in indexing if a new template was
			// inserted before the end, or one was deleted
			$old_i = $i;
			if ( $new_template_loc != null ) {
				if ( $i > $new_template_loc ) {
					$old_i = $i - 1;
				} elseif ( $i == $new_template_loc ) {
					// it's the new template; it shouldn't
					// get any query string data
					$old_i = - 1;
				}
			} elseif ( $deleted_template_loc != null ) {
				if ( $i >= $deleted_template_loc ) {
					$old_i = $i + 1;
				}
			}
			$new_label = $wgRequest->getVal( "label_" . $old_i . "_" . $j );
			if ( $new_label )
				$field->template_field->label = $new_label;
			$input_type = $wgRequest->getVal( "input_type_" . $old_i . "_" . $j );
			$field->template_field->input_type = $input_type;
			if ( $wgRequest->getVal( "hidden_" . $old_i . "_" . $j ) == "hidden" ) {
				$field->is_hidden = true;
			}
			if ( $wgRequest->getVal( "restricted_" . $old_i . "_" . $j ) == "restricted" ) {
				$field->is_restricted = true;
			}
			if ( $wgRequest->getVal( "mandatory_" . $old_i . "_" . $j ) == "mandatory" ) {
				$field->is_mandatory = true;
			}
		}
	}
	$form = SFForm::create( $form_name, $form_templates );

	# if submit button was pressed, create the form definitions file, then redirect
	$save_page = $wgRequest->getCheck( 'wpSave' );
	$preview_page = $wgRequest->getCheck( 'wpPreview' );
	if ( $save_page || $preview_page ) {
		# validate form name
		if ( $form->form_name == "" ) {
			$form_name_error_str = wfMsg( 'sf_blank_error' );
		} else {
			# redirect to wiki interface
			$wgOut->setArticleBodyOnly( true );
			$title = Title::makeTitleSafe( SF_NS_FORM, $form->form_name );
			$full_text = $form->createMarkup();
			$text = SFUtils::printRedirectForm( $title, $full_text, "", $save_page, $preview_page, false, false, false, null, null );
			$wgOut->addHTML( $text );
			return;
		}
	}

	$text = '	<form action="" method="post">' . "\n";
	// set 'title' field, in case there's no URL niceness
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];
	$text .= '    <input type="hidden" name="title" value="' . $special_namespace . ':CreateForm">' . "\n";
	$text .= '	<p>' . wfMsg( 'sf_createform_nameinput' ) . ' ' . wfMsg( 'sf_createform_nameinputdesc' ) . ' <input size=25 name="form_name" value="' . $form_name . '">';
	if ( ! empty( $form_name_error_str ) )
		$text .= '	' . Xml::element( 'font', array( 'color' => 'red' ), $form_name_error_str );
	$text .= "</p>\n";

	$text .= $form->creationHTML();

	$text .= '	<p>' . wfMsg( 'sf_createform_addtemplate' ) . "\n";

	$select_body = "";
	foreach ( $all_templates as $template ) {
		$select_body .= "	" . Xml::element( 'option', array( 'value' => $template ), $template ) . "\n";
	}
	$text .= '	' . Xml::tags( 'select', array( 'name' => 'new_template' ), $select_body ) . "\n";
	// if a template has already been added, show a dropdown letting the
	// user choose where in the list to add a new dropdown
	if ( count( $form_templates ) > 0 ) {
		$before_template_msg = wfMsg( 'sf_createform_beforetemplate' );
		$text .= $before_template_msg;
		$select_body = "";
		foreach ( $form_templates as $i => $ft ) {
			$select_body .= "	" . Xml::element( 'option', array( 'value' => $i ), $ft->template_name ) . "\n";
		}
		$final_index = count( $form_templates );
		$at_end_msg = wfMsg( 'sf_createform_atend' );
		$select_body .= '	' . Xml::element( 'option', array( 'value' => $final_index, 'selected' => 'selected' ), $at_end_msg );
		$text .= Xml::tags( 'select', array( 'name' => 'before_template' ), $select_body ) . "\n";
	}

	// disable 'save' and 'preview' buttons if user has not yet added any
	// templates
	$disabled_text = ( count( $form_templates ) == 0 ) ? "disabled" : "";
	$save_button_text = wfMsg( 'savearticle' );
	$preview_button_text = wfMsg( 'preview' );
	$add_button_text = wfMsg( 'sf_createform_add' );
	$sk = $wgUser->getSkin();
	$ct = SpecialPage::getPage( 'CreateTemplate' );
	$create_template_link = $sk->makeKnownLinkObj( $ct->getTitle(), $ct->getDescription() );
	$text .= <<<END
	<input type="submit" name="add_field" value="$add_button_text"></p>
	<br />
	<div class="editButtons">
	<p>
	<input type="submit" id="wpSave" name="wpSave" value="$save_button_text" $disabled_text />
	<input type="submit" id="wpPreview" name="wpPreview" value="$preview_button_text" $disabled_text />
	</p>
	</div>

END;
	// explanatory message if buttons are disabled because no templates
	// have been added
	if ( count( $form_templates ) == 0 ) {
		$text .= "	" . Xml::element( 'p', null, "(" . wfMsg( 'sf_createtemplate_addtemplatebeforesave' ) . ")" );
	}
	$text .= <<<END
	</form>
	<hr /><br />

END;
	$text .= "	" . Xml::tags( 'p', null, $create_template_link . '.' );

	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen",
		'href' => $sfgScriptPath . "/skins/SF_main.css"
	) );
	$wgOut->addHTML( $text );
}
