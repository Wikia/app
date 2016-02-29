<?php

class CommunityPageExperimentHooks {
	public static function onPageHeaderIndexExtraButtons( $response ) {
		$context = RequestContext::getMain();

		if ( !$context->getUser()->isLoggedIn() && $context->getTitle()->inNamespace( NS_MAIN ) ) {
			$extraButtons = $response->getVal( 'extraButtons' );

			$extraButtons[] = Html::rawElement(
				'div',
				[
					'class' => 'community-page-entry-point',
					'id' => 'CommunityPageEntryPoint',
				],
				Html::element( 'span', [], $context->msg( 'communitypageexperiment-entry-join' )->plain() ) .
				Html::element(
					'a',
					[
						'class' => 'community-page-button',
						'href' => SpecialPage::getTitleFor( 'Community' )->getLocalURL(),
					],
					$context->msg( 'communitypageexperiment-entry-learn-more' )->plain()
				)
			);

			$output = $context->getOutput();
			$output->addModuleStyles( 'ext.communityPageExperimentEntryPoint' );
			$output->addModuleScripts( 'ext.communityPageExperimentEntryPoint' );

			$response->setVal( 'extraButtons', $extraButtons );
		}

		return true;
	}
}
