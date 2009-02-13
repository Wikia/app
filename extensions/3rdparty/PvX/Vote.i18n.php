<?php

/**
 * Internationalisation file for the Vote extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */

function efVoteMessages() {
	$messages = array(

/* English (Rob Church) */
'en' => array(
'vote' => 'Vote',
'vote-header' => "You can vote for build vetting policy here! You can change your vote anytime during the voting time.

Everyone who takes the time to read and vote on policy will be entered in a small lottery. The lottery winner will be chosen when the new policy comes into effect. 

The prize? A Miniature Bone Dragon. 
== Candidates ==
* [[PvXwiki:Real Vetting]] - A real vetting system. 
* [[PvXwiki:Test Before Voting]] - A procedure designed to prevent the lack of testing and bad votes prevalent in GuildWiki.
* [[PvXwiki:True Build Ratings]] - A concept on how to truly rate the build to assist in voting.
* [[PvXwiki:Rating Based on Types and Goals]] - Rating that is actually based on the build and not on the personal opinion of the people who vote. 
* [[PvXwiki:Percentage Favored Vetting]] - A system that will assign a percentage rating based on votes.
* [[PvXwiki:Ranked User Vetting]] - A vetting procedure based on experience of voters.
== Thank you ==
Thank you for your time and good luck with lottery!
",
'vote-current' => "Your current vote is for '''$1'''.",
'vote-legend' => 'Place or amend vote',
'vote-caption' => 'Your selection:',
'vote-choices' => "realvetting|Real Vetting
testbeforevoting|Test Before Voting
truebuildratings|True Build Ratings
ratingbasedontag|Rating Based on Types and Goals
percentagefavored|Percentage Favored Vetting
rankeduservetting|Ranked User Vetting",
'vote-submit' => 'Vote',
'vote-registered' => 'Your vote has been registered.',
'vote-view-results' => 'View results',
'vote-results' => 'Vote results',
'vote-results-choice' => 'Choice',
'vote-results-count' => 'Count',
'vote-results-none' => 'No votes have been placed at this time.',
'vote-login' => 'You must $1 to vote.',
'vote-login-link' => 'log in',
'vote-invalid-choice' => 'You must select one of the available options.',
),

/* French (Ashar Voultoiz) */
'fr' => array(
'vote' => 'Vote',
'vote-header' => "Vous pouvez voter pour le '''maître de l'Univers''' ici !",
'vote-current' => "Votre vote actuel est pour '''$1'''.",
'vote-legend' => 'Placer ou modifier un vote',
'vote-caption' => 'Votre sélection :',
'vote-choices' => "joker|Le Joker
pingouin|Le Pingouin
sphinx|Sphinx",
'vote-submit' => 'Voter',
'vote-registered' => 'Votre vote a été enregistré.',
'vote-view-results' => 'Résultats',
'vote-results' => 'Résultats',
'vote-results-choice' => 'Choix',
'vote-results-count' => 'Voix',
'vote-results-none' => 'Aucun vote n\'a été placé pour le moment.',
'vote-login' => 'Vous devez $1 pour voter.',
'vote-login-link' => 'vous connecter',
'vote-invalid-choice' => 'Vous devez choisir une des options disponible.',
),

/* Indonesian (Ivan Lanin) */
'id' => array(
'vote' => 'Pemilihan',
'vote-header' => "Anda dapat memilih '''Penguasa Tertinggi Dunia''' di sini!",
'vote-current' => "Pilihan Anda saat ini adalah '''$1'''.",
'vote-legend' => 'Berikan atau ubah pilihan',
'vote-caption' => 'Pilihan Anda:',
'vote-choices' => "joker|The Joker
penguin|The Penguin
riddler|Riddler",
'vote-submit' => 'Pilih',
'vote-registered' => 'Pilihan Anda telah didaftarkan.',
'vote-view-results' => 'Lihat hasil',
'vote-results' => 'Hasil pemungutan suara',
'vote-results-choice' => 'Pilihan',
'vote-results-count' => 'Suara',
'vote-results-none' => 'Saat ini belum ada suara yang masuk.',
'vote-login' => 'Anda harus $1 untuk memilih.',
'vote-login-link' => 'masuk log',
'vote-invalid-choice' => 'Anda harus memilih salah satu pilihan yang tersedia.',
),

/* Occitan (Cedric31) */
'oc' => array(
'vote' => 'Vòte',
'vote-header' => 'Podètz votar pel \'\'\'mèstre de l\'Univèrs\'\'\' aicí !',
'vote-current' => 'Vòstre vòte actual es per \'\'\'$1\'\'\'.',
'vote-legend' => 'Plaçar o modificar un vòte',
'vote-caption' => 'Vòstra seleccion:',
'vote-choices' => 'joker|Lo Joquèr
pingouin|Lo Pingoin
sphinx|Esfinx',
'vote-submit' => 'Votar',
'vote-registered' => 'Vòstre vòte es estat enregistrat.',
'vote-view-results' => 'Veire los resultats',
'vote-results' => 'Resultats del vòte',
'vote-results-choice' => 'Causida',
'vote-results-count' => 'Compte',
'vote-results-none' => 'Cap de vòte es pas estat efectuat a aqueste moment.',
'vote-login' => 'Devètz $1 per votar.',
'vote-login-link' => 'vos connectar',
'vote-invalid-choice' => 'Devètz causir una de las opcions disponibla.',
),

'sk' => array(
'vote' => 'Hlasovať',
'vote-header' => 'Tu môžete hlasovať o \'\'\'Hlavnom diktátorovi sveta\'\'\'!',
'vote-current' => 'Aktuálne hlasujete za \'\'\'$1\'\'\'.',
'vote-legend' => 'Hlasovať alebo zmeniť hlas',
'vote-caption' => 'Vaša voľba:',
'vote-submit' => 'Hlasovať',
'vote-registered' => 'Váš hlas bol zaznamenaný.',
'vote-view-results' => 'Zobraziť výsledky',
'vote-results' => 'Výsledky hlasovania',
'vote-results-choice' => 'Voľba',
'vote-results-count' => 'Počet',
'vote-results-none' => 'Momentálne nie sú žiadne hlasy.',
'vote-login' => 'Aby ste mohli hlasovať, musíte $1.',
'vote-login-link' => 'sa prihlásiť',
'vote-invalid-choice' => 'Musíte vybrať jednu z dostupných možností.',
),

	);
	return $messages;
}

?>
