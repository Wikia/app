<?php
	/**
	 * Service helping to tweak images
	 *
	 * @author Artur Klajnerok <arturk(at)wikia-inc.com>
	 */
class ImageTweaksService extends WikiaService {

	public function getTag(){
		wfProfileIn( __METHOD__ );

		$imageHTML = $this->request->getVal('imageHTML');
		$align = $this->request->getVal('align');
		$width = $this->request->getVal('width');
		$showCaption = $this->request->getVal('showCaption', false);
		$caption = $this->request->getVal('caption', '');
		$zoomIcon = $this->request->getVal('zoomIcon', '');
		$showPictureAttribution = $this->request->getVal('showPictureAttribution', false);
		$attributeTo = $this->request->getVal('$attributeTo', null);

		$html = "<figure class=\"thumb" .
			( ( !empty( $align ) ) ? " t{$align}" : '' ) .
			" thumbinner\" style=\"width:{$width}px;\">{$imageHTML}{$zoomIcon}";

		if ( !empty( $showCaption ) ) {
			$html .= "<figcaption class=\"thumbcaption\">{$caption}";
		}

		//picture attribution
		if ( !empty( $showPictureAttribution ) && !empty( $attributeTo ) ) {
			wfProfileIn( __METHOD__ . '::PictureAttribution' );

			// render avatar and link to user page
			$avatar = AvatarService::renderAvatar( $attributeTo, 16 );
			$link = AvatarService::renderLink( $attributeTo );

			$html .= Xml::openElement( 'div', array( 'class' => 'picture-attribution' ) ) .
				$avatar .
				wfMessage('oasis-content-picture-added-by', $link, $attributeTo )->text() .
				Xml::closeElement( 'div' );

			wfProfileOut( __METHOD__ . '::PictureAttribution' );
		}

		if ( !empty( $showCaption ) ) {
			$html .= '</figcaption>';
		}

		$html .= '</figure>';

		$this->setVal( 'tag', $html );

		wfProfileOut( __METHOD__ );
	}

}