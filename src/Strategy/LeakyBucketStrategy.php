<?php
namespace PHPRateLimiter\Strategy;

use PHPRateLimiter\Storage\RateLimiterStorageInterface;

class LeakyBucketStrategy implements RateLimitStrategyInterface {
    public function isAllowed(
        string $key, int $limit, int $interval, int $currentCount, RateLimiterStorageInterface $storage
    ): bool {
        // 漏桶流速
        $lastRequestTime = $storage->getLastRequestTime($key);
        $timePassed = time() - $lastRequestTime;
        $leakRate = $limit / $interval; // 每秒漏掉多少个请求
        
        // 更新当前请求数，漏掉的请求数从总数中减少
        $currentCount = max(0, $currentCount - $leakRate * $timePassed);
        
        // 判断是否还能继续处理请求
        if ($currentCount < $limit) {
            $storage->set($key, $currentCount + 1);
            $storage->setLastRequestTime($key, time());
            return true;
        }
        
        return false;
    }
}
