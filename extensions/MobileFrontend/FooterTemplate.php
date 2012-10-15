<?php

if ( !defined( 'MEDIAWIKI' ) ) {
        die( -1 );
}

class FooterTemplate extends MobileFrontendTemplate {

	public function getHTML() {

		$regularSite = $this->data['messages']['mobile-frontend-regular-site'];
		$permStopRedirect = $this->data['messages']['mobile-frontend-perm-stop-redirect'];
		$copyright = $this->data['messages']['mobile-frontend-copyright'];
		$disableImages = $this->data['messages']['mobile-frontend-disable-images'];
		$enableImages = $this->data['messages']['mobile-frontend-enable-images'];
		$leaveFeedback = $this->data['messages']['mobile-frontend-leave-feedback'];

		$leaveFeedbackURL = $this->data['leaveFeedbackURL'];
		$disableMobileSiteURL = $this->data['disableMobileSiteURL'];
		$viewNormalSiteURL = $this->data['viewNormalSiteURL'];

		if ( $this->data['disableImages'] == 0 ) {
			$imagesToggle = $disableImages;
			$imagesURL = $this->data['disableImagesURL'];
		} else {
			$imagesToggle = $enableImages;
			$imagesURL = $this->data['enableImagesURL'];
		}

		$logoutLink = ( $this->data['logoutHtml'] ) ? ' | ' . $this->data['logoutHtml'] : '';
		$logoutLink = ( $this->data['loginHtml'] ) ? ' | ' . $this->data['loginHtml'] : $logoutLink;

		$feedbackLink = ( $this->data['code'] == 'en' && $this->data['isBetaGroupMember'] ) ? "| <a href=\"{$leaveFeedbackURL}\">{$leaveFeedback}</a>" : '';

		$footerDisplayNone = ( $this->data['hideFooter'] ) ? ' style="display: none;" ' : '';

		$footerHtml = <<<HTML
			<div id='footer' {$footerDisplayNone}>
			  <div class='nav' id='footmenu'>
				<div class='mwm-notice'>
				  <a href="{$viewNormalSiteURL}">{$regularSite}</a> | <a href="{$imagesURL}">{$imagesToggle}</a> {$feedbackLink} {$logoutLink}
					<div id="perm">
						<a href="{$disableMobileSiteURL}">{$permStopRedirect}</a>
					</div>
				</div>
			  </div>
			  <div id='copyright'>{$copyright}</div>
			</div>

HTML;
	return $footerHtml;
}
}
