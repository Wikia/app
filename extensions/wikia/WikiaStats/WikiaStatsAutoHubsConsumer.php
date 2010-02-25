<?php

/**
 * @package MediaWiki
 * @author Bartlomiej Lapinski <bartek@wikia.com> for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: whatever goes here
 */

/**
 * class that transfers data from Stomp queue into database
 */
class WikiaStatsAutoHubsConsumer {
        /**
         * constructor
         */
        function __construct( ) {
        }

	/**
	 * connect to Stomp, subscribe to queue, read frames, fire up functions
	 */
	public function receiveFromStomp() {
		global $wgStompServer, $wgStompUser, $wgStompPassword, $wgCityId;
		wfProfileIn( __METHOD__ );
		try {
			$stomp = new Stomp( $wgStompServer );
			$stomp->connect( $wgStompUser, $wgStompPassword );
			$stomp->setReadTimeout(120);		
		} catch( StompException $e ) {
			$mesg = $e->getMessage();			
			Wikia::log( __METHOD__, 'stomp_exception', $mesg );
			die( 'Stomp connection failed. Data logged. Message was: ' . $mesg  );
		}

		$stomp->subscribe('wikia.article.#', array(
				'exchange' => 'amq.topic',
				'ack' => 'client',
				'activemq.prefetchSize'	=> 1,
				'routing_key' => "wikia.article.#"
			)
		);
		Wikia::log( __METHOD__, 'Stomp_queue', 'Subscribed to queue successfully' );				

		while( 1 ) {
			$frame = $stomp->readFrame();
			Wikia::log( __METHOD__, 'Stomp_frame', 'Frame was read successfully' );
	
			if ( is_object($frame) ) {
				// check which frame we had, and act accordingly		
				if (empty($frame->headers['destination'])) {
					continue;
				}
				$dest = explode( '.', $frame->headers['destination'] );
				$producerDB = new WikiaStatsAutoHubsConsumerDB;
				$body = Wikia::json_decode( $frame->body );					
				if( is_object( $body ) ) {
					Wikia::log( __METHOD__, 'Stomp_frame', 'Initiated frame processing' );				
					switch( $dest[2] ) {
						case 'edit':
							// blog or normal edit?							
							$tags = unserialize( $body->cityTag  );
							if( NS_BLOG_ARTICLE == $body->pageNs ) {
								foreach( $tags as $id => $val ) {
									$producerDB->insertBlogComment( $body->cityId, $body->pageId, $id, $body->pageName, $body->pageURL, $body->wikiname, $body->wikiURL, $body->cityLang );						
								}
							} else {
								foreach( $tags as $id => $val ) {
									$producerDB->insertArticleEdit(  $body->cityId, $body->pageId, $body->editorId, $id, $body->pageName, $body->pageURL, $body->wikiname, $body->wikiURL, $body->userGroups, $body->username, $body->cityLang );
								}
							}	
							break;
						case 'delete':
						case 'undelete':
							// needs a function for ProducerDB class, leaving for now until more feedback
							break;
						default:
							break;
					}				
				}
				$stomp->ack( $frame->headers['message-id'] );
				Wikia::log( __METHOD__, 'Stomp_frame', 'Acknowledgement was sent' );				
			}	
		}

		unset($stomp);	

		wfProfileOut( __METHOD__ );
	}
}
