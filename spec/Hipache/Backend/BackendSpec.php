<?php

namespace spec\Hipache\Backend;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BackendSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hipache\Backend\Backend');
    }

    function let()
    {
        $this->beConstructedWith('bar');
    }

    function it_should_have_an_address()
    {
        $this->getAddress()->shouldReturn('bar');
    }
}
