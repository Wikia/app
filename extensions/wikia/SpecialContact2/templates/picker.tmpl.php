<!-- s:<?= __FILE__ ?> -->
<div class="special-contact-picker">
<?php print $head ?>
<br/>
<?php if( !empty( $local ) ) {
	print $local;
	print "<br/>\n";
} ?>
<?php
print Xml::openElement('table', array('id'=>'picker_grid', 'style'=>'width:100%;') );

$side = 'left';
foreach($sectionData as $section)
{
	if($side == 'left') {
		print "<tr>\n";
	}
		print "<td style='width:50%;'><b>" . $section['header'] . "</b><br/>\n";
		foreach($section['links'] as $link)
		{
			print "". $link ."<br/>\n";
		}
		print "</td>\n";
	if($side == 'right') {
		print "</tr>\n";
	}

	if($side == 'left') {
		$side = 'right';
	} else {
		$side = 'left';
	}
}

print Xml::closeElement('table');
?>
<div id="SpecialContactFooterPicker">
<?php echo $foot ?>
</div>
</div>
<!-- e:<?= __FILE__ ?> -->
