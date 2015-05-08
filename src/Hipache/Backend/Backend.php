<?php
namespace Hipache\Backend;

class Backend implements BackendInterface
{
    /**
     * @var string
     */
    private $address;

    /**
     * @param string $address
     */
    public function __construct($address)
    {
        $this->address = $address;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }
}
