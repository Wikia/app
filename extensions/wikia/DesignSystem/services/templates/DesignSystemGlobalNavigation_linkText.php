<a href="<?= Sanitizer::encodeAttribute( $model['href'] ); ?>"<?= !empty($standaloneLink) ? ' class="wds-global-navigation__link"' : '' ?>><?= DesignSystemHelper::renderText( $model['title'] ) ?></a>
