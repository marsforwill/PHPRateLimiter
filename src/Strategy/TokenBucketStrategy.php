<?php
namespace PHPRateLimiter\Strategy;

use PHPRateLimiter\Storage\RateLimiterStorageInterface;

// 获取到token令牌的请求才会被处理
class TokenBucketStrategy implements RateLimitStrategyInterface {
    public function isAllowed(
        string $key, int $limit, int $interval, int $currentCount, RateLimiterStorageInterface $storage
    ): bool {
        $lastTokenTime = $storage->getLastRequestTime($key);
        $timePassed = time() - $lastTokenTime;

        // 根据固定的时间速率生成令牌
        $tokensToAdd = $timePassed * ($limit / $interval);
        // 判断当前请求是否可以获取定牌： 桶里令牌数=currentCount + generate token
        $currentCount = min($limit, $currentCount + $tokensToAdd);

        if ($currentCount >= 1) {
            $storage->set($key, $currentCount - 1);
            $storage->setLastRequestTime($key, time());
            return true;
        }

        return false;
    }
}
