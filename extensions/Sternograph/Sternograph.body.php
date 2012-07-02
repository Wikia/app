<?php
/**
 Processes the Sternograph tags.
 Requires PHP 5 as it uses some unique methods.
*/
class Sternograph{
//====FIELDS
	/**
	Separates the different lines.
	*/
	const DELIMETER = '^'; 
	/**
	Delimeter for Speaker blocks.  The very first occurence of this string
	is used to separate the speaker block from the content block.
	*/
	const SPEAKER_DELIM = '^^^';
	/**
	Delimeter for Context block.  The very last occurence of this string
	is used to separate the content block from the context block.
	*/
	const CONTEXT_DELIM = '^^';
	/**
	Indicates an in-line break in the speaker.
	*/
	const INLINE = '_';
	/**
	Separator indicating who the speaker is.
	*/
	const SPEAKER_IS = '=';
	/**
	The name of the tag; used to set our hook and prevent recursive
	Sternographs.
	*/
	const TAG = 'sterno';
//====CONSTRUCTORS
	/**
	Core constructor.  Sets the hooks to be used.
	*/
	function __construct($parser){
		$parser->setHook(Sternograph::TAG, array($this, 'parse'));
	}
//====METHODS
	/**
	Performs the processing of everything within the <sterno> tags.  Note that everything is done
	with local variables for thread safety.

	@param $input The user text provided within the <sterno> tags.
	@param array $args The sterno tag arguments.  None are accepted, so this field is ignored.
	@param Parser $parser The parser.
	@param PPFrame $frame The frame.
	@return string The formatted text that will be displayed on the browser.
	*/
	public function parse($input, array $args, Parser $parser, PPFrame $frame){
	//Sanity checks
		if ($input == null){
			return Sternograph::error('sternograph-empty', Sternograph::TAG);
		}
		if (preg_match('/<\s*'.Sternograph::TAG.'\s*>/', $input) > 0){
			return Sternograph::error('sternograph-nested', Sternograph::TAG);
		}
	//3 chunks we have to work through:
		$speakers = null;
		$lines = null;
		$context = null;
	//Speakers is optional; if present, it comes first
		$speakers = strpos($input, Sternograph::SPEAKER_DELIM);
		if ($speakers === false){
			$speakers = null;
			$lines = $input;
		}else{
			$lines = substr($input,
				$speakers + strlen(Sternograph::SPEAKER_DELIM));
			$speakers = substr($input, 0, $speakers);
		}
	//Context is also optional, and comes last if present
		$context = strrpos($lines, Sternograph::CONTEXT_DELIM);
		if ($context === false){
			$context = null;
		}else{
			$input = substr($lines, 0, $context);
			$context = substr($lines, $context + strlen(Sternograph::CONTEXT_DELIM));
			$context = wfMsgNoTrans('sternograph-context-pre').
				trim($context).
				wfMsgNoTrans('sternograph-context-post');
			$context = '<div class="sternographContext">'.
				$parser->recursiveTagParse($context, $frame).
				'</div>';
			$lines = $input;
		}
		return Sternograph::render(trim($speakers), trim($lines), $parser, $frame).$context;
	}

	static private function render($speakers, $lines, Parser $parser, PPFrame $frame){
		$speakers = Sternograph::parseSpeakers($speakers, $parser, $frame);
		if ($speakers != null && !is_array($speakers)){
			return $speakers;
		}
		$result = null;
		$current = null;
		$lines = explode(Sternograph::DELIMETER, $lines);
		$limit = count($lines);
		for ($i = 0; $i < $limit; $i++){
			$current = $lines[$i];
			if (Sternograph::contains($current, Sternograph::SPEAKER_IS)){
				$result .= Sternograph::line($current, $speakers, $parser, $frame);
			}else{
				$result .= Sternograph::direction($current, $speakers, true, $parser, $frame);
			}
			if ($i+1 != $limit){//There are more tokens
				$result .='<br/>';
			}
		}
		return '<div class="sternograph">'.$result.'</div>';
	}

