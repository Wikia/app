<?php
	$wgWikiTweet = array(
		// User roles configuration :
		'informuser'   => "Informer",                  // A special generic user, who informs
		'informers'    => array("Admin","WikiSysop"),  // Who are allowed to post instead of the "Informer"
		'admin'        => array("Admin"),              // Who are the wikitweet administrators
		'allowAnonymous'    => True,                   // Is it possible to tweet anonymously ?
		'AnonymousUser'     => 'Anonymous',            // Who is the "Anonymous user" (fictive user)
		'allowDisconnected' => False,                  // Is it possible to post tweet when not log in ?
		'refreshTime'       => 15000,                  // Time to refresh in milliseconds
		'textlength'        => 500,                    // Tweet text length (140 by default)
		'dateformat'   => 'H:i, F jS',                 // 'H:i, F jS' by default
		'alertroom'    => 'alerts',                    // alert room name
		'showsubscriptions' => 0,                      // Show subscriptions to a room
		'rows' => 100,                                 // How mant rows to display in a timeline
		'roomlink' => 'Discussion:' ,                  // Prefix for the link of a room
		'tweetandemail' => True,                       // Allow forced "email" sending
		
		// SMTP configuration :
		'email'=> true,                                // Allow email sending
		'SMTP'         => array(                       // SMTP configuration
			 'host'    => "localhost",                 //could also be an IP address
			 'IDHost'  => "",
			 'port'    => 25,
			 'auth'    => false,
			 'username'=> "",
			 'password'=> ""
			),
		'wikimail'     => 'wikitweet@yourdomain.com',  // generic sender email
		'wikimail-concerns' => 'wikitweet-concerns@yourdomain.com',
		'wikimails'    => array(
				'0' => 'wikitweet@yourdomain.com',
				'1' => 'wikitweet@yourdomain.com',
				'2' => 'wikitweet-attention@yourdomain.com',
				'3' => 'wikitweet-alert@yourdomain.com'
			),
		
		// Size CSS configuration :
		'size'         => array(
			'normal'   => array(
				'line_height'       => '16px',         // Height of a tweet line
				'font_size'         => '14px',
				'avatar_size'       => '48',           // Size of the avatar picture (in px)
				'span_avatar_width' => '50px',
				'paddingli'         => '10px 0 8px',
				'margin_left'       => '0px',
				'child_line_height'       => '13px',         // Height of a tweet line
				'child_font_size'         => '12px',
				'child_avatar_size'       => '35',           // Size of the avatar picture (in px)
				'child_span_avatar_width' => '37px',
				'child_paddingli'         => '5px 0 3px',
				'child_margin_left'       => '20px',
				),
			'medium'   => array(
				'line_height'       => '13px',
				'font_size'         => '14px',
				'avatar_size'       => '35',
				'span_avatar_width' => '37px',
				'paddingli'         => '5px 0 3px',
				'margin_left'       => '0px',
				'child_line_height'       => '13px',
				'child_font_size'         => '11px',
				'child_avatar_size'       => '35',
				'child_span_avatar_width' => '37px',
				'child_paddingli'         => '5px 0 3px',
				'child_margin_left'       => '15px',
				),
			'small'   => array(
				'line_height'       => '13px',
				'font_size'         => '11px',
				'avatar_size'       => '35',
				'span_avatar_width' => '37px',
				'paddingli'         => '5px 0 3px',
				'margin_left'       => '0px',
				'child_line_height'       => '12px',
				'child_font_size'         => '10px',
				'child_avatar_size'       => '28',
				'child_span_avatar_width' => '30px',
				'child_paddingli'         => '5px 0 3px',
				'child_margin_left'       => '10px',
				),
			),
		'inherit'      => array(                            // inherit tree description
			'main' => array('room1','room2','room3'),
			'room1'     => array('room1.1'),
			'room3'     => array('room3.1','room3.2')
			),
		'titles' => array(                                 // Aliases for the rooms
			"room1"   => "Title room 1",
			"room1.1" => "Title room 1.1",
			"room2"   => "Title room 2",
			"room3"   => "Title room 3",
			"room3.1" => "Title room 3.1",
			"room3.2" => "Title room 3.2"
		)
		);
?>
