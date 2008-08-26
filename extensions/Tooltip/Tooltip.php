<?php

$wgExtensionFunctions[]             = "wfToolTipExtension";
$wgHooks['LanguageGetMagic'][]      = 'wfTooltipParserFunction_Magic';
$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'ToolTip',
	'author'         => 'Paul Grinberg',
	'description'    => 'adds <nowiki><tooltip></nowiki> and <nowiki>{{#tooltip:}}</nowiki>tag',
	'descriptionmsg' => 'tooltip-desc',
	'version'        => '0.5.2',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Tooltip'] = $dir . 'Tooltip.i18n.php';

function wfToolTipExtension() {
    global $wgParser;
    global $wgOut;
    global $wgScriptPath;
    
    $output = <<< END
<style type="text/css">
    .xstooltip{
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 2;
        font: normal 8pt sans-serif;
        color: white;
        padding: 3px;
        border: solid 1px;
        background-repeat: repeat;
        background-image: url($wgScriptPath/images/ttbg.png);
    }
    .xstooltip_body{
        color: green;
    }
</style>
<script type= "text/javascript">
    function xstooltip_findPosX(obj) {
        var curleft = 0;
        if (obj.offsetParent) {
            while (obj.offsetParent){
                curleft += obj.offsetLeft;
                obj = obj.offsetParent;
            }
        } else if (obj.x)
            curleft += obj.x;
        return curleft - 200;
    }
    function xstooltip_findPosY(obj) {
        var curtop = 0;
        if (obj.offsetParent) {
            while (obj.offsetParent) {
                curtop += obj.offsetTop;
                obj = obj.offsetParent;
            }
        } else if (obj.y)
            curtop+= obj.y;
        return curtop - 25
    }
    function xstooltip_show(tooltipId, parentId, posX, posY) {
        it = document.getElementById(tooltipId);
        if (it.style.top == '' || it.style.top == 0) {
            if (it.style.left == '' || it.style.left == 0) {
                it.style.width = it.offsetWidth + 'px';
                it.style.height = it.offsetHeight + 'px';
                img = document.getElementById(parentId);
                x = xstooltip_findPosX(img) + posX;
                y = xstooltip_findPosY(img) + posY;
                if (x < 0 )
                    x = 0;
                if (x + it.offsetWidth > img.offsetParent.offsetWidth )
                    x = img.offsetParent.offsetWidth - it.offsetWidth - 1;
                it.style.top = y + 'px';
                it.style.left = x + 'px';
            }
        }
        it.style.visibility = 'visible';
    }
    function xstooltip_hide(id) {
        it = document.getElementById(id);
        it.style.visibility = 'hidden';
    }
</script>
END;
    $wgOut->addScript($output);
    $wgParser->setHook( "tooltip", "renderToolTip" );
    $wgParser->setFunctionHook( 'tooltip', 'wfTooltipParserFunction_Render' );
}

function wfTooltipParserFunction_Magic( &$magicWords, $langCode ) {
        # Add the magic word
        # The first array element is case sensitive, in this case it is not case sensitive
        # All remaining elements are synonyms for our parser function
        $magicWords['tooltip'] = array( 0, 'tooltip' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}

function wfTooltipParserFunction_Render( $parser, $basetext = '', $tooltiptext = '', $x = 0, $y = 0) {
    $output = renderToolTip($tooltiptext, array('text'=>$basetext, 'x'=>$x, 'y'=>$y), $parser);
    return array($output, 'nowiki' => false, 'noparse' => true, 'isHTML' => false);
}

function renderToolTip($input, $argv, &$parser) {
    $text = 'see tooltip';
    $xoffset = 0;
    $yoffset = 0;
    foreach ($argv as $key => $value) {
        switch ($key) {
            case 'text':
                $text = $value;
                break;
            case 'x':
                $xoffset = intval($value);
                break;
            case 'y':
                $yoffset = intval($value);
                break;
            default :
                wfDebug( __METHOD__ . ": Requested '$key ==> $value'\n" );
                break;
        }
    }

    $output = '';

    if ($input != '') {
        $tooltipid = uniqid('tooltipid');
        $parentid = uniqid('parentid');
        $output .= "<span id='$tooltipid' class='xstooltip'>" . $parser->unstrip($parser->recursiveTagParse($input),$parser->mStripState) . "</span>";
        $output .= "<span id='$parentid' class='xstooltip_body' onmouseover=\"xstooltip_show('$tooltipid', '$parentid', $xoffset, $yoffset);\" onmouseout=\"xstooltip_hide('$tooltipid');\">" . $parser->unstrip($parser->recursiveTagParse($text),$parser->mStripState) . "</span>";
    }

    return $output;
}

?>
