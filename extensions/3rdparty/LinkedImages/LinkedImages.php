<?php
/**
 * This file contains the main include file for the LinkedImage extension of
 * MediaWiki.
 *
 * Usage: require_once("path/to/LinkedImage.php"); in LocalSettings.php
 *
 * This extension requires MediaWiki 1.5 or higher.
 *
 * @author Alexander Kraus <kraus.alexander@gmail.com>
 * @author Alan Trick <alan.trick@twu.ca>
 * @copyright Public domain
 * @license Public domain
 * @package MediaWikiExtensions
 * @version 0.3
 */

/**
 * Register the LinkedImage extension with MediaWiki
 */
$wgExtensionFunctions[] = 'wfLinkedImage';
$wgExtensionCredits['parserhook'][] = array(
'name' => 'LinkedImage',
'author' => array( 'Alexander Kraus', 'Alan Trick' ),
'description' => 'Allows client-side clickable images with custom link targets etc. using <tt>&lt;linkedimage&gt;</tt> tag',
'url' => 'http://www.mediawiki.org/wiki/Extension:LinkedImage',
);

/**
 * Sets the tag that this extension looks for and the function by which it
 * operates
 */
function wfLinkedImage() {
    global $wgParser, $wgMessageCache;

    $wgMessageCache->addMessages( array(
    'linkedimage_nowikipage'=> 'LinkedImage: No link target specified! e.g. \'wikipage=Main_page\'',
    'linkedimage_noimg'     => 'LinkedImage: No image specified! e.g. \'img_src=Image:LinkedImage.png\''
    ) );
    $wgParser->setHook('linkedimage', 'renderLinkedImage');
}

function renderLinkedImage($input) {
    $img=new LinkedImage();

    $img->getBoxOption($img->wikipage,   $input,'wikipage');
    $img->getBoxOption($img->tooltip,    $input,'tooltip');
    $img->getBoxOption($img->img_src,    $input,'img_src');
    $img->getBoxOption($img->img_height, $input,'img_height');
    $img->getBoxOption($img->img_width,  $input,'img_width');
    $img->getBoxOption($img->img_alt,    $input,'img_alt');
    $img->getBoxOption($img->img_border, $input,'img_border');

    // render and return linked image ...
    return $img->render();
}

class LinkedImage {
    public $wikipage = '';
    public $tooltip = '';
    public $img_src = '';
    public $img_alt = '';
    public $img_height = '';
    public $img_width = '';
    public $img_border = '';

    private function getTooltipHTML() {
        if ($this->tooltip != '') {
            return " title='{$this->tooltip}''";
        } else return '';
    }
    public function getURL() {
        global $wgArticlePath, $wgParser;
        $page = str_replace('{{PAGENAMEE}}', $wgParser->mTitle->getSubpageUrlForm(), $this->wikipage);
        return str_replace( "$1", $page, $wgArticlePath);
    }
    public function getImg() {
        // alt and src are required, alt may be empty though
        $r = "<img src='{$this->image->getUrl()}' alt='{$this->img_alt}'";
        if ($this->img_width != '') $r .= " width='{$this->img_width}'";
        if ($this->img_height != '') $r .= " height='{$this->img_height}'";
        if ($this->img_border != '') $r .= " border='{$this->img_border}'";
        return $r . ' />';
    }

    public function render() {
        // sanity checking
        if ($this->wikipage == '') {
            return htmlspecialchars( wfMsg( 'linkedimage_nowikipage' ) );
        }
        if ($this->img_src == '') {
            return htmlspecialchars( wfMsg( 'linkedimage_noimg' ) );
        }
        // create mediawiki image object ...
        $this->image = new Image( Title::newFromText( $this->img_src ) );
        // return link
        return "<a href='{$this->getURL()}'{$this->getTooltipHTML()}>{$this->getImg()}</a>";
    }

    public function getBoxOption(&$value,&$input,$name) {
        if(preg_match("/^\s*$name\s*=\s*(.*)/mi",$input,$matches)) {
                    $value = htmlspecialchars($matches[1], ENT_QUOTES);
        }
   }
}
?>