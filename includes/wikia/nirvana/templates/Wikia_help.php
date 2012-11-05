<h1>Wikia API</h1>
<h2><?= $class; ?> Controller</h2>
<dl>
	 <?php foreach( $methods as $method ): ?>
	 <dt><h3><?= $method['method']; ?></h3></d3t>
	 <dd>
	 	<?= $method['description']; ?>
	 	<? if ( !empty( $method['request'] ) ) :?>
			<dl>
		 		<dt><h4>Request</h4></dt>
		 		<dd><ul>
				 <? foreach ( $method['request'] as $item ) :?>
				 	<li>
			 		 <? foreach ( $item as $key => $val ) :?>
					 	<strong><?= $key ;?></strong>: <?= ($key == 'optional') ? (($val) ? 'yes' : 'no' ) : $val ;?><br/>
					 <? endforeach ;?>
					</li>
				 <? endforeach ;?>
				</ul></dd>
			</dl>
		<?	endif ;?>
		<? if ( !empty( $method['response'] ) ) :?>
			<dl>
		 		<dt><h4>Response</h4></dt>
		 		<dd><ul>
				 <? foreach ( $method['request'] as $item ) :?>
				 	<li>
			 		 <? foreach ( $item as $key => $val ) :?>
					 	<strong><?= $key ;?></strong>: <?= ($key == 'optional') ? (($val) ? 'yes' : 'no' ) : $val ;?><br/>
					 <? endforeach ;?>
					</li>
				 <? endforeach ;?>
				</ul></dd>
			</dl>
		<?	endif ;?>
	 </dd>
 <?php endforeach; ?>
</dl>
