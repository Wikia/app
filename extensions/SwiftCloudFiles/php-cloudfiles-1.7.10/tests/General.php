<?php # -*- compile-command: (concat "phpunit " buffer-file-name) -*-
if ( php_sapi_name() !== 'cli' ) {
	die( "This is not a valid web entry point." );
}
require_once 'PHPUnit/Framework.php';
require_once 'common.php';

class CloudFileAccountInfoTest extends PHPUnit_Framework_TestCase
{
    function __construct()
    {
        $this->auth = null;
        $this->container = null;
        $this->temp_name = tempnam(get_tmpdir(), "php-cloudfiles");
        $this->object_data = "Some Random text for object data";
    }

   function __destruct() {
       unlink($this->temp_name);
   }
    
    protected function setUp()
    {
        $this->auth = new CF_Authentication(USER, API_KEY);
        $this->auth->authenticate();
        $this->conn = new CF_Connection($this->auth);
        #We will need it all of those
        $this->conn->set_read_progress_function("read_callback_test");
        $this->conn->set_write_progress_function("write_callback_test");
        $this->orig_info = $this->conn->get_info();
        $this->orig_container_list = $this->conn->list_containers();

        $this->container = $this->conn->create_container("php-cloudfiles");
        $this->o1 = $this->container->create_object("fuzzy.txt");        
    } 

    public function testListContainers()
    {        
        $this->assertTrue(is_array($this->orig_info));
        $this->assertTrue(is_array($this->orig_container_list));
    }

    public function testCreateLongContainer()
    {
        //Long names are not permitted
        $this->setExpectedException('SyntaxException');
        
        $long_name = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $container = $this->conn->create_container($long_name);
    }

    public function testCreateEmptyContainer()
    {
        $this->setExpectedException('SyntaxException');
        $container = $this->conn->create_container();
    }

    public function testCreateContainerWithZero()
    {
        $container = $this->conn->create_container("0");
        $result = $this->conn->delete_container('0');
        $this->assertNotNull($container);
    }
    
    public function testCreateContainer()
    {
        $this->assertNotNull($this->container);
    }

    public function testCreateContainerWithSpace()
    {
        $container = $this->conn->create_container('php cloudfiles');
        $this->assertNotNull($container);        
    }

    public function testDeleteContainerWithSpace()
    {
        $result = $this->conn->delete_container('php cloudfiles');
        $this->assertNotNull($result);        
    }

    public function testCreateLongObject()
    {
        $this->setExpectedException('SyntaxException');
        
        $long_name = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        $long_name .= "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $this->container->create_object($long_name);
    }
    
    public function testNonExistentContainer()
    {
        //Long names are not permitted
        $this->setExpectedException('NoSuchContainerException');
        $no_container = $this->conn->get_container("7HER3_1S_N0_5PO0N");
    }

    public function testDeleteNonExistentContainer()
    {
        $this->setExpectedException('NoSuchContainerException');
        $no_container = $this->conn->delete_container("7HER3_1S_N0_5PO0N");
    }

    public function testDeleteNonSpecifiedContainer()
    {
        $this->setExpectedException('SyntaxException');
        $result = $this->conn->delete_container();
    }

    public function testDeleteNonExistentObject()
    {
        $this->setExpectedException('NoSuchObjectException');
        $result = $this->container->delete_object("7HER3_1S_N0_5PO0N");
    }
    
    public function testCreateContainerWithASlash()
    {
        $this->setExpectedException('SyntaxException');        
        $bad_cont = $this->conn->create_container("php/cloudfiles");
    }

    public function testCheckContainerAttribute()
    {
        $container_name = "test_containner";
        $cont = $this->conn->create_container($container_name);
        $clist = $this->conn->get_containers();
        $cont_name_check = false;
        foreach ($clist as $cont) {
            if ($cont->name == $container_name)
                $cont_name_check = true;
        }
        $this->assertTrue($cont_name_check);
    }
    
    public function testManifestObject ()
    { 
        $o0 = $this->container->create_object("manifest");
        $o0->manifest = $this->container->name . "/manifest";
        $result = $o0->write();
        $this->assertNotNull($result);
        $o0 = $this->container->get_object("manifest");
        $this->assertTrue($o0->manifest == $this->container->name . "/manifest");
    }

    public function testObjectWithSlash ()
    { 
        $o0 = $this->container->create_object("test/slash");
        $this->assertNotNull($o0);

        $text = "Some sample text.";
        $md5 = md5($text);
        $o0->content_type = "text/plain";
        $result = $o0->write($text);
        $this->assertNotNull($result);
        $this->assertNotNull($o0->getETag() == $md5);
    }
    
