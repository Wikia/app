<?php
/**
 * Quick & Dirty mock cloud files classes for testing.
 * Doesn't actually do authentication or HTTP stuff, just calls the methods.
 * Objects are just stored on the File System under the container and object name.
 * $IP/fake_cloudfiles.config.php must exist and set FAKE_SWIFT_CONTAINER_PATH,
 * which is the directory that holds the container directories.
 */

/**
 */
if ( file_exists( dirname( __FILE__ ) . "/../../../fake_cloudfiles.config.php" ) ) {
	require_once( dirname( __FILE__ ) . "/../../../fake_cloudfiles.config.php" );
} else {
	die( "Nothing to see here.\n" );
}
require_once( dirname( __FILE__ ) . "/cloudfiles_exceptions.php" );
define( "DEFAULT_CF_API_VERSION", 1 );
define( "MAX_CONTAINER_NAME_LEN", 256 );
define( "MAX_OBJECT_NAME_LEN", 1024 );
define( "MAX_OBJECT_SIZE", 5 * 1024 * 1024 * 1024 + 1 );
define( "US_AUTHURL", "https://auth.api.rackspacecloud.com" );
define( "UK_AUTHURL", "https://lon.auth.api.rackspacecloud.com" );
/**
 * Class for handling Cloud Files Authentication, call it's {@link authenticate()}
 * method to obtain authorized service urls and an authentication token.
 *
 * Example:
 * <code>
 * # Create the authentication instance
 * #
 * $auth = new CF_Authentication("username", "api_key");
 *
 * # NOTE: For UK Customers please specify your AuthURL Manually
 * # There is a Predfined constant to use EX:
 * #
 * # $auth = new CF_Authentication("username, "api_key", NULL, UK_AUTHURL);
 * # Using the UK_AUTHURL keyword will force the api to use the UK AuthUrl.
 * # rather then the US one. The NULL Is passed for legacy purposes and must
 * # be passed to function correctly.
 *
 * # NOTE: Some versions of cURL include an outdated certificate authority (CA)
 * #       file.  This API ships with a newer version obtained directly from
 * #       cURL's web site (http://curl.haxx.se).  To use the newer CA bundle,
 * #       call the CF_Authentication instance's 'ssl_use_cabundle()' method.
 * #
 * # $auth->ssl_use_cabundle(); # bypass cURL's old CA bundle
 *
 * # Perform authentication request
 * #
 * $auth->authenticate();
 * </code>
 *
 * @package php-cloudfiles
 */
class CF_Authentication
{
	public $dbug;
	public $username;
	public $api_key;
	public $auth_host;
	public $account;

	/**
	 * Instance variables that are set after successful authentication
	 */
	public $storage_url;
	public $cdnm_url;
	public $auth_token;

	/**
	 * Class constructor (PHP 5 syntax)
	 *
	 * @param string $username Mosso username
	 * @param string $api_key Mosso API Access Key
	 * @param string $account  <i>Account name</i>
	 * @param string $auth_host  <i>Authentication service URI</i>
	 */
	function __construct( $username = NULL, $api_key = NULL, $account = NULL, $auth_host = US_AUTHURL )
	{

		$this->dbug = False;
		$this->username = $username;
		$this->api_key = $api_key;
		$this->account_name = $account;
		$this->auth_host = $auth_host;

		$this->storage_url = NULL;
		$this->cdnm_url = NULL;
		$this->auth_token = NULL;

		$this->cfs_http = NULL;
	}

