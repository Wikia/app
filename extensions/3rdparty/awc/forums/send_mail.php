<?PHP
/**
* AWC`s Mediawiki Forum Extension
* 
* License: <br />
* Another Web Compnay (AWC) 
* 
* All of Another Web Company's (AWC) MediaWiki Extensions are licensed under<br />
* Creative Commons Attribution-Share Alike 3.0 United States License<br />
* http://creativecommons.org/licenses/by-sa/3.0/us/
* 
* All of AWC's MediaWiki extension's can be freely-distribute, 
*  no profit of any kind is allowed to be made off of or because of the extension itself, this includes Donations.
* 
* All of AWC's MediaWiki extension's can be edited or modified and freely-distribute <br />
*  but these changes must be made public and viewable noting the changes are not original AWC code. <br />
*  A link to http://anotherwebcom.com must be visable in the source code 
*  along with being visable in render code for the public to see.
* 
* You are not allowed to remove the Another Web Company's (AWC) logo, link or name from any source code or rendered code.<br /> 
* You are not allowed to create your own code which will remove or hide Another Web Company's (AWC) logo, link or name.
* 
* This License can and will be change with-out notice. 
* 
* All of Another Web Company's (AWC) software/code/programs are distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* 
* 4/2008 Another Web Compnay (AWC)<br />
* The above text must stay intact and not edited in any way.
* 
* @filepath /extensions/awc/forums/send_mail.php
* @package awcsForum
* @author Another Web Company
* @license http://wiki.anotherwebcom.com/AWC%27s_MediaWiki_Scripts_License
* @link http://wiki.anotherwebcom.com/Category:AWC's_MediaWiki_Forum_Extension
* 
*/



class awcsforum_mailer{


    function __construct(){
    global $awcs_forum_config;
    

        $this->post_in_email = $awcs_forum_config->cf_send_post_body_in_email ;
        $this->thread_in_email = $awcs_forum_config->cf_send_thread_body_in_email  ;
        $this->pm_in_email = $awcs_forum_config->cf_send_pm_body_in_email  ;
        
    }
    
    private function CleanTitle($str){
    	# do str_replace() instead of html_entity_decode() for security
    	 return str_replace(array('&amp;', '&quot;', '&#039;'), array('&', '"', '\'', '\''), $str);
    }


    function send_mail($email_addresses, $send_title, $send_body, $html = true){
    global $wgOutputEncoding, $wgPasswordSender, $wgVersion, $awcsf_css_output, $awcs_forum_config;
    
            $from_address = new MailAddress( $wgPasswordSender ); 
            
            # do str_replace() instead of html_entity_decode() for security
            $send_title = self::CleanTitle($send_title);
            $send_body = self::CleanTitle($send_body);
            
            
             /** @changeVer 2.5.8 older wiki's MailAddress() dont handle objects so split to string and pass that */
            foreach($email_addresses as $email){
				$addr = $email->address;
				$name = $email->name;
                
                if($addr == ''){
                     $addr =  $email;
                     $name = '';
                }
                
                $to_address[] = new MailAddress( $addr, $name );
            }
            
            $contentType = ($html) ? 'text/html; charset='.$wgOutputEncoding : null ;
            
            $reply_address = null;
            
            wfRunHooks( 'awcsforum_send_mail', array(&$to_address, &$from_address, &$send_title, &$awcsf_css_output, &$send_body, &$reply_address, &$contentType ) ); // 2.5.5
            
            
            if($html){
                global $wgServer;
                
                $str_find = array('href="/', 'src="/');
                $str_replace = array('href="' . $wgServer . '/', 'src="' . $wgServer . '/');   
                
                $awcsf_css_output = str_replace($str_find, $str_replace, $awcsf_css_output);
                
                $send_body = str_replace($str_find, $str_replace, $send_body);
                
   
                    $send_body = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
                                    <head>
                                        $awcsf_css_output
                                    </head>
                                        <body>$send_body</body>
                                    </html>";
            }
            
            
            if(version_compare($wgVersion, '1.14.0', '>=')){
                UserMailer::send( $to_address, $from_address, $send_title, $send_body, $reply_address, $contentType ) ;
            } else {
                // use the copied (below) 1.14 class
                mw_UserMailer::send( $to_address, $from_address, $send_title, $send_body, $reply_address, $contentType ) ;
            }
    
    }
    

    function check_msg_len($msg, $len){
    
                       
            if (function_exists('mb_strlen')) {
                $str_len = 'awc_mbstrlen'  ; 
            } else {
                $str_len = 'awcsforum_funcs::awc_strlen' ;
            }
            
             
            if($str_len($msg) > $len AND $len != '0'){
                
                if (function_exists('mb_substr')) {
                    $msg = awcsforum_funcs::awc_shorten($msg, $len); 
                } else {
                    $msg = substr($msg, 0, $len); 
                }
                
            }
            
            
            require_once(awc_dir . 'includes/post_phase.php');
            
            $post_phase = new awcs_forum_post_phase();
            $post_phase->convert_wTitle = 0;
            $post_phase->displaysmiles = 1;

             $msg = $post_phase->phase_post($msg, 0, false);
            
        return $msg;
        
    }

}







 // The following was taking from the MediaWiki 1.15 UserMailer.php file
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @author <brion@pobox.com>
 * @author <mail@tgries.de>
 * @author Tim Starling
 *
 */
 
 /**
 * Collection of static functions for sending mail
 */
class mw_UserMailer {
    /**
     * Send mail using a PEAR mailer
     */
    protected static function sendWithPear($mailer, $dest, $headers, $body)
    {
        $mailResult = $mailer->send($dest, $headers, $body);

        # Based on the result return an error string,
        if( PEAR::isError( $mailResult ) ) {
            wfDebug( "PEAR::Mail failed: " . $mailResult->getMessage() . "\n" );
            return new WikiError( $mailResult->getMessage() );
        } else {
            return true;
        }
    }

