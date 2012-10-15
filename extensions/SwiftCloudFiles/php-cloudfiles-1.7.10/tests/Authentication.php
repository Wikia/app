<?php # -*- compile-command: (concat "phpunit " buffer-file-name) -*-
if ( php_sapi_name() !== 'cli' ) {
	die( "This is not a valid web entry point." );
}
require_once 'PHPUnit/Framework.php';
require_once 'common.php';

class Authentication extends PHPUnit_Framework_TestCase
{
    function __construct() {
        $this->auth = null;
    }

    protected function setUp() {
        $this->auth = new CF_Authentication(USER, API_KEY);
        $this->auth->authenticate();
        $conn = new CF_Connection($this->auth);
    }    
    public function testTokenCache()
    {
	$this->auth =  new CF_Authentication(USER, API_KEY);
	$this->auth->authenticate();
	$arr = $this->auth->export_credentials();
	$this->assertNotNull($arr['storage_url']);
	$this->assertNotNull($arr['cdnm_url']);
	$this->assertNotNull($arr['auth_token']);
    }
    public function testTokenAuth()
    {
        $this->auth =  new CF_Authentication(USER, API_KEY);
        $this->auth->authenticate();
        $arr = $this->auth->export_credentials();
        $this->assertNotNull($arr['storage_url']);
        $this->assertNotNull($arr['cdnm_url']);
        $this->assertNotNull($arr['auth_token']);
	$this->auth = new CF_Authentication();
	$this->auth->load_cached_credentials($arr['auth_token'], $arr['storage_url'], $arr['cdnm_url']);
	$conn = new CF_Connection($this->auth);
    }
    public function testTokenErrors()
    {
	$auth =  new CF_Authentication(USER, API_KEY);
        $auth->authenticate();
        $arr = $auth->export_credentials();
        $this->assertNotNull($arr['storage_url']);
        $this->assertNotNull($arr['cdnm_url']);
        $this->assertNotNull($arr['auth_token']);
        $this->auth = new CF_Authentication();
	$this->setExpectedException('SyntaxException');
        $auth->load_cached_credentials(NULL, $arr['storage_url'], $arr['cdnm_url']);
	$this->setExpectedException('SyntaxException');
	$auth->load_cached_credentials($arr['auth_token'], NULL, $arr['cdnm_url']);
	$this->setExpectedException('SyntaxException');
        $auth->load_cached_credentials($arr['auth_token'], $arr['storage_url'], NULL);
    }

    public function testBadAuthentication()
    {
        $this->setExpectedException('AuthenticationException');
        $auth = new CF_Authentication('e046e8db7d813050b14ce335f2511e83', 'bleurrhrhahra');
        $auth->authenticate();
    }
    
    public function testAuthenticationAttributes()
    {        
        $this->assertNotNull($this->auth->storage_url);
        $this->assertNotNull($this->auth->auth_token);

        if (ACCOUNT)
            $this->assertNotNull($this->auth->cdnm_url);
    }
    public function testUkAuth()
    {
        $this->assertTrue(UK_AUTHURL 
                          == 'https://lon.auth.api.rackspacecloud.com');
    }
}

?>
