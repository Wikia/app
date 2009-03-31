<?php
/**
 * PdfBook extension
 * - Composes a book from articles in a category and exports as a PDF book
 *
 * See http://www.mediawiki.org/Extension:PdfBook for installation and usage details
 * See http://www.organicdesign.co.nz/Extension_talk:PdfBook for development notes and disucssion
 *
 * Started: 2007-08-08
 * 
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2007 Aran Dunkley
 * @licence GNU General Public Licence 2.0 or later
 */
if (!defined('MEDIAWIKI')) die('Not an entry point.');

define('PDFBOOK_VERSION', '1.0.3, 2008-12-09');

$wgExtensionFunctions[]        = 'wfSetupPdfBook';
$wgHooks['LanguageGetMagic'][] = 'wfPdfBookLanguageGetMagic';

$wgExtensionCredits['parserhook'][] = array(
	'name'	      => 'PdfBook',
	'author'      => '[http://www.organicdesign.co.nz/nad User:Nad]',
	'description' => 'Composes a book from articles in a category and exports as a PDF book',
	'url'	      => 'http://www.mediawiki.org/wiki/Extension:PdfBook',
	'version'     => PDFBOOK_VERSION
	);

class PdfBook {

	function PdfBook() {
		global $wgHooks, $wgParser, $wgPdfBookMagic;
		global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
		$wgHooks['UnknownAction'][] = $this;

		# Add a new pdf log type
		$wgLogTypes[]             = 'pdf';
		$wgLogNames  ['pdf']      = 'pdflogpage';
		$wgLogHeaders['pdf']      = 'pdflogpagetext';
		$wgLogActions['pdf/book'] = 'pdflogentry';
	}