    /**
     * This function will perform a direct (authenticated) login to
     * a SMTP Server to use for mail relaying if 'wgSMTP' specifies an
     * array of parameters. It requires PEAR:Mail to do that.
     * Otherwise it just uses the standard PHP 'mail' function.
     *
     * @param $to MailAddress: recipient's email
     * @param $from MailAddress: sender's email
     * @param $subject String: email's subject.
     * @param $body String: email's text.
     * @param $replyto MailAddress: optional reply-to email (default: null).
     * @param $contentType String: optional custom Content-Type
     * @return mixed True on success, a WikiError object on failure.
     */
    static function send( $to, $from, $subject, $body, $replyto=null, $contentType=null ) {
        global $wgSMTP, $wgOutputEncoding, $wgErrorString, $wgEnotifImpersonal;
        global $wgEnotifMaxRecips;

        if (is_array( $wgSMTP )) {
            require_once( 'Mail.php' );

            $msgid = str_replace(" ", "_", microtime());
            if (function_exists('posix_getpid'))
                $msgid .= '.' . posix_getpid();

            if (is_array($to)) {
                $dest = array();
                foreach ($to as $u)
                    $dest[] = $u->address;
            } else
                $dest = $to->address;

            $headers['From'] = $from->toString();

            if ($wgEnotifImpersonal) {
                $headers['To'] = 'undisclosed-recipients:;';
            }
            else {
                $headers['To'] = implode( ", ", (array )$dest );
            }

            if ( $replyto ) {
                $headers['Reply-To'] = $replyto->toString();
            }
            $headers['Subject'] = wfQuotedPrintable( $subject );
            $headers['Date'] = date( 'r' );
            $headers['MIME-Version'] = '1.0';
            $headers['Content-type'] = (is_null($contentType) ?
                    'text/plain; charset='.$wgOutputEncoding : $contentType);
            $headers['Content-transfer-encoding'] = '8bit';
            $headers['Message-ID'] = "<$msgid@" . $wgSMTP['IDHost'] . '>'; // FIXME
            $headers['X-Mailer'] = 'MediaWiki mailer';

            // Create the mail object using the Mail::factory method
            $mail_object =& Mail::factory('smtp', $wgSMTP);
            if( PEAR::isError( $mail_object ) ) {
                wfDebug( "PEAR::Mail factory failed: " . $mail_object->getMessage() . "\n" );
                return new WikiError( $mail_object->getMessage() );
            }

            wfDebug( "Sending mail via PEAR::Mail to $dest\n" );
            $chunks = array_chunk( (array)$dest, $wgEnotifMaxRecips );
            foreach ($chunks as $chunk) {
                $e = self::sendWithPear($mail_object, $chunk, $headers, $body);
                if( WikiError::isError( $e ) )
                    return $e;
            }
        } else    {
            # In the following $headers = expression we removed "Reply-To: {$from}\r\n" , because it is treated differently
            # (fifth parameter of the PHP mail function, see some lines below)

            # Line endings need to be different on Unix and Windows due to
            # the bug described at http://trac.wordpress.org/ticket/2603
            if ( wfIsWindows() ) {
                $body = str_replace( "\n", "\r\n", $body );
                $endl = "\r\n";
            } else {
                $endl = "\n";
            }
            $ctype = (is_null($contentType) ? 
                    'text/plain; charset='.$wgOutputEncoding : $contentType);
            $headers =
                "MIME-Version: 1.0$endl" .
                "Content-type: $ctype$endl" .
                "Content-Transfer-Encoding: 8bit$endl" .
                "X-Mailer: MediaWiki mailer$endl".
                'From: ' . $from->toString();
            if ($replyto) {
                $headers .= "{$endl}Reply-To: " . $replyto->toString();
            }

            $wgErrorString = '';
            $html_errors = ini_get( 'html_errors' );
            ini_set( 'html_errors', '0' );
            set_error_handler( array( 'mw_UserMailer', 'errorHandler' ) );
            wfDebug( "Sending mail via internal mail() function\n" );

            if (function_exists('mail')) {
                if (is_array($to)) {
                    foreach ($to as $recip) {
                        $sent = mail( $recip->toString(), wfQuotedPrintable( $subject ), $body, $headers );
                    }
                } else {
                    $sent = mail( $to->toString(), wfQuotedPrintable( $subject ), $body, $headers );
                }
            } else {
                $wgErrorString = 'PHP is not configured to send mail';
            }

            restore_error_handler();
            ini_set( 'html_errors', $html_errors );

            if ( $wgErrorString ) {
                wfDebug( "Error sending mail: $wgErrorString\n" );
                return new WikiError( $wgErrorString );
            } elseif (! $sent) {
                //mail function only tells if there's an error
                wfDebug( "Error sending mail\n" );
                return new WikiError( 'mailer error' );
            } else {
                return true;
            }
        }
    }

    /**
     * Get the mail error message in global $wgErrorString
     *
     * @param $code Integer: error number
     * @param $string String: error message
     */
    static function errorHandler( $code, $string ) {
        global $wgErrorString;
        $wgErrorString = preg_replace( '/^mail\(\)(\s*\[.*?\])?: /', '', $string );
    }

    /**
     * Converts a string into a valid RFC 822 "phrase", such as is used for the sender name
     */
    static function rfc822Phrase( $phrase ) {
        $phrase = strtr( $phrase, array( "\r" => '', "\n" => '', '"' => '' ) );
        return '"' . $phrase . '"';
    }
}