	/**
	 * Attempt to validate Username/API Access Key
	 *
	 * Attempts to validate credentials with the authentication service.  It
	 * either returns <kbd>True</kbd> or throws an Exception.  Accepts a single
	 * (optional) argument for the storage system API version.
	 *
	 * Example:
	 * <code>
	 * # Create the authentication instance
	 * #
	 * $auth = new CF_Authentication("username", "api_key");
	 *
	 * # Perform authentication request
	 * #
	 * $auth->authenticate();
	 * </code>
	 *
	 * @param string $version API version for Auth service (optional)
	 * @return boolean <kbd>True</kbd> if successfully authenticated
	 * @throws AuthenticationException invalid credentials
	 * @throws InvalidResponseException invalid response
	 */
	function authenticate( $version = DEFAULT_CF_API_VERSION )
	{
		$this->storage_url = 'http://localhost/swift/storage/someuserurl';
		$this->cdnm_url = 'http://localhost/swift/curl/someuserurl';
		$this->auth_token = 'somerandomishtokenstring';
		return True;
	}
	/**
	 * Use Cached Token and Storage URL's rather then grabbing from the Auth System
		 *
		 * Example:
	 * <code>
		 * #Create an Auth instance
		 * $auth = new CF_Authentication();
		 * #Pass Cached URL's and Token as Args
	 * $auth->load_cached_credentials("auth_token", "storage_url", "cdn_management_url");
		 * </code>
	 *
	 * @param string $auth_token A Cloud Files Auth Token (Required)
		 * @param string $storage_url The Cloud Files Storage URL (Required)
		 * @param string $cdnm_url CDN Management URL (Required)
		 * @return boolean <kbd>True</kbd> if successful
	 * @throws SyntaxException If any of the Required Arguments are missing
		 */
	function load_cached_credentials( $auth_token, $storage_url, $cdnm_url )
	{
		$this->storage_url = $storage_url;
		$this->cdnm_url    = $cdnm_url;
		$this->auth_token  = $auth_token;
		return True;
	}
	/**
		 * Grab Cloud Files info to be Cached for later use with the load_cached_credentials method.
		 *
	 * Example:
		 * <code>
		 * #Create an Auth instance
		 * $auth = new CF_Authentication("UserName","API_Key");
		 * $auth->authenticate();
		 * $array = $auth->export_credentials();
		 * </code>
		 *
	 * @return array of url's and an auth token.
		 */
	function export_credentials()
	{
		$arr = array();
		$arr['storage_url'] = $this->storage_url;
		$arr['cdnm_url']    = $this->cdnm_url;
		$arr['auth_token']  = $this->auth_token;

		return $arr;
	}


	/**
	 * Make sure the CF_Authentication instance has authenticated.
	 *
	 * Ensures that the instance variables necessary to communicate with
	 * Cloud Files have been set from a previous authenticate() call.
	 *
	 * @return boolean <kbd>True</kbd> if successfully authenticated
	 */
	function authenticated()
	{
		if ( !( $this->storage_url || $this->cdnm_url ) || !$this->auth_token ) {
			return False;
		}
		return True;
	}

	/**
	 * Toggle debugging - set cURL verbose flag
	 */
	function setDebug( $bool )
	{
		$this->dbug = $bool;
	}
}

/**
 * Class for establishing connections to the Cloud Files storage system.
 * Connection instances are used to communicate with the storage system at
 * the account level; listing and deleting Containers and returning Container
 * instances.
 *
 * Example:
 * <code>
 * # Create the authentication instance
 * #
 * $auth = new CF_Authentication("username", "api_key");
 *
 * # Perform authentication request
 * #
 * $auth->authenticate();
 *
 * # Create a connection to the storage/cdn system(s) and pass in the
 * # validated CF_Authentication instance.
 * #
 * $conn = new CF_Connection($auth);
 *
 * # NOTE: Some versions of cURL include an outdated certificate authority (CA)
 * #       file.  This API ships with a newer version obtained directly from
 * #       cURL's web site (http://curl.haxx.se).  To use the newer CA bundle,
 * #       call the CF_Authentication instance's 'ssl_use_cabundle()' method.
 * #
 * # $conn->ssl_use_cabundle(); # bypass cURL's old CA bundle
 * </code>
 *
 * @package php-cloudfiles
 */
class CF_Connection
{
	public $dbug;
	public $cfs_auth;

	/**
	 * Pass in a previously authenticated CF_Authentication instance.
	 *
	 * Example:
	 * <code>
	 * # Create the authentication instance
	 * #
	 * $auth = new CF_Authentication("username", "api_key");
	 *
	 * # Perform authentication request
	 * #
	 * $auth->authenticate();
	 *
	 * # Create a connection to the storage/cdn system(s) and pass in the
	 * # validated CF_Authentication instance.
	 * #
	 * $conn = new CF_Connection($auth);
	 *
	 * # If you are connecting via Rackspace servers and have access
	 * # to the servicenet network you can set the $servicenet to True
	 * # like this.
	 *
	 * $conn = new CF_Connection($auth, $servicenet=True);
	 *
	 * </code>
	 *
	 * If the environement variable RACKSPACE_SERVICENET is defined it will
	 * force to connect via the servicenet.
	 *
	 * @param obj $cfs_auth previously authenticated CF_Authentication instance
	 * @param boolean $servicenet enable/disable access via Rackspace servicenet.
	 * @throws AuthenticationException not authenticated
	 */
	function __construct( $cfs_auth, $servicenet = False )
	{
		if ( isset( $_ENV['RACKSPACE_SERVICENET'] ) )
			$servicenet = True;
		$this->cfs_auth = $cfs_auth;
		if ( !$this->cfs_auth->authenticated() ) {
			$e = "Need to pass in a previously authenticated ";
			$e .= "CF_Authentication instance.";
			throw new AuthenticationException( $e );
		}
		$this->dbug = False;
	}

