<?php
/**
 * AutomaticWikiAdoption
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

$messages = array();

$messages['en'] = array(
	'automaticwikiadoption' => 'AutomaticWikiAdoption',
	'automaticwikiadoption-desc' => 'TODO',
	'automaticwikiadoption-header' => 'Adopt this wiki',
	'automaticwikiadoption-button-adopt' => 'Adopt now',
	'automaticwikiadoption-description' => "You've contributed ... TODO",
	'automaticwikiadoption-know-more-header' => 'Want to know more?',
	'automaticwikiadoption-know-more-description' => 'Check out these links for more information. Adn of course, feel free to contact us if you have any questions!',
	'automaticwikiadoption-adoption-successed' => 'Congratulations! You are a now an admin on this wiki!',
	'automaticwikiadoption-adoption-failed' => "We're sorry - we tried to make you an admin, but it didn't work out. Please [http://community.wikia.com/Special:Contact contact us], and we'll try to help you out.",
	'automaticwikiadoption-not-allowed' => "We're sorry, you can't adopt this wiki right now.",
	'automaticwikiadoption-log-reason' => 'AutomaticWikiAdoption',
	'automaticwikiadoption-notification' => "$1 is up for adoption! You can become the new owner. '''Adopt now!'''",
	'automaticwikiadoption-mail-first-subject' => "We haven't seen you around in a while",
	'automaticwikiadoption-mail-first-content' => "Hi $1,

It's been a couple of weeks since we've seen an administrator on your wiki. Remember, your community will be looking to you to make sure the wiki is running smoothly.

If you need help taking care of the wiki, you can also allow other community members to become admins by going to http://community.wikia.com/wiki/Special:UserRights.

The Wikia Team



You can click here to {{fullurl:{{ns:special}}:Preferences}} from changes to this list.",
	'automaticwikiadoption-mail-first-content-HTML' => "Hi $1,

It's been a couple of weeks since we've seen an administrator on your wiki. Remember, your community will be looking to you to make sure the wiki is running smoothly.

If you need help taking care of the wiki, you can also allow other community members to become admins by going to <a href=\"http://community.wikia.com/wiki/Special:UserRights\">User Rights management></a>.

<b>The Wikia Team</b>



<small>You can click here to <nowiki><a href=\"{{fullurl:{{ns:special}}:Preferences}}\">unsubscribe</a></nowiki> from changes to this list.</small>",
	'automaticwikiadoption-mail-second-subject' => "We'll be putting your wiki up for adoption soon",
	'automaticwikiadoption-mail-second-content' => "Hi $1,

It's been a while since we've seen an administrator around on your wiki. It's important to have active administrators for the community so the wiki can continue to run smoothly - so we'll be putting your wiki up for adoption soon to enable to have a chance to become administrators.

The Wikia Team

You can click here to {{fullurl:{{ns:special}}:Preferences}} from changes to this list.",
	'automaticwikiadoption-mail-second-content-HTML' => "Hi $1,

It's been a while since we've seen an administrator around on your wiki. It's important to have active administrators for the community so the wiki can continue to run smoothly - so we'll be putting your wiki up for adoption soon to enable to have a chance to become administrators.

<b>The Wikia Team</b>

<small><small>You can click here to <nowiki><a href=\"{{fullurl:{{ns:special}}:Preferences}}\">unsubscribe</a></nowiki> from changes to this list</small>.</small>",
	'automaticwikiadoption-mail-adoption-subject' => 'Your wiki has been adopted',
	'automaticwikiadoption-mail-adoption-content' => "Hi $1,

Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Don't worry - you're still an admin, and you're welcome to come back at any time.

The Wikia Team

You can click here to {{fullurl:{{ns:special}}:Preferences}} from changes to this list.",
	'automaticwikiadoption-mail-adoption-content-HTML' => "Hi $1,

Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Don't worry - you're still an admin, and you're welcome to come back at any time.

<b>The Wikia Team</b>

<small><small>You can click here to <nowiki><a href=\"{{fullurl:{{ns:special}}:Preferences}}\">unsubscribe</a></nowiki> from changes to this list</small>.</small>",
);