--TEST--
Diff test A
--SKIPIF--
<?php if (!extension_loaded("wikidiff2")) print "skip"; ?>
--FILE--
<?php 
$x = <<<EOT
== Added line ==

== Removed line ==

kjahegwnygw
== Moved text ==
a
---line---
a
a
a
a
a
a
a
a
== Two moved lines ==
a
a
a
--line1--
--line2--
a
a
a
a
a
a
a
a
a
a
a
a
a
== Shortest sequence in Y ==
x1
x2
x1
x2
x1
x2
x1
x2
context
context
context
context
context
== Changed line ==
blah blah blah 1


EOT;

#---------------------------------------------------

$y = <<<EOT
== Added line ==

sjgfkdjfgb
== Removed line ==

== Moved text ==
a
a
a
a
a
a
a
---line---
a
a
== Two moved lines ==
a
a
a
a
a
a
a
a
a
a
a
--line1--
--line2--
a
a
a
a
a
== Shortest sequence in Y ==
x2
x1
x2
x1
context
context
context
context
context
== Changed line ==
blah blah blah 2


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
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Added line ==</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Added line ==</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>sjgfkdjfgb</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Removed line ==</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Removed line ==</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>kjahegwnygw</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Moved text ==</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Moved text ==</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>---line---</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 13--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 12--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>---line---</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 19--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 19--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>--line1--</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>--line2--</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 29--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 27--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>--line1--</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-empty">&#160;</td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>--line2--</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 35--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 35--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>a</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Shortest sequence in Y ==</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Shortest sequence in Y ==</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>x1</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x2</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x2</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x1</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x1</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x2</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x2</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x1</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>x1</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>x2</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>x1</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>x2</div></td>
  <td colspan="2" class="diff-empty">&#160;</td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>context</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>context</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>context</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>context</div></td>
</tr>
<tr>
  <td colspan="2" class="diff-lineno"><!--LINE 49--></td>
  <td colspan="2" class="diff-lineno"><!--LINE 45--></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>context</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>context</div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Changed line ==</div></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"><div>== Changed line ==</div></td>
</tr>
<tr>
  <td class="diff-marker">−</td>
  <td class="diff-deletedline"><div>blah blah blah <span class="diffchange diffchange-inline">1</span></div></td>
  <td class="diff-marker">+</td>
  <td class="diff-addedline"><div>blah blah blah <span class="diffchange diffchange-inline">2</span></div></td>
</tr>
<tr>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
  <td class="diff-marker">&#160;</td>
  <td class="diff-context"></td>
</tr>