	/**
	 * Toggle debugging of instance and back-end HTTP module
	 *
	 * @param boolean $bool enable/disable cURL debugging
	 */
	function setDebug( $bool )
	{
		$this->dbug = (boolean) $bool;
	}

	/**
	 * Close a connection
	 *
	 * Example:
	 * <code>
	 *
	 * $conn->close();
	 *
	 * </code>
	 *
	 * Will close all current cUrl active connections.
	 *
	 */
	public function close()
	{
	}

	/**
	 * Create a Container
	 *
	 * Given a Container name, return a Container instance, creating a new
	 * remote Container if it does not exit.
	 *
	 * Example:
	 * <code>
	 * # ... authentication code excluded (see previous examples) ...
	 * #
	 * $conn = new CF_Authentication($auth);
	 *
	 * $images = $conn->create_container("my photos");
	 * </code>
	 *
	 * @param string $container_name container name
	 * @return CF_Container
	 * @throws SyntaxException invalid name
	 * @throws InvalidResponseException unexpected response
	 */
	function create_container( $container_name = NULL )
	{
		if ( $container_name != "0" and !isset( $container_name ) )
			throw new SyntaxException( "Container name not set." );

		if ( !isset( $container_name ) or $container_name == "" )
			throw new SyntaxException( "Container name not set." );

		if ( strpos( $container_name, "/" ) !== False ) {
			$r = "Container name '" . $container_name;
			$r .= "' cannot contain a '/' character.";
			throw new SyntaxException( $r );
		}
		if ( strlen( $container_name ) > MAX_CONTAINER_NAME_LEN ) {
			throw new SyntaxException( sprintf(
				"Container name exeeds %d bytes.",
				MAX_CONTAINER_NAME_LEN ) );
		}

		if ( !is_dir( FAKE_SWIFT_CONTAINER_PATH . "/$container_name" ) ) {
			mkdir( FAKE_SWIFT_CONTAINER_PATH . "/$container_name" );
		}

		return new CF_Container( $this->cfs_auth, $this->cfs_http, $container_name );
	}

	/**
	 * Delete a Container
	 *
	 * Given either a Container instance or name, remove the remote Container.
	 * The Container must be empty prior to removing it.
	 *
	 * Example:
	 * <code>
	 * # ... authentication code excluded (see previous examples) ...
	 * #
	 * $conn = new CF_Authentication($auth);
	 *
	 * $conn->delete_container("my photos");
	 * </code>
	 *
	 * @param string|obj $container container name or instance
	 * @return boolean <kbd>True</kbd> if successfully deleted
	 * @throws SyntaxException missing proper argument
	 * @throws InvalidResponseException invalid response
	 * @throws NonEmptyContainerException container not empty
	 * @throws NoSuchContainerException remote container does not exist
	 */
	function delete_container( $container = NULL )
	{
		$container_name = NULL;

		if ( is_object( $container ) ) {
			if ( get_class( $container ) == "CF_Container" ) {
				$container_name = $container->name;
			}
		}
		if ( is_string( $container ) ) {
			$container_name = $container;
		}

		if ( $container_name != "0" and !isset( $container_name ) )
			throw new SyntaxException( "Must specify container object or name." );

		if ( !is_dir( FAKE_SWIFT_CONTAINER_PATH . "/$container_name" ) ) {
			throw new NoSuchContainerException(
				"Specified container did not exist to delete." );
		}
		if ( !rmdir( FAKE_SWIFT_CONTAINER_PATH . "/$container_name" ) ) {
			throw new NonEmptyContainerException(
				"Container must be empty prior to removing it." );
		}
		return True;
	}

	/**
	 * Return a Container instance
	 *
	 * For the given name, return a Container instance if the remote Container
	 * exists, otherwise throw a Not Found exception.
	 *
	 * Example:
	 * <code>
	 * # ... authentication code excluded (see previous examples) ...
	 * #
	 * $conn = new CF_Authentication($auth);
	 *
	 * $images = $conn->get_container("my photos");
	 * print "Number of Objects: " . $images->count . "\n";
	 * print "Bytes stored in container: " . $images->bytes . "\n";
	 * </code>
	 *
	 * @param string $container_name name of the remote Container
	 * @return container CF_Container instance
	 * @throws NoSuchContainerException thrown if no remote Container
	 * @throws InvalidResponseException unexpected response
	 */
	function get_container( $container_name = NULL )
	{
		if ( !is_dir( FAKE_SWIFT_CONTAINER_PATH . "/$container_name" ) ) {
			throw new NoSuchContainerException( "Container not found." );
		}
		$count = $bytes = -1; // not implemented
		return new CF_Container( $this->cfs_auth, $this->cfs_http,
			$container_name, $count, $bytes );
	}
}

