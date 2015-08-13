<?php

class TemplateDraftHooks {

	public static function onSkinAfterBottomScripts( Skin $skin, &$text ) {
		$title = $skin->getTitle();
		if ( TemplateDraftHelper::allowedForTitle( $title ) ) {
			$scripts = AssetsManager::getInstance()->getURL( 'template_draft' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}

		return true;
	}

	/**
	 * Attaches a new module to right rail which is an entry point to convert a given template.
	 * @param array $railModuleList
	 * @return bool
	 */
	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgTitle;

		$helper = new TemplateDraftHelper();
		if ( $helper->isRailModuleAllowed( $wgTitle ) ) {
			$helper->addRailModule( $wgTitle, $railModuleList );
		}

		return true;
	}

	/**
	 * Triggered if a user edits a Draft subpage of a template.
	 * It pre-fills the content of the Draft with a converted markup.
	 * @param $text
	 * @param Title $title
	 * @return bool
	 */
	public static function onEditFormPreloadText( &$text, Title $title ) {
		$helper = new TemplateDraftHelper();

		if ( $helper->isTitleNewDraft( $title )
			&& TemplateConverter::isConversion()
		) {
			$parentTitleId = $helper->getParentTitle( $title )->getArticleID();

			if ( $parentTitleId > 0 ) {
				$parentContent = WikiPage::newFromID( $parentTitleId )->getText();


				/**
				 * TODO: Introduce a parameter to modify conversion flags
				 * If you want to perform different conversions, not only the infobox one,
				 * you can introduce a URL parameter to control the binary sum of flags.
				 */
				$controller = new TemplateDraftController();
				$text = $controller->createDraftContent(
					$title, // @TODO this is currently taking the *edited* title (with subpage), not the *converted* title
					$parentContent,
					TemplateClassification::TEMPLATE_INFOBOX
				);
			}
		}
		return true;
	}

	/**
	 * Triggered if a user edits a Draft subpage of a template.
	 * It adds an editintro message with help and links.
	 *
	 * @param Array $preloads
	 * @param Title $title
	 * @return bool
	 */
	public static function onEditPageLayoutShowIntro( &$preloads, Title $title ) {
		if ( $title->getNamespace() == NS_TEMPLATE ) {
			if ( TemplateDraftHelper::isTitleDraft( $title ) ) {
				$base = Title::newFromText( $title->getBaseText(), NS_TEMPLATE );
				$baseHelp = Title::newFromText( 'Help:PortableInfoboxes' );
				$preloads['EditPageIntro'] = [
					'content' => wfMessage( 'templatedraft-editintro' )->rawParams(
						Xml::element( 'a', [
							'href' => $baseHelp->getFullURL(),
							'target' => '_blank',
						],
							wfMessage( 'templatedraft-module-help' )->plain()
						),
						Xml::element( 'a', [
							'href' => $base->getFullUrl( [ 'action' => 'edit' ] ),
							'target' => '_blank'
						],
							wfMessage( 'templatedraft-module-view-parent' )->plain() )
					)->escaped(),
				];
			} elseif ( !TemplateDraftHelper::titleHasPortableInfobox( $title ) ) {
				$draft = wfMessage( 'templatedraft-subpage' )->inContentLanguage()->escaped();
				$base = Title::newFromText( $title->getBaseText() .'/'. $draft, NS_TEMPLATE );
				$draftUrl = $base->getFullUrl( [
					'action' => 'edit',
					TemplateConverter::CONVERSION_MARKER => 1,
				] );
				$preloads['EditPageIntro'] = [
					'content' => wfMessage( 'templatedraft-module-editintro-please-convert' )->rawParams(
						Xml::element( 'a', [
							'href' => $draftUrl,
							'target' => '_blank'
						],
							wfMessage( 'templatedraft-module-button-create' )->plain() )
					)->escaped(),
				];
			}
		}
		return true;
	}
}