    public function testObjectWithSpace ()
    { 
        $ospace = $this->container->create_object("space name");
        $this->assertNotNull($ospace);

        $text = "Some sample text.";
        $md5 = md5($text);
        $ospace->content_type = "text/plain";
        $result = $ospace->write($text);

        $this->assertNotNull($ospace);
        $this->assertNotNull($ospace->getETag() == $md5);        
    }

    public function testRange ()
    { 
        $orange = $this->container->get_object("space name");
        $partial = $orange->read(array("Range"=>"bytes=0-10"));

        $this->assertTrue(strlen($partial) == 11);
        $this->assertTrue($partial == "Some sample");

        //Check last modified
        $this->assertTrue(substr($orange->last_modified, -3) == "GMT");
        
    }

    public function testCreateObjectTwo()
    {
        $o1 = $this->container->create_object("fuzzy.txt");
        $this->assertNotNull($o1);

        // "======= UPLOAD STRING CONTENT FOR OBJECT(1) =================\n";
        $text = "This is some sample text.";
        $md5 = md5($text);
        $o1->content_type = "text/plain";
        $result = $o1->write($text);

        $this->assertNotNull($result);        
        $this->assertTrue($o1->getETag() == $md5);

        // ======= UPLOAD STRING CONTENT FOR OBJECT(2) =================
        $o1->content_type = "text/plain";
        $result = $o1->write("Even more sample text.");
        $this->assertNotNull($result);        

        // ======= RE-UPLOAD STRING CONTENT FOR OBJECT WITH METADATA ===
        $text = "This is some different sample text.";
        $md5 = md5($text);
        $o1->content_type = "text/plain";
        $o1->metadata = array(
            "Foo" => "This is foo",
            "Bar" => "This is bar");
        $result = $o1->write($text);
        $this->assertNotNull($result);
        $this->assertTrue($o1->getETag() == $md5);

        # ======= IF-MATCH (MATCHED MD5) ==============================
        $ifmatch = $this->container->get_object($o1->name);
        $ifdata = $ifmatch->read(array("If-Match" => $md5));
        $this->assertTrue($ifdata == $text);

        # ======= IF-NONE-MATCH (UNMATCHED MD5) =======================
        $ifmatch = $this->container->get_object($o1->name);
        $ifdata = $ifmatch->read(array("If-Match" => "foo"));
        $this->assertFalse($ifdata == $text); # an HTML response entity is returned. :-(

        # ======= IF-NONE-MATCH (MATCHED MD5) =========================
        $ifmatch = $this->container->get_object($o1->name);
        $ifdata = $ifmatch->read(array("If-None-Match" => $md5));
        $this->assertTrue(!$ifdata);

        # ======= IF-MODIFIED-SINCE (PAST TIMESTAMP) ==================
        $ifmatch = $this->container->get_object($o1->name);
        $ifdata = $ifmatch->read(array("If-Modified-Since" => httpDate(time()-86400)));
        $this->assertTrue($ifdata == $text);

        # ======= IF-MODIFIED-SINCE (FUTURE TIMESTAMP) ================
        $ifmatch = $this->container->get_object($o1->name);
        $ifdata = $ifmatch->read(array("If-Modified-Since" => httpDate(time()+86400)));
        $this->assertTrue($ifdata != $text);

        # ======= IF-UNMODIFIED-SINCE (PAST TIMESTAMP) ================
        $ifmatch = $this->container->get_object($o1->name);
        $ifdata = $ifmatch->read(array("If-Unmodified-Since" => httpDate(time()-86400)));
        $this->assertTrue($ifdata != $text);

        # ======= IF-UNMODIFIED-SINCE (FUTURE TIMESTAMP) ==============
        $ifmatch = $this->container->get_object($o1->name);
        $ifdata = $ifmatch->read(array("If-Unmodified-Since" => httpDate(time()+86400)));
        $this->assertTrue($ifdata == $text);

    }

    public function testUploadObjectFromFile ()
    { 
        $fname = basename(__FILE__);
        if (!file_exists("$fname"))
            $fname = "tests/$fname";
        $md5 = md5_file($fname);
        $o2 = $this->container->create_object($fname);
        $o2->content_type = "text/plain";
        $result = $o2->load_from_filename($fname);
        $this->assertNotNull($result);
        $this->assertTrue($o2->getETag() == $md5);
    }

    public function testGetContainner ()
    { 
        $cont2 = $this->conn->get_container("php-cloudfiles");
        $this->assertNotNull($cont2);
    }

    public function testObjectMetadata ()
    { 
        $o3 = $this->container->get_object("fuzzy.txt");
        $this->assertTrue($o3->getETag() == $this->o1->getETag());

        # ======= UPDATE OBJECT METADATA ==============================
        $o3->metadata = array(
            "NewFoo" => "This is new foo",
            "NewBar" => "This is new bar");
        $result = $o3->sync_metadata();
        $this->assertNotNull($result);

        # ======= VERIFY UPDATED METADATA =============================
        $o4 = $this->container->get_object("fuzzy.txt");
        $this->assertTrue($o4->getETag() == $o3->getETag());
    }

