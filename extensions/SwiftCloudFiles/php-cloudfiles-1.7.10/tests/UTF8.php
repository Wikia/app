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
class UTF8 extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->auth = null;
    }
    
    public function setUp()
    {

        global $UTF8_TEXT;
        $this->utf8_text = $UTF8_TEXT;
        
        #Connect!
        $this->auth = new CF_Authentication(USER, API_KEY);
        $this->auth->authenticate();
        
        $this->conn = new CF_Connection($this->auth);
        
        #Make sure it's deleted at the end
        $this->container = $this->conn->create_container("utf-8");

        $this->utf8_names=array();
        $utf8_container_length= 15; // Length of each containers
        $utf8_container_numbers= 20; // Number of containers to test

        // Fill it up
        for ($i = 0; $i < $utf8_container_numbers;$i++) {
            array_push($this->utf8_names, random_utf8_string(10, $this->utf8_text));
        }
    }
    
    /**
      * Test containers with different UTF8 name.
      *
      * @return None
      */
    public function test_container ()
    { 
        foreach ($this->utf8_names as $name) {
            $container = $this->conn->create_container($name);
            $this->assertEquals(get_class($container), "CF_Container");
            $this->assertEquals($container->name, $name);
        }

        foreach ($this->utf8_names as $name) {
            $container = $this->conn->get_container($name);
            $this->assertEquals($container->name, $name);            
        }

        foreach ($this->utf8_names as $name) {
            $name = $this->conn->delete_container($name);
            $this->assertTrue($name);
        }
        
    }

    /**
      * Test objects with different UTF8 name.
      *
      * @return None
      */
    public function test_object ()
    { 
        foreach ($this->utf8_names as $name) { 
            $text = "Veni vidi vici says Julius Cesar";
            $object = $this->container->create_object($name);
            $object->content_type = "text/plain";
            $result = $object->write($text);
            $this->assertTrue($result);
            $this->assertEquals(get_class($object), "CF_Object");
            $this->assertEquals($object->name, $name);
        }

        foreach ($this->utf8_names as $name) {
            $object = $this->container->get_object($name);
            $this->assertEquals($object->name, $name);            
        }

        foreach ($this->utf8_names as $name) {
            $name = $this->container->delete_object($name);
            $this->assertTrue($name);
        }
    }
       
    /**
      * Test the content of an object with UTF8 text inside it.
      *
      * @return None
      */
    public function test_object_content() {
        //Create
        foreach ($this->utf8_text as $lang => $text) {
            $md5 = md5($text);
            $object = $this->container->create_object($lang . ".txt");
            $object->content_type = "text/plain";
            $result = $object->write($text);
            $this->assertEquals($md5, $object->getETag());
        }

        //Get
        foreach ($this->utf8_text as $lang => $text) {
            $md5 = md5($text);            
            $object = $this->container->get_object($lang . ".txt");
            $this->assertEquals($md5, $object->getETag());
        }

        //Delete
        foreach ($this->utf8_text as $lang => $text) {
            $md5 = md5($text);            
            $result = $this->container->delete_object($lang . ".txt");
            $this->assertTrue($result);
        }
    }

    public function test_delete_main_container () { 
        $result = $this->conn->delete_container("utf-8");
        $this->assertTrue($result);        
    }
    
};

?>