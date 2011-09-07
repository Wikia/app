<?php

/**
 * AssetsConfig
 *
 * In this class word 'item' stands for single entry in configuration array while 'asset' stand for specific path or url
 *
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsConfig {

	public static function getSiteCSS( $combine, $minify = null, $params = null, $skinname = 'oasis', $articleName = 'Wikia.css') {
		$srcs = array();
		global $wgSquidMaxage;
		$siteargs = array(
			'action' => 'raw',
			'maxage' => $wgSquidMaxage,
		);
		$query = wfArrayToCGI( array(
			'usemsgcache' => 'yes',
			'ctype' => 'text/css',
			'smaxage' => $wgSquidMaxage
		) + $siteargs );
		$siteargs['gen'] = 'css';
		$siteargs['useskin'] = $skinname;

		$srcs[] = Title::newFromText( $articleName, NS_MEDIAWIKI)->getFullURL( $query );
		$srcs[] = Title::newFromText( '-' )->getFullURL( wfArrayToCGI( $siteargs ) );

		return $srcs;
	}

	public static function getSiteJS( $combine ) {
		return array(Title::newFromText('-')->getFullURL('action=raw&smaxage=0&gen=js&useskin=oasis'));
	}

	public static function getRTEAssetsEx( $combine, $path ) {
		global $IP;

		$files = array();

		if( $combine ) {
			$input = file_get_contents( $IP . '/' . $path . '/ckeditor/ckeditor.wikia.pack' );
			$input = substr( $input, strpos($input, 'files :') + 7 );
			$input = trim( $input, " \n\t[]{}" );

			// CK core files
			$files[] = $path . '/ckeditor/_source/core/ckeditor_base.js';

			// get all *.js files
			if ( preg_match_all( '%[^/]\'([^\']+).js%', $input, $matches, PREG_SET_ORDER ) ) {
				foreach( $matches as $match ) {
					$name = $match[1] . '.js';
					$files[] = $path . '/ckeditor/' . $name;
				}
			}
		} else {
			$files[] = $path . '/ckeditor/ckeditor_source.js';
			$files[] = $path . '/js/RTE.js';
		}

		return $files;
	}

	public static function getRTEAssets( $combine ) {
		return self::getRTEAssetsEx( $combine,"extensions/wikia/RTE" );
	}

	public static function getRTEAssetsEPL($combine) {
		$files = self::getRTEAssetsEx( $combine, "extensions/wikia/EditPageReskin/RTE" );
		if ( !$combine ) {
			$files[] = 'extensions/wikia/EditPageReskin/RTE/js/jquery.editor.js';
		}
		return $files;
	}

	public static function getEPLAssets( $combine ) {
		global $IP;
		$file = "$IP/extensions/wikia/EditPageLayout/assets-config.php";
		if ( file_exists( $file ) ) {
			include $file;
			return $files;
		}
		return array();
	}

	public static function getJQueryUrl( $combine, $minify, $params ) {
		global $wgUseJQueryFromCDN;

		if (!empty($wgUseJQueryFromCDN)) {
			$url = $minify
				? '#external_http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'
				: '#external_http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js';
		}
		else {
			$url = 'skins/common/jquery/jquery-1.6.1.js';
		}

		return array($url);
	}

	private /* array */ $mConfig;

	/**
	 * Returns type of particular group. If group does not exists then return null
	 *
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	public function getGroupType( $groupName ) {
		if( empty( $this->mConfig ) ) {
			include( 'config.php' );
			$this->mConfig = $config;
		}

		if( isset( $this->mConfig[$groupName] ) ) {
			return $this->mConfig[$groupName]['type'];
		} else {
			return null;
		}
	}

	/**
	 * Returns assets array for particular group. If group does not exists in config then returns empty array
	 *
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	protected function getGroupAssets( $groupName ) {
		if(empty( $this->mConfig ) ) {
			include('config.php');
			$this->mConfig = $config;
		}

		if(isset( $this->mConfig[$groupName] ) ) {
			return $this->mConfig[$groupName]['assets'];
		} else {
			return array();
		}
	}

	/**
	 * Based on the group name get items assigned to it and pass to resolveItemsToAssets mathod for resolving into particular assets
	 *
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	public function resolve( /* string */ $groupName, /* boolean */ $combine = true, /* boolean */ $minify = true, /* array */ $params = array() ) {
		return $this->resolveItemsToAssets( $this->getGroupAssets( $groupName ), $combine, $minify, $params );
	}

	/**
	 * Based on the array of items resolves it into array of assets
	 * Parameters $combine, $minify and $params are eventually passed to custom function (look at #function_) which may deliver different set of assets based on them
	 *
	 * @author Inez Korczyński <korczynski@gmail.com>
 	 */
	private function resolveItemsToAssets( /* array */ $items, /* boolean */ $combine, /* boolean */ $minify, /* array */ $params ) {

		$assets = array();

		foreach( $items as $item ) {
			if( substr( $item, 0, 2 ) == '//' ) {

				// filepath - most typical case
				$assets[] = substr( $item, 2 );

			} else if(substr($item, 0, 7) == '#group_') {

				// reference to another group
				$assets = array_merge( $assets, $this->resolve( substr( $item, 7 ), $combine, $minify, $params ) );

			} else if( substr ($item, 0, 10 ) == '#function_' ) {

				// reference to a function that returns array of URIs
				$assets = array_merge( $assets, call_user_func( substr( $item, 10 ), $combine, $minify, $params ) );

			} else if( substr ($item, 0, 10 ) == '#external_' ) {

				// reference to a file to be fetched by the browser from external server (BugId:9522)
				$assets[] = $item;

			} else if( Http::isValidURI( $item ) ) {

				// reference to remote file (http and https)
				$assets[] = $item;

			}
		}

		return $assets;
	}

}