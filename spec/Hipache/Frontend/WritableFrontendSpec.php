<?php

namespace spec\Hipache\Frontend;

use Hipache\Adapter\AdapterInterface;
use Hipache\Backend\BackendInterface;
use Hipache\Frontend\ReadOnlyFrontend;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WritableFrontendSpec extends ObjectBehavior
{
    function it_is_initializable(AdapterInterface $adapter, ReadOnlyFrontend $frontend)
    {
        $this->beConstructedWith($adapter, $frontend);
        $this->shouldHaveType('Hipache\Frontend\WritableFrontend');
    }

    function it_should_be_able_to_add_a_backend(AdapterInterface $adapter, ReadOnlyFrontend $frontend, BackendInterface $backend)
    {
        $this->beConstructedWith($adapter, $frontend);
        $adapter->addBackend($frontend, $backend)->shouldBeCalled();
        $this->add($backend);
    }

    function it_should_be_able_to_remove_a_backend(AdapterInterface $adapter, ReadOnlyFrontend $frontend, BackendInterface $backend)
    {
        $this->beConstructedWith($adapter, $frontend);
        $adapter->removeBackend($frontend, $backend)->shouldBeCalled();
        $this->remove($backend);
    }
}
