<h1>Wikia API</h1>
<h2><?= $class; ?> Controller</h2>
<dl>
 <?php foreach( $methods as $method ): ?>
 <dt><strong><?= $method['method']; ?></strong></dt>
 <dd><?= $method['description']; ?></dd>
 <?php endforeach; ?>
</dl>
