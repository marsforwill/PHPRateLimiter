<?php
namespace PHPRateLimiter;

use PHPRateLimiter\Strategy\RateLimitStrategyInterface;
use PHPRateLimiter\Storage\RateLimiterStorageInterface;

class RateLimiter {
    private RateLimitStrategyInterface $strategy;
    private RateLimiterStorageInterface $storage;

    public function __construct(
        RateLimitStrategyInterface $strategy, 
        RateLimiterStorageInterface $storage
    ) {
        $this->strategy = $strategy;
        $this->storage = $storage;
    }

    public function isAllowed(string $key, int $limit, int $interval): bool {
        $currentCount = $this->storage->get($key);
        return $this->strategy->isAllowed($key, $limit, $interval, $currentCount, $this->storage);
    }
}
