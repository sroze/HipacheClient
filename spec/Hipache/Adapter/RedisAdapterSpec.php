<?php

namespace spec\Hipache\Adapter;

use Hipache\Adapter\RedisClient;
use PhpSpec\ObjectBehavior;
use Predis\Client;
use Prophecy\Argument;

class RedisAdapterSpec extends ObjectBehavior
{
    function it_is_initializable(RedisClient $redisClient)
    {
        $this->beConstructedWith($redisClient);
        $this->shouldHaveType('Hipache\Adapter\RedisAdapter');
    }

    function it_should_ask_redis_for_frontends(RedisClient $redisClient)
    {
        $redisClient->keys('frontend:*')->shouldBeCalled()->willReturn([]);
        $this->beConstructedWith($redisClient);
        $this->getFrontendCollection()->shouldReturnAnInstanceOf('Hipache\Collection');
    }

    function it_should_throw_an_exception_if_frontend_do_not_exists(RedisClient $redisClient)
    {
        $redisClient->exists('frontend:foo')->shouldBeCalled()->willReturn(false);
        $this->beConstructedWith($redisClient);
        $this->shouldThrow('Hipache\Frontend\Exception\FrontendNotFound')->during('getFrontend', ['foo']);
    }

    function it_should_return_frontend_with_its_backends(RedisClient $redisClient)
    {
        $redisClient->exists('frontend:foo')->shouldBeCalled()->willReturn(true);
        $redisClient->lrange('frontend:foo', 1, -1)->shouldBeCalled()->willReturn([]);
        $this->beConstructedWith($redisClient);
        $this->getFrontend('foo')->shouldReturnAnInstanceOf('Hipache\Frontend\ReadOnlyFrontend');
    }
}
