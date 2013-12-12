<?php
class ChatPreferenesHooks {
	/**
	 * @var String user_property value in DB
	 */
	const CHAT_INCOMING_MESSAGE_SOUND_KEY = 'chatincomingmessagesound';

	/**
	 * @var String chat sounds sub-directory
	 */
	const CHAT_SOUNDS_DIR = '/sounds/';

	/**
	 * @var String chat sounds memcached key
	 */
	const CHAT_SOUNDS_MEMC_KEY = 'chat-sounds';

	static function loadSounds() {
		return WikiaDataAccess::cache(
			wfSharedMemcKey( self::CHAT_SOUNDS_MEMC_KEY ),
			( 14 * 24 * 60 * 60 ), // 14 days
			function() {
				$files = [];
				$path = __DIR__ . self::CHAT_SOUNDS_DIR;
				$dir = new DirectoryIterator( $path );

				while( !$dir->isDot() && $dir->isReadable() ) {
					$files[] = $dir->getFilename();
					$dir->next();
				}

				return $files;
			}
		);
	}

	static function getSounds() {
		$soundsFromFS = self::loadSounds();

		$out = [];
		foreach( $soundsFromFS as $sound ) {
			$filename = explode( '.', $sound );
			$name = ucwords( str_replace( '-', ' ', $filename[0]) );
			$out[$name] = $sound;
		}

		return $out;
	}

	/**
	 * Creates communication tab in Special:Preferences or adds there chat related options
	 *
	 * @param User $user current logged-in user object
	 * @param Array $preferences preferences form
	 *
	 * @return true
	 */
	static function onGetPreferences( $user, &$preferences ) {
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
		$wgOut->addScript(
			'<script type="' . $wgJsMimeType . '"
					 src="' . $wgExtensionsPath . '/wikia/Chat2/js/chat-prefs.js?' . $wgStyleVersion . '">
			</script>' . "\n"
		);

		$selected = $user->getOption( self::CHAT_INCOMING_MESSAGE_SOUND_KEY, false );
		$options = [ wfMessage( 'chat-pref-sound-none' )->plain() => '' ];
		$options = array_merge( $options, self::getSounds() );

		$preferences[self::CHAT_INCOMING_MESSAGE_SOUND_KEY] = [
			'id' => 'chatIncomingMsgSound',
			'type' => 'select',
			'label-message' => 'chat-pref-incoming-message-sound',
			'section' => 'communication/chat',
			'options' => $options,
			'default' => $selected,
			'help-message' => 'chat-pref-help',
		];

		return true;
	}

}