/**
 * Container operations
 *
 * Containers are storage compartments where you put your data (objects).
 * A container is similar to a directory or folder on a conventional filesystem
 * with the exception that they exist in a flat namespace, you can not create
 * containers inside of containers.
 *
 * You also have the option of marking a Container as "public" so that the
 * Objects stored in the Container are publicly available via the CDN.
 *
 * @package php-cloudfiles
 */
class CF_Container
{
	public $cfs_auth;
	public $cfs_http;
	public $name;
	public $object_count;
	public $bytes_used;

	public $cdn_enabled;
	public $cdn_ssl_uri;
	public $cdn_uri;
	public $cdn_ttl;
	public $cdn_log_retention;
	public $cdn_acl_user_agent;
	public $cdn_acl_referrer;

	/**
	 * Class constructor
	 *
	 * Constructor for Container
	 *
	 * @param obj $cfs_auth CF_Authentication instance
	 * @param obj $cfs_http HTTP connection manager
	 * @param string $name name of Container
	 * @param int $count number of Objects stored in this Container
	 * @param int $bytes number of bytes stored in this Container
	 * @throws SyntaxException invalid Container name
	 */
	function __construct( &$cfs_auth, &$cfs_http, $name, $count = 0,
		$bytes = 0, $docdn = True )
	{
		if ( strlen( $name ) > MAX_CONTAINER_NAME_LEN ) {
			throw new SyntaxException( "Container name exceeds "
				. "maximum allowed length." );
		}
		if ( strpos( $name, "/" ) !== False ) {
			throw new SyntaxException(
				"Container names cannot contain a '/' character." );
		}
		$this->cfs_auth = $cfs_auth;
		$this->cfs_http = $cfs_http;
		$this->name = $name;
		$this->object_count = $count;
		$this->bytes_used = $bytes;
		$this->cdn_enabled = NULL;
		$this->cdn_uri = NULL;
		$this->cdn_ssl_uri = NULL;
		$this->cdn_ttl = NULL;
		$this->cdn_log_retention = NULL;
		$this->cdn_acl_user_agent = NULL;
		$this->cdn_acl_referrer = NULL;
	}

	/**
	 * Create a new remote storage Object
	 *
	 * Return a new Object instance.  If the remote storage Object exists,
	 * the instance's attributes are populated.
	 *
	 * Example:
	 * <code>
	 * # ... authentication code excluded (see previous examples) ...
	 * #
	 * $conn = new CF_Authentication($auth);
	 *
	 * $public_container = $conn->get_container("public");
	 *
	 * # This creates a local instance of a storage object but only creates
	 * # it in the storage system when the object's write() method is called.
	 * #
	 * $pic = $public_container->create_object("baby.jpg");
	 * </code>
	 *
	 * @param string $obj_name name of storage Object
	 * @return obj CF_Object instance
	 */
	function create_object( $obj_name = NULL )
	{
		return new CF_Object( $this, $obj_name );
	}

	/**
	 * Return an Object instance for the remote storage Object
	 *
	 * Given a name, return a Object instance representing the
	 * remote storage object.
	 *
	 * Example:
	 * <code>
	 * # ... authentication code excluded (see previous examples) ...
	 * #
	 * $conn = new CF_Authentication($auth);
	 *
	 * $public_container = $conn->get_container("public");
	 *
	 * # This call only fetches header information and not the content of
	 * # the storage object.  Use the Object's read() or stream() methods
	 * # to obtain the object's data.
	 * #
	 * $pic = $public_container->get_object("baby.jpg");
	 * </code>
	 *
	 * @param string $obj_name name of storage Object
	 * @return obj CF_Object instance
	 */
	function get_object( $obj_name = NULL )
	{
		return new CF_Object( $this, $obj_name, True );
	}

