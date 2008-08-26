<?php
 
// MediaWiki Skype Extension Ver 2.1a (http://www.mediawiki.org/wiki/Extension:Skype)
 
// set up MediaWiki to react to the "<skype>" tag
$wgExtensionFunctions[] = "wfSkype";
 
function wfSkype() {
        global $wgParser;
        $wgParser->setHook( "skype", "RenderSkype" );
}
 
 
// the function that reacts to "<skype>"
 
function RenderSkype( $input, $argv ) {
 
// set your defaults for the style and action (add, call or chat) (add, call, chat, ballon, bigclassic smallclassic, smallicon or mediumicon)
 
        $style_default = "bigclassic" ;
        $action_default = "chat" ;
 
// the varibles are: <skype style="$argv['style']" action="$argv['action']">$input</skpye>
 
// escape $input to prevent XSS
        $input = htmlspecialchars($input) ;
 
// test to see if the optinal elements of the tags are set and supported. if not set them to the defaults
 
        if( isset( $argv['style'] ) ){
                $style = $argv['style'] ;
                if ( ! in_array( $style, array( 'add' , 'chat', 'call', 'balloon', 'bigclassic', 'smallclassic', 'smallicon', 'mediumicon') ) ){
                        $style = $style_default ;
                }
        } else {
                $style = $style_default ;
        }
 
        if( isset( $argv['action'] ) ){
                $action = $argv['action'] ;
                if ( ! in_array( $action, array( 'add' , 'chat', 'call') ) ){
                        $action = $action_default ;
                }
        } else {
                $action = $action_default ;
        }
 
// set the url to the image and the stype of the image
        switch( $style ){
 
                case "add":
                        $image = '<img src="http://download.skype.com/share/skypebuttons/buttons/add_blue_transparent_118x23.png" ' ;
                        $image .= ' style="border: none; width: 118px; height: 23px;" alt="My status" />' ;
                break;
 
                case "chat":
                        $image = '<img src="http://download.skype.com/share/skypebuttons/buttons/chat_blue_transparent_97x23.png" ' ;
                        $image .= ' style="border: none; width: 97px; height: 23px;" alt="My status" />' ;
                break;
 
                case "call":
                        $image = '<img src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_70x23.png" ' ;
                        $image .= ' style="border: none; width: 70px; height: 23px;" alt="My status" />' ;
                break;
 
                case "balloon":
                        $image = '<img src="http://mystatus.skype.com/balloon/'.$input.'" ' ;
                        $image .= ' style="border: none; width: 150px; height: 60px;" alt="My status" />' ;
                break;
 
                case "bigclassic":
                        $image = '<img src="http://mystatus.skype.com/bigclassic/'.$input.'" ' ;
                        $image .= ' style="border: none; width: 182px; height: 44px;" alt="My status" />' ;
                break;
 
                case "smallclassic":
                        $image = '<img src="http://mystatus.skype.com/smallclassic/'.$input.'"' ;
                        $image .= ' style="border: none; width: 114px; height: 20px;" alt="My status" />' ;
                break;
                case "smallicon":
                        $image = '<img src="http://mystatus.skype.com/smallicon/'.$input.'"' ;
                        $image .= ' style="border: none; width: 16px; height: 16px;" alt="My status" />' ;
                break;
                case "mediumicon":
                        $image = '<img src="http://mystatus.skype.com/mediumicon/'.$input.'"' ;
                        $image .= ' style="border: none; width: 26px; height: 26px;" alt="My status" />' ;
                break;
     }
 
// start the rendering the html outupt
 
     $output  = '<!-- Skype "My status" button http://www.skype.com/go/skypebuttons -->';
     $output .= '<!-- MediaWiki extension http://www.mediawiki.org/w/index.php?title=Extension:Skype -->';
     $output .= '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>';
     $output .= '<a href="skype:'.$input.'?'.$action.'">'.$image.'</a>';
     $output .= '<!-- end of skype button -->';
 
// send the output to MediaWiki
     return $output;
}
?>
