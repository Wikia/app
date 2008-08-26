<?php
class MyExtension extends SpecialPage
{
        function MyExtension() {
                SpecialPage::SpecialPage("MyExtension");
                self::loadMessages();
        }

        function execute( $par ) {
                global $wgRequest, $wgOut;
                
                $this->setHeaders();

                # Get request data from, e.g.
                $param = $wgRequest->getText('param');
                
                # Do stuff
                # ...

                # Output
                # $wgOut->addHTML( $output );
        }

        function loadMessages() {
                static $messagesLoaded = false;
                global $wgMessageCache;
                if ( $messagesLoaded ) return true;
                $messagesLoaded = true;

                require( dirname( __FILE__ ) . '/MyExtension.i18n.php' );
                foreach ( $allMessages as $lang => $langMessages ) {
                        $wgMessageCache->addMessages( $langMessages, $lang );
                }

				return true;
        }
}

