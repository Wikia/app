<?php

/**
 * @package MediaWiki
 * @subpackage CustomizeWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}


class LogoCustomizeModule extends CustomizeModule {

    private $mPosition;
    private $mLogoName = "Wiki_wide.png";

    /**
     * construct
     *
     * @access public
     * @author eloy@wikia
     */
    public function getHTML( &$title )
    {
        global $wgCityId;

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) );
        $oTmpl->set_vars( array(
            "title" => $title,
            "module" => $this,
            "postinfo" => $this->getPostInfo( true /*remove from $_SESSION */),
            "currentlogo" => $this->getCurrentLogo()
        ));
        return $oTmpl->execute( "LogoCustomizeModule" );
    }

    /**
     * getLabel
     *
     * get label for tab in tabview mode
     *
     * @access public
     *
     * @return string: label of module
     */
    public function getLabel()
    {
        return "Logo";
    }

    /**
     * getName
     *
     * get short name for module
     *
     * @access public
     *
     * @return string: label of module
     */
    public function getName()
    {
        return "logo";
    }

    /**
     * submit
     *
     * store data submited from form
     *
     * @access public
     *
     * @return CustomizeModuleResponse object
    */
    public function submit( &$request )
    {
        global $wgRequest;

        $bUploading = $wgRequest->getVal("wpSubmitUpload", null);
        if (! is_null($bUploading) ) {

            #--- upload file and return false for reloading form
            $oUploadForm = new AjaxUploadForm( $wgRequest );
            $aResponse = $oUploadForm->execute();

            return new CustomizeModuleResponse( false, wfMsgForContent("customlogo_error"));
        }
        return new CustomizeModuleResponse( true, wfMsgForContent("customizewiki_logouploadsuccess"));    
    }

    /**
     * private functions
     */

    /**
     * getCurrentLogo
     *
     * @access private
     * @author eloy@wikia
     *
     * @return Article with Image
     */
    public function getCurrentLogo()
    {
        $oImage = Image::newFromName( $this->mLogoName );
        return $oImage;
    }
};

#--- Add messages
global $wgMessageCache, $wgLogoCustomizeModuleMsgs;

$wgLogoCustomizeModuleMsgs = array();
$wgLogoCustomizeModuleMsgs["en"] = array(
    "customizewiki_logoinfo" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur in ligula in massa fermentum dictum. Sed porta adipiscing lorem. Morbi pe
llentesque nibh in ante. Duis laoreet lacus fermentum tortor. Vivamus mattis tortor. Quisque et ante. Cum sociis natoque penatibus et magnis
dis parturient montes, nascetur ridiculus mus. Curabitur imperdiet dolor ac leo. Phasellus tincidunt. Proin diam justo, lobortis ut, volutpat
 sit amet, semper vel, massa. Proin blandit arcu eu dui porttitor ullamcorper. Integer velit. Nulla facilisi. Maecenas gravida neque.",
    "customizewiki_logouploadsuccess" => "Success."
);

foreach( $wgLogoCustomizeModuleMsgs as $key => $value ) {
    $wgMessageCache->addMessages( $wgLogoCustomizeModuleMsgs[$key], $key );
}
