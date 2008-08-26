<?php

// WikiMedia Yahoo Extension Ver 1.0 (http://meta.wikimedia.org/wiki/Yahoo_extension)

// set up WikiMedia to react to the "<yahoo>" tag
$wgExtensionFunctions[] = "wfYahoo";
 
function wfYahoo() {
        global $wgParser;
        $wgParser->setHook( "yahoo", "RenderYahoo" );
}
 
 
// the function that reacts to "<yahoo>"
 
function RenderYahoo( $input, $argv ) {
    
// set your defaults for the style and action (addfriend, call or chat) (0, 1, 2, 3 and 4)

        $style_default = "2" ;
        $action_default = "chat" ;
    
// the varibles are: <skype style="$argv['style']" action="$argv['action']">$input</skpye>

// test to see if the optinal elements of the tags are set and supported. if not set them to the defaults

        if( isset( $argv['style'] ) ){
                $style = $argv['style'] ;
                if( !($style == "0" OR $style == "1" OR $style == "2" OR $style == "3" OR $style == "4" ) ){
                        $style = $style_default ;
                }
        } else {
                $style = $style_default ;
        }
     
        if( isset( $argv['action'] ) ){
                $action = $argv['action'] ;
                if( !($action == "addfriend" OR $action == "chat" OR $action == "call") ){
                        $action = $action_default ;
                }
        } else {
                $action = $action_default ;
        }
        
// set the url to the image and the style of the image
        switch( $style ){

                case "0":    
                        $image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=0" ' ;
                        $image .= ' style="border: none; width: 12px; height: 12px;" alt="My status" />' ;
                break;
                
                case "1":    
                        $image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=1" ' ;
                        $image .= ' style="border: none; width: 64px; height: 16px;" alt="My status" />' ;
                break;
                
                case "2":    
                        $image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=2" ' ;
                        $image .= ' style="border: none; width: 125px; height: 25px;" alt="My status" />' ;
                break;
                
                case "3":    
                        $image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=3" ' ;
                        $image .= ' style="border: none; width: 86px; height: 16px;" alt="My status" />' ;
                break;
                
                case "4":
                        $image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=4" ' ;
                        $image .= ' style="border: none; width: 12px; height: 12px;" alt="My status" />' ;                  
                break;

     }
     
// start the rendering the html outupt
     $output  = '<!-- MediaWiki extension http://meta.wikimedia.org/w/index.php?title=Yahoo_extension -->';
     $output .= '<a href="ymsgr:'.$input.'?'.$action.'">'.$image.'</a>';
     $output .= '<!-- end of Yahoo button -->';

// send the output to MediaWiki
     return $output;
}
?>