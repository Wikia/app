diff --git a/includes/cache/MemcachedSessions.php b/includes/cache/MemcachedSessions.php
index dd5a3c1..de35b15 100644
--- a/includes/cache/MemcachedSessions.php
+++ b/includes/cache/MemcachedSessions.php
@@ -29,10 +29,6 @@ function memsess_key( $id ) {
  * @return Boolean: success
  */
 function memsess_open( $save_path, $session_name ) {
-	/** Wikia change - begin - PLATFORM-308 */
-	global $wgSessionDebugData;
-	$wgSessionDebugData[] = [ 'event' => 'open', 'save_path' => $save_path, 'session_name' => $session_name ];
-	/** Wikia change - end */
 	return true;
 }
 
@@ -43,10 +39,6 @@ function memsess_open( $save_path, $session_name ) {
  * @return Boolean: success
  */
 function memsess_close() {
-	/** Wikia change - begin - PLATFORM-308 */
-	global $wgSessionDebugData;
-	$wgSessionDebugData[] = [ 'event' => 'close' ];
-	/** Wikia change - end */
 	return true;
 }
 
@@ -57,27 +49,9 @@ function memsess_close() {
  * @return Mixed: session data
  */
 function memsess_read( $id ) {
-	/** Wikia change - begin - PLATFORM-308 */
-	global $wgSessionDebugData;
-
-	try {
-		if ( empty( $id ) ) {
-			throw new Exception();
-		}
-	} catch ( Exception $e ) {
-		$wgSessionDebugData[] = [ 'event' => 'read', 'id' => 'empty', 'backtrace' => json_encode( $e->getTrace() ) ];
-		memsess_destroy( $id );
-		return true;
-	}
-	/** Wikia change - end */
-
 	$memc =& getMemc();
 	$data = $memc->get( memsess_key( $id ) );
 
-	/** Wikia change - begin - PLATFORM-308 */
-	$wgSessionDebugData[] = [ 'event' => 'read', 'id' => $id ];
-	/** Wikia change - end */
-
 	if( ! $data ) return '';
 	return $data;
 }
@@ -90,27 +64,9 @@ function memsess_read( $id ) {
  * @return Boolean: success
  */
 function memsess_write( $id, $data ) {
-	/** Wikia change - begin - PLATFORM-308 */
-	global $wgSessionDebugData;
-
-	try {
-		if ( empty( $id ) ) {
-			throw new Exception();
-		}
-	} catch ( Exception $e ) {
-		$wgSessionDebugData[] = [ 'event' => 'write', 'id' => 'empty', 'backtrace' => json_encode( $e->getTrace() ) ];
-		memsess_destroy( $id );
-		return true;
-	}
-	/** Wikia change - end */
-
 	$memc =& getMemc();
 	$memc->set( memsess_key( $id ), $data, 3600 );
 
-	/** Wikia change - begin - PLATFORM-308 */
-	$wgSessionDebugData[] = [ 'event' => 'write', 'id' => $id, 'data' => $data ];
-	/** Wikia change - end */
-
 	return true;
 }
 
@@ -124,11 +80,6 @@ function memsess_destroy( $id ) {
 	$memc =& getMemc();
 	$memc->delete( memsess_key( $id ) );
 
-	/** Wikia change - begin - PLATFORM-308 */
-	global $wgSessionDebugData;
-	$wgSessionDebugData[] = [ 'event' => 'destroy', 'id' => $id ];
-	/** Wikia change - end */
-
 	return true;
 }
 
@@ -144,29 +95,7 @@ function memsess_gc( $maxlifetime ) {
 }
 
 function memsess_write_close() {
-	/** Wikia change - begin - PLATFORM-308 */
-	global $wgSessionDebugData, $wgRequest, $wgUser, $wgSessionName, $wgCookiePrefix;
-	$wgSessionDebugData[] = [ 'event' => 'write_close-begin' ];
-	/** Wikia change - end */
 	session_write_close();
-	/** Wikia change - begin - PLATFORM-308 */
-	$wgSessionDebugData[] = [ 'event' => 'write_close-end' ];
-	$sBrowser = isset( $_SERVER['HTTP_USER_AGENT'] )? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
-	$sCookie = isset( $_COOKIE[session_name()] )? $_COOKIE[session_name()] : 'empty';
-	\Wikia\Logger\WikiaLogger::instance()->debug(
-		'PLATFORM-308',
-		[
-			'data'       => $wgSessionDebugData,
-			'ip'         => IP::sanitizeIP( $wgRequest->getIP() ),
-			'user_id'    => $wgUser->getId(),
-			'user_name'  => $wgUser->getName(),
-			'session_id' => session_id(),
-			'user_agent' => $sBrowser,
-			'cookie'     => $sCookie
-
-		]
-	);
-	/** Wikia change - end */
 }
 
 /* Wikia */
@@ -191,3 +120,4 @@ function &getMemc() {
 		return $wgMemc;
 	}
 }
+