	static private function parseSpeakers($speakers, Parser $parser, PPFrame $frame){
		if ($speakers == null){
			return null;
		}else{
			$speakers = explode('<br />',
				nl2br($speakers));
			$result = array();
			foreach ($speakers as $i){
				if (preg_match('/[^\s]+/', $i) > 0){
					$i = Sternograph::splitSpeaker($i);
					if (is_array($i)){
						$result[$i[0]] = $parser->recursiveTagParse(trim($i[1]), $frame);
					}else{
						return $i;
					}
				}else{
					continue;
				}
			}
			return $result;
		}
	}

	static private function splitSpeaker($raw){
		if (Sternograph::contains($raw, Sternograph::SPEAKER_IS)){
			$raw = explode(Sternograph::SPEAKER_IS, $raw);
			$raw[0] = Sternograph::collapseWhitespace($raw[0]);
			$raw[1] = trim($raw[1]);
			return $raw;
		}else{
			return Sternograph::error('sternograph-speaker-is', Sternograph::TAG, Sternograph::SPEAKER_IS);
		}
	}

	static private function line($raw, $speakers, Parser $parser, PPFrame $frame){
		$result = '<font class="sternographName">'.wfMsgNoTrans('sternograph-speaker-pre');
		$raw = Sternograph::splitSpeaker($raw);
		if (!is_array($raw)){
			return $raw;
		}
		$raw[0] = trim($raw[0]);
		if ($speakers == null || !isset($speakers[$raw[0]])){
			$raw[0] = $parser->recursiveTagParse($raw[0]);
		}else{
			$raw[0] = $speakers[$raw[0]];
		}
		$result .= $raw[0].wfMsgNoTrans('sternograph-speaker-post').'</font>';
		$raw = explode(Sternograph::INLINE, $raw[1]);
		$limit = count($raw);
		$result .= Sternograph::expandSpeakers($raw[0], $speakers, $parser, $frame);
		for ($i = 1; $i < $limit; $i++){
			if ($i % 2 == 0){
				$result .= Sternograph::expandSpeakers($raw[$i], $speakers, $parser, $frame);
			}else{
				$result .= Sternograph::direction($raw[$i], $speakers, false, $parser, $frame);
			}
			if ($i+1 != $limit){//There are more tokens
				$result .='&nbsp;';
			}
		}
		return $result;
	}

	static private function expandSpeakers($raw, $speakers, Parser $parser, PPFrame $frame){
		if ($speakers != null){
			foreach($speakers as $key => $value){
				$raw = preg_replace('/<\s*'.$key.'\s*>/', $value, $raw);
			}
		}
		return $parser->recursiveTagParse($raw, $frame);
	}

	static private function direction($raw, $speakers, $block, Parser $parser, PPFrame $frame){
		if ($block === true){
			return '<font class="sternographDirection sternographDirectionBlock">'.
					Sternograph::expandSpeakers(wfMsgNoTrans('sternograph-block-pre').
						$raw.wfMsgNoTrans('sternograph-block-post'),
					$speakers, $parser, $frame).'</font>';
		}else{
			return '<font class="sternographDirection sternographDirectionInline">'.
					Sternograph::expandSpeakers(wfMsgNoTrans('sternograph-inline-pre').
							$raw.wfMsgNoTrans('sternograph-inline-post'),
					$speakers, $parser, $frame).'</font>';
		}
	}

//====
	/**
	Returns the i18n'd error message.
	*/
	static private function error($key, $param1 = '', $param2 = ''){
		return '<strong class="error">' . htmlspecialchars( wfMsgForContent( $key, $param1, $param2 ) ) .'</strong>';
	}

	/**
	Trims and then strips multiple whitespace, so that only the first one appears.
	*/
	static public function collapseWhitespace($str){
		return preg_replace('/\s\s+/', ' ', trim($str));
	}

	/**
	The given haystack contains the desired needle.
	*/
	static public function contains($haystack, $needle){
		return strpos($haystack, $needle) !== false;
	}
}
