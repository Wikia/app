<?php

namespace PhpAmqpLib\Message;

use PhpAmqpLib\Wire\GenericContent;

/**
 * A Message for use with the Channnel.basic_* methods.
 */
class AMQPMessage extends GenericContent
{
    public $body;

    protected static $PROPERTIES = array(
        "content_type" => "shortstr",
        "content_encoding" => "shortstr",
        "application_headers" => "table",
        "delivery_mode" => "octet",
        "priority" => "octet",
        "correlation_id" => "shortstr",
        "reply_to" => "shortstr",
        "expiration" => "shortstr",
        "message_id" => "shortstr",
        "timestamp" => "timestamp",
        "type" => "shortstr",
        "user_id" => "shortstr",
        "app_id" => "shortstr",
        "cluster_id" => "shortstr"
    );

    public function __construct($body = '', $properties = null)
    {
        $this->body = $body;

		// Wikia change - begin
		// @see PLATFORM-1943
		if (is_array($properties)) {
			$properties['app_id'] = 'mediawiki';
			$properties['correlation_id'] = \Wikia\Util\RequestId::instance()->getRequestId();
		}
		// Wikia change - end

        parent::__construct($properties, static::$PROPERTIES);
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }
}
