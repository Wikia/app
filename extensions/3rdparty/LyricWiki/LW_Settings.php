<?php

$LW = "$IP/extensions/LyricWiki/";

	# Parser Extensions
	require_once "$LW/Parser_LWMagicWords.php";

	# Additional Tags
	require_once "$LW/Tag_Lyric.php";
	require_once "$LW/Tag_XML.php";

	# New Special Pages
	require_once "$LW/Special_BatchMove.php";
	require_once "$LW/Special_Wikify.php";
	require_once "$LW/Special_SendToAFriend.php";
	require_once "$LW/Special_GoogleSearch.php";

	# teknomunk - local testing
	//require_once "$LW/Special_SOAP.php";
	//require_once "$LW/Special_SOAPFailures.php";
	require_once "$LW/Special_WatchlistFeed.php"; // local testing - SpecialWatchlist is an absolute mess, even in the newest version

	# Other Extensions
	require_once "$LW/Templates.php";
	require_once "$LW/Hook_PreventBlanking.php";
	require_once "$LW/Special_ArtistRedirects.php";
	require_once "$LW/lw_spiderableBadArtists.php";
	require_once "$LW/Special_Soapfailures.php";

	// Allows a redirect from one artist-name to another to create implied redirects from all of that source-artists songs to the dest artist.
	// For example, "Prodigy" redirects to "The Prodigy", so if a user looks for "Prodigy:Breathe", they will be taken by an implied redirect to "The Prodigy:Breathe".
	require_once "$LW/lw_impliedRedirects.php";


$wgShowExceptionDetails = true;

?>
