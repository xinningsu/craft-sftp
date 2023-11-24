<?php

declare(strict_types=1);

namespace Sulao\CraftSftp;

use Craft;
use craft\behaviors\EnvAttributeParserBehavior;
use craft\flysystem\base\FlysystemFs;
use craft\helpers\App;
use craft\helpers\Assets;
use League\Flysystem\Config;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\PhpseclibV3\SftpAdapter;
use League\Flysystem\PhpseclibV3\SftpConnectionProvider;

class Fs extends FlysystemFs
{
    public string  $host = '';
    public string  $port = '22';
    public string  $username = '';
    public ?string $password = null;
    public ?string $privateKey = null;
    public ?string $passphrase = null;
    public string  $root = '';

    public static function displayName(): string
    {
        return 'SFTP';
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['parser'] = [
            'class'      => EnvAttributeParserBehavior::class,
            'attributes' => ['host', 'port', 'username', 'password', 'privateKey', 'passphrase', 'root'],
        ];

        return $behaviors;
    }

    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('craft-sftp/fsSettings', [
            'fs'      => $this,
            'periods' => array_merge(['' => ''], Assets::periodList()),
        ]);
    }

    protected function defineRules(): array
    {
        return array_merge(parent::defineRules(), [
            [['host', 'username'], 'required'],
        ]);
    }

    protected function createAdapter(): FilesystemAdapter
    {
        return new SftpAdapter(
            SftpConnectionProvider::fromArray([
                'host'       => App::parseEnv($this->host),
                'username'   => App::parseEnv($this->username),
                'password'   => App::parseEnv($this->password),
                'privateKey' => App::parseEnv($this->privateKey),
                'passphrase' => App::parseEnv($this->passphrase),
                'port'       => intval(App::parseEnv($this->port)) ?: 22,
            ]),
            App::parseEnv($this->root)
        );
    }

    protected function addFileMetadataToConfig(array $config): array
    {
        return array_merge(
            parent::addFileMetadataToConfig($config),
            [Config::OPTION_DIRECTORY_VISIBILITY => $this->visibility()]
        );
    }

    protected function invalidateCdnPath(string $path): bool
    {
        return true;
    }
}
