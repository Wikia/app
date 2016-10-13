<?php

/**
 * Represents a user-defined form.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */
class SFForm {
	private $mFormName;
	private $mPageNameFormula;
	private $mCreateTitle;
	private $mEditTitle;
	private $mAssociatedCategory;
	private $mItems;

	static function create( $formName, $items ) {
		$form = new SFForm();
		$form->mFormName = ucfirst( str_replace( '_', ' ', $formName ) );
		$form->mAssociatedCategory = null;
		$form->mItems = $items;
		return $form;
	}

	function getFormName() {
		return $this->mFormName;
	}

	function getItems() {
		return $this->mItems;
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

	function createMarkup( $standardInputs = array(), $freeTextLabel = null ) {
		$title = Title::makeTitle( SF_NS_FORM, $this->mFormName );
		$fs = SpecialPageFactory::getPage( 'FormStart' );
		$form_start_url = SFUtils::titleURLString( $fs->getTitle() ) . "/" . $title->getPartialURL();
		$form_description = wfMessage( 'sf_form_docu', $this->mFormName, $form_start_url )->inContentLanguage()->text();
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
		foreach ( $this->mItems as $item ) {
			if ( $item['type'] == 'template' ) {
				$template = $item['item'];
				$text .= $template->createMarkup() . "\n";
			} elseif ( $item['type'] == 'section' ) {
				$section = $item['item'];
				$text .= $section->createMarkup() . "\n";
			}
		}

		if ( is_null( $freeTextLabel ) ) {
			$freeTextLabel = wfMessage( 'sf_form_freetextlabel' )->inContentLanguage()->text();
		}

		// Add in standard inputs if they were specified.
		if ( count( $standardInputs ) > 0 ) {
			if ( array_key_exists( 'free text', $standardInputs ) ) {
				$text .= "'''$freeTextLabel:'''\n\n";
				$text .= $standardInputs['free text'] . "\n\n\n";
			}
			if ( array_key_exists( 'summary', $standardInputs ) ) {
				$text .= $standardInputs['summary'] . "\n\n";
			}
			if ( array_key_exists( 'minor edit', $standardInputs ) ) {
				$text .= $standardInputs['minor edit'] . ' ';
			}
			if ( array_key_exists( 'watch', $standardInputs ) ) {
				$text .= $standardInputs['watch'];
			}
			if ( array_key_exists( 'minor edit', $standardInputs ) || array_key_exists( 'watch', $standardInputs ) ) {
				$text .= "\n\n";
			}
			if ( array_key_exists( 'save', $standardInputs ) ) {
				$text .= $standardInputs['save'] . ' ';
			}
			if ( array_key_exists( 'preview', $standardInputs ) ) {
				$text .= $standardInputs['preview'] . ' ';
			}
			if ( array_key_exists( 'changes', $standardInputs ) ) {
				$text .= $standardInputs['changes'] . ' ';
			}
			if ( array_key_exists( 'cancel', $standardInputs ) ) {
				$text .= $standardInputs['cancel'];
			}
		} else {
			$text .= <<<END
'''$freeTextLabel:'''

{{{standard input|free text|rows=10}}}


{{{standard input|summary}}}

{{{standard input|minor edit}}} {{{standard input|watch}}}

{{{standard input|save}}} {{{standard input|preview}}} {{{standard input|changes}}} {{{standard input|cancel}}}
END;
		}
		$text .= "\n</includeonly>\n";

		return $text;
	}

}