    # ======= CREATE OBJECT =======================================
    public function testUploadStringContentForObject ()
    { 
        $o5 = $this->container->create_object("fussy.txt");
        $this->assertNotNull($o5);

        $text = "This is more sample text for a different object.";
        $md5 = md5($text);
        $o5->content_type = "text/plain";
        $result = $o5->write($text);
        $this->assertNotNull($result);

        $this->assertTrue($o5->getETag() == $md5);
    }

    public function testDownloadObject ()
    { 
        $o4 = $this->container->get_object("fuzzy.txt");
        $result = $o4->save_to_filename($this->temp_name);
        $this->assertNotNull($result);

        # ======= DOWNLOAD OBJECT TO STRING ===========================
        $data = $o4->read();
        $this->assertTrue(strlen($data) == 35);
    }

    public function testListAllObjects () { 
        $obj_list = $this->container->list_objects();
        $this->assertTrue(is_array($obj_list) && !empty($obj_list));
    }

    # ======= CHECK ACCOUNT INFO ==================================
    public function testCheckAccountInfo () { 
        list($num_containers, $total_bytes) = $this->conn->get_info();
        $this->assertTrue($num_containers >= 1);
        $this->assertTrue($total_bytes >= 7478);
   }

    # ======= FIND OBJECTS (LIMIT) ================================
    public function testFindObjectLimit () { 
        $obj_list = $this->container->list_objects(1);
        $this->assertTrue(is_array($obj_list) && !empty($obj_list));
    }

    # ======= FIND OBJECTS (LIMIT,OFFSET) =========================
    public function testFindObjectLimitOffest () { 
        $obj_list = $this->container->list_objects(1,1);
        $this->assertTrue(is_array($obj_list) && !empty($obj_list));
    }

    # ======= FIND OBJECTS (PREFIX='fu') ==========================
    public function findObjectPrefix ()
    { 
        $obj_list = $this->container->list_objects(0,-1,"fu");
        $this->assertTrue(is_array($obj_list) && !empty($obj_list));
    }

    public function testNonEmptyContainerDelete ()
    { 
        $this->setExpectedException('NonEmptyContainerException');
        $this->conn->delete_container($this->container);        
    }

    public function testDeleteAllObjectsAndContainner ()
    { 
        $obj_list = $this->container->list_objects();
        foreach ($obj_list as $obj) {
            $result = $this->container->delete_object($obj);
            $this->assertNotNull($result);
        }

        $obj_list = $this->container->list_objects();
        $this->assertTrue(empty($obj_list));

        $result = $this->conn->delete_container($this->container);
        $this->assertNotNull($result);
        
    }

