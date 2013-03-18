<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerServer {

	public static function serve(WebRequest $request) {

		$type = $request->getText('type');

		try {
			switch($type) {
				case 'one':
					$builder = new AssetsManagerOneBuilder($request);
					break;

				case 'group':
					$builder = new AssetsManagerGroupBuilder($request);
					break;

				case 'groups':
					$builder = new AssetsManagerGroupsBuilder($request);
					break;

				case 'sass':
					$builder = new AssetsManagerSassBuilder($request);
					break;

				default:
					Wikia::log(__METHOD__, false, "Unknown type: {$_SERVER['REQUEST_URI']}", true /* $always */);
					Wikia::log(__METHOD__, false, AssetsManager::getRequestDetails(), true /* $always */);
					throw new Exception('Unknown type.');
			}

		} catch (Exception $e) {
			header('HTTP/1.1 404 Not Found');
			echo $e->getMessage();
			return;
		}

		// do not log illegal request type (one/group/groups/sass supported only) - not to pollute
		// logs
		if( function_exists( 'newrelic_name_transaction' ) ) {
			if ( function_exists( 'newrelic_disable_autorum') ) {
				newrelic_disable_autorum();
			}
			newrelic_name_transaction( "am/AssetManager/" . $type );
		}

		$headers = array();

		if($builder->getContentType()) {
			$headers['Content-Type'] = $builder->getContentType();
		}

		// BugId:31327
		$headers['Vary'] = $builder->getVary();

		$cacheDuration = $builder->getCacheDuration();
		if($cacheDuration > 0) {
			$headers['Expires'] = gmdate('D, d M Y H:i:s \G\M\T', strtotime($cacheDuration['server'] . ' seconds'));
			$headers['Cache-Control'] = $builder->getCacheMode() . ', max-age=' . $cacheDuration['server'];
			$headers['X-Pass-Cache-Control'] = $builder->getCacheMode() . ', max-age=' . $cacheDuration['client'];
		}

		$headers['Last-Modified'] = gmdate('D, d M Y H:i:s \G\M\T');

		foreach($headers as $k => $v) {
			header($k . ': ' . $v);
		}

		echo $builder->getContent();
	}
}