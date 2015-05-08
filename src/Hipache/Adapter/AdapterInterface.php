<?php
namespace Hipache\Adapter;

use Hipache\Backend\BackendInterface;
use Hipache\Collection;
use Hipache\Frontend\ReadOnlyFrontend;

interface AdapterInterface
{
    /**
     * Get the collection of registered frontends.
     *
     * @return Collection
     */
    public function getFrontendCollection();

    /**
     * Get a frontend by its name.
     *
     * @param string $name
     * @return ReadOnlyFrontend
     */
    public function getFrontend($name);

    /**
     * Create a new frontend.
     *
     * @param ReadOnlyFrontend $frontend
     * @return ReadOnlyFrontend
     */
    public function createFrontend(ReadOnlyFrontend $frontend);

    /**
     * Add a backend to the given frontend.
     *
     * @param ReadOnlyFrontend $frontend
     * @param BackendInterface $backend
     */
    public function addBackend(ReadOnlyFrontend $frontend, BackendInterface $backend);

    /**
     * Remove a given backend from the given frontend.
     *
     * @param ReadOnlyFrontend $frontend
     * @param BackendInterface $backend
     */
    public function removeBackend(ReadOnlyFrontend $frontend, BackendInterface $backend);
}
