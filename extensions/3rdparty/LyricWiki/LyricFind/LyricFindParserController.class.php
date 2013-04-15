<?php

class LyricFindParserController extends WikiaController {

	const NAME = 'lyricfind';
	const CATEGORY = 'LyricFind Lyrics';

	/**
	 * Call controller view to render <lyricfind> parser hook
	 *
	 * Add an article to appriopriate category
	 *
	 * @param $content string tag content
	 * @param array $arguments tag atribbutes
	 * @param Parser $parser parser instance
	 * @return string rendered content
	 */
	static public function render($content, Array $arguments, Parser $parser) {
		wfProfileIn(__METHOD__);

		$data = array_merge($arguments, [
			'lyric' => self::encodeLyric($content)
		]);

		// RingTone URL
		$data['ringtoneUrl'] = 'http://www.ringtonematcher.com/co/ringtonematcher/02/noc.asp' . http_build_query([
			'sid' => 'WILWros',
			'artist' => $data['artist'],
			'song' => $data['song']
		]);

		$html = F::app()->renderPartial('LyricFindParser', 'content', $data);

		// add a category + CSS and JavaScript
		$parser->getOutput()->addCategory(self::CATEGORY, self::CATEGORY);
		$parser->getOutput()->addModules('ext.lyrics.lyricbox');

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * @see http://stackoverflow.com/questions/3005116/how-to-convert-all-characters-to-their-html-entity-equivalent-using-php
	 */
	private static function encodeUtf($str) {
		$str = mb_convert_encoding($str , 'UTF-32', 'UTF-8');
		$t = unpack("N*", $str);
		$t = array_map(function($n) {
			return $n != 10 ? "&#$n;" : "\n"; // keep newlines
		}, $t);

		return implode("", $t);
	}

	/**
	 * Encode and obfuscate lyric content
	 *
	 * @param $lyric string content
	 * @return string processed content
	 */
	private static function encodeLyric($lyric) {
		$lyric = self::encodeUtf($lyric);

		$lyric = strtr(trim($lyric), [
			"\n\n" => '</p><p>',
			"\n" => '<br>',
		]);

		return $lyric;
	}

	/**
	 * Render HTML for <lyricfind> parser hook
	 */
	public function content() {}
}
