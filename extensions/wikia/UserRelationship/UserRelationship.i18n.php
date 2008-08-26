<?php

/**
 * Internationalisation file for the Special:Invite extension
 *
 * @addtogroup Extensions
 */

function efSpecialUserReplationship() 
{
	return array (
		'en' => efSpecialUserReplationship_en(),
	);
}

function efSpecialUserReplationship_en()
{
return array(
'invalid_friend_foe_select' => 'No user selected. Please request friends/foes through the correct link.',
'user_dont_exist' => 'The user you are trying to add does not exist.',
'user_is_in_relation' => 'You are already a $1 with $2',
'user_pending_request' => 'You have a pending $1 Request with $2.',
'notify_to_confirm_your_request' => 'We will notify you when $1 confirms your request.',
'user_profile_page' => '$1\'s profile page',
'patience_error' => 'Patience!',
'selected_user_page' => '$1\'s User Page',
'your_user_page' => 'Your User Page',
'friend_text' => 'friend',
'friendship' => 'friendship',
'grudge' => 'grudge',
'foe_text' => 'foe',
'adduserrelation' => 'Add $1 as Your $2',
'backto_user_page' => 'Back to $1\'s Page',
'viewalluserfriends' => 'View All of $1\'s Friends',
'viewallyourfriends' => 'View All of Your Friends',
'viewalluserfoes' => 'View All of $1\'s Foes',
'viewallyourfoes' => 'View All of Your Foes',
'woopserrormsg' => 'Woops',
'plural_friends' => 'Friends',
'plural_foes' => 'Foes',
'request_text' => 'request',
'plural_request' => 'requests',
'your_with_two_params' => 'Your $1 $2',
'notify_toadd_user_rel' => 'You are about to add $1 as your $2. We will notify $1 to confirm your $3',
'add_personal_msg' => 'add a personal message',
'userrequestsenttitle' => 'We have sent your $1 Request to $2!',
'userrequestsent' => 'Your $1 Request has been sent to $2 for confirmation.  If $2 accepts your $1 Request, you will receive a follow-up e-mail.',
'user_haveto_logged_to_add' => 'You must be logged in to add a $1',
'user_haveto_logged_to_remove' => 'You must be logged in to remove a $1',
'cannot_request_yourself' => 'You cannot request yourself.',
'friend_request_subject' => '$1 has added you as a friend on Wikia!',
'foe_request_subject' => "It's war! $1 has added you to as a foe on Wikia!",
'friend_accept_subject' => '$1 has accepted your friend request on Wikia!',
'foe_accept_subject' => 'It\'s on! $1 has accepted your foe request on Wikia!',
'friend_removed_subject' => 'Oh No! $1 has removed you as a friend on Wikia!',
'foe_removed_subject' => 'Woohoo! $1 has removed you as a foe on Wikia!',
'invalid_friend_foe_remove' => 'No user selected.  Please remove relationship through the correct link.',
'cant_remove_yourself' => 'You can\'t remove yourself. That makes no sense!',
'invalid_relationship' => 'You do not have a relationship with $1.',
'you_remove_relationship' => 'You have removed $1 as your $2',
'remove_relation_question' => 'Do you want to remove $1 as your $2?',
'requested_remove' => 'You have requested to remove $1 as your $2, press "Remove" to confirm.',
'remove_btn' => 'Remove',
'request_sent' => 'Your request has been sent',
'request_new_relationship' => '$1 wants to be your $2',
'accept_relationship' => 'If you want to be $1\'s $2, click accept.',
'accept_btn' => 'accept',
'reject_btn' => 'reject',
'no_new_friends_request' => 'No new friend requests',
'no_friends_foes' => 'Boo!  You have no current friend or foe requests. Want more friends?',
'invitethem' => 'Invite them',
'startwar' => 'Start a war!',
'addrelationship' => 'Add user relationship',
'viewrelationships' => 'View relationship requests',
'viewrelationshiprequests' => 'View relationship requests',
'removerelationship' => 'Remove relationship',
'user_add_relationship' => '$1 has been added as your $2.',
'user_reject_relationship' => 'You have rejected $1 as your $2.',
'userrelationshipaction' => 'action for user relationships',
'woops_wrong_turn' => 'Woops, you took a wrong turn!',
'user_not_exist' => 'You can\'t view this user, because this user does not exist.',
'user_friend_list' => '$1\'s friend list',
'your_friend_list' => 'Your friend list',
'user_foe_list' => '$1\'s foe list',
'you_have_one_friend' => 'You have one friend.&nbsp;',
'you_have_more_friends' => 'You have $1 friends.&nbsp;',
'you_have_one_foe' => 'You have one foe.&nbsp;',
'you_have_more_foes' => 'You have $1 foes.&nbsp;',
'user_have_one_friend' => '$1 has one friend.&nbsp;',
'user_have_one_foe' => '$1 has one foe.&nbsp;',
'user_have_more_friends' => '$1 has $2 friends.&nbsp;',
'user_have_more_foes' => '$1 has $2 foes',
'wantmorefriends' => 'Want more friends?',
'wantmorefoes' => 'Want more foes?',
'addasfriend' => 'add as friend',
'addasfoe' => 'add as foe',
'delete_relationship' => 'remove as $1',

#subjects

#emails
'friend_request_body' => 'Hi $1:

$2 has added you as a friend on Wikia. We want to make sure that you two are actually friends.

Please click this link to confirm your friendship: $3

Thanks,


The Wikia Team

---

Hey, want to stop getting emails from us?

Click $4 and change your settings to disable email notifications. 
',

'foe_request_body' => 'Hi $1:

$2 just listed you as a foe on Wikia. We want to make sure that you two are actually mortal enemies – or at least having an argument.

Please click this link to confirm the grudge match.

$3

Thanks,


The Wikia team

---

Hey, want to stop getting emails from us?

Click $4 and change your settings to disable email notifications. 
',

'friend_accept_body' => 'Hi $1:

$2 has accepted your friend request on Wikia!

Check out $2\'s page at $3

Thanks,


The Wikia team

---

Hey, want to stop getting emails from us?

Click $4 and change your settings to disable email notifications. 
',
'foe_accept_body' => 'Hi $1:

$2 has accepted your foe request on Wikia!

Check out $2 \'s page at $3

Thanks,


The Wikia team

---

Hey, want to stop getting emails from us?

Click $4 and change your settings to disable email notifications. 
',


'friend_removed_body' => 'Hi $1:

$2 has removed you as a friend on Wikia!

Try to win $2 back by giving them a gift by clicking the link below.

$3

Thanks,


The Wikia team

---

Hey, want to stop getting emails from us?

Click $4 and change your settings to disable email notifications.',


'foe_removed_body' => 'Hi $1:

$2 has removed you as a foe on Wikia!

Perhaps you two are on your way to becoming friends? Why don\'t you try giving $2 a gift?

$3

Thanks,


The Wikia team

---

Hey, want to stop getting emails from us?

Click $4 and change your settings to disable email notifications.
',

	);
}

?>
