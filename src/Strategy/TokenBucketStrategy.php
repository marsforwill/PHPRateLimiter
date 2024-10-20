<?php
namespace PHPRateLimiter\Strategy;

use PHPRateLimiter\Storage\RateLimiterStorageInterface;

class TokenBucketStrategy implements RateLimitStrategyInterface {
    public function isAllowed(
        string $key, int $limit, int $interval, int $currentCount, RateLimiterStorageInterface $storage
    ): bool {
        $lastTokenTime = $storage->getLastRequestTime($key);
        $timePassed = time() - $lastTokenTime;

        // 生成令牌
        $tokensToAdd = $timePassed * ($limit / $interval);
        $currentCount = min($limit, $currentCount + $tokensToAdd);

        if ($currentCount >= 1) {
            $storage->set($key, $currentCount - 1);
            $storage->setLastRequestTime($key, time());
            return true;
        }

        return false;
    }
}
