<?PHP


class bla {
	protected $foo = array();

	function __set($key,$value) {
		$this->foo[$key]=$value;
	}
	
	function __get($key) {
		return $this->foo[$key];
	}
}

$b=new bla();
$baz="bar";
$b->$baz="hello";
echo $b->bar;

?>