	/**
	 * Perform the export operation
	 */
	function onUnknownAction($action, $article) {
		global $wgOut, $wgUser, $wgTitle, $wgParser, $wgRequest;
		global $wgServer, $wgArticlePath, $wgScriptPath, $wgUploadPath, $wgUploadDirectory, $wgScript;

		if ($action == 'pdfbook') {

			$title = $article->getTitle();
			$opt = ParserOptions::newFromUser($wgUser);

			# Log the export
			$msg = $wgUser->getUserPage()->getPrefixedText().' exported as a PDF book';
			$log = new LogPage('pdf', false);
			$log->addEntry('book', $wgTitle, $msg);

			# Initialise PDF variables
			$format  = $wgRequest->getText('format');
			$notitle = $wgRequest->getText('notitle');
			$layout  = $format == 'single' ? '--webpage' : '--firstpage toc';
			$charset = $this->setProperty('Charset',     'iso-8859-1');
			$left    = $this->setProperty('LeftMargin',  '1cm');
			$right   = $this->setProperty('RightMargin', '1cm');
			$top     = $this->setProperty('TopMargin',   '1cm');
			$bottom  = $this->setProperty('BottomMargin','1cm');
			$font    = $this->setProperty('Font',	     'Arial');
			$size    = $this->setProperty('FontSize',    '8');
			$linkcol = $this->setProperty('LinkColour',  '217A28');
			$levels  = $this->setProperty('TocLevels',   '2');
			$exclude = $this->setProperty('Exclude',     array());
			$width   = $this->setProperty('Width',       '');
			$width   = $width ? "--browserwidth $width" : '';
			if (!is_array($exclude)) $exclude = split('\\s*,\\s*', $exclude);
 
			# Select articles from members if a category or links in content if not
			if ($format == 'single') $articles = array($title);
			else {
				$articles = array();
				if ($title->getNamespace() == NS_CATEGORY) {
					$db     = &wfGetDB(DB_SLAVE);
					$cat    = $db->addQuotes($title->getDBkey());
					$result = $db->select(
						'categorylinks',
						'cl_from',
						"cl_to = $cat",
						'PdfBook',
						array('ORDER BY' => 'cl_sortkey')
					);
					if ($result instanceof ResultWrapper) $result = $result->result;
					while ($row = $db->fetchRow($result)) $articles[] = Title::newFromID($row[0]);
				}
				else {
					$text = $article->fetchContent();
					$text = $wgParser->preprocess($text, $title, $opt);
					if (preg_match_all('/^\\*\\s*\\[{2}\\s*([^\\|\\]]+)\\s*.*?\\]{2}/m', $text, $links))
						foreach ($links[1] as $link) $articles[] = Title::newFromText($link);
				}
			}

			# Format the article(s) as a single HTML document with absolute URL's
			$book = $title->getText();
			$html = '';
			$wgArticlePath = $wgServer.$wgArticlePath;
			$wgScriptPath  = $wgServer.$wgScriptPath;
			$wgUploadPath  = $wgServer.$wgUploadPath;
			$wgScript      = $wgServer.$wgScript;
			foreach ($articles as $title) {
				$ttext = $title->getPrefixedText();
				if (!in_array($ttext, $exclude)) {
					$article = new Article($title);
					$text    = $article->fetchContent();
					$text    = preg_replace('/<!--([^@]+?)-->/s', '@@'.'@@$1@@'.'@@', $text); # preserve HTML comments
					if ($format != 'single') $text .= '__NOTOC__';
					$opt->setEditSection(false);    # remove section-edit links
					$wgOut->setHTMLTitle($ttext);   # use this so DISPLAYTITLE magic works
					$out     = $wgParser->parse($text, $title, $opt, true, true);
					$ttext   = $wgOut->getHTMLTitle();
					$text    = $out->getText();
					$text    = preg_replace('|(<img[^>]+?src=")(/.+?>)|', "$1$wgServer$2", $text);       # make image urls absolute
					$text    = preg_replace('|<div\s*class=[\'"]?noprint["\']?>.+?</div>|s', '', $text); # non-printable areas
					$text    = preg_replace('|@{4}([^@]+?)@{4}|s', '<!--$1-->', $text);                  # HTML comments hack
					#$text    = preg_replace('|<table|', '<table border borderwidth=2 cellpadding=3 cellspacing=0', $text);
					$ttext   = basename($ttext);
					$h1      = $notitle ? '' : "<center><h1>$ttext</h1></center>";
					$html   .= utf8_decode("$h1$text\n");
				}
			}

			# If format=html in query-string, return html content directly
			if ($format == 'html') {
				$wgOut->disable();
				header("Content-Type: text/html");
				header("Content-Disposition: attachment; filename=\"$book.html\"");
				print $html;
			}
			else {
				# Write the HTML to a tmp file
				$file = "$wgUploadDirectory/".uniqid('pdf-book');
				$fh = fopen($file, 'w+');
				fwrite($fh, $html);
				fclose($fh);

				$footer = $format == 'single' ? '...' : '.1.';
				$toc    = $format == 'single' ? '' : " --toclevels $levels";

				# Send the file to the client via htmldoc converter
				$wgOut->disable();
				header("Content-Type: application/pdf");
				header("Content-Disposition: attachment; filename=\"$book.pdf\"");
				$cmd  = "--left $left --right $right --top $top --bottom $bottom";
				$cmd .= " --header ... --footer $footer --headfootsize 8 --quiet --jpeg --color";
				$cmd .= " --bodyfont $font --fontsize $size --linkstyle plain --linkcolor $linkcol";
				$cmd .= "$toc --format pdf14 --numbered $layout $width";
				$cmd  = "htmldoc -t pdf --charset $charset $cmd $file";
				putenv("HTMLDOC_NOCGI=1");
				passthru($cmd);
				@unlink($file);
			}
			return false;
		}
	
		return true;
	}

	/**
	 * Return a property for htmldoc using global, request or passed default
	 */
	function setProperty($name, $default) {
		global $wgRequest;
		if ($wgRequest->getText("pdf$name"))   return $wgRequest->getText("pdf$name");
		if (isset($GLOBALS["wgPdfBook$name"])) return $GLOBALS["wgPdfBook$name"];
		return $default;
	}

	/**
	 * Needed in some versions to prevent Special:Version from breaking
	 */
	function __toString() { return 'PdfBook'; }
}

/**
 * Called from $wgExtensionFunctions array when initialising extensions
 */
function wfSetupPdfBook() {
	global $wgPdfBook;
	$wgPdfBook = new PdfBook();
}

/**
 * Needed in MediaWiki >1.8.0 for magic word hooks to work properly
 */
function wfPdfBookLanguageGetMagic(&$magicWords, $langCode = 0) {
	global $wgPdfBookMagic;
	$magicWords[$wgPdfBookMagic] = array($langCode, $wgPdfBookMagic);
	return true;
}
