<form action="" method="get">
<?php foreach( range( 1, $limit) as $cnt ):
	$row = array_shift( $data )
?>
<div>
	<h4><a href="<?php echo $title->getFullUrl() . "/{$row->wiki->city_id}" ?>">
		<?php echo $row->wiki->city_title ?>
	</a></h4>
	<?php echo empty( $row->wiki->city_description) ? "no description" : $row->wiki->city_description ?>
	<br />
	<em>Used domains: <?php echo implode ( ", ", $row->domains ) ?></em>
</div
<?php endforeach ?>
</form
