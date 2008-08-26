<?php

class SpecialContributorsAddon extends SpecialContributors {
	public function getContributorsText() {
		global $wgUser, $wgLang, $wgTitle;
		$this->target = $wgTitle;
		$contribText = '';
		
		if( $this->target->exists() ) {
			$total = 0;
			$skin =& $wgUser->getSkin();
			$link = $skin->makeKnownLinkObj( $this->target );
			$contribText .= '<h2>' . wfMsgHtml( 'contributors-subtitle', $link ) . '</h2>';
			list( $contributors, $others ) = $this->getMainContributors();
			$contribText .=  '<ul>';
			foreach( $contributors as $username => $info ) {
				list( $id, $count ) = $info;
				$line = $skin->userLink( $id, $username ) . $skin->userToolLinks( $id, $username );
				$line .= ' [' . $wgLang->formatNum( $count ) . ']';
				$contribText .=  '<li>' . $line . '</li>' ;
			}
			$contribText .=  '</ul>';
			if( $others > 0 ) {
				$others = $wgLang->formatNum( $others );
				$contribText .=  wfMsgNoTrans( 'contributors-others-long', $others ) ;
			}
		} else {
			$contribText .=  '<p>' . htmlspecialchars( wfMsg( 'contributors-nosuchpage', $this->target->getPrefixedText() ) ) . '</p>';
		}
		return preg_replace('/"/','\"',$contribText);
	}
}