	/**
	 * Return a list of Objects
	 *
	 * Return an array of strings listing the Object names in this Container.
	 *
	 * Example:
	 * <code>
	 * # ... authentication code excluded (see previous examples) ...
	 * #
	 * $images = $conn->get_container("my photos");
	 *
	 * # Grab the list of all storage objects
	 * #
	 * $all_objects = $images->list_objects();
	 *
	 * # Grab subsets of all storage objects
	 * #
	 * $first_ten = $images->list_objects(10);
	 *
	 * # Note the use of the previous result's last object name being
	 * # used as the 'marker' parameter to fetch the next 10 objects
	 * #
	 * $next_ten = $images->list_objects(10, $first_ten[count($first_ten)-1]);
	 *
	 * # Grab images starting with "birthday_party" and default limit/marker
	 * # to match all photos with that prefix
	 * #
	 * $prefixed = $images->list_objects(0, NULL, "birthday");
	 *
	 * # Assuming you have created the appropriate directory marker Objects,
	 * # you can traverse your pseudo-hierarchical containers
	 * # with the "path" argument.
	 * #
	 * $animals = $images->list_objects(0,NULL,NULL,"pictures/animals");
	 * $dogs = $images->list_objects(0,NULL,NULL,"pictures/animals/dogs");
	 * </code>
	 *
	 * @param int $limit <i>optional</i> only return $limit names
	 * @param int $marker <i>optional</i> subset of names starting at $marker
	 * @param string $prefix <i>optional</i> Objects whose names begin with $prefix
	 * @param string $path <i>optional</i> only return results under "pathname"
	 * @return array array of strings
	 * @throws InvalidResponseException unexpected response
	 */
	function list_objects( $limit = 0, $marker = NULL, $prefix = NULL, $path = NULL )
	{
		$names = array();
		// $prefix must be a dir in mock class
		$dir = FAKE_SWIFT_CONTAINER_PATH . "/{$this->name}/$prefix";
		if ( is_dir( $dir ) ) {
			$handle = opendir( $dir );
			if ( $handle ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					if ( $file { 0 } != '.' ) {
						$names[] = $file;
					}
				}
				closedir( $handle );
			}
		}
		return $names;
	}

	/**
	 * Delete a remote storage Object
	 *
	 * Given an Object instance or name, permanently remove the remote Object
	 * and all associated metadata.
	 *
	 * Example:
	 * <code>
	 * # ... authentication code excluded (see previous examples) ...
	 * #
	 * $conn = new CF_Authentication($auth);
	 *
	 * $images = $conn->get_container("my photos");
	 *
	 * # Delete specific object
	 * #
	 * $images->delete_object("disco_dancing.jpg");
	 * </code>
	 *
	 * @param obj $obj name or instance of Object to delete
	 * @return boolean <kbd>True</kbd> if successfully removed
	 * @throws SyntaxException invalid Object name
	 * @throws NoSuchObjectException remote Object does not exist
	 * @throws InvalidResponseException unexpected response
	 */
	function delete_object( $obj )
	{
		$obj_name = NULL;
		if ( is_object( $obj ) ) {
			if ( get_class( $obj ) == "CF_Object" ) {
				$obj_name = $obj->name;
			}
		}
		if ( is_string( $obj ) ) {
			$obj_name = $obj;
		}
		if ( !$obj_name ) {
			throw new SyntaxException( "Object name not set." );
		}
		if ( !@unlink( $this->getObjectFSPath( $obj_name ) ) ) {
			$m = "Specified object '" . $this->name . "/" . $obj_name;
			$m .= "' did not exist to delete.";
			throw new NoSuchObjectException( $m );
		}
		return True;
	}

	function getObjectFSPath( $file ) {
		return FAKE_SWIFT_CONTAINER_PATH . "/{$this->name}/{$file}";
	}
}


/**
 * Object operations
 *
 * An Object is analogous to a file on a conventional filesystem. You can
 * read data from, or write data to your Objects. You can also associate
 * arbitrary metadata with them.
 *
 * @package php-cloudfiles
 */
class CF_Object
{
	public $container;
	public $name;
	public $last_modified;
	public $content_type;
	public $content_length;
	public $metadata;
	public $manifest;
	private $etag;

	/**
	 * Class constructor
	 *
	 * @param obj $container CF_Container instance
	 * @param string $name name of Object
	 * @param boolean $force_exists if set, throw an error if Object doesn't exist
	 */
	function __construct( &$container, $name, $force_exists = False, $dohead = True )
	{
		if ( $name[0] == "/" ) {
			$r = "Object name '" . $name;
			$r .= "' cannot contain begin with a '/' character.";
			throw new SyntaxException( $r );
		}
		if ( strlen( $name ) > MAX_OBJECT_NAME_LEN ) {
			throw new SyntaxException( "Object name exceeds "
				. "maximum allowed length." );
		}
		$this->container = $container;
		$this->name = $name;
		$this->etag = NULL;
		$this->_etag_override = False;
		$this->last_modified = NULL;
		$this->content_type = NULL;
		$this->content_length = 0;
		$this->metadata = array();
		$this->manifest = NULL;
		if ( $dohead ) {
			if ( !$this->_initialize() && $force_exists ) {
				throw new NoSuchObjectException( "No such object '" . $name . "'" );
			}
		}
	}

