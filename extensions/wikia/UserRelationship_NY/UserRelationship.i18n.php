<?php
function efWikiaUserRelationship() {

	return array(
	
	'en' => array(
		'ur-error-title'=>'Woops, you took a wrong turn!',
		'ur-error-message-no-user'=>'We cannot complete your request, because no user with this name exists.',
		'ur-main-page'=>'Main Page',
		'ur-your-profile'=>'Your Profile',
		'ur-backlink'=>'&lt; Back to $1\'s Profile',
		'ur-friend'=>'friend',
		'ur-foe'=>'foe',
		'ur-relationship-count'=>'$1 has $2 {{PLURAL:$2|$3|$3s}}. Want more $3s? <a href="$4">Invite them</a>.',
		'ur-add-friends'=>' Want more friends? <a href="$1">Invite Them</a>',
		'ur-add-friend'=>'Add as Friend',
		'ur-add-foe'=>'Add as Foe',
		'ur-remove-relationship'=>'Remove as $1',
		'ur-give-gift'=>'Give a Gift',
		'ur-previous'=>'prev',
		'ur-next'=>'next',
		'ur-remove-relationship-title'=>'Do you want to remove $1 as your $2?',
		'ur-remove-relationship-title-confirm'=>'You have removed $1 as your $2',
		'ur-remove-relationship-message'=>'You have requested to remove $1 as your $2, press "$3" to confirm.',
		'ur-remove-relationship-message-confirm'=>'You have successfully removed $1 as your $2.',
		'ur-remove-error-message-no-relationship'=>'You do not have a relationship with $1.',
		'ur-remove-error-message-remove-yourself'=>'You cannot remove yourself.',
		'ur-remove-error-message-pending-request'=>'You have a pending $1 request with $2.',
		'ur-remove-error-not-loggedin'=>'You have to be logged in to remove a $1.',
		'ur-remove'=>'Remove',
		'ur-cancel'=>'Cancel',
		'ur-login'=>"Login",
		'ur-add-title'=>'Do you want to add $1 as your $2?',
		'ur-add-message'=>'You are about to add $1 as your $2.  We will notify $1 to confirm your $3.',
		'ur-friendship'=>'friendship',
		'ur-grudge'=>'grudge',
		'ur-add-button'=>"Add as $1",
		'ur-add-sent-title'=>'We have sent your $1 request to $2!',
		'ur-add-sent-message'=>'Your $1 request has been sent to $2 for confirmation.  If $2 confirms your request, you will receive a follow-up e-mail',
		'ur-add-error-message-no-user'=>'The user you are trying to add does not exist.',
		'ur-add-error-message-blocked'=>'You are currently blocked and cannot add friends or foes.',
		'ur-add-error-message-yourself'=>'You cannot add yourself as a friend or foe.',
		'ur-add-error-message-existing-relationship'=>'You are already $1s with $2.',
		'ur-add-error-message-pending-request-title'=>'Please be Patient',
		'ur-add-error-message-pending-request'=>'You have a pending $1 request with $2.<br/>  We will notify you when $2 confirms your request.',
		'ur-add-error-message-not-loggedin'=>'You must be logged in to add a $1',
		'ur-requests-title'=>'Relationship Requests',
		'ur-requests-message'=>'<a href="$1">$2</a> wants to be your $3.',
		'ur-accept'=>'Accept',
		'ur-reject'=>'Reject',
		'ur-no-request-message'=>'You have no requests.',
		'ur-requests-added-message'=>'You have added $1 as your $2.',
		'ur-requests-reject-message'=>'You have rejected $1 as your $2.',
		'friend_request_subject' => '$1 has added you as a friend on {{SITENAME}}!',
		'friend_request_body' => 'Hi $1:

$2 has added you as a friend on {{SITENAME}}.  We want to make sure that you two are actually friends.

Please click this link to confirm your friendship:
$3

Thanks

---

Hey, want to stop getting emails from us?  

Click $4 
and change your settings to disable email notifications.',
		'foe_request_subject' => 'It\'s war! $1 has added you to as a foe on {{SITENAME}}!',
		'foe_request_body' => 'Hi $1:

$2 just listed you as a foe on {{SITENAME}}.  We want to make sure that you two are actually mortal enemies – or at least having an argument.

Please click this link to confirm the grudge match.

$3

Thanks

---

Hey, want to stop getting emails from us?',
		'friend_accept_subject' => '$1 has accepted your friend request on {{SITENAME}}!',
		'friend_accept_body' => 'Hi $1:

$2 has accepted your friend request on {{SITENAME}}!

Check out $2\'s page at $3

Thanks,

---

Hey, want to stop getting emails from us?  

Click $4 
and change your settings to disable email notifications.',
		'foe_accept_subject' => 'It\'s on! $1 has accepted your foe request on {{SITENAME}}!',
		'foe_accept_body' => 'Hi $1:

$2 has accepted your foe request on {{SITENAME}}!

Check out $2\'s page at $3

Thanks

---

Hey, want to stop getting emails from us?  

Click $4 
and change your settings to disable email notifications.',
		'friend_removed_subject' => 'Oh No! $1 has removed you as a friend on {{SITENAME}}!',
		'friend_removed_body' => 'Hi $1:

$2 has removed you as a friend on {{SITENAME}}!  

Thanks

---

Hey, want to stop getting emails from us?  

Click $4 
and change your settings to disable email notifications.',
		'foe_removed_subject' => 'Woohoo! $1 has removed you as a foe on {{SITENAME}}!',
		'foe_removed_body' => 'Hi $1:

		$2 has removed you as a foe on {{SITENAME}}!  

Perhaps you two are on your way to becoming friends?

Thanks

---

Hey, want to stop getting emails from us?  

Click $4 
and change your settings to disable email notifications.',
'viewrelationshiprequests'=>'View Relationship Requests',
'viewrelationships'=>'View Relationships'
		
		
		),
	); 
}

?>
