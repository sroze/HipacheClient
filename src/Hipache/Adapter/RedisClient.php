<?php
namespace Hipache\Adapter;

use Predis\Client;

class RedisClient extends Client
{
    public function keys($pattern)
    {
        return parent::keys($pattern);
    }

    public function exists($pattern)
    {
        return parent::exists($pattern);
    }

    public function lrange($pattern, $count, $end)
    {
        return parent::lrange($pattern, $count, $end);
    }
}
