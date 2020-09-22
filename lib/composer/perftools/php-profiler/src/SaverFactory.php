<?php

namespace Xhgui\Profiler;

use RuntimeException;
use Xhgui\Profiler\Saver\SaverInterface;
use Xhgui_Saver;
use Xhgui_Saver_Interface;

final class SaverFactory
{
    /**
     * @param string $saveHandler
     * @param array $config
     * @return SaverInterface|null
     */
    public static function create($saveHandler, array $config = array())
    {
        switch ($saveHandler) {
            case Profiler::SAVER_FILE:
                $saverConfig = array_merge(array(
                    'filename' => null,
                ), isset($config['save.handler.file']) ? $config['save.handler.file'] : array());
                $saver = new Saver\FileSaver($saverConfig['filename']);
                break;
            case Profiler::SAVER_UPLOAD:
                $saverConfig = array_merge(array(
                    'uri' => null,
                    'token' => null,
                    'timeout' => 3,
                ), isset($config['save.handler.upload']) ? $config['save.handler.upload'] : array());
                $saver = new Saver\UploadSaver($saverConfig['uri'], $saverConfig['token'], $saverConfig['timeout']);
                break;
            default:
                // create via xhgui-collector
                if (!class_exists('\Xhgui_Saver')) {
                    throw new RuntimeException("For {$saveHandler} you need to install xhgui-collector package: composer require perftools/xhgui-collector");
                }
                $config = self::migrateConfig($config, $saveHandler);
                $legacySaver = Xhgui_Saver::factory($config);
                $saver = static::getAdapter($legacySaver);
                break;
        }

        if (!$saver || !$saver->isSupported()) {
            return null;
        }

        return $saver;
    }

    /**
     * Prepare config for Xhgui_Saver specific to $saveHandler
     *
     * @param array $config
     * @param string $saveHandler
     * @return array
     */
    private static function migrateConfig(array $config, $saveHandler)
    {
        switch ($saveHandler) {
            case Profiler::SAVER_MONGODB:
                if (isset($config['save.handler.mongodb']['dsn'])) {
                    $config['db.host'] = $config['save.handler.mongodb']['dsn'];
                }
                if (isset($config['save.handler.mongodb']['database'])) {
                    $config['db.db'] = $config['save.handler.mongodb']['database'];
                }
                if (isset($config['save.handler.mongodb']['options'])) {
                    $config['db.options'] = $config['save.handler.mongodb']['options'];
                } else {
                    $config['db.options'] = array();
                }
                if (isset($config['save.handler.mongodb']['driverOptions'])) {
                    $config['db.driverOptions'] = $config['save.handler.mongodb']['driverOptions'];
                } else {
                    $config['db.driverOptions'] = array();
                }
                break;
            case Profiler::SAVER_PDO:
                if (isset($config['save.handler.pdo'])) {
                    $config['pdo'] = $config['save.handler.pdo'];
                }
                break;
        }

        $config['save.handler'] = $saveHandler;

        return $config;
    }

    private static function getAdapter(Xhgui_Saver_Interface $saver)
    {
        $adapters = array(
            new Saver\PdoSaver($saver),
            new Saver\MongoSaver($saver),
        );

        $available = array_filter($adapters, function (SaverInterface $adapter) {
            return $adapter->isSupported();
        });

        return current($available) ?: null;
    }
}
