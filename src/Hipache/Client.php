<?php

namespace Hipache;

use Hipache\Adapter\AdapterInterface;
use Hipache\Frontend\FrontendInterface;
use Hipache\Frontend\ReadOnlyFrontend;
use Hipache\Frontend\WritableFrontend;

class Client
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return FrontendInterface[]
     */
    public function getFrontendCollection()
    {
        return new Collection(array_map(
            [$this, 'getWritableFrontend'],
            $this->adapter->getFrontendCollection()->toArray()
        ));
    }

    /**
     * @param string $name
     * @return FrontendInterface
     */
    public function getFrontend($name)
    {
        return $this->getWritableFrontend($this->adapter->getFrontend($name));
    }

    /**
     * @param ReadOnlyFrontend $frontend
     * @return FrontendInterface
     */
    public function createFrontend(ReadOnlyFrontend $frontend)
    {
        return $this->getWritableFrontend($this->adapter->createFrontend($frontend));
    }

    /**
     * @param ReadOnlyFrontend $frontend
     * @return FrontendInterface
     */
    private function getWritableFrontend(ReadOnlyFrontend $frontend)
    {
        if (!$frontend instanceof FrontendInterface) {
            $frontend = new WritableFrontend($this->adapter, $frontend);
        }

        return $frontend;
    }
}
