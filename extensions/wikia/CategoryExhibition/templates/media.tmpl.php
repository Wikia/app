<? if(!$fromAjax){ ?><div id="mw-images">
<h2><?=wfMsg( 'category-exhibition-media-header', htmlspecialchars( $category ) ) ?></h2>

<div class="category-gallery">
	<div class="category-gallery-holder">
		<div class="category-gallery-room1" /><? } ?>

	<? foreach($data as $row){ ?>
		<div class="category-gallery-media ">
			<span class="category-gallery-item-image">
				<a href="<?=$row['url'] ?>" data-ref="<?=$row['data-ref']; ?>" class="<?=$row['class']; ?>" title="<?=$row['title']; ?>">
					<? if($row['class'] != 'lightbox'){ ?><div class="category-gallery-item-play"></div><? } ?>
					<img src="<?=$row['img'] ?>" alt="<?=$row['title'] ?>" style="<?
						if(!empty($row['dimensions']['w'])){
							echo "width:".$row['dimensions']['w']."px; ";
						};
						if(!empty($row['dimensions']['h'])){
							echo "height:".$row['dimensions']['h']."px; ";
						};
					?>" />
				</a>
			</span>
			<details><a href="<?=$row['url'] ?>" class="<?=$row['class']; ?>" title="<?=$row['title']; ?>"><?=$row['title']; ?></a></details>
			<details class="bigger"><? if(!empty($row['targetUrl']) && !empty($row['targetText'])){ echo 'Posted in: <a href="'.$row['targetUrl'].'" title="'.$row['targetText'].'">'.$row['targetText'].'</a>';  } ; ?></details>
		</div>
		<? }; if(!$fromAjax){ ?>
		</div>
		<div class="category-gallery-room2" />
		</div>
	</div>

</div>
	<div class="category-gallery-paginator"><?=$paginator; ?></div>
</div> <? } ?>