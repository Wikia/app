<?php
$wgExtensionFunctions[] = "wfInflectionExtension";

function wfInflectionExtension() {
	global $wgParser;
	$wgParser->setHook("infl", "renderInflection");
}

class InflectionRule {
	var $entryMatchPattern;
	var $inflKeyPattern;
	var $generationReplacementPattern;

	function InflectionRule ($ruleAttributes)
	{
		$this->generationReplacementPattern = array();
		foreach ($ruleAttributes as $key=>$value) {
			switch($key) {
				case "entry":
					$this->entryMatchPattern = $value; break;
				case "key":
					$this->inflKeyPattern = $value; break;
				default:
					$this->generationReplacementPattern[$key] = $value;
			}
       }
   }
}

function readRules($lang, $pos)
{
	$ruleSettingsTitle = Title::newFromText("infl-$lang-$pos", NS_MEDIAWIKI);
	$revision = Revision::newFromTitle($ruleSettingsTitle);
	if(!$revision)
		throw new Exception("missing MediaWiki:infl-$lang-$pos");
	$ruleXml = $revision->getText();
	$parser = xml_parser_create();
	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parse_into_struct($parser, $ruleXml, $ruleTagValues, $ruleTagIndices);
	xml_parser_free($parser);

	for ($i=0; $i < count($ruleTagIndices["rule"]); $i+=2) {
		$offset = $ruleTagIndices["rule"][$i] + 1;
		$len = $ruleTagIndices["rule"][$i + 1] - $offset;
		$rules[] = parseRuleTags(array_slice($ruleTagValues, $offset, $len));
	}

	return $rules;
}

function parseRuleTags($ruleTagValues)
{
   for ($i=0; $i < count($ruleTagValues); $i++) {
       $ruleAttributes[$ruleTagValues[$i]["tag"]] = $ruleTagValues[$i]["value"];
   }
   return new InflectionRule($ruleAttributes);
}

function renderInflection($input, $argv) {
	global $wgParser, $wgUser;

	$key = $wgParser->replaceVariables($input, end( $wgParser->mArgStack ));
	if(array_key_exists("lang", $argv))
		$language = $argv["lang"];
	else
		return "?<!-- missing required \"lang\" parameter. -->";
	if(array_key_exists("pos", $argv))
		$partOfSpeech = $argv["pos"];
	else
		return "?<!-- missing required \"pos\" parameter. -->";
	if(array_key_exists("generate", $argv))
		$inflectionTypeToGenerate = $argv["generate"];
	else
		return "?<!-- missing required \"generate\" parameter. -->";

	$entry = $wgParser->mTitle->getText();

	try {
		$rules = readRules($language, $partOfSpeech);
		foreach($rules as $rule) {
			if($rule->entryMatchPattern)
			{
				if(!$rule->inflKeyPattern ||
					($rule->inflKeyPattern && preg_match("/" . $rule->inflKeyPattern . "/", $wgParser->replaceVariables($key, $wgParser->mArgStack))))
				{
					$inflectedForm = preg_replace(
						"/" . $rule->entryMatchPattern . "/",
						$rule->generationReplacementPattern[$inflectionTypeToGenerate],
						$entry, -1, $count);
					if($count >= 1)
						return $inflectedForm;
				}
			} elseif($rule->inflKeyPattern) {
				$inflectedForm = preg_replace(
					"/" . $rule->inflKeyPattern . "/",
					$rule->generationReplacementPattern[$inflectionTypeToGenerate],
					$wgParser->replaceVariables($key, $wgParser->mArgStack), -1, $count);
				if($count >= 1)
					return $inflectedForm;
			}
		}
	} catch (Exception $e) {
		return "?<!-- " . $e->getMessage() . " -->";
	}
}

