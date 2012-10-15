<?php

/**
 * Object that wraps an operation list and other features concerning an article
 * page.
 *
 * @copyright INRIA-LORIA-ECOO project
 * @author muller jean-philippe & Morel Émile
 */
class DSMWPatch {

    private $mPatchId;
    private $mOperations = array();
    private $mPrevPatch;
    private $mCausal;
    private $mSiteId;
    private $mSiteUrl;
    private $mRemote;
    private $mAttachment;
    private $mMime;
    private $mSize;
    private $mUrl;
    private $mDate;
    private $mID;

    /**
     *
     * @param <bool> $remote
     * @param <bool> $attachment
     * @param <array> $operations
     * @param <string> $siteUrl
     * @param <array> $causalLink
     * @param <string> $patchid
     * @param <string> $previousPatch
     * @param <string> $siteID
     * @param <string> $Mime
     * @param <string> $Size
     * @param <string> $Url
     * @param <string> $Date
     */
    public function __construct( $remote, $attachment, $operations, $siteUrl = '', $causalLink = '', $patchid = '', $previousPatch = '', $siteID = '', $Mime = '', $Size = '', $Url = '', $Date = '' ) {
        global $wgServer;
        
        $this->mRemote = $remote;
        $this->mID = utils::generateID();
        
        if ( $remote == true ) {
            $this->mPatchId = $patchid;
            $this->mSiteId = $siteID;
            $this->mID = $patchid;
        } else {
            $this->mPatchId = "Patch:" . $this->mID;
            $this->mSiteId = DSMWSiteId::getInstance()->getSiteId();
        }
        
        $this->mOperations = $operations;
        $this->mPrevPatch = $previousPatch;
        $this->mSiteUrl = $siteUrl;
        $this->mCausal = $causalLink;

        $this->mAttachment = $attachment;
        if ( $attachment == true ) {
            $this->mMime = $Mime;
            $this->mSize = $Size;
            if ( $remote ) {
                $this->mDate = $Date;
                $this->mUrl = $Url;
            }
            else {
                $this->mDate = date( DATE_RFC822 );
                $this->mPatchId = "Patch:ATT" . $this->mID;
                $this->mUrl = $wgServer . $Url;
                $this->mID = "Patch:ATT" . $this->mID;
            }
        }
    }

    public function storePage( $pageName, $rev ) {
        global $wgUser;
        $text = '
[[Special:ArticleAdminPage|DSMW Admin functions]]

==Features==
[[patchID::' . $this->mPatchId . '| ]]

\'\'\'SiteID:\'\'\' [[siteID::' . $this->mSiteId . ']]

\'\'\'SiteUrl:\'\'\' [[siteUrl::' . $this->mSiteUrl . ']]

\'\'\'Rev:\'\'\' [[Rev::' . $rev . ']]

';

        if ( $this->mRemote ) {
            $text .= '\'\'\'Remote Patch\'\'\'

';
        } else {
            $this->mPrevPatch = utils::getLastPatchId( $pageName );
            if ( $this->mPrevPatch == false ) {
                $this->mPrevPatch = "none";
            }
            $this->mCausal = utils::searchCausalLink( $pageName, $this->mCausal );
        }


        $text .= '\'\'\'Date:\'\'\' ' . date( DATE_RFC822 ) . '

';
        if ( $this->mAttachment ) {
            $text .= '\'\'\'Date of upload of the Attachment:\'\'\' [[DateAtt::' . $this->mDate . ']]

\'\'\'Mime:\'\'\' [[Mime::' . $this->mMime . ']]

\'\'\'Size:\'\'\' [[Size::' . $this->mSize . ']]

\'\'\'Url:\'\'\' [[Url::' . $this->mUrl . ']]

';
        }
        $text .= '\'\'\'User:\'\'\' ' . $wgUser->getName() . '

This is a patch of the article: [[onPage::' . $pageName . ']] <br>

';
        if ( $this->mAttachment == false ) {
            $text .= '==Operations of the patch==

{| class="wikitable" border="1" style="text-align:left; width:80%;"
|-
!bgcolor=#c0e8f0 scope=col | Type
!bgcolor=#c0e8f0 scope=col | Content
|-
';
            if ( $this->mRemote == true ) {
                foreach ( $this->mOperations as $op ) {
                    $opArr = explode( ";", $op );
                    $text .= '|[[hasOperation::' . $op . '| ]]' . $opArr[1] . '
|<nowiki>' . utils::contentDecoding( $opArr[3] ) . '</nowiki>
|-
';
                }
            } else {
                $i = 1; // op counter
                foreach ( $this->mOperations as $operation ) {
                    $lineContent = $operation->getLineContent();
                    $lineContent1 = utils::contentEncoding( $lineContent ); // base64 encoding
                    $type = $operation instanceof LogootIns ? 'Insert' : 'Delete';

                    $operationID = utils::generateID();
                    $text .= '|[[hasOperation::' . $operationID . ';' . $type . ';'
                            . $operation->getLogootPosition()->toString() . ';' . $lineContent1 . '| ]]' . $type;

                    // displayed text
                    $lineContent2 = $lineContent;
                    $text .= '
|<nowiki>' . $lineContent2 . '</nowiki>
|-
';
                }
            }

            $text .= '|}';
        }
        if ( is_array( $this->mPrevPatch ) ) {
            $text .= '

==Previous patch(es)==
[[previous::';
            foreach ( $this->mPrevPatch as $prev ) {
                $text .= $prev . ';';
            }
            $text .= ']]';
        } else {
            $text .= '

==Previous patch(es)==
[[previous::' . $this->mPrevPatch . ']]';
        }
        $text .= '

==Causal Link==
[[causal::' . $this->mCausal . ']]';

        $title = Title::newFromText( $this->mID, PATCH );
        $article = new Article( $title );
        $article->doEdit( $text, $summary = "" );
    }

    protected function splitLine( $line ) {
    	return implode( '<br>', str_split( $line, 150 ) ) . '<br />';
    }

}
