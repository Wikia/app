<?php

/**
 * Represents a user-defined form.
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */
class SFForm {
	private $mFormName;
	private $mTemplates;
	private $mPageNameFormula;
	private $mCreateTitle;
	private $mEditTitle;
	private $mAssociatedCategory;

	static function create( $formName, $templates ) {
		$form = new SFForm();
		$form->mFormName = ucfirst( str_replace( '_', ' ', $formName ) );
		$form->mTemplates = $templates;
		$form->mAssociatedCategory = null;
		return $form;
	}

	function getFormName() {
		return $this->mFormName;
	}

	function setPageNameFormula( $pageNameFormula ) {
		$this->mPageNameFormula = $pageNameFormula;
	}

	function setCreateTitle( $createTitle ) {
		$this->mCreateTitle = $createTitle;
	}

	function setEditTitle( $editTitle ) {
		$this->mEditTitle = $editTitle;
	}

	function setAssociatedCategory( $associatedCategory ) {
		$this->mAssociatedCategory = $associatedCategory;
	}

	function creationHTML() {
		$text = "";
		foreach ( $this->mTemplates as $i => $ft ) {
			$text .= $ft->creationHTML( $i );
		}
		return $text;
	}

	function createMarkup() {
		$title = Title::makeTitle( SF_NS_FORM, $this->mFormName );
		$fs = SFUtils::getSpecialPage( 'FormStart' );
		$form_start_url = SFUtils::titleURLString( $fs->getTitle() ) . "/" . $title->getPartialURL();
		$form_description = wfMsgForContent( 'sf_form_docu', $this->mFormName, $form_start_url );
		$form_input = "{{#forminput:form=" . $this->mFormName;
		if ( !is_null( $this->mAssociatedCategory ) ) {
			$form_input .= "|autocomplete on category=" . $this->mAssociatedCategory;
		}
	       	$form_input .= "}}\n";
		$text = <<<END
<noinclude>
$form_description


$form_input
</noinclude><includeonly>

END;
		if ( !empty( $this->mPageNameFormula ) || !empty( $this->mCreateTitle ) || !empty( $this->mEditTitle ) ) {
			$text .= "{{{info";
			if ( !empty( $this->mPageNameFormula ) ) {
				$text .= "|page name=" . $this->mPageNameFormula;
			}
			if ( !empty( $this->mCreateTitle ) ) {
				$text .= "|create title=" . $this->mCreateTitle;
			}
			if ( !empty( $this->mEditTitle ) ) {
				$text .= "|edit title=" . $this->mEditTitle;
			}
			$text .= "}}}\n";
		}
		$text .= <<<END
<div id="wikiPreview" style="display: none; padding-bottom: 25px; margin-bottom: 25px; border-bottom: 1px solid #AAAAAA;"></div>

END;
		foreach ( $this->mTemplates as $template ) {
			$text .= $template->createMarkup() . "\n";
		}
		$free_text_label = wfMsgForContent( 'sf_form_freetextlabel' );
		$text .= <<<END
'''$free_text_label:'''

{{{standard input|free text|rows=10}}}


{{{standard input|summary}}}

{{{standard input|minor edit}}} {{{standard input|watch}}}

{{{standard input|save}}} {{{standard input|preview}}} {{{standard input|changes}}} {{{standard input|cancel}}}
</includeonly>

END;

		return $text;
	}

}
