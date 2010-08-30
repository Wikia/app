<?php
/**
 * @todo Adapt to use $messages to get this localised at transatewiki.net.
 */

function efWikiaUserBulletin() {

	return array(
		'en' => array(
			'bulletin_status' => 'changed $2 status to "$1"',	
			'bulletin_friend' => 'and  [{{PROFILEJSONPATH}}profile.html?user={{#BULLETINNAME:$1}} $3] are now friends.',
			'bulletin_wall' => 'wrote on  [{{PROFILEJSONPATH}}profile.html?user={{#BULLETINNAME:$1}} $3\'s] wall',
			'bulletin_personal_profile' => 'changed $2 personal profile',
			'bulletin_work_profile' => 'changed $2 work profile ',
			'bulletin_basic_profile' => 'changed $2 basic profile',
			'bulletin_nudge' => 'nudged [{{PROFILEJSONPATH}}profile.html?user={{#BULLETINNAME:$1}} $3]',
			'bulletin_nudge' => 'nudged [{{PROFILEJSONPATH}}profile.html?user={{#BULLETINNAME:$1}} $3] back',
			'bulletin_profile_photo' => 'changed $2 profile picture',
			),
		); 
}
