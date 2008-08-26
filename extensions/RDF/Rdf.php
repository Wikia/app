<?php
/**
 * MwRdf.php -- RDF framework for MediaWiki
 * Copyright 2005, 2006 Evan Prodromou <evan@wikitravel.org>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @ingroup Extensions
 */
if (defined('MEDIAWIKI')) {

	require_once('GlobalFunctions.php');
	if (!defined('RDFAPI_INCLUDE_DIR')) {
		wfDebugDieBacktrace("MwRdf: you must install RAP (RDF API for PHP) " .
							"and define 'RDFAPI_INCLUDE_DIR' in LocalSettings.php");
	}
	require_once(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
	require_once(RDFAPI_INCLUDE_DIR . PACKAGE_VOCABULARY);
	require_once('SpecialPage.php');

	define('MWRDF_VERSION', '0.7');
	define('MWRDF_XML_TYPE_PREFS',
		   "application/rdf+xml,text/xml;q=0.7," .
		   "application/xml;q=0.5,text/rdf;q=0.1");
	define('MWRDF_TURTLE_TYPE_PREFS',
		   "application/x-turtle,application/turtle;q=0.5,text/plain;q=0.1");
	define('MWRDF_NTRIPLES_TYPE_PREFS',
		   "text/plain");

	# Creative Commons namespace

	define('CC_NS', "http://web.resource.org/cc/");
	$CC_name = array('Work', 'Agent', 'License', 'Permission',
					 'Requirement', 'Prohibition', 'PublicDomain',
					 'Reproduction', 'Distribution', 'DerivativeWorks',
					 'Notice', 'Attribution', 'ShareAlike', 'SourceCode',
					 'CommercialUse', 'license', 'permits', 'requires',
					 'prohibits', 'derivativeWork');

	foreach ($CC_name as $name) {
		$CC[$name] = new Resource(CC_NS . $name);
	}

	/* Config stuff -- set and reset in LocalSettings.php */

	$wgRdfModelFunctions = array('inpage' => 'MwRdfInPage',
								 'dcmes' => 'MwRdfDcmes',
								 'cc' => 'MwRdfCreativeCommons',
								 'linksto' => 'MwRdfLinksTo',
								 'linksfrom' => 'MwRdfLinksFrom',
								 'links' => 'MwRdfAllLinks',
								 'image' => 'MwRdfImage',
								 'history' => 'MwRdfHistory',
								 'interwiki' => 'MwRdfInterwiki',
								 'categories' => 'MwRdfCategories');

	$wgRdfDefaultModels = array('inpage', 'cc', 'links', 'image', 'interwiki', 'categories');

	$wgRdfOutputFunctions = array('xml' => 'MwRdfOutputXml',
								  'turtle' => 'MwRdfOutputTurtle',
								  'ntriples' => 'MwRdfOutputNtriples');

	$wgRdfNamespaces = array('cc' => CC_NS);
	$wgRdfCacheExpiry = 86400;

	/* Config end */
	
	$wgExtensionCredits['other'][] = array(
		'name' => 'RDF',
		'version' => MWRDF_VERSION,
		'description' => 'RDF framework for MediaWiki',
		'author' => 'Evan Prodromou',
		'url' => 'http://www.mediawiki.org/wiki/Extension:RDF',
	);

	$wgExtensionFunctions[] = 'setupMwRdf';

	function setupMwRdf() {
		global $wgParser, $wgMessageCache, $wgRequest, $wgOut, $wgHooks;

		$wgMessageCache->addMessages(array('rdf' => 'Rdf',
										   'rdf-inpage' => "Embedded In-page Turtle",
										   'rdf-dcmes' => "Dublin Core Metadata Element Set",
										   'rdf-cc' => "Creative Commons",
										   'rdf-image' => "Embedded images",
										   'rdf-linksto' => "Links to the page",
										   'rdf-linksfrom' => "Links from the page",
										   'rdf-links' => "All links",
										   'rdf-history' => "Historical versions",
										   'rdf-interwiki' => "Interwiki links",
										   'rdf-categories' => "Categories",
										   'rdf-target' => "Target page",
										   'rdf-modelnames' => "Model(s)",
										   'rdf-format' => "Output format",
										   'rdf-output-xml' => "XML",
										   'rdf-output-turtle' => "Turtle",
										   'rdf-output-ntriples' => "NTriples",
										   'rdf-instructions' => "Select the target page and RDF models you're interested in."));;

		$wgParser->setHook( 'rdf', 'renderMwRdf' );
		SpecialPage::AddPage(new SpecialPage('Rdf', '', true, 'wfSpecialRdf',
											 'extensions/MwRdf.php'));

		# Add an RDF metadata link if requested

		$action = $wgRequest->getText('action', 'view');

		# Note: $wgTitle not yet set; have to get it from the request

		$title = $wgRequest->getText('title');

		# If there's no requested title...

		if (!isset($title) || strlen($title) == 0) {
			# If there's no title, and Cache404 is in use, check using its stuff
			if (defined('CACHE404_VERSION')) {
				if ($_SERVER['REDIRECT_STATUS'] == 404) {
					$url = getRedirectUrl($_SERVER);
					if (isset($url)) {
						$title = cacheUrlToTitle($url);
					}
				}
			}
		}

		if (isset($title) && strlen($title) > 0) {
			$nt = Title::newFromText($title);

			if (isset($nt) &&
				$nt->getNamespace() != NS_SPECIAL)
			{
				if ($action == 'view') {
					$rdft = Title::makeTitle(NS_SPECIAL, "Rdf");
					$target = $nt->getPrefixedDBkey();
					$linkdata = array('title' => 'RDF Metadata',
									  'type' => 'application/rdf+xml',
									  'href' => $rdft->getLocalURL("target={$target}" ));
					$wgOut->addMetadataLink($linkdata);
				} else if ($action == 'purge') {
					# clear cache on purge
					MwRdfClearCacheAll($nt);
				}
			}
		}

		# We set some hooks for invalidating the cache

		$wgHooks['ArticleSave'][] = 'MwRdfOnArticleSave';
		$wgHooks['ArticleSaveComplete'][] = 'MwRdfOnArticleSaveComplete';
		$wgHooks['TitleMoveComplete'][] = 'MwRdfOnTitleMoveComplete';
		$wgHooks['ArticleDeleteComplete'][] = 'MwRdfOnArticleDeleteComplete';
	}

	function wfSpecialRdf($par) {
		global $wgRequest, $wgRdfDefaultModels, $wgRdfOutputFunctions;

		$target = $wgRequest->getVal('target');

		if (!isset($target)) { # no target parameter
			MwRdfShowForm();
		} else if (strlen($target) == 0) { # no target contents
			MwRdfShowForm(wfMsg('badtitle'));
		} else {
			$nt = Title::newFromText($target);
			if ($nt->getArticleID() == 0) { # not an article
				MwRdfShowForm(wfMsg('badtitle'));
			} else {
				$article = new Article($nt);

				# Note: WebRequest chokes on arrays here
				$modelnames = $_REQUEST['modelnames'];
				if (is_null($modelnames)) {
					$modelnames = $wgRdfDefaultModels;
				}

				if (is_string($modelnames)) {
					$modelnames = explode(',', $modelnames);
				}

				$format = $wgRequest->getVal('format', 'xml');

				$outfun = $wgRdfOutputFunctions[$format];

				if (!isset($outfun)) {
					wfDebugDieBacktrace("No output function for format '$format'.");
				}

				$fullModel = MwRdfGetModel($article, $modelnames);

				$outfun($fullModel);
			}
		}
	}

	function MwRdfOutputXml($model) {

		global $wgOut, $_SERVER, $wgRdfNamespaces;

		$rdftype = wfNegotiateType(wfAcceptToPrefs($_SERVER['HTTP_ACCEPT']),
								   wfAcceptToPrefs(MWRDF_XML_TYPE_PREFS));

		if (!$rdftype) {
			wfHttpError(406, "Not Acceptable", wfMsg("notacceptable"));
			return false;
		} else {

			$wgOut->disable();
			header( "Content-type: {$rdftype}; charset=utf-8" );
			$wgOut->sendCacheControl();

			# Make sure serializer is loaded
			require_once(RDFAPI_INCLUDE_DIR . PACKAGE_SYNTAX_RDF);

			$ser = new RDFSerializer();

			$ser->configSortModel(true);
			$ser->configUseAttributes(false);
			$ser->configUseEntities(false);

			foreach($wgRdfNamespaces as $key => $value) {
				$ser->addNamespacePrefix($key,$value);
			}

			print($ser->serialize($model));

			return true;
		}
	}

	function MwRdfOutputNtriples($model) {

		global $wgOut, $_SERVER, $wgRdfNamespaces;

		$rdftype = wfNegotiateType(wfAcceptToPrefs($_SERVER['HTTP_ACCEPT']),
								   wfAcceptToPrefs(MWRDF_NTRIPLES_TYPE_PREFS));

		if (!$rdftype) {
			wfHttpError(406, "Not Acceptable", wfMsg("notacceptable"));
			return false;
		} else {

			$wgOut->disable();
			header( "Content-type: {$rdftype}; charset=utf-8" );
			$wgOut->sendCacheControl();

			# Make sure serializer is loaded
			require_once(RDFAPI_INCLUDE_DIR . PACKAGE_SYNTAX_RDF);

			$ser = new NTripleSerializer();

			print($ser->serialize($model));

			return true;
		}
	}

	function MwRdfOutputTurtle($model) {

		global $wgOut, $_SERVER, $wgRdfNamespaces;

		$rdftype = wfNegotiateType(wfAcceptToPrefs($_SERVER['HTTP_ACCEPT']),
								   wfAcceptToPrefs(MWRDF_TYPE_PREFS));

		if (!$rdftype) {
			wfHttpError(406, "Not Acceptable", wfMsg("notacceptable"));
			return false;
		} else {

			$wgOut->disable();
			header( "Content-type: {$rdftype}; charset=utf-8" );
			$wgOut->sendCacheControl();

			# Make sure serializer is loaded
			require_once(RDFAPI_INCLUDE_DIR . PACKAGE_SYNTAX_N3);

			$ser = new N3Serializer();

			foreach($wgRdfNamespaces as $key => $value) {
				$ser->addNSPrefix($key,$value);
			}

			print($ser->serialize($model));

			return true;
		}
	}

	function MwRdfGetModel($article, $modelnames = null) {

		global $wgRdfModelFunctions, $wgRdfDefaultModels;

		if ($modelnames == null) {
			$modelnames = $wgRdfDefaultModels;
		}

		$fullModel = ModelFactory::getDefaultModel();
		$title = $article->mTitle;

		$uri = $title->getFullURL();
		$fullModel->setBaseURI($uri);

		foreach ($modelnames as $modelname) {
			$modelfunc = $wgRdfModelFunctions[$modelname];
			if (!$modelfunc) {
				wfDebugDieBacktrace("MwRdf: No RDF model named '$modelname'.");
			} elseif (!function_exists($modelfunc)) {
				wfDebugDieBacktrace("MwRdf: No function named '$modelfunc' " .
									" for model '$modelname'.");
			}

			# Check the cache...

			$model = MwRdfGetCache($title, $modelname);

			# If it's not there, regenerate.

			if (!isset($model) || !$model) {
				$model = $modelfunc($article);
				MwRdfSetCache($title, $modelname, $model);
			}

			if (isset($model)) {
				$fullModel->addModel($model);
			}
		}

		return $fullModel;
	}

	function MwRdfShowForm($msg = null) {
		global $wgOut, $wgRdfModelFunctions, $wgRdfOutputFunctions, $wgRdfDefaultModels, $wgUser;
		$sk = $wgUser->getSkin();
		$instructions = $wgOut->parse(wfMsg('rdf-instructions'));
		if (isset($msg) && strlen($msg) > 0) {
			$wgOut->addHTML("<p class='error'>${msg}</p>");
		}
		$wgOut->addHTML("<p>{$instructions}</p>" .
						"<form action='" . $sk->makeSpecialUrl('Rdf') . "' method='POST'>" .
						"<table border='0'>" .
						"<tr>" .
						"<td align='right'><label for='target'>" . wfMsg('rdf-target') . "</label></td>" .
						"<td align='left'><input type='text' size='30' name='target' id='target' /></td> " .
						"</tr>" .
						"<tr>" .
						"<td align='right'><label for='modelnames[]'>" . wfMsg('rdf-modelnames') . "</label></td>" .
						"<td align='left'><select name='modelnames[]' multiple='multiple' size='6'>");
		foreach (array_keys($wgRdfModelFunctions) as $modelname) {
			$selectedpart = in_array($modelname, $wgRdfDefaultModels) ? "selected='selected'" : "";
			$wgOut->addHTML("<option value='{$modelname}' {$selectedpart}>" . wfMsg('rdf-' . $modelname) . "</option>");
		}
		$wgOut->addHTML("</select></td></tr>" .
						"<tr> " .
						"<td align='right'><label for='format'>" . wfMsg('rdf-format') . "</label></td>" .
						"<td align='left'><select name='format'>");
		foreach (array_keys($wgRdfOutputFunctions) as $outputname) {
			$wgOut->addHTML("<option value=${outputname}>" . wfMsg('rdf-output-' . $outputname) . "</option>");
		}
		$wgOut->addHTML("</select></td></tr>" .
						"<tr><td>&nbsp;</td>" .
						"<td><input type='submit' /></td></tr></table></form>");
	}

	function MwRdfInPage($article) {
		$text = $article->getContent(true);
		$parser = new Parser();
		$text = $parser->preprocess($text, $article->mTitle, new ParserOptions());

		preg_match_all("@<rdf>(.*?)</rdf>@s", $text, $matches, PREG_PATTERN_ORDER);
		$content = $matches[1];
		$rdf = implode(' ', array_values($content));

		$model = null;

		if (strlen($rdf) > 0) {

			$parser->mOutputType = OT_HTML;
			$rdf = $parser->replaceVariables($rdf);

			global $default_prefixes, $wgRdfNamespaces;
			require_once(RDFAPI_INCLUDE_DIR.PACKAGE_SYNTAX_N3);

			$parser = new N3Parser();
			$parser->baseURI = $article->mTitle->getFullURL();

			$prefixes = array_merge($default_prefixes, $wgRdfNamespaces, MwRdfNamespacePrefixes());

			$prelude = "";

			foreach ($prefixes as $prefix => $uri) {
				$prelude .= "@prefix $prefix: <$uri> .\n";
			}

			# XXX: set correct properties
			$model = $parser->parse2model($prelude . $rdf);
			if ($model === false) {
				global $RDFS_comment;
				$model = ModelFactory::getDefaultModel();
				$model->add(new Statement(MwRdfArticleResource($article),
										  $RDFS_comment,
										  MwRdfLiteral("Error parsing in-page RDF: "
													   . $parser->errors[0] .
													   "\n code here: \n '" . $prelude . $rdf . "'" , null,
													   "en")));
			} else {
				# To make it unique, we unite with an empty model
				$fake = new MemModel();
				$model =& $fake->unite($model);
			}
		}
		return $model;
	}

	function MwRdfDcmes($article) {

		global $wgContLanguageCode, $wgSitename, $DCMES, $DCMITYPE;

		$model = ModelFactory::getDefaultModel();

		$nt = $article->mTitle;
		$artres = MwRdfArticleResource($article);

		$model->add(new Statement($artres, $DCMES['title'],
								  MwRdfLiteral($article->mTitle->getText(),
											   null, $wgContLanguageCode)));
		$model->add(new Statement($artres, $DCMES['publisher'],
									MwRdfPageOrString(wfMsg('aboutpage'),
													  $wgSitename)));
		$model->add(new Statement($artres, $DCMES['language'],
								  MwRdfLanguage($wgContLanguageCode)));
		$model->add(new Statement($artres, $DCMES['type'],
								  $DCMITYPE['Text']));
		$model->add(new Statement($artres, $DCMES['format'],
								  MwRdfMediaType('text/html')));

		$model->add(new Statement($artres, $DCMES['date'],
								  MwRdfTimestamp($article->getTimestamp())));

		if (Namespace::isTalk($nt->getNamespace())) {
			$model->add(new Statement($artres, $DCMES['subject'],
									  MwRdfTitleResource($nt->getSubjectPage())));
		} else {
			$model->add(new Statement(MwRdfTitleResource($nt->getTalkPage()),
									  $DCMES['subject'], $artres));
		}

		# 'Creator' is responsible for this version

		$last_editor = $article->getUser();

		$creator = ($last_editor == 0) ?
		  MwRdfPersonResource(0) :
		  MwRdfPersonResource($last_editor, $article->getUserText(),
					 User::whoIsReal($last_editor));

		$model->add(new Statement($artres, $DCMES['creator'],
								  $creator));

		# 'Contributors' are all other version authors

		$contributors = $article->getContributors();

		foreach ($contributors as $user_parts) {
			$contributor = MwRdfPersonResource($user_parts[0],
											   $user_parts[1],
											   $user_parts[2]);
			$model->add(new Statement($artres, $DCMES['contributor'],
									  $contributor));
		}

		# Rights notification

		global $wgRightsPage, $wgRightsUrl, $wgRightsText;

		$rights = (isset($wgRightsPage) &&
				   ($nt = Title::newFromText($wgRightsPage))
				   && ($nt->getArticleID() != 0)) ?
		  MwRdfTitleResource($nt) :
		(isset($wgRightsUrl)) ?
		  MwRdfGetResource($wgRightsUrl) :
		(isset($wgRightsText)) ?
		  new Literal($wgRightsText) : null;

		if ($rights != null) {
			$model->add(new Statement($artres, $DCMES['rights'], $rights));
		}

		return $model;
	}

	function MwRdfCreativeCommons($article) {
		global $RDF_type, $CC, $wgRightsUrl;

		$ar = MwRdfArticleResource($article);
		$model = MwRdfDcmes($article);
		$model->add(new Statement($ar, $RDF_type, $CC['Work']));

		if (isset($wgRightsUrl)) {
			$lr = MwRdfGetResource($wgRightsUrl);
			$model->add(new Statement($ar, $CC['license'], $lr));
			$model->add(new Statement($lr, $RDF_type, $CC['License']));
			$terms = MwRdfGetCcTerms($wgRightsUrl);
			if (isset($terms)) {
				foreach ($terms as $term) {
					switch ($term) {
					 case 're':
						$model->add(new Statement($lr, $CC['permits'],
												  $CC['Reproduction']));
						break;
					 case 'di':
						$model->add(new Statement($lr, $CC['permits'],
												  $CC['Distribution']));
						break;
					 case 'de':
						$model->add(new Statement($lr, $CC['permits'],
												  $CC['DerivativeWorks']));
						break;
					 case 'nc':
						$model->add(new Statement($lr, $CC['prohibits'],
												  $CC['CommercialUse']));
						break;
					 case 'no':
						$model->add(new Statement($lr, $CC['requires'],
												  $CC['Notice']));
						break;
					 case 'by':
						$model->add(new Statement($lr, $CC['requires'],
												  $CC['Attribution']));
						break;
					 case 'sa':
						$model->add(new Statement($lr, $CC['requires'],
												  $CC['ShareAlike']));
						break;
					 case 'sc':
						$model->add(new Statement($lr, $CC['requires'],
												  $CC['SourceCode']));
						break;
					}
				}
			}
		}

		return $model;
	}

	function MwRdfLinksTo($article) {
		global $DCTERM;
		$model = ModelFactory::getDefaultModel();
		$nt = $article->getTitle();
		$tr = MwRdfTitleResource($nt);
		$linksto = $nt->getLinksTo();
		foreach ($linksto as $linkto) {
			$lr = MwRdfTitleResource($linkto);
			$model->add(new Statement($tr, $DCTERM['isReferencedBy'], $lr));
		}
		return $model;
	}

	function MwRdfLinksFrom($article) {
		global $DCTERM;
		$model = ModelFactory::getDefaultModel();
		$ar = MwRdfArticleResource($article);
		$dbr =& wfGetDB(DB_SLAVE);
		$res = $dbr->select(array('pagelinks'),
							array('pl_namespace', 'pl_title'),
							array('pl_from = ' . $article->mTitle->getArticleID()),
							'MwRdfLinksFrom',
							array('ORDER BY' => 'pl_namespace, pl_title'));
		while ($res && $row = $dbr->fetchObject($res)) {
			$lt = Title::makeTitle($row->pl_namespace, $row->pl_title);
			$model->add(new Statement($ar, $DCTERM['references'],
									  MwRdfTitleResource($lt)));
		}
		$dbr->freeResult($res);
		return $model;
	}

	function MwRdfAllLinks($article) {
		$model = ModelFactory::getDefaultModel();
		$model->addModel(MwRdfLinksTo($article));
		$model->addModel(MwRdfLinksFrom($article));

		return $model;
	}

	function MwRdfHistory($article) {
		global $DCTERM, $DCMES, $wgContLanguageCode;

		$model = ModelFactory::getDefaultModel();
		$nt = $article->getTitle();
		$tr = MwRdfTitleResource($nt);
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( array('page', 'revision'),
							 array('rev_id', 'rev_timestamp', 'rev_user', 'rev_user_text'),
							 array('page_namespace = ' . $nt->getNamespace(),
								   'page_title = ' . $dbr->addQuotes($nt->getDBkey()),
								   'rev_page = page_id',
								   'rev_id != page_latest'),
							 'MwRdfHistory',
							 array('ORDER BY' => 'rev_timestamp DESC'));
		while ($res && $row = $dbr->fetchObject($res)) {
			$url = $nt->getFullURL('oldid=' . $row->rev_id);
			$ur = MwRdfGetResource($url);
			$model->add(new Statement($tr, $DCTERM['hasVersion'], $ur));
			$model->add(new Statement($ur, $DCTERM['isVersionOf'], $tr));
			$model->add(new Statement($ur, $DCMES['language'], MwRdfLanguage($wgContLanguageCode)));
			$pr = MwRdfPersonResource($row->rev_user, $row->rev_user_text,
									  ($row->rev_user == 0) ? null : User::whoIsReal($row->rev_user));
			$model->add(new Statement($ur, $DCMES['creator'], $pr));
			$model->add(new Statement($ur, $DCMES['date'],
									  MwRdfTimestamp($row->rev_timestamp)));
		}
		$dbr->freeResult($res);
		return $model;
	}

	function MwRdfImage($article) {
		global $DCTERM, $DCMES, $DCMITYPE, $wgServer;

		static $typecode = array( 1 => 'image/gif', 2 => 'image/jpeg',
								  3 => 'image/png' );

		$model = ModelFactory::getDefaultModel();

		$nt = $article->getTitle();
		$tr = MwRdfTitleResource($nt);

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select('imagelinks',
							array('il_to'),
							array('il_from = ' . $nt->getArticleID()),
							'MwRdfImage');

		while ($res && $row = $dbr->fetchObject($res)) {
			$img = Image::newFromName($row->il_to);
			if ($img->exists()) {
				$iuri = $img->getURL();
				if ($iuri[0] == '/') {
					$iuri = $wgServer . $iuri;
				}
				$ir = MwRdfGetResource($iuri);
				$model->add(new Statement($tr, $DCTERM['hasPart'], $ir));
				$model->add(new Statement($ir, $DCMES['type'], $DCMITYPE['Image']));
				$tc = $img->getMimeType();
				$mt = $typecode[$tc];
				if (isset($mt)) {
					$model->add(new Statement($ir, $DCMES['format'],
											  MwRdfMediaType($mt)));
				}
				$hl = $img->nextHistoryLine();
				if ($hl) {
					$creator = MwRdfPersonResource($hl->img_user, $hl->img_user_text,
												   User::whoIsReal($hl->img_user));
					$model->add(new Statement($ir, $DCMES['creator'], $creator));
					$model->add(new Statement($ir, $DCMES['date'],
											  MwRdfTimestamp($hl->img_timestamp)));
					$seen = array($hl->img_user => true);
					while ($hl = $img->nextHistoryLine()) {
						if (!isset($seen[$hl->img_user])) {
							$contributor = MwRdfPersonResource($hl->img_user, $hl->img_user_text,
															   User::whoIsReal($hl->img_user));
							$model->add(new Statement($ir, $DCMES['contributor'], $contributor));
							$seen[$hl->img_user] = true;
						}
					}
				}
			}
		}

		$dbr->freeResult($res);
		return $model;
	}

	function MwRdfInterwiki($article) {
		global $DCTERM, $DCMES, $DCMITYPE, $RDFS_seeAlso, $wgContLang;

		$model = ModelFactory::getDefaultModel();

		$nt = $article->getTitle();
		$tr = MwRdfTitleResource($nt);
		$text = $article->getContent(true);

		$parser = new Parser();

		$text = $parser->preprocess($text, $article->mTitle, new ParserOptions());
		# XXX: this sucks
		# Ignore <nowiki> blocks
		$text = preg_replace("|(<nowiki>.*</nowiki>)|", "", $text);

		# Find prefixed links
		preg_match_all("/\[\[([^|\]]+:[^|\]]+)(\|.*)?\]\]/", $text, $matches);

		# XXX: this fails for Category: namespace; why?

		if (isset($matches)) {
			foreach ($matches[1] as $linktext) {
				$iwlink = Title::newFromText($linktext);
				if (isset($iwlink)) {
					$pfx = $iwlink->getInterwiki();
					if (strlen($pfx) > 0) {
						$iwr = MwRdfTitleResource($iwlink);
						# XXX: Wikitravel uses some 4+ prefixes for sister site links
						if ($wgContLang->getLanguageName($pfx) && strlen($pfx) < 4) {
							$model->add(new Statement($tr, $DCTERM['hasVersion'], $iwr));
							$model->add(new Statement($iwr, $DCMES['language'],
													  MwRdfLanguage($pfx)));
						} else {
							# XXX: Express the "sister site" relationship better
							$model->add(new Statement($tr, $RDFS_seeAlso,
													  $iwr));
						}
					}
				}
			}
		}

		return $model;
	}

	function MwRdfCategories($article) {
		global $DCMES;

		$model = ModelFactory::getDefaultModel();
		$nt = $article->mTitle;
		$ar = MwRdfTitleResource($nt);
		$categories = $nt->getParentCategories();

		if (is_array($categories)) {
			foreach (array_keys($categories) as $category) {
				$cattitle = Title::newFromText($category);
				$model->add(new Statement($ar, $DCMES['subject'],
										  MwRdfTitleResource($cattitle)));
			}
		}

		return $model;
	}

	# Utility functions

	# A dummy rendering procedure for the <rdf> ... </rdf> block used for in-page RDF

	function renderMwRdf($input, $argv = null, $parser = null) {
		return ' ';
	}

	function MwRdfGetResource($url) {
		static $_MwRdfResourceCache = array();

		if ($_MwRdfResourceCache[$url]) {
			return $_MwRdfResourceCache[$url];
		} else {
			$res = new Resource($url);
			$_MwRdfResourceCache[$url] = $res;
			return $res;
		}
	}

	function MwRdfArticleResource($article) {
		$title = $article->getTitle();
		return MwRdfTitleResource($title);
	}

	function MwRdfTitleResource($title) {
		return MwRdfGetResource($title->getFullURL());
	}

	function MwRdfPersonResource($id, $user_name='', $user_real_name='') {
		global $wgContLang;

		if ($id == 0) {
			return new Literal(wfMsg('anonymous'));
		} else if ( !empty($user_real_name) ) {
			return new Literal($user_real_name);
		} else {
			# XXX: This shouldn't happen.
			if( empty( $user_name ) ) {
				$user_name = User::whoIs($id);
			}
			return MwRdfPageOrString($wgContLang->getNsText(NS_USER) . ':' . $user_name,
									 wfMsg('siteuser', $user_name));
		}
	}

	function MwRdfPageOrString($page, $str) {
		$nt = Title::newFromText($page);

		if (!$nt || $nt->getArticleID() == 0) {
			return MwRdfLiteral($str);
		} else {
			return MwRdfTitleResource($nt);
		}
	}

	function MwRdfGetCcTerms($url) {
		static $knownLicenses;

		if (!isset($knownLicenses)) {
			$knownLicenses = array();
			$ccLicenses = array('by', 'by-nd', 'by-nd-nc', 'by-nc',
								'by-nc-sa', 'by-sa', 'nd', 'nd-nc',
								'nc', 'nc-sa', 'sa');
			$ccVersions = array('1.0', '2.0', '2.5');

			foreach ($ccVersions as $version) {
				foreach ($ccLicenses as $license) {
					if( $version != '1.0' && substr($license, 0, 2) != 'by' ) {
						# 2.0 dropped the non-attribs licenses
						continue;
					}
					$lurl = "http://creativecommons.org/licenses/{$license}/{$version}/";
					$knownLicenses[$lurl] = explode('-', $license);
					$knownLicenses[$lurl][] = 're';
					$knownLicenses[$lurl][] = 'di';
					$knownLicenses[$lurl][] = 'no';
					if (!in_array('nd', $knownLicenses[$lurl])) {
						$knownLicenses[$lurl][] = 'de';
					}
				}
			}

			/* Handle the GPL and LGPL, too. */

			$knownLicenses['http://creativecommons.org/licenses/GPL/2.0/'] =
			  array('de', 're', 'di', 'no', 'sa', 'sc');
			$knownLicenses['http://creativecommons.org/licenses/LGPL/2.1/'] =
			  array('de', 're', 'di', 'no', 'sa', 'sc');
			$knownLicenses['http://www.gnu.org/copyleft/fdl.html'] =
			  array('de', 're', 'di', 'no', 'sa', 'sc');
		}

		return $knownLicenses[$url];
	}

	function MwRdfLiteral($str, $type = null, $lang = null) {
		static $cache = array();
		if (isset($cache["$type:$lang:$str"])) {
			return $cache["$type:$lang:$str"];
		} else {
			if (isset($lang)) {
				$lit = new Literal($str, $lang);
			} else {
				$lit = new Literal($str);
			}

			if (isset($type)) {
				$lit->setDatatype($type);
			}
			$cache["$type:$lang:$str"] = $lit;
			return $lit;
		}
	}

	function MwRdfMediaType($str) {
		return MwRdfLiteral($str, DC_NS . 'IMT');
	}

	function MwRdfLanguage($code) {
		return MwRdfLiteral($code, DC_NS . 'ISO639-2');
	}

	function MwRdfTimestamp($timestamp) {
		$dt = wfTimestamp(TS_DB, $timestamp);
		# 'YYYY-MM-DD HH:MI:SS' => 'YYYY-MM-DDTHH:MI:SSZ'
		$dt = str_replace(" ", "T", $dt) . "Z";
		return MwRdfLiteral($dt, DC_NS . W3CDTF);
	}

	# Returns an array of prefixes for all namespaces

	function MwRdfNamespacePrefixes() {
		static $prefixes;

		if (!isset($prefixes)) {
			global $wgLang; # all working namespaces
			$prefixes = array();
			$spaces = $wgLang->getNamespaces();
			foreach ($spaces as $code => $text) {
				$prefix = urlencode(str_replace(' ', '_', $text));
				# FIXME: this is a hack
				if (strpos($prefix, '%') === false) {
					# XXX: figure out a less sneaky way to do this
					# XXX: won't work if article title isn't at the end of the URL
					$title = Title::makeTitle($code, '');
					$uri = $title->getFullURL();
					$prefixes[$prefix] = $uri;
				}
			}
		}
		return $prefixes;
	}

	function MwRdfGetCache($title, $modelname) {
		global $wgMemc;
		if (!isset($wgMemc)) {
			return false;
		} else {
			$ntrip = $wgMemc->get(MwRdfCacheKey($title, $modelname));
			if (isset($ntrip) && $ntrip && strlen($ntrip) > 0) {
				return MwRdfNTriplesToModel($ntrip);
			} else {
				return null;
			}
		}
	}

	function MwRdfClearCache($title, $modelname) {
		global $wgMemc;
		if (!isset($wgMemc)) {
			return false;
		} else {
			return $wgMemc->delete(MwRdfCacheKey($title, $modelname));
		}
	}

	function MwRdfClearCacheAll($title) {
		global $wgRdfModelFunctions;
		$nt = $title;
		foreach (array_keys($wgRdfModelFunctions) as $modelname) {
			MwRdfClearCache($nt, $modelname);
		}
	}

	function MwRdfSetCache($title, $modelname, $model) {
		global $wgMemc, $wgRdfCacheExpiry;
		if (!isset($wgMemc)) {
			return false;
		} else {
			return $wgMemc->set(MwRdfCacheKey($title, $modelname),
								MwRdfModelToNTriples($model),
								$wgRdfCacheExpiry);
		}
	}

	function MwRdfCacheKey($title, $modelname) {
		if (!isset($title)) {
			return null;
		} else {
			global $wgDBname;
			$dbkey = $title->getDBkey();
			$ns = $title->getNamespace();
			return "$wgDBname:rdf:$ns:$dbkey:$modelname";
		}
	}

	# Before saving, we clear the cache for articles this article links to

	function MwRdfOnArticleSave($article, $dc1, $dc2, $dc3, $dc4, $dc5, $dc6) {
		$id = $article->mTitle->getArticleID();
		if ($id != 0) {
			$dbr =& wfGetDB(DB_SLAVE);
			$res = $dbr->select('pagelinks',
								array('pl_namespace', 'pl_title'),
								array('pl_from = ' . $id),
								'MwRdfOnArticleSave');
			while ($res && $row = $dbr->fetchObject($res)) {
				$lt = Title::makeTitle($row->pl_namespace, $row->pl_title);
				MwRdfClearCache($lt, 'linksto');
			}
		}
	    return true;
	}

	# Clear the cache when the article is saved

	function MwRdfOnArticleSaveComplete($article, $dc1, $dc2, $dc3, $dc4, $dc5, $dc6) {
	   MwRdfClearCacheAll($article->mTitle);
	    return true;
	}

	# Clear the cache when an article is moved

	function MwRdfOnTitleMoveComplete($oldt, $newt, $user, $oldid, $newid) {
	   MwRdfClearCacheAll($newt);
	   MwRdfClearCacheAll($oldt);
	    return true;
	}

	# Clear the cache when an article is deleted

	function MwRdfOnArticleDeleteComplete($article, $user, $reason) {
		MwRdfClearCacheAll($article->mTitle);
	    return true;
	}

	function MwRdfNTriplesToModel($ntrip) {
		require_once(RDFAPI_INCLUDE_DIR.PACKAGE_SYNTAX_N3);
		$parser = new N3Parser();
		$model = $parser->parse2model($ntrip);
		return $model;
	}

	function MwRdfModelToNTriples($model) {
		# Make sure serializer is loaded
		if (!isset($model) || $model->size() == 0) {
			return '';
		} else {
			require_once(RDFAPI_INCLUDE_DIR . PACKAGE_SYNTAX_N3);
			$ser = new NTripleSerializer();
			return $ser->serialize($model);
		}
	}

	# This is used by a lot of RDF extensions, so put it here

	function MwRdfFullUrlToTitle($url) {
		global $wgArticlePath, $wgServer;
		$parts = parse_url($url);
		$relative = $parts['path'];
		if (!is_null($parts['query']) && strlen($parts['query']) > 0) {
			$relative .= '?' . $parts['query'];
		}
		$pattern = str_replace('$1', '(.*)', $wgArticlePath);
		$pattern = str_replace('?', '\?', $pattern);
		# Can't have a pound-sign in the relative, since that's for fragments
		if (preg_match("#$pattern#", $relative, $matches)) {
			$titletext = urldecode($matches[1]);
			$nt = Title::newFromText($titletext);
			return $nt;
		} else {
			return null;
		}
	}

}


