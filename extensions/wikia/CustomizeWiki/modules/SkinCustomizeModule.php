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


class SkinCustomizeModule extends CustomizeModule {

    private $mPosition;

    /**
     * construct
     *
     * @access public
     * @author eloy@wikia
     */
    public function __construct( $position = null )
    {
        $this->mPosition = $position;
    }

    public function getHTML( &$title )
    {
        global $wgCityId, $wgDefaultSkin, $wgDefaultTheme;


        $oTmpl = new EasyTemplate( dirname( __FILE__ ) );
        $oTmpl->set_vars( array(
            "next" => $this->getNext(),
            "title"  => $title,
            "module" => $this,
            "themes" => Wikia::getThemesOfSkin(),
            "current" => isset($wgDefaultTheme) ? $wgDefaultTheme : "smoke",
            "postinfo" => $this->getPostInfo( true /*remove from $_SESSION */)
        ));

        return $oTmpl->execute( "SkinCustomizeModule" );
    }

    public function getLabel()
    {
        return "Default skin";
    }

    public function getName()
    {
        return "skin";
    }

    public function submit( &$request )
    {

        $sSkin =  $request->getVal("wpSkin", null);
        $sTheme =   $request->getVal("wpTheme", null);

        if ( !is_null( $sSkin ) && !is_null($sTheme) ) {
            #--- create empty object
            $oFakePrefs = new stdClass();
            $oFakePrefs->mAdminSkin = "{$sSkin}-{$sTheme}";
            $oFakePrefs->mTheme = null;
            SavePreferencesSkinChooser( $oFakePrefs );
            return new CustomizeModuleResponse( true, wfMsgForContent( "customizewiki_skinsuccess" ));
        }
        return new CustomizeModuleResponse( false, wfMsgForContent( "customizewiki_skinerror" ));
    }

    /**
     * getDefaultSkin
     *
     * return default skin & theme for wiki
     *
     * @access public
     * @author eloy@wikia
     *
     * @return string "skin-theme"
     */
    public function getDefaultSkin()
    {
        global $wgDefaultSkin, $wgDefaultTheme;
    }

};

#--- Add messages
global $wgMessageCache, $wgSkinCustomizeModuleMsgs;

$wgSkinCustomizeModuleMsgs = array();
$wgSkinCustomizeModuleMsgs["en"] = array(
    "customizewiki_skininfo" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur in ligula in massa fermentum dictum. Sed porta adipiscing lorem. Morbi pe
llentesque nibh in ante. Duis laoreet lacus fermentum tortor. Vivamus mattis tortor. Quisque et ante. Cum sociis natoque penatibus et magnis
dis parturient montes, nascetur ridiculus mus. Curabitur imperdiet dolor ac leo. Phasellus tincidunt. Proin diam justo, lobortis ut, volutpat
 sit amet, semper vel, massa. Proin blandit arcu eu dui porttitor ullamcorper. Integer velit. Nulla facilisi. Maecenas gravida neque.",
    "customizewiki_skinsuccess" => "Skin set.",
    "customizewiki_skinerror" => "Skin not set."
);

foreach( $wgSkinCustomizeModuleMsgs as $key => $value ) {
    $wgMessageCache->addMessages( $wgSkinCustomizeModuleMsgs[$key], $key );
}
