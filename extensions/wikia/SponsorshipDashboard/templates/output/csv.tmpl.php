<?
$tmpArr = array();
$tmpArr[] = '"date"';
foreach( $labels as $key => $val ){
	$tmpVal = $val;
	str_replace( '"', '""', $tmpVal );
	$tmpArr[] = '"'.$tmpVal.'"';
}
echo implode( ',' , $tmpArr )."\n";

foreach( $data as $dataKey => $row ){
	$tmpArr = array();
	$tmpArr[] = '"'.$row['date'].'"';
	foreach( $labels as $key => $val ){
		$tmpArr[] = ( isset( $row[ $key ] ) ) ? '"'.$row[ $key ].'"' : '"0"' ;
	}
	echo implode( ',' , $tmpArr )."\n";
}
