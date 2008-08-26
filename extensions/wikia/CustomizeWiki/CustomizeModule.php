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

/**
 * @name wgWikiaCustomizeModules
 */

global $wgWikiaCustomizeModules;
$wgWikiaCustomizeModules = array();

/**
 * base class for customize modules
 */
abstract class CustomizeModule {
    private $mName;

    public function __construct()
    {

    }

    /**
     * abstract methods, defined in extended classes
     */

    /**
     * getHTML
     *
     * create html page and return it as a string
     *
     * access public
     * @abstract
     *
     * @param Title $title, standard MW title object
     *
     * @return string HTML code
     */
    abstract public function getHTML( &$title );
    abstract public function getName();
    abstract public function getLabel();

    /**
     * submit
     *
     * submit form data back to module
     *
     * @access public
     * @abstract
     *
     * @param WebRequest $request, standard MW Request object
     *
     * @return boolean: true if post is successfull, false if not
     */
    abstract public function submit( &$request );

    /**
     * getNext
     *
     * simple wrapper for CustomizeWikiPage::nextModule
     *
     * @access public
     * @author eloy@wikia
     *
     * @return CustomizeModule object with next module
     */
    public function getNext()
    {
        return CustomizeWikiPage::nextModule( $this );
    }

    /**
     * getPostInfo
     *
     * get info about previous module post status
     *
     * @access public
     * @author eloy@wikia
     *
     * @param boolean $remove default false: remove info from session
     *
     * @return CustomizeModuleResponse object or null if empty
     */
    public function getPostInfo( $remove = false )
    {
        #--- get message (if any) from session
        $oPostInfo = isset($_SESSION["customizewiki_message"])
            ? $_SESSION["customizewiki_message"]
            : null;
        
        if ( !empty($remove) && isset( $_SESSION["customizewiki_message"] ) ) {
            unset($_SESSION["customizewiki_message"]);
        }
        return $oPostInfo;
    }
}

/**
 * CustomizeModuleResponse
 *
 * simple (so far) class with response. Contains fields: status, message.
 * all fields are public.
 *
 * class returned by  CustomizeModule->submit
 */
class  CustomizeModuleResponse
{
    public $status;
    public $message;
    
    public function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
    }
}

/**
 * extAddCustomizeModule
 *
 * Add module to customization modules
 *
 * @param string $file Filename containing task class
 * @param string $shortName Short name of task
 * @param string $className task class name
 *
 * @return void
 */
function extAddCustomizeModule( $file, $shortName, $className )
{
    global $wgWikiaCustomizeModules, $wgAutoloadClasses;

    $wgWikiaCustomizeModules[] = array( "name" => $shortName, "class" => $className );
    $wgAutoloadClasses[$className] = $file;
}
