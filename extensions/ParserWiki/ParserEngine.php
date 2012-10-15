<?php
/**
 * Acts as the primary interface between the world and the parser.
 * mStartRule - the first rule to use while parsing
 * mRules - The list of rules to use while parsing
 * mDom - Used to create Dom objects and get's returned at the end of parsing
 * mIter - Keeps track of how many times the parser recurses to stop endless loops
 */
class ParseEngine {
	const maxIter = 2048;
	private $mGrammars;

	function __construct() {
		$this->mGrammars = array();
	}

	function parse($grammarName, &$text) {
		wfDebugLog("ParseEngine", "==========Start Parse Engine==========\n");
		$grammar = isset($this->mGrammars[$grammarName]) ? $this->mGrammars[$grammarName] : NULL;
		if ($grammar == NULL) {
			$revision = Revision::newFromTitle(Title::newFromText($grammarName, NS_GRAMMAR));
			$grammar = new DOMDocument();
			if ($revision == NULL || ! $grammar->loadXML($revision->getText(), LIBXML_NOBLANKS)) {
				return TRUE;
			}
			$this->pushTags($grammar->documentElement, NULL);
			$this->mGrammars[$grammarName] = $grammar;
		}
		$doc = new DOMDocument();
		$rootTag = $doc->createElement($grammar->documentElement->getAttribute("rootTag"));
		$startRule = $grammar->documentElement->getAttribute("startRule");
		$xpath = new DOMXPath($grammar);
		$startRule = $xpath->query("/Grammar/*[@name='$startRule']")->item(0);
		$refText = $text;
		if (! $this->parseRec($startRule, "", "", $iter, $refText, $rootTag)) {
			return TRUE;
		}
		$doc->appendChild($rootTag);
		$text = $doc->saveXML();
		wfDebugLog("ParseEngine", "Parsed text - $text\n");
		return TRUE;
	}

	static function unparse($inNodes) {
		$retStr = "";
		foreach ($inNodes as $child) {
			if ($child instanceof DOMText) {
				$retStr .= $child->data;
			} else {
				$retStr .= $child->getAttribute("tag") . self::unparse($child->childNodes);
			}
		}
		return $retStr;
	}

	private function parseRec($rule, $replaceStr, $saveTags, &$iter, &$text, &$outNode) {
		wfDebugLog("ParseEngine", "Entering {$rule->nodeName}, {$rule->getAttribute("name")}\n");
		$iter ++;
		if ($iter > ParseEngine::maxIter) {
			throw new MWException("Parser iterated too many times. Probable loop in grammar.");
		}
		if ($rule->nodeName == "Assignment" || $rule->nodeName == "Reference" || $rule->nodeName == "Text") {
			$saveTags = str_replace("~r", preg_quote($replaceStr, "/"), $saveTags);
			$newTags = $rule->getAttribute("saveTags");
			if ($saveTags == "") {
				$saveTags = $newTags;
			} elseif ($newTags != "") {
				$saveTags .= "|" . $newTags;
			}
		}
		$dom = $outNode->ownerDocument;
		$retCode = FALSE;
		if ($rule->nodeName == "Assignment") {
			$tag = $rule->getAttribute("tag");
			$foundTag = $tag == NULL;
			if (! $foundTag) {
				if ($rule->getAttribute("regex") != NULL) {
					$tag = str_replace("~r", preg_quote($replaceStr, "/"), $tag);
					$foundTag = preg_match("/^$tag/s", $text, $matches);
					if ($foundTag) {
						$tag = $matches[0];
						if (isset($matches[1])) {
							$replaceStr = $matches[1];
						}
					}
				} else {
					$tag = str_replace("~r", $replaceStr, $tag);
					$foundTag = strncmp($tag, $text, strlen($tag)) == 0;
				}
			}
			if ($foundTag) {
				$newText = $text;
				$newElement = $dom->createElement($rule->getAttribute("tagName"));
				if ($tag != NULL) {
					$newText = substr($newText, strlen($tag));
					$newElement->setAttribute("tag", $tag);
				}
				$retCode = $rule->firstChild == NULL || $this->parseRec($rule->firstChild, $replaceStr, $saveTags, $iter, $newText, $newElement);
				if ($retCode) {
					$outNode->appendChild($newElement);
					$text = $newText;
				}
			}
		} elseif ($rule->nodeName == "Sequence") {
			$saveText = $text;
			$saveNode = $outNode->cloneNode(TRUE);
			$pushInd = $rule->getAttribute("pushInd");
			foreach ($rule->childNodes as $i => $crrnt) {
				$pushTags = $i >= $pushInd ? $saveTags : "";
				$retCode = $this->parseRec($crrnt, $replaceStr, $pushTags, $iter, $text, $outNode);
				if (! $retCode) {
					$text = $saveText;
					$outNode = $saveNode;
					break;
				}
			}
		} elseif ($rule->nodeName == "Choice") {
			foreach ($rule->childNodes as $crrnt) {
				$retCode = $this->parseRec($crrnt, $replaceStr, $saveTags, $iter, $text, $outNode);
				if ($retCode) {
					break;
				}
			}
			$retCode |= $rule->getAttribute("failSafe") != NULL;
		} elseif ($rule->nodeName == "Reference") {
			$newVar = $rule->hasAttribute("var") ? str_replace("~r", $replaceStr, $rule->getAttribute("var")) : $replaceStr;
			$xpath = new DOMXPath($rule->ownerDocument);
			$refRule = $xpath->query("/Grammar/*[@name='{$rule->getAttribute("name")}']")->item(0);
			$retCode = $this->parseRec($refRule, $newVar, $saveTags, $iter, $text, $outNode);
		} elseif ($rule->nodeName == "Text") {
			$tagSearch = $rule->getAttribute("childTags");
			if ($tagSearch == "") {
				$tagSearch = $saveTags;
			} elseif ($saveTags != "") {
				$tagSearch .= "|" . $saveTags;
			}
			while ($text != "" && ($saveTags == "" || ! preg_match("/^($saveTags)/s", $text))) {
				$offset = $rule->firstChild != NULL && $this->parseRec($rule->firstChild, $replaceStr, "", $iter, $text, $outNode) ? 0 : 1;
				if (preg_match("/$tagSearch/s", $text, $matches, PREG_OFFSET_CAPTURE, $offset)) {
					if ($matches[0][1] > 0) {
						$outNode->appendChild($dom->createTextNode(substr($text, 0, $matches[0][1])));
						$text = substr($text, $matches[0][1]);
					}
				} else {
					$outNode->appendChild($dom->createTextNode($text));
					$text = "";
				}
			}
			$retCode = true;
		}
		wfDebugLog("ParseEngine", "Exiting {$rule->nodeName}, Return Code - $retCode\n");
		wfDebugLog("ParseEngine", "Text - $text\n");
		return $retCode;
	}

