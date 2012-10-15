<?php # -*- compile-command: (concat "phpunit " buffer-file-name) -*-
if ( php_sapi_name() !== 'cli' ) {
	die( "This is not a valid web entry point." );
}
require_once 'PHPUnit/Framework.php';
require_once 'common.php';


/**
* Comprensive Tests
*
* This is a comprehensive test to be launched only if you don't mind
* getting billed (or not) for 1GB file upload/download.
*
* @return 	type	none
*/
class Comprehensive extends PHPUnit_Framework_TestCase
{
    function __construct() {
        $this->auth = null;
        $this->temp_name_write = tempnam(get_tmpdir(), "php-cloudfiles");
        $this->temp_name_read = tempnam(get_tmpdir(), "php-cloudfiles");
    }
    function __destruct () { 
        unlink($this->temp_name_write);
        unlink($this->temp_name_read);
    }

    protected function setUp() {
        $this->auth = new CF_Authentication(USER, API_KEY);
        $this->auth->authenticate();
        $this->conn = new CF_Connection($this->auth);
    }

    protected function __create_big_file($size) {

        // Check if we have enough free space, this is time two
        // because we are creating uploading and downloading which
        // after get compared.
        if ($size * 2 >= disk_free_space(get_tmpdir())) {
            print "not enough free space to continue";
            exit(1);
        }
        
        $chunk = 8192;
        $fp = fopen($this->temp_name_write, "wb");
        for ($i=1; $i <= $size;) {
            $tmp = "";
            for ($j=1; $j < $chunk; $j++) {
                $tmp .= sprintf("%d", $j*$i);
            }
            fwrite($fp, $tmp);
            $i += strlen($tmp);
        }
        fclose($fp);
    }    
    
    public function test_big_file () { 
        $fname = basename($this->temp_name_write);

        $this->__create_big_file(500 * 1024 * 1024);

        #Upload IT
        $md5_orig = md5_file($this->temp_name_write);
        $filesize_orig = filesize($this->temp_name_write);
        
        $comp_cont = $this->conn->create_container("big-file-php");
        $obj = $comp_cont->create_object($fname);
        $obj->content_type = "application/octet-stream";
        $obj->set_etag($md5_orig);
        $fp = fopen($this->temp_name_write, "rb");
        $obj->write($fp);
        fclose($fp);

        #GET IT
        $o2 = $comp_cont->get_object($fname);
        $o2->save_to_filename($this->temp_name_read);
        $md5_new = md5_file($this->temp_name_read);
        $filesize_new = filesize($this->temp_name_read);
        
        $this->assertEquals($md5_orig, $md5_orig);
        $this->assertEquals($filesize_orig, $filesize_new);

        # Clean it
        $comp_cont->delete_object($fname);
        
    }
}
?>
