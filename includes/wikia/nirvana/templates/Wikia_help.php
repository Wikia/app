<h1>Wikia API</h1>
<h2><?= $class; ?> Controller</h2>
<dl>
	 <?php foreach( $methods as $method ): ?>
	 <dt><h3><?= $method['method']; ?></h3></d3t>
	 <dd>
	 	<?= $method['description']; ?>
	 	<? foreach( array( 'request', 'response' ) as $section ) :?>
		 	<? if ( !empty( $method[$section] ) ) :?>
				<dl>
			 		<dt><h4><?= ucfirst( $section ) ;?></h4></dt>
			 		<dd><ul>
					 <? foreach ( $method[$section] as $item ) :?>
					 	<li>
				 		 <? foreach ( $item as $key => $val ) :?>
						 	<strong><?= $key ;?></strong>: <?= ($key == 'optional') ? (($val) ? 'yes' : 'no' ) : $val ;?><br/>
						 <? endforeach ;?>
						</li>
					 <? endforeach ;?>
					</ul></dd>
				</dl>
			<?	endif ;?>
		<? endforeach ;?>
	 </dd>
 <?php endforeach; ?>
</dl>
