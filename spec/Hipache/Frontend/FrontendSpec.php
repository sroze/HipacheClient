<?php

namespace spec\Hipache\Frontend;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FrontendSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('address');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hipache\Frontend\Frontend');
    }

    function it_should_have_an_address()
    {
        $this->getHostname()->shouldReturn('address');
    }
}

