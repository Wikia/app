--TEST--
Basic transliterate extension check
--SKIPIF--
<?php if (!extension_loaded("transliterate")) print "skip"; ?>
--FILE--
<?php 
echo transliterate_with_id('Any-Latin','ウィキペディア');
?>
--EXPECT--
u~ikipedia
