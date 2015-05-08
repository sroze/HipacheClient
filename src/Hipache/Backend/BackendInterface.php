<?php
namespace Hipache\Backend;

interface BackendInterface
{
    /**
     * Get address of this backend target.
     *
     * @return string
     */
    public function getAddress();
}
