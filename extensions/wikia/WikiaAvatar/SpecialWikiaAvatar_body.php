<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzy¿aniak <eloy@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

#--- Add messages
global $wgMessageCache, $wgWikiaAvatarMessages;
foreach( $wgWikiaAvatarMessages as $key => $value ) {
    $wgMessageCache->addMessages( $wgWikiaAvatarMessages[$key], $key );
}

class WikiaAvatarUploadPage extends SpecialPage {

    var $mAvatar, $mTitle, $mPosted, $mCommitRemoved;

    #--- constructor

    public function __construct()
    {
        $this->mPosted = false;
        $this->mCommitRemoved = false;
        parent::__construct( "AvatarUpload" /*class*/); #--- restriction - user have to be logged
    }

    public function execute( $subpage )
    {
        global $wgUser, $wgOut, $wgRequest;

        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }
        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }
        if ( !$wgUser->isLoggedIn() ) {
            $this->displayRestrictionError();
            return;
        }

        #--- WikiaAvatar instance
        $this->mAvatar = new WikiaAvatar($wgUser->getID());

        #--- initial output
        $this->mTitle = Title::makeTitle( NS_SPECIAL, "AvatarUpload" );
        $wgOut->setPageTitle( wfMsg("avatarupload_pagetitle") );
        $wgOut->setRobotpolicy( "noindex,nofollow" );
        $wgOut->setArticleRelated( false );

        if ($wgRequest->getVal("action") === "upload") {
            $this->mPosted = true;
        }
        elseif ($wgRequest->getVal("action") === "remove") {
        	$this->mCommitRemoved = true;
        }
        $this->uploadForm();
    }

    private function uploadForm()
    {
        global $wgUser, $wgOut, $wgRequest;
        #---
		$iStatus = "";
		#---
        if ($this->mPosted) {
            $iStatus = wfWAvatarUpload($wgRequest, $wgUser);
        }

        if ($this->mCommitRemoved) {
			if ($wgUser->getID() !== 0)
			{
				//$this->mUser = $avUser;
				if (!$this->mAvatar->removeAllAvatarFile($wgUser->getID()))
				{
					$iStatus = "WMSG_REMOVE_ERROR";
				}
			}
		}

        $aLinks = array(
            0 => array( "name" => wfMsg('yourprofile'),  "link" => Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL()),
            1 => array( "name" => wfMsg('your_user_page'),  "link" => Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL()),
        );

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "title"     => $this->mTitle,
            "avatar"    => $this->mAvatar,
            "user"      => $wgUser,
            "links"     => $aLinks,
            "is_posted" => $this->mPosted,
            "status"    => $iStatus
        ));
        $wgOut->addHTML( $oTmpl->execute("upload-form") );

    }
};

class WikiaAvatarRemovePage extends SpecialPage {
    var $mAvatar, $mTitle, $mPosted, $mUser, $mCommitRemoved;

    #--- constructor
    public function __construct()
    {
        $this->mPosted = false;
        $this->mCommitRemoved = false;
        $this->mSysMsg = false;
        $this->mTitle = Title::makeTitle( NS_SPECIAL, "AvatarRemove" );
        parent::__construct( "AvatarRemove", 'avatarremove'); #--- restriction - user have to be logged
    }

    public function execute( )
    {
        global $wgUser, $wgOut, $wgRequest;

        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }
        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }
        if ( !$wgUser->isLoggedIn() ) {
            $this->displayRestrictionError();
            return;
        }
    	if ( !$wgUser->isAllowed( 'avatarremove' ) ) {
            $this->displayRestrictionError();
            return;
        }        

        $wgOut->setPageTitle( wfMsg("avatarupload_removeavatar") );

        if ($wgRequest->getVal("action") === "search_user") {
            $this->mPosted = true;
        }

        if ($wgRequest->getVal("action") === "remove_avatar")
        {
        	$this->mCommitRemoved = true;
		}

		$this->removeForm();
	}

    private function removeForm()
    {
        global $wgUser, $wgOut, $wgRequest;

        if ($this->mPosted) {
        	if ($wgRequest->getVal("av_user"))
        	{
        		$avUser = User::newFromName($wgRequest->getVal("av_user"));
        		if ($avUser->getID() !== 0)
        		{
        			$this->mAvatar = new WikiaAvatar($avUser->getID());
        			$this->mUser = $avUser;
				}
			}
		}

        if ($this->mCommitRemoved) {
        	if ($wgRequest->getVal("av_user"))
        	{
        		$avUser = User::newFromName($wgRequest->getVal("av_user"));
        		if ($avUser->getID() !== 0)
        		{
        			//$this->mUser = $avUser;
					$this->mAvatar = new WikiaAvatar($avUser->getID());
        			if (!$this->mAvatar->removeAllAvatarFile($avUser->getID()))
        			{
        				$this->iStatus = "WMSG_REMOVE_ERROR";
					}
        			$this->mUser = $avUser;
        			$this->mPosted = true;
				}
			}
		}


        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "title"     	=> $this->mTitle,
            "avatar"   	 	=> $this->mAvatar,
            "search_user"	=> $wgRequest->getVal("av_user"),
       		"user"			=> $this->mUser,
            "is_posted" 	=> $this->mPosted,
            "status"    	=> $iStatus
        ));
        $wgOut->addHTML( $oTmpl->execute("remove-form") );

    }
}

?>