	/**
	 * String representation of Object
	 *
	 * Pretty print the Object's location and name
	 *
	 * @return string Object information
	 */
	function __toString()
	{
		return $this->container->name . "/" . $this->name;
	}

	/**
	 * Internal check to get the proper mimetype.
	 *
	 * This function would go over the available PHP methods to get
	 * the MIME type.
	 *
	 * By default it will try to use the PHP fileinfo library which is
	 * available from PHP 5.3 or as an PECL extension
	 * (http://pecl.php.net/package/Fileinfo).
	 *
	 * It will get the magic file by default from the system wide file
	 * which is usually available in /usr/share/magic on Unix or try
	 * to use the file specified in the source directory of the API
	 * (share directory).
	 *
	 * if fileinfo is not available it will try to use the internal
	 * mime_content_type function.
	 *
	 * @param string $handle name of file or buffer to guess the type from
	 * @return boolean <kbd>True</kbd> if successful
	 * @throws BadContentTypeException
	 */
	function _guess_content_type( $handle ) {
		if ( $this->content_type )
			return;

		if ( function_exists( "finfo_open" ) ) {
			$local_magic = dirname( __FILE__ ) . "/share/magic";
			$finfo = @finfo_open( FILEINFO_MIME, $local_magic );

			if ( !$finfo )
				$finfo = @finfo_open( FILEINFO_MIME );

			if ( $finfo ) {

				if ( is_file( (string)$handle ) )
					$ct = @finfo_file( $finfo, $handle );
				else
					$ct = @finfo_buffer( $finfo, $handle );

				/* PHP 5.3 fileinfo display extra information like
				   charset so we remove everything after the ; since
				   we are not into that stuff */
				if ( $ct ) {
					$extra_content_type_info = strpos( $ct, "; " );
					if ( $extra_content_type_info )
						$ct = substr( $ct, 0, $extra_content_type_info );
				}

				if ( $ct && $ct != 'application/octet-stream' )
					$this->content_type = $ct;

				@finfo_close( $finfo );
			}
		}

		if ( !$this->content_type && (string)is_file( $handle ) && function_exists( "mime_content_type" ) ) {
			$this->content_type = @mime_content_type( $handle );
		}

		if ( !$this->content_type ) {
			throw new BadContentTypeException( "Required Content-Type not set" );
		}
		return True;
	}

	function getFSPath() {
		return $this->container->getObjectFSPath( $this->name );
	}

	/**
	 * Read the remote Object's data
	 *
	 * Returns the Object's data.  This is useful for smaller Objects such
	 * as images or office documents.  Object's with larger content should use
	 * the stream() method below.
	 *
	 * Pass in $hdrs array to set specific custom HTTP headers such as
	 * If-Match, If-None-Match, If-Modified-Since, Range, etc.
	 *
	 * Example:
	 * <code>
	 * # ... authentication/connection/container code excluded
	 * # ... see previous examples
	 *
	 * $my_docs = $conn->get_container("documents");
	 * $doc = $my_docs->get_object("README");
	 * $data = $doc->read(); # read image content into a string variable
	 * print $data;
	 *
	 * # Or see stream() below for a different example.
	 * #
	 * </code>
	 *
	 * @param array $hdrs user-defined headers (Range, If-Match, etc.)
	 * @return string Object's data
	 * @throws InvalidResponseException unexpected response
	 */
	function read( $hdrs = array() )
	{
		return file_get_contents( $this->getFSPath() );
	}

	/**
	 * Streaming read of Object's data
	 *
	 * Given an open PHP resource (see PHP's fopen() method), fetch the Object's
	 * data and write it to the open resource handle.  This is useful for
	 * streaming an Object's content to the browser (videos, images) or for
	 * fetching content to a local file.
	 *
	 * Pass in $hdrs array to set specific custom HTTP headers such as
	 * If-Match, If-None-Match, If-Modified-Since, Range, etc.
	 *
	 * Example:
	 * <code>
	 * # ... authentication/connection/container code excluded
	 * # ... see previous examples
	 *
	 * # Assuming this is a web script to display the README to the
	 * # user's browser:
	 * #
	 * <?php
	 * // grab README from storage system
	 * //
	 * $my_docs = $conn->get_container("documents");
	 * $doc = $my_docs->get_object("README");
	 *
	 * // Hand it back to user's browser with appropriate content-type
	 * //
	 * header("Content-Type: " . $doc->content_type);
	 * $output = fopen("php://output", "w");
	 * $doc->stream($output); # stream object content to PHP's output buffer
	 * fclose($output);
	 * ?>
	 *
	 * # See read() above for a more simple example.
	 * #
	 * </code>
	 *
	 * @param resource $fp open resource for writing data to
	 * @param array $hdrs user-defined headers (Range, If-Match, etc.)
	 * @return string Object's data
	 * @throws InvalidResponseException unexpected response
	 */
	function stream( &$fp, $hdrs = array() )
	{
		$data = file_get_contents( $this->getFSPath() );
		fwrite( $fp, $data );
		return True;
	}

