<?php
require 'ProtobufCompiler/ProtobufParser.php';

if (!debug_backtrace()) {
    if (!class_exists('\ProtobufMessage')) {

        echo $argv[0] .
            ' requires protobuf extension installed to run' .
            PHP_EOL;

        exit(1);
    }

    if (count($argv) < 2 || count($argv) > 3) {
        printf('USAGE: %s PROTO_FILE [NAMESPACE]' . PHP_EOL, $argv[0]);
        exit(1);
    }

    $parser = new ProtobufParser();
    $file = $argv[1];
    if (isset($argv[2]))
      $namespace = $argv[2];
    else
      $namespace = null;

    if (!file_exists($file)) {
        printf($file . ' does not exist' . PHP_EOL);
        exit(1);
    }

    if (!is_file($file)) {
        printf($file . ' is not a file' . PHP_EOL);
        exit(1);
    }

    try {
        $parser->parse($file, null, $namespace);
    } catch (Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
}
