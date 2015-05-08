<?php
namespace Hipache\Frontend;

use Hipache\Backend\BackendInterface;
use Hipache\Collection;

interface ReadOnlyFrontend
{
    /**
     * Get hostname the frontend should answer to.
     *
     * @return string
     */
    public function getHostname();

    /**
     * Get backend by its address.
     *
     * @param string $address
     * @return BackendInterface
     */
    public function getBackendByAddress($address);

    /**
     * Return a collection of registered backends.
     *
     * @return Collection
     */
    public function getBackendCollection();
}
