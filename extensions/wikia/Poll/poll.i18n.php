<?php

if (!defined('MEDIAWIKI')) {
        echo "This is MediaWiki extension named SiteWideMessages.\n";
        exit(1) ;
}

$messages = array(
        'en' => array(
	        "pollVoteUpdate" => "Your vote has been updated.",
	        "pollVoteAdd"    => "Your vote has been added.",
	        "pollVoteError"  => "There was a problem with processing your vote, please try again.",
	        "pollPercentVotes" => "$1% of all votes",
	        "pollYourVote"   => "You already voted for \"$1\" on $2, you can change your vote by clicking an answer below.",
        	"pollNoVote"     => "Please vote below.",
	        "pollInfo"       => "There were $1 votes since the poll was created on $2.",
	        "pollSubmitting" => "Please wait, submitting your vote."
 	 ),
 	 'pl' => array(
	        "pollVoteUpdate" => "Twój głos został zmieniony.",
	        "pollVoteAdd"    => "Twój głos został dodany.",
	        "pollVoteError"  => "Wystąpił błąd w czasie dodawania głosu, proszę spróbować później.",
	        "pollPercentVotes" => "$1% wszystkich głosów",
	        "pollYourVote"   => "Zagłosowałeś juz na \"$1\" $2, możesz zaktualizować swój głos klikając na odpowiedź poniżej.",
	        "pollNoVote"     => "Podaj swój głos poniżej.",
	        "pollInfo"       => "Oddano już $1 głosy/ów od założenia ankiety dnia $2.",
	        "pollSubmitting" => "Proszę czekać, trwa dodawanie głosu."
	),
	'de' => array(
		"pollInfo"       => "Bisher gab es $1 Stimmen seit der Erstellung der Umfrage am $2.",
		"pollSubmitting" => "Bitte warten, deine Stimme wird gezählt.",
	)
);
