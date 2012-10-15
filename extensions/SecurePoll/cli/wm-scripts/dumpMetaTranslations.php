<?php

require( dirname( __FILE__ ) . '/../cli.inc' );

$spConf = array(
	'numCandidates' => 18,
	'baseId' => 17,
	'basePage' => 'Board elections/2009/Vote interface',
	'langs' => array(
		'ar',
		'bn',
		'ca',
		'cs',
		'da',
		'de',
		'el',
		'en',
		'eo',
		'es',
		'fi',
		'fr',
		'gl',
		'hi',
		'hr',
		'hu',
		'ia',
		'id',
		'it',
		'ja',
		'jv',
		'ko',
		'ksh',
		'ms',
		'nb',
		'nl',
		'oc',
		'pl',
		'pt',
		'pt-br',
		'ru',
		'sk',
		'sv',
		'tr',
		'uk',
		'vi',
		'zh-hans',
		'zh-hant',
	)
);

$header = <<<EOT
<SecurePoll>
<election>
<configuration>
<title>Wikimedia Board of Trustees Election, 2009</title>
<ballot>preferential</ballot>
<tally>schulze</tally>
<primaryLang>en</primaryLang>
<startDate>2009-07-28T12:00:00Z</startDate>
<endDate>2009-08-10T23:59:59Z</endDate>
<auth>remote-mw</auth>
<id>{$spConf['baseId']}</id>
<property name="admins">Tim Starling|Philippe|Werdna|Daniel|Yann|Mardetanha</property>
<property name="not-blocked">1</property>
<property name="not-bot">1</property>
<property name="need-list">board-vote-2009</property>
<property name="encrypt-type">gpg</property>
<property name="remote-mw-script-path">https://secure.wikimedia.org/\$site/\$lang/w</property>
<property name="shuffle-options">1</property>
<property name="gpg-encrypt-key"><!-- insert key here --></property>
<property name="gpg-sign-key"><!-- insert key here --></property>


EOT;

$allMessages = array();
foreach ( $spConf['langs'] as $lang ) {
	$messages = spGetMetaTranslations( $lang );
	if ( $messages ) {
		$allMessages[$lang] = $messages;
	} else {
		fwrite( STDERR, "Messages not found for $lang\n" );
	}
}

$s = $header .
	spFormatEntityMessages( $allMessages, 'election' ) .
	"<question>\n" .
	"<id>" . ($spConf['baseId'] + 1) . "</id>\n" .
	"<message name=\"text\" lang=\"en\"></message>\n";

for ( $i = 1; $i <= $spConf['numCandidates']; $i++ ) {
	$s .= 
		"<option>\n" .
		"<id>" . ( $i + $spConf['baseId'] + 1 ) . "</id>\n" .
		spFormatEntityMessages( $allMessages, "option_$i" ) .
		"</option>\n";
}
$s .= "</question>
</configuration>
</election>
</SecurePoll>
";

echo $s;
exit( 0 );
//------------------------------------------------------------------

function spGetMetaTranslations( $lang ) {
	global $spConf, $wgParser;
	$messages = array();
	$titleText = "{$spConf['basePage']}/$lang";
	$title = Title::newFromText( $titleText );
	$numMessages = 0;
	if ( !$title ) {
		fwrite( STDERR, "Title invalid for lang $lang\n" );
		return false;
	}
	$revision = Revision::newFromTitle( $title );
	if ( !$revision ) {
		fwrite( STDERR, "Revision not found for page [[$titleText]]\n" );
		return false;
	}
	$text = $revision->getText();
	if ( $text === false ) {
		fwrite( STDERR, "Text not found for page [[$titleText]]\n" );
		return false;
	}

	for ( $sectionIndex = 1; $sectionIndex <= 10; $sectionIndex++ ) {
		$section = $wgParser->getSection( $text, $sectionIndex, false );
		if ( $section === false ) {
			break;
		}

		if ( !preg_match( '/^== *(.*?) *==\s*$/m', $section, $m ) ) {
			fwrite( STDERR, "Section header mismatch for section $sectionIndex of [[$titleText]]\n" );
			continue;
		}
		$sectionName = strtolower( $m[1] );
		$remainder = trim( substr( $section, strlen( $m[0] ) ) );
		if ( strpos( $remainder, '<nowiki>' ) !== false ) {
			fwrite( STDERR, "Message $sectionName for $lang contains <nowiki>\n" );
			continue;
		}

		$electionMsgMap = array(
			'title' => 'title',
			'introduction' => 'intro',
			'jump text' => 'jump-text'
		);
		if ( isset( $electionMsgMap[$sectionName] ) ) {
			$messages['election'][$electionMsgMap[$sectionName]] = $remainder;
			$numMessages++;
			continue;
		}
		
		if ( $sectionName == 'candidate text' ) {
			$i = 1;
			$lines = explode( "\n", $remainder );
			foreach ( $lines as $line ) {
				if ( preg_match( '/^# *(.*)/', $line, $m ) ) {
					$messages["option_$i"]['text'] = $m[1];
					$numMessages++;
					$i++;
				}
			}
			$i--;
			if ( $i !== $spConf['numCandidates'] ) {
				fwrite( STDERR, "Not enough candidates for $lang: $i/{$spConf['numCandidates']}\n" );
				return false;
			}
			continue;
		}

		fwrite( STDERR, "Unrecognised section \"$sectionName\" in $lang\n" );
	}

	fwrite( STDERR, "[[$titleText]]: found " . $numMessages . " messages\n" );
	return $messages;
}

function spFormatEntityMessages( $messages, $entity ) {
	$s = '';
	$targetEntity = $entity;
	foreach ( $messages as $lang => $langMsgs ) {
		foreach ( $langMsgs as $entity => $entityMsgs ) {
			if ( $entity === $targetEntity ) {
				foreach ( $entityMsgs as $key => $value ) {
					$s .= Xml::element( 
							'message', 
							array( 'name' => $key, 'lang' => $lang ),
							$value 
						) . 
						"\n";
				}
			}
		}
	}
	return $s;
}

