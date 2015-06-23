<?php

/**
 * A class that contains all methods that are hooked to events occurring in the stack.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

namespace Flags;

class Hooks {

	const FLAGS_DROPDOWN_ACTION = 'flags';

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$helper = new FlagsHelper();
		/* Assets for flags view */
		if ( $helper->shouldDisplayFlags()
			|| $out->getTitle()->isSpecial( 'Flags' ) ) {
			\Wikia::addAssetsToOutput( 'flags_view_scss' );
		}
		/* Assets for flags edit form */
		if ( $helper->areFlagsEditable() ) {
			\Wikia::addAssetsToOutput( 'flags_editform_js' );
			$out->addModules( 'ext.wikia.Flags.EditFormMessages' );
		}
		return true;
	}

	/**
	 * Adds flags item to edit button dropdown. Flags item shows modal for editing flags for article.
	 * This is attached to the MediaWiki 'SkinTemplateNavigation' hook.
	 *
	 * @param SkinTemplate $skin
	 * @param array $links Navigation links
	 * @return bool true
	 */
	public static function onSkinTemplateNavigation( $skin, &$links ) {
		$helper = new FlagsHelper();
		if ( $helper->areFlagsEditable() ) {
			$links['views'][self::FLAGS_DROPDOWN_ACTION] = [
				'href' => '#',
				'text' => wfMessage( 'flags-edit-modal-title' )->escaped(),
				'class' => 'flags-access-class',
			];
		}
		return true;
	}

	/**
	 * Adds flags action to dropdown actions to enable displaying flags item on edit dropdown
	 * @param array $actions
	 * @return bool true
	 */
	public static function onPageHeaderDropdownActions( array &$actions ) {
		$helper = new FlagsHelper();
		if ( $helper->areFlagsEditable() ) {
			$actions[] = self::FLAGS_DROPDOWN_ACTION;
		}
		return true;
	}

	/**
	 * Hooks into the internalParse() process and injects a wikitext
	 * with notices for the given page.
	 * @param \Parser $parser
	 * @param string $text
	 * @param \StripState $stripState
	 * @return bool
	 */
	public static function onParserBeforeInternalParse( \Parser $parser, &$text, &$stripState ) {
		/**
		 * Don't check for flags if:
		 * - Parser is not used for the main content
		 * - Flags have already been parsed
		 * - a user is on an edit page
		 * - the request is from VE
		 */
		$helper = new FlagsHelper();
		if ( $parser->getOptions()->getIsMain()
			&& $parser->mFlagsParsed !== true
			&& $helper->shouldInjectFlags() ) {
			$addText = ( new \FlagsController )
				->getFlagsForPageWikitext( $parser->getTitle()->getArticleID() );

			if ( $addText !== null ) {
				$mwf = \MagicWord::get( 'flags' );
				if ( $mwf->match( $text ) ) {
					$text = $mwf->replace( $addText, $text );
				} else {
					$text = $addText . $text;
				}
			}

			$parser->mFlagsParsed = true;
		}

		return true;
	}
}