	private function pushTags($rule, $tagStr) {
		if ($rule->nodeName == "Sequence") {
			$pushInd = $rule->childNodes->length - 1;
			$shouldPush = true;
			for ($child = $rule->lastChild; $child != NULL; $child = $child->previousSibling) {
				$this->pushTags($child, $tagStr);
				if ($child->previousSibling != NULL) {
					if ($this->pullTags($child, $iter, $childTag)) {
						if ($shouldPush) {
							$pushInd --;
						}
						if ($tagStr == "") {
							$tagStr = $childTag;
						} elseif ($childTag != "") {
							$tagStr .= "|" . $childTag;
						}
					} else {
						$shouldPush = false;
						$tagStr = $childTag;
					}
				}
			}
			$rule->setAttribute("pushInd", $pushInd);
		} else {
			if ($rule->nodeName != "Choice") {
				$rule->setAttribute("saveTags", $tagStr);
				$tagStr = NULL;
				if ($rule->nodeName == "Text") {
					$childTags = "";
					foreach ($rule->childNodes as $crrnt) {
						if ($childTags != "") {
							$childTags .= "|";
						}
						$this->pullTags($crrnt, $iter, $childTag);
						$childTags .= $childTag;
					}
					$rule->setAttribute("childTags", $childTags);
				}
			}
			foreach ($rule->childNodes as $crrnt) {
				$this->pushTags($crrnt, $tagStr);
			}
		}
	}

	private function pullTags($rule, &$iter, &$childTags) {
		$iter ++;
		if ($iter > ParseEngine::maxIter) {
			throw new MWException("Collecter iterated too many times. Probable loop in grammar.");
		}
		$childTags = "";
		$failSafe = TRUE;
		if ($rule->nodeName == "Assignment") {
			$childTags = $rule->getAttribute("tag");
			if ($rule->getAttribute("regex") == NULL) {
				$childTags = preg_quote($childTags, "/");
			}
			$failSafe = FALSE;
		} elseif ($rule->nodeName == "Choice" || $rule->nodeName == "Sequence") {
			$failSafe = $rule->nodeName == "Sequence";
			foreach ($rule->childNodes as $child) {
				$failSafe = $this->pullTags($child, $iter, $newTags);
				if ($childTags == "") {
					$childTags = $newTags;
				} elseif ($newTags != "") {
					$childTags .= "|" . $newTags;
				}
				if (($failSafe && $rule->nodeName == "Choice") || (! $failSafe && $rule->nodeName == "Sequence")) {
					break;
				}
			}
			$failSafe |= $rule->nodeName == "Choice" && $rule->getAttribute("failSafe") != NULL;
		} elseif ($rule->nodeName == "Reference") {
			$xpath = new DOMXPath($rule->ownerDocument);
			$refRule = $xpath->query("/Grammar/*[@name='{$rule->getAttribute("name")}']")->item(0);
			$failSafe = $this->pullTags($refRule, $iter, $childTags);
		}
		return $failSafe;
	}
}

