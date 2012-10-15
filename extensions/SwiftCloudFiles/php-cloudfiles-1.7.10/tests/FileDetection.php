<?php # -*- compile-command: (concat "phpunit " buffer-file-name) -*-

if ( php_sapi_name() !== 'cli' ) {
	die( "This is not a valid web entry point." );
}

require_once 'PHPUnit/Framework.php';
require_once 'common.php';

/**
   * UTF8Testing tests class
   *
   * @package php-cloudfiles::tests
   */
class FileDetection extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->auth = null;
    }
    
    public function setUp()
    {

        if (!function_exists("finfo_open")) {
            print "you need fileinfo extension installed to run this test\n";
            exit(1);
        }
        global $UTF8_TEXT;
        $this->utf8_text = $UTF8_TEXT;
        
        #Connect!
        $this->auth = new CF_Authentication(USER, API_KEY);
        $this->auth->authenticate();
        
        $this->conn = new CF_Connection($this->auth);
        
        #Make sure it's deleted at the end
        $this->container = $this->conn->create_container("file-detection");

        $this->media_files = array(
            array("jpg", "image/jpeg", array(0xffd8, 0xffe0, 0x0010, 0x4a46, 0x4946, 0x0001, 0x0101, 0x0048, 0x0048)),
            array("png", "image/png", array(0x8950, 0x4e47, 0x0d0a, 0x1a0a, 0x0000, 0x000d, 0x4948, 0x4452, 0x0000)),
            array("mp4", "video/mp4", array(0x0000, 0x001c, 0x6674, 0x7970, 0x6d70, 0x3432, 0x0000, 0x0000, 0x6973)),
            array("avi", "video/x-msvideo", array(0x5249, 0x4646, 0x6a42, 0x0100, 0x4156, 0x4920, 0x4c49, 0x5354, 0x8c05)),
            array("ogg", "application/ogg", array(0x4f67, 0x6753, 0x0002, 0x0000, 0x0000, 0x0000, 0x0000, 0x5d28, 0xf95e)),
            );
    }

    public function test_filetype_detection_buffers () { 
        foreach ($this->media_files as $mime) {        
            list($type, $mimetype, $binary_pack) = $mime;
            
            # Write Object
            $object = $this->container->create_object("sample." . $type);
            $object->write(call_user_func_array("pack",array_merge(array("n*"),(array)$binary_pack)));
            
            # Get the OBJECT
            $object = $this->container->get_object("sample." . $type);

            # Test it
            $this->assertEquals($object->content_type, $mimetype);
            
            # Delete the OBJECT
            $object = $this->container->delete_object("sample." . $type);
            
        }
    }

    public function test_filetype_detection_files () { 
        foreach ($this->media_files as $mime) {        
            list($type, $mimetype, $binary_pack) = $mime;
            
            # Write Object
            $object = $this->container->create_object("sample." . $type);

            # Write temporary files with the proper mime-type
            $temp = tempnam(get_tmpdir(), "php-cloudfiles-content-type-$type");
            $temp_fh = fopen($temp, "wb");
            fwrite($temp_fh,
                   call_user_func_array("pack",array_merge(array("n*"),(array)$binary_pack)));
            fclose($temp_fh);
            
            $object->load_from_filename($temp);

            # Get the OBJECT
            $object = $this->container->get_object("sample." . $type);

            # Test it
            $this->assertEquals($object->content_type, $mimetype);
            
            # Delete OBJECT
            $object = $this->container->delete_object("sample." . $type);
            unlink($temp);
        }
    }

    /*
      If set application/octet-stream it should not throw
      BadContentTypeException
    */
    public function test_set_application_octet_stream ()
    {
        #CREATE
        $o = $this->container->create_object("ct.mp3");

        #PUT
        $o->content_type = "application/octet-stream";
        $o->write(pack("n*", 0x4944, 0x3303, 0x0000, 0x0000, 0x0f76, 0x5450, 0x4531, 0x0000, 0x000d)); #MP3
        
        #GET
        $o = $this->container->get_object("ct.mp3");

        #TEST
        $this->assertEquals($o->content_type, "application/octet-stream");

        #CLEAN
        $this->container->delete_object("ct.mp3");
    }
    

    /*
      If set with another content type than supposed to be it should not auto detect it
    */
    public function test_set_wrong_content_type ()
    {
        #CREATE
        $o = $this->container->create_object("ct.mp4");

        #PUT
        $o->content_type = "video/mp4"; #it should be image/jpeg but if the user really want to set as MP4 it's his problem
        $o->write(pack("n*", 0x0000, 0x001c, 0x6674, 0x7970, 0x6d70, 0x3432, 0x0000, 0x0000, 0x6973)); #JPG
        
        #GET
        $o = $this->container->get_object("ct.mp4");

        #TEST
        $this->assertEquals($o->content_type, "video/mp4");

        #CLEAN
        $this->container->delete_object("ct.mp4");
    }
    


    public function test_bad_content_type ()
    { 
        $this->setExpectedException('BadContentTypeException');
        $o2 = $this->container->create_object("bad-content-type");
        $o2->write(pack("n*", 0xf00f, 0xdead, 0xbeef, 0x0100, 0x0ff0));
    }
    
    public function test_delete_main_container () { 
        $result = $this->conn->delete_container("file-detection");
        $this->assertTrue($result);        
    }
}
