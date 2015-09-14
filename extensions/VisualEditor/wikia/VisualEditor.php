<?php

ExtensionRegistry::getInstance()->queue( __DIR__ . '/extension.json' );
ExtensionRegistry::getInstance()->loadFromQueue();