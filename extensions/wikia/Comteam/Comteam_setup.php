<?php

/*
this is the setup base file

this 'extension' is a collection of (tiny) code level hacks/changes/tweaks
 requested by the comteam, for the protection of wikia at large.
 
each one will have its own on/off, but this loader will be included always
*/

if( !empty($wgEnableForumIndexProtector) ) {
	include "ForumIndexProtector.php";
}
