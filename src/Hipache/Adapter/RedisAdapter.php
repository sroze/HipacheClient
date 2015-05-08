<?php

namespace Hipache\Adapter;

use Hipache\Backend\Backend;
use Hipache\Backend\BackendInterface;
use Hipache\Collection;
use Hipache\Frontend\Exception\FrontendAlreadyExists;
use Hipache\Frontend\Exception\FrontendNotFound;
use Hipache\Frontend\Frontend;
use Hipache\Frontend\ReadOnlyFrontend;
use Predis\Client as RedisClient;

class RedisAdapter implements AdapterInterface
{
    /**
     * Key prefix for each frontend.
     *
     * @var string
     */
    const KEY_PREFIX = 'frontend:';

    /**
     * @var RedisClient
     */
    private $redis;

    /**
     * @param RedisClient $redis
     */
    public function __construct(RedisClient $redis)
    {
        $this->redis = $redis;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrontendCollection()
    {
        $keys = $this->redis->keys(self::KEY_PREFIX.'*');
        $frontendCollection = new Collection(array_map([$this, 'getFrontendByKey'], $keys));

        return $frontendCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrontend($name)
    {
        $frontend = new Frontend($name);
        if (!$this->exists($frontend)) {
            throw new FrontendNotFound();
        }

        $backendKeys = $this->redis->lrange($this->getFrontendKey($frontend), 1, -1);
        $backendCollection = new Collection(array_map([$this, 'getBackendByHostname'], $backendKeys));

        return new Frontend($name, $backendCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function addBackend(ReadOnlyFrontend $frontend, BackendInterface $backend)
    {
        $this->redis->rpush($this->getFrontendKey($frontend), [
            $backend->getAddress()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function removeBackend(ReadOnlyFrontend $frontend, BackendInterface $backend)
    {
        $this->redis->lrem($this->getFrontendKey($frontend), 1, $backend->getAddress());
    }

    /**
     * {@inheritdoc}
     */
    public function createFrontend(ReadOnlyFrontend $frontend)
    {
        if ($this->exists($frontend)) {
            throw new FrontendAlreadyExists();
        }

        $this->redis->rpush($this->getFrontendKey($frontend), [
            $frontend->getHostname()
        ]);

        return $frontend;
    }

    /**
     * Get a frontend object by its key.
     *
     * @param string $key
     * @return Frontend
     */
    private function getFrontendByKey($key)
    {
        if (substr($key, 0, strlen(self::KEY_PREFIX)) === self::KEY_PREFIX) {
            $key = substr($key, strlen(self::KEY_PREFIX));
        }

        return new Frontend($key);
    }

    /**
     * Return true if the frontend exists.
     *
     * @param ReadOnlyFrontend $frontend
     * @return bool
     */
    private function exists(ReadOnlyFrontend $frontend)
    {
        return $this->redis->exists($this->getFrontendKey($frontend));
    }

    /**
     * Create a backend object based on an hostname.
     *
     * @param string $hostname
     * @return Backend
     */
    private function getBackendByHostname($hostname)
    {
        return new Backend($hostname);
    }

    /**
     * Get the internal key that represents this frontend.
     *
     * @param ReadOnlyFrontend $frontend
     * @return string
     */
    private function getFrontendKey(ReadOnlyFrontend $frontend)
    {
        return self::KEY_PREFIX.$frontend->getHostname();
    }
}
