<?php
namespace Hipache\Frontend;

use Hipache\Collection;

class Frontend implements ReadOnlyFrontend
{
    /**
     * @var string
     */
    private $hostname;

    /**
     * @var Collection
     */
    private $backendCollection;

    /**
     * @param string $hostname
     * @param Collection $backendCollection
     */
    public function __construct($hostname, Collection $backendCollection = null)
    {
        $this->hostname = $hostname;
        $this->backendCollection = $backendCollection ?: new Collection();
    }

    /**
     * {@inheritdoc}
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackendByAddress($address)
    {
        foreach ($this->backendCollection as $backend) {
            if ($backend->getAddress() === $address) {
                return $backend;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackendCollection()
    {
        return $this->backendCollection;
    }
}
