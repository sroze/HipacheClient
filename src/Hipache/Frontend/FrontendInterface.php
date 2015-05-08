<?php
namespace Hipache\Frontend;

use Hipache\Backend\BackendInterface;

interface FrontendInterface extends ReadOnlyFrontend
{
    /**
     * Add a new backend to the frontend.
     *
     * @param BackendInterface $backend
     */
    public function add(BackendInterface $backend);

    /**
     * Remove a backend from the frontend.
     *
     * @param BackendInterface $backend
     */
    public function remove(BackendInterface $backend);
}
