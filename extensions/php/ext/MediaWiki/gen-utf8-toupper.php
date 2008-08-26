<?php

require_once("includes/Utf8Case.php");

    function dump( $hash )
    {
            global $hash;
            foreach ( $hash as $lower => $upper )
            {
                    if ( strlen( $lower ) == 1 ) {
                            continue;
                    }
                    if ( strlen( $lower ) == 2 ) {
                            if ( ! isset( $s[dechex(ord($lower[0]))] ) ) {
                                    $s[dechex(ord($lower[0]))] = "\tswitch ( arg[1] ) {\n";
                            }
                            $s[dechex(ord($lower[0]))] .= "\tcase '\\x".dechex(ord($lower[1]))."':\n";
                            for ( $i=0; $i<strlen($upper); $i++ ) {
                                    $s[dechex(ord($lower[0]))] .= "\t\tstring[{$i}] = '\\x".dechex(ord($upper[$i]))."';\n";
                            }
                            $s[dechex(ord($lower[0]))] .= "\t\tstringskip = ".strlen($upper).";\n";
                            $s[dechex(ord($lower[0]))] .= "\t\targskip    = ".strlen($lower).";\n";
                            $s[dechex(ord($lower[0]))] .= "\t\tbreak;\n";
                            $end[dechex(ord($lower[0]))] = "\t}\n";
                    } else {
                            if ( isset( $s[dechex(ord($lower[0]))] ) ) {
                                    $s[dechex(ord($lower[0]))] .= " else ";
                            }
                            $s[dechex(ord($lower[0]))] .= "\tif ( arg[1] == '\\x".dechex(ord($lower[1]))."' ";
                            $l=strlen($lower);
                            for ($i=2; $i<$l; $i++) {
                                    $s[dechex(ord($lower[0]))] .= "&& arg[{$i}] == '\\x".dechex(ord($lower[$i]))."' ";
                            }
                            $s[dechex(ord($lower[0]))] .= ") {\n";
                            for ( $i=0; $i<strlen($upper); $i++ ) {
                                    $s[dechex(ord($lower[0]))] .= "\t\tstring[{$i}] = '\\x".dechex(ord($upper[$i]))."';\n";
                            }
                            $s[dechex(ord($lower[0]))] .= "\t\tstringskip = ".strlen($upper).";\n";
                            $s[dechex(ord($lower[0]))] .= "\t\targskip    = ".strlen($lower).";\n";
                            $s[dechex(ord($lower[0]))] .= "\t}";
                            $end[dechex(ord($lower[0]))] = "";
                    }
            }
            print "switch( arg[0] ) {\n";
            foreach ( $s as $key => $code ) {
                    print "case '\\x".$key."': \n".$s[$key]."\n".$end[$key]."\tbreak;\n";
            }
            print "}\n";
    }

dump( $wikiUpperChars );


