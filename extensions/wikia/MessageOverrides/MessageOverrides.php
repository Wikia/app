<?php
/**
 * MessageOverrides
 *
 * This is a temporary replacement for messaging.wikia.com -- essentially a dump of all the messages customized via the old system.
 * Because of the way MediaWiki handles message key definitions and their priority this needs to be included before any other messages
 * are set, so that the overrides take effect (the first use of a message key reserves it).
 *
 * If you're a developer you probably shouldn't care about these overrides at all. These are used by the International Team to "block"
 * certain messages from being altered by volunteer translators, while still allowing extension translations to conform to core MediaWiki
 * language standards used by the awesome volunteer translators at TranslateWiki.net.
 *
 * @TODO Get rid of this entirely, i.e. distribute the overrides to the relevant extension directories so that they're packaged together.
 *
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 */

// Messages
$wgExtensionMessagesFiles['MessageOverrides'] = dirname(__FILE__) . '/MessageOverrides.i18n.php';
