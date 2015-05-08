<?php
namespace Hipache\Frontend;

use Hipache\Adapter\AdapterInterface;
use Hipache\Backend\BackendInterface;

class WritableFrontend implements FrontendInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;
    /**
     * @var ReadOnlyFrontend
     */
    private $frontend;

    public function __construct(AdapterInterface $adapter, ReadOnlyFrontend $frontend)
    {
        $this->adapter = $adapter;
        $this->frontend = $frontend;
    }

    public function add(BackendInterface $backend)
    {
        $this->adapter->addBackend($this->frontend, $backend);
    }

    public function remove(BackendInterface $backend)
    {
        $this->adapter->removeBackend($this->frontend, $backend);
    }

    public function getHostname()
    {
        return $this->frontend->getHostname();
    }

    public function getBackendByAddress($address)
    {
        return $this->frontend->getBackendByAddress($address);
    }

    public function getBackendCollection()
    {
        return $this->frontend->getBackendCollection();
    }
}