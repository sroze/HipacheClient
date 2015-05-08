<?php

namespace spec\Hipache;

use Hipache\Adapter\AdapterInterface;
use Hipache\Collection;
use Hipache\Frontend\ReadOnlyFrontend;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
    function it_is_initializable(AdapterInterface $adapter)
    {
        $this->beConstructedWith($adapter);
        $this->shouldHaveType('Hipache\Client');
    }

    function it_can_return_collection_of_frontends(AdapterInterface $adapter)
    {
        $adapter->getFrontendCollection()->shouldBeCalled()->willReturn(new Collection());
        $this->beConstructedWith($adapter);

        $this->getFrontendCollection();
    }

    function it_should_return_a_writable_frontend(AdapterInterface $adapter, ReadOnlyFrontend $readOnlyFrontend)
    {
        $adapter->getFrontend('foo')->shouldBeCalled()->willReturn($readOnlyFrontend);
        $this->beConstructedWith($adapter);
        $this->getFrontend('foo')->shouldReturnAnInstanceOf('Hipache\Frontend\WritableFrontend');
    }
}
