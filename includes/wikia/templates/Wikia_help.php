<h2><?= $class; ?></h2>
<dl>
 <?php foreach( $methods as $method ): ?>
 <dt><?= $method['method']; ?></dt>
 <dd><?= $method['description']; ?>
  <p>
  <strong>Formats:</strong>
  <?= implode( ', ', $method['formats'] ); ?>
  </p>
 </dd>
 <?php endforeach; ?>
</dl>
