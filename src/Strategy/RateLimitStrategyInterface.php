<?php
namespace PHPRateLimiter\Strategy;

use PHPRateLimiter\Storage\RateLimiterStorageInterface;

interface RateLimitStrategyInterface {
    public function isAllowed(
        string $key, int $limit, int $interval, int $currentCount, RateLimiterStorageInterface $storage
    ): bool;
}