	 /**
	 * Upload Object's data to Cloud Files
	 *
	 * Write data to the remote Object.  The $data argument can either be a
	 * PHP resource open for reading (see PHP's fopen() method) or an in-memory
	 * variable.  If passing in a PHP resource, you must also include the $bytes
	 * parameter.
	 *
	 * Example:
	 * <code>
	 * # ... authentication/connection/container code excluded
	 * # ... see previous examples
	 *
	 * $my_docs = $conn->get_container("documents");
	 * $doc = $my_docs->get_object("README");
	 *
	 * # Upload placeholder text in my README
	 * #
	 * $doc->write("This is just placeholder text for now...");
	 * </code>
	 *
	 * @param string|resource $data string or open resource
	 * @param float $bytes amount of data to upload (required for resources)
	 * @param boolean $verify generate, send, and compare MD5 checksums
	 * @return boolean <kbd>True</kbd> when data uploaded successfully
	 * @throws SyntaxException missing required parameters
	 * @throws BadContentTypeException if no Content-Type was/could be set
	 * @throws MisMatchedChecksumException $verify is set and checksums unequal
	 * @throws InvalidResponseException unexpected response
	 */
	function write( $data = NULL, $bytes = 0, $verify = True )
	{
		if ( !$data && !is_string( $data ) ) {
			throw new SyntaxException( "Missing data source." );
		}
		if ( $bytes > MAX_OBJECT_SIZE ) {
			throw new SyntaxException( "Bytes exceeds maximum object size." );
		}
		if ( $verify ) {
			if ( !$this->_etag_override ) {
				$this->etag = $this->compute_md5sum( $data );
			}
		} else {
			$this->etag = NULL;
		}

		$close_fh = False;
		if ( !is_resource( $data ) ) {
			# A hack to treat string data as a file handle.  php://memory feels
			# like a better option, but it seems to break on Windows so use
			# a temporary file instead.
			#
			$fp = fopen( "php://temp", "wb+" );
			# $fp = fopen("php://memory", "wb+");
			fwrite( $fp, $data, strlen( $data ) );
			rewind( $fp );
			$close_fh = True;
			$this->content_length = (float) strlen( $data );
			if ( $this->content_length > MAX_OBJECT_SIZE ) {
				throw new SyntaxException( "Data exceeds maximum object size" );
			}
			$ct_data = substr( $data, 0, 64 );
		} else {
			$this->content_length = $bytes;
			$fp = $data;
			$ct_data = fread( $data, 64 );
			rewind( $data );
		}

		$this->_guess_content_type( $ct_data );

		$dir = dirname( $this->getFSPath() );
		if ( !file_exists( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		file_put_contents( $this->getFSPath(), $data, LOCK_EX );

		if ( $close_fh ) { fclose( $fp ); }
		return True;
	}

   /**
	 * Copy one Object to another Object to Cloud Files
	 *
	 * Example:
	 * <code>
	 * # ... authentication/connection/container code excluded
	 * # ... see previous examples
	 *
	 * $my_docs = $conn->get_container("documents");
	 * $doc = $my_docs->get_object("README");
	 *
	 * # Copy README.txt on top of this object (which you must have
	 * already written something to).
	 * #
	 * $doc->copy("/documents/README.txt");
	 * </code>
	 *
	 * @param string $source Name of existing object
	 * @return boolean <kbd>True</kbd> when data uploaded successfully
	 * @throws SyntaxException missing required parameters
	 * @throws BadContentTypeException if no Content-Type was/could be set
	 * @throws MisMatchedChecksumException $verify is set and checksums unequal
	 * @throws InvalidResponseException unexpected response
	 */
	function copy( $source )
	{
		if ( !$source && !is_string( $source ) ) {
			throw new SyntaxException( "Missing data source." );
		}
		$sObj = new self( $this->container, $source );
		copy( $sObj->getFSPath(), $this->getFSPath() );
		return True;
	}

	/**
	 * Upload Object data from local filename
	 *
	 * This is a convenience function to upload the data from a local file.  A
	 * True value for $verify will cause the method to compute the Object's MD5
	 * checksum prior to uploading.
	 *
	 * Example:
	 * <code>
	 * # ... authentication/connection/container code excluded
	 * # ... see previous examples
	 *
	 * $my_docs = $conn->get_container("documents");
	 * $doc = $my_docs->get_object("README");
	 *
	 * # Upload my local README's content
	 * #
	 * $doc->load_from_filename("/home/ej/cloudfiles/readme");
	 * </code>
	 *
	 * @param string $filename full path to local file
	 * @param boolean $verify enable local/remote MD5 checksum validation
	 * @return boolean <kbd>True</kbd> if data uploaded successfully
	 * @throws SyntaxException missing required parameters
	 * @throws BadContentTypeException if no Content-Type was/could be set
	 * @throws MisMatchedChecksumException $verify is set and checksums unequal
	 * @throws InvalidResponseException unexpected response
	 * @throws IOException error opening file
	 */
	function load_from_filename( $filename, $verify = True )
	{
		$fp = @fopen( $filename, "r" );
		if ( !$fp ) {
			throw new IOException( "Could not open file for reading: " . $filename );
		}

		clearstatcache();

		$size = (float) sprintf( "%u", filesize( $filename ) );
		if ( $size > MAX_OBJECT_SIZE ) {
			throw new SyntaxException( "File size exceeds maximum object size." );
		}

		$this->_guess_content_type( $filename );

		$this->write( $fp, $size, $verify );
		fclose( $fp );
		return True;
	}

	/**
	 * Save Object's data to local filename
	 *
	 * Given a local filename, the Object's data will be written to the newly
	 * created file.
	 *
	 * Example:
	 * <code>
	 * # ... authentication/connection/container code excluded
	 * # ... see previous examples
	 *
	 * # Whoops!  I deleted my local README, let me download/save it
	 * #
	 * $my_docs = $conn->get_container("documents");
	 * $doc = $my_docs->get_object("README");
	 *
	 * $doc->save_to_filename("/home/ej/cloudfiles/readme.restored");
	 * </code>
	 *
	 * @param string $filename name of local file to write data to
	 * @return boolean <kbd>True</kbd> if successful
	 * @throws IOException error opening file
	 * @throws InvalidResponseException unexpected response
	 */
	function save_to_filename( $filename )
	{
		$fp = @fopen( $filename, "wb" );
		if ( !$fp ) {
			throw new IOException( "Could not open file for writing: " . $filename );
		}
		$result = $this->stream( $fp );
		fclose( $fp );
		return $result;
	}

	/**
	 * Set Object's MD5 checksum
	 *
	 * Manually set the Object's ETag.  Including the ETag is mandatory for
	 * Cloud Files to perform end-to-end verification.  Omitting the ETag forces
	 * the user to handle any data integrity checks.
	 *
	 * @param string $etag MD5 checksum hexidecimal string
	 */
	function set_etag( $etag )
	{
		$this->etag = $etag;
		$this->_etag_override = True;
	}

	/**
	 * Object's MD5 checksum
	 *
	 * Accessor method for reading Object's private ETag attribute.
	 *
	 * @return string MD5 checksum hexidecimal string
	 */
	function getETag()
	{
		return $this->etag;
	}

	/**
	 * Compute the MD5 checksum
	 *
	 * Calculate the MD5 checksum on either a PHP resource or data.  The argument
	 * may either be a local filename, open resource for reading, or a string.
	 *
	 * <b>WARNING:</b> if you are uploading a big file over a stream
	 * it could get very slow to compute the md5 you probably want to
	 * set the $verify parameter to False in the write() method and
	 * compute yourself the md5 before if you have it.
	 *
	 * @param filename|obj|string $data filename, open resource, or string
	 * @return string MD5 checksum hexidecimal string
	 */
	function compute_md5sum( &$data )
	{
		if ( function_exists( "hash_init" ) && is_resource( $data ) ) {
			$ctx = hash_init( 'md5' );
			while ( !feof( $data ) ) {
				$buffer = fgets( $data, 65536 );
				hash_update( $ctx, $buffer );
			}
			$md5 = hash_final( $ctx, false );
			rewind( $data );
		} elseif ( (string)is_file( $data ) ) {
			$md5 = md5_file( $data );
		} else {
			$md5 = md5( $data );
		}
		return $md5;
	}

	/**
	 * PRIVATE: fetch information about the remote Object if it exists
	 */
	private function _initialize()
	{
		clearstatcache();
		$path = $this->getFSPath();
		if ( !file_exists( $path ) ) {
			return False;
		}
		// Slow...but whatever...
		$this->etag = md5_file( $path );
		$this->last_modified = strftime( '%a, %d %b %Y %H:%M:%S GMT', filemtime( $path ) );
		$this->content_type = $this->_guess_content_type( $path );
		$this->content_length = (float)filesize( $path );
		$this->metadata = NULL;
		$this->manifest = NULL;
		return True;
	}
}

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
