<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
div.wf-list { text-align: left; margin-bottom: 1em;}
/*]]>*/
</style>
<form action="" method="get">
<?php
$cnt = 0;
foreach( $data as $row ):
?>
<div class="wf-list">
	<h4><a href="<?php echo $title->getFullUrl() . "/{$row->wiki->city_id}" ?>">
		<?php CityListPager::bold( $row->wiki->city_title, $part )?>
		<span style="font-size: smaller">language: <?php echo $row->wiki->city_lang ?></span>
	</a></h4>
	<?php echo empty( $row->wiki->city_description ) ? "no description" : $row->wiki->city_description ?>
	<br />
	<em>Used domains: <?php echo CityListPager::bold( implode ( ", ", (array) $row->domains ), $part ) ?></em>
	<br />
	<span style="color: darkgreen;"><?php CityListPager::bold( $row->wiki->city_url, $part ) ?></a></span>
	 - <a href="<?php echo $title->getFullUrl() . "/{$row->wiki->city_id}" ?>">wikifactory</a>
	 - <a href="<?php echo $row->wiki->city_url ?>">link</a>
</div>
<?php
	 if( $cnt > $limit) break;
endforeach
?>
</form>
