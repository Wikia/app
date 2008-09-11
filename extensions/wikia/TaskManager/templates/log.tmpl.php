<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#tm-log pre {
	max-height: 500px
}
/*]]>*/
</style>
<div id="tm-log">
<pre>
<?php
if (is_array($events)) {
    foreach ($events as $event) {
        echo wfTimestamp( TS_EXIF, $event->log_timestamp );
        echo " {$event->log_line} \n";
    }
}
else {
    echo "log is empty";
}
?>
</pre>
</div>
<!-- e:<?= __FILE__ ?> -->