    public function testCDN () { 
        # ======= CHECK ACCOUNT INFO BEFORE CDN TESTS =================
        $cnames = array();
        $cdn_info = $this->conn->get_info();

        # ======= CREATE NEW TEST CONTAINER (ASCII) ===================
        $n1 = "cdn-ascii-test" . rand(0, 500);
        $ascii_cont = $this->conn->create_container($n1);
        $cnames[$n1] = $ascii_cont;
        $this->assertNotNull($ascii_cont);
        # ======= Test CDN Edge Purge =================================
        $cf_purge_container = ".__cf__purge_test";
        $cf_purge_obj = "foo";
        $cont = $this->conn->create_container($cf_purge_container);
        $cont->make_public();
        $this->assertTrue($cont->purge_from_cdn());
        $obj = $cont->create_object($cf_purge_obj);
        $obj->write('asdf');
        $this->assertTrue($obj->purge_from_cdn());
        $cont->delete_object($cf_purge_obj);
        $this->conn->delete_container($cf_purge_container);
        # ======= CREATE NEW GOOP CONTAINER (ASCII) ===================
        $n2 = "#$%^&*()-_=+{}[]\|;:'><,'";
        $goop_cont = $this->conn->create_container($n2);
        $cnames[$n2] = $goop_cont;
        $this->assertNotNull( $goop_cont );

        # ======= CREATE NEW TEST CONTAINER (UTF-8) ===================
        $n3 = "©Ï&mMMÂaxÔ¾¶Áºá±â÷³¡YDéBSQÜO´ãánÉ¤°Bxn¹tðÁVètØBñü+3Pe-¹ùðVÚ_";
        $utf8_cont = $this->conn->create_container($n3);
        $cnames[$n3] = $utf8_cont;
        $this->assertNotNull( $utf8_cont );
        

        # Test CDN-enabling each container for an hour
        #
        # ======= CDN-ENABLE CONTAINERS ===============================
        foreach ($cnames as $name => $cont) {
            $uri = $cont->make_public(3600);
            $this->assertNotNull($cont->is_public());
        }

        # ======= TEST CONTAINER ATTRIBUTES ===========================
        foreach ($cnames as $name => $cont) {
            $tcont = $this->conn->get_container($name);    
            
            $this->assertNotNull($tcont->is_public());
            $this->assertNotNull($tcont->name == $name);
            $this->assertNotNull($tcont->cdn_uri == $cont->cdn_uri);
            $this->assertNotNull($tcont->cdn_ssl_uri == $cont->cdn_ssl_uri);
            $this->assertNotNull($tcont->cdn_ttl == $cont->cdn_ttl);
        }

        # ======= ADJUST TTL ==========================================
        foreach ($cnames as $name => $cont) {
            $uri = $cont->make_public(7200);
            $this->assertNotNull($cont->is_public());
            
        }

        # ======= TEST CONTAINER ATTRIBUTES ===========================
        foreach ($cnames as $name => $cont) {
            $tcont = $this->conn->get_container($name);    
            
            
            $this->assertNotNull($tcont->is_public());
            $this->assertNotNull($tcont->name == $name);
            $this->assertNotNull($tcont->cdn_uri == $cont->cdn_uri);
            $this->assertNotNull($tcont->cdn_ssl_uri == $cont->cdn_ssl_uri);
            $this->assertNotNull($tcont->cdn_ttl == $cont->cdn_ttl);
        }

        # ======= UPLOAD STORAGE OBJECT AND FETCH FROM CDN ============
        $contents = "This is a sample text file.";
        $o = $ascii_cont->create_object("foo.txt");
        $o->content_type = "text/plain";
        $o->write($contents);
        sleep(2);
        
        $fp = fopen($o->public_uri(), "r");
        $cdn_contents = fread($fp, 1024);
        fclose($fp);
        $this->assertNotNull($contents == substr($cdn_contents, -strlen($contents)));


        # ==== Enable Features on CDN ====
        foreach ($cnames as $name => $cont) {
            $cont->log_retention(True);
            $cont->acl_referrer("http://www.example.com");
            $cont->acl_user_agent("Mozilla");            

            /* Make sure set on the fly */
            $this->assertTrue($cont->cdn_log_retention);
            $this->assertEquals($cont->cdn_acl_referrer, "http://www.example.com");
            $this->assertEquals($cont->cdn_acl_user_agent, "Mozilla");

            /* Make sure set on the server */
            $cont_msure = $this->conn->get_container($name);            
            $this->assertTrue($cont_msure->cdn_log_retention);
            $this->assertEquals($cont_msure->cdn_acl_referrer, "http://www.example.com");
            $this->assertEquals($cont_msure->cdn_acl_user_agent, "Mozilla");
            
        }
                   
        # ======= DISABLE CDN =========================================
        foreach ($cnames as $name => $cont) {
            $uri = $cont->make_private();
            $this->assertNotNull($cont->is_public() == False);
            
            $tcont = $this->conn->get_container($name);
            $this->assertNotNull($cont->is_public() == False);
        }

        # ======= CLEAN-UP AND DELETE =================================
        $ascii_cont->delete_object("foo.txt");
        foreach ($cnames as $name => $cont) {
            $this->conn->delete_container($cont);
        }

        # ======= CHECK ACCOUNT INFO AFTER CDN TESTS ==================
        $info = $this->conn->get_info();
        $this->assertNotNull($info == $cdn_info);
    }

    public function test_cached_stats() {
        $fname = $this->temp_name;
        $bname = basename($this->temp_name);
        
        $f = fopen($fname,"w");
        fclose($f);

        $o2 = $this->container->create_object($bname);
        $o2->content_type = "text/plain";
        $result = $o2->load_from_filename($fname);
        
        $f = fopen($fname,"a");
        fputs($f,"x");
        fclose($f);

        $o3 = $this->container->create_object($bname);
        $o3->content_type = "text/plain";
        $result = $o3->load_from_filename($fname);

        $this->assertNotEquals($o2->content_length, $o3->content_length);
    }

    public function test_wrong_etag() {
        $this->setExpectedException('MisMatchedChecksumException');
        
        $fname = $this->temp_name;
        $f = fopen($fname,"w");
        fclose($f);
        
        $o1 = $this->container->create_object("wrong_etag.txt");
        $o1->content_type = "text/plain";
        $o1->set_etag("ffffffffffffffffffffffff");
        $result = $o1->load_from_filename($fname, $verify = True);
    }
	
	public function test_close() {
        $this->setExpectedException('ConnectionNotOpenException');

        $this->conn->list_containers(); // Open a connection.
		$this->conn->close();
		$this->conn->list_containers(); // Open a connection.
	}    
    
}

?>
