<?php
/**
* Internationalisation file for the NotAValidWikia extension.
*
* @addtogroup Languages
*/

$messages = [];

$messages['en'] = [
	'not-a-valid-wikia' => '
<div class="center" style="padding: 1em 0; font-weight:bold; font-size:120%; margin-bottom:1em">This is not the wiki you\'re looking for! We didn\'t recognize the URL you provided. Head over to search and find the wiki of your dreams [{{fullurl:homepage:Special:Search|search={{urlencode:$1}}}} here].</div>

{| style="margin: 1em auto 0; font-weight: bold; text-align: center" cellpadding="7" cellspacing="5"
!colspan="3" style="font-size: 120%"|Looking for help on Fandom?
|-
|[[Help:Contents|Explore our Help pages]]
|
|[[Special:Forum|Ask questions in the Forum]]
|-
|[[homepage:Special:CreateWiki|Start your own wiki]]
|
|[[Blog:Fandom Staff Blog|Read the latest Fandom news]]
|}
',
];

$messages['qqq'] = [
	'not-a-valid-wikia' => 'Wiki text displayed when user got redirected from a domain that does not
		correspond to any known wiki. The intent of the page is to encourage user to stay at Wikia
		and search for other exciting content. $1 is replaced with the search query based on the
		originally entered domain.',
];
