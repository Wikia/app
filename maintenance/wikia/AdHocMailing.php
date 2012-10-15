<?php
/**
 * Michał Roszka (Mix) <michal@wikia-inc.com>
 * 
 * Very simple ad-hoc email distribution.
 * 
 * Usage:
 * 
 * Edit the file according to your needs and run:
 * 
 * SERVER_ID=177 php AdHocMailing.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php
 */
$dir = realpath( dirname( __FILE__ ) . '/../' );
include "{$dir}/commandLine.inc";

class AdHocMailing {
    /**
     * The list of the recipients.
     */
    private $recipients;
    /**
     * The subject for the message.
     */
    private $subject;
    /**
     * The body of the message.
     */
    private $body;
    /**
     * The sender's email address.
     */
    private $from;
    /**
     * The reply-to email address.
     */
    private $replyTo;
    /**
     * Constructor
     */
    public function __construct( $recipients, $subject, $body, $from, $replyTo ) {
        $this->recipients = $recipients;
        $this->subject = $subject;
        $this->body = $body;
        $this->from = new MailAddress( $from );
        $this->replyTo = new MailAddress( $replyTo );
    }
    /**
     * The main method, creates
     */
    public function execute() {
        foreach ( $this->recipients as $recipient ) {
            echo "Sending to: {$recipient}... ";
            $to = new MailAddress( $recipient );
            $sent = UserMailer::send( $to, $this->from, $this->subject, $this->body, $this->replyTo, null );
            if ( $sent ) {
                echo "done!\n";
            } else {
                echo "failed!\n";
            }
        }
        return null;
    }
}

// The subject for the message.
$subject = 'Hello World!';

// The body of the message.
$body = array();
// text/plain
$body['text'] = <<<BODYTEXT
Hello World!
BODYTEXT;
// text/html
$body['html'] = <<<BODYHTML
<p>Hello World!</p>
BODYHTML;

// The list of recipients.
$recipients = array( 'john@example.com', 'jane@example.com' );

// The sender's address.
$from = 'mom@example.com';

// The reply-to address.
$replyTo = 'dad@example.com';

// Ready, steady...
$d = new AdHocMailing( $recipients, $subject, $body, $from, $replyTo );
// ... go!
$d->execute();
exit( 0 );
