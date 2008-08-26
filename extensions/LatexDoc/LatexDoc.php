<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

$wgExtensionCredits['other'][] = array(
	'version'     => '0.2',
	'name'        => 'LatexDoc',
	'author'      => 'Tim Starling',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:LatexDoc',
	'description' => 'LatexDoc',
	'descriptionmsg' => 'latexdoc-desc',
);

$wgExtensionFunctions[] = 'wfLatexDocInit';
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LatexDoc'] = $dir . 'LatexDoc.i18n.php';

class LatexDoc {
	var $latexCommand = 'latex';
	var $pdflatexCommand = 'pdflatex';

	var $workingDir;
	var $workingPath;

	function LatexDoc() {
		global $wgUploadDirectory, $wgUploadPath;

		$this->workingDir = "$wgUploadDirectory/latexdoc";
		$this->workingPath = "$wgUploadPath/latexdoc";

		return true;
	}

	function onUnknownAction( $action, &$article ) {
		global $wgOut, $wgRequest;

		// Respond only to latexdoc action
		if ( $action != 'latexdoc' ) {
			return true;
		}

		// Check for non-existent article
		if ( !$article || !( $text = $article->fetchContent() ) ) {
			$wgOut->addWikiText( wfMsg( 'latexdoc_no_text' ) );
			return false;
		}

		// Check permissions
		if ( !$article->mTitle->userCanRead() ) {
			$wgOut->loginToUse();
			return false;
		}

		$ext = $wgRequest->getText( 'ext' );

		$wgOut->setArticleFlag( false );
		$wgOut->setArticleRelated( true );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setPageTitle( $article->mTitle->getPrefixedText() );

		if ( $ext == 'pdf' ) {
			$this->runLatex( $text, $this->pdflatexCommand, 'pdf' );
		} else {
			$this->runLatex( $text, $this->latexCommand, 'dvi' );
		}

		return false;
	}

	function runLatex( $text, $command, $ext ) {
		global $wgOut, $IP;

		// Filter out obvious insecure control sequences
		$text = preg_replace( "/\\\\(input|openin|openout|read|write|escapechar)/",
		  '\begin{math}\backslash\end{math}\1', $text );

		// Get path
		if ( !is_dir( $this->workingDir ) ) {
			if ( !mkdir( $this->workingDir, 0777 ) ) {
				$wgOut->addWikiText( wfMsg( 'latexdoc_cant_create_dir', $this->workingDir ) );
				return;
			}
		}

		$hash = md5( $text );
		$fn = $this->workingDir . '/' . 'ltd_' . $hash;
		$url = $this->workingPath . '/' . 'ltd_' . $hash;

		if ( !file_exists( "$fn.$ext" ) ) {
			// Write input file

			$inFile = fopen( "$fn.tex", 'w' );
			if ( !$inFile ) {
				$wgOut->addWikiText( wfMsg( 'latexdoc_cant_write', "$fn.tex" ) );
				return;
			}
			fwrite( $inFile, $text );
			fclose( $inFile );

			// Run LaTeX
			$cmd = $command .
			  ' -interaction=batchmode -quiet ' .
			  '\input ' . wfEscapeShellArg( "$fn.tex" ) . ' 2>&1';

			chdir( $this->workingDir );
			$errorText = shell_exec( $cmd );
			chdir( $IP );

			// Report errors
			if ( !file_exists( "$fn.$ext" ) ){
				wfSuppressWarnings();
				$log = '<pre>' . file_get_contents( "$fn.log" ) . '</pre>';
				wfRestoreWarnings();
				$wgOut->addWikiText( wfMsg( 'latexdoc_error', $cmd, $errorText, $log ) );
				return;
			}
		}

		// Redirect to output file
		$wgOut->redirect( "$url.$ext" );

		// Delete temporary files
		@unlink( "$fn.tex" );
		@unlink( "$fn.aux" );
		@unlink( "$fn.log" );

	}

	function onParserBeforeStrip( &$parser, &$text, &$stripState ) {
		// If the article looks vaguely like TeX, render it as a pre, with a button for DVI generation
		if ( strpos( $text, '\begin{document}' ) !== false ) {
			$sk =& $parser->getOptions()->getSkin();
			$dviLink = $sk->makeKnownLinkObj( $parser->getTitle(), wfMsg( 'latexdoc_get_dvi' ),
			  'action=latexdoc&ext=dvi' );
			$pdfLink = $sk->makeKnownLinkObj( $parser->getTitle(), wfMsg( 'latexdoc_get_pdf' ),
			  'action=latexdoc&ext=pdf' );
			$htmlLatex = nl2br( htmlspecialchars( $text ) );

			$framedLatex = <<<ENDTEXT
$dviLink | $pdfLink
<hr />
<tt>$htmlLatex</tt>
ENDTEXT;

			$text = $parser->insertStripItem( $framedLatex, $stripState );
		}
		return true;
	}
}

$wgLatexDoc = new LatexDoc;

function wfLatexDocInit() {
	global $wgHooks, $wgLatexDoc;
	wfLoadExtensionMessages( 'LatexDoc' );
	$wgHooks['UnknownAction'][] = &$wgLatexDoc;
	$wgHooks['ParserBeforeStrip'][] = &$wgLatexDoc;
}
