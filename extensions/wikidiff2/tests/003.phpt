--TEST--
Diff test C: https://bugzilla.wikimedia.org/show_bug.cgi?id=27993
--SKIPIF--
<?php if (!extension_loaded("wikidiff2")) print "skip"; ?>
--FILE--
<?php 
$x = <<<EOT
!!FUZZY!!Rajaa

EOT;

#---------------------------------------------------

$y = <<<EOT
Rajaa

EOT;

#---------------------------------------------------

print wikidiff2_do_diff( $x, $y, 2 );

?>
--EXPECT--
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 1--></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div><span class="diffchange diffchange-inline">!!FUZZY!!</span>Rajaa</div></td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>Rajaa</div></td>
</tr>
