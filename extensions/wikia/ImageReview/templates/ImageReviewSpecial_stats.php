<style type="text/css" scoped>
fieldset {
        display: inline;
}

table {
	width: 100%;
}
</style>

<form method="get">
<?php
	$dates = array( 'start', 'end' ); $currentYear = date( 'Y' );
	foreach ( $dates as $prefix ) {
?>
	<fieldset>
		<legend><?= ucfirst( $prefix ) ?> date</legend>
		<select name="<?= $prefix ?>Day">
			<?php for ( $i = 1; $i <= 31; ++$i ) {
				echo Xml::option( $i, $i, $i == ${$prefix . "Day"} );
			} ?>
		</select>
		<select name="<?= $prefix ?>Month">
<?php
		global $wgLang;
		for( $i = 1; $i < 13; $i++ )
                       echo Xml::option( $wgLang->getMonthName( $i ), $i, $i == ${$prefix . "Month"} );
?>
		</select>
		<select name="<?= $prefix ?>Year">
			<?php for ( $i = 2012; $i <= $currentYear; ++$i ) {
				echo Xml::option( $i, $i, $i == ${$prefix . "Year"} );
			} ?>
		</select>
	</fieldset>
<?php	} ?>

	<?= Xml::submitButton( 'Show stats' ) ?>
	<?= Xml::submitButton( 'Download as CSV', array( 'formaction' => 'csvstats', 'class' => 'secondary' )  ); ?>
</form>

<h2>Summary</h2>

<?= Xml::buildTable( array( $summary ), array( 'class' => 'wikitable' ), $summaryHeaders ); ?>

<h2>Breakdown by user</h2>

<?= Xml::buildTable( $data, array( 'class' => 'wikitable sortable' ), $headers ); ?>
