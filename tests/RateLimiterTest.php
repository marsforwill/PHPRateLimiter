<?php
use PHPUnit\Framework\TestCase;
use PHPRateLimiter\RateLimiter;
use PHPRateLimiter\Strategy\LeakyBucketStrategy;
use PHPRateLimiter\Strategy\TokenBucketStrategy;
use PHPRateLimiter\Storage\MemoryStorage;

class RateLimiterTest extends TestCase {

    public function testBasic() {
        print("this is basic test");
        $this->assertTrue(TRUE);
    }

    public function testLeakyBucketStrategyAllowed() {
        $storage = new MemoryStorage();
        $strategy = new LeakyBucketStrategy();
        $rateLimiter = new RateLimiter($strategy, $storage);

        $key = 'user_1';
        $limit = 10;  // 允许10次请求
        $interval = 60;  // 1分钟

        // 第一次请求应该通过
        $this->assertTrue($rateLimiter->isAllowed($key, $limit, $interval));

        // 模拟多次请求，直到达到限额
        for ($i = 1; $i < $limit; $i++) {
            $this->assertTrue($rateLimiter->isAllowed($key, $limit, $interval));
        }

        // 第11次请求应被拒绝
        $this->assertFalse($rateLimiter->isAllowed($key, $limit, $interval));
    }

    public function testTokenBucketStrategyAllowed() {
        $storage = new MemoryStorage();
        $strategy = new TokenBucketStrategy();
        $rateLimiter = new RateLimiter($strategy, $storage);

        $key = 'user_2';
        $limit = 5;  // 每秒允许生成5个令牌
        $interval = 1;  // 1秒生成令牌

        // 5次请求应该通过
        for ($i = 0; $i < $limit; $i++) {
            $this->assertTrue($rateLimiter->isAllowed($key, $limit, $interval));
        }

        // 超过5次的请求应被拒绝
        $this->assertFalse($rateLimiter->isAllowed($key, $limit, $interval));

        // 模拟等待1秒，令牌重新生成，允许新的请求
        sleep(1);
        $this->assertTrue($rateLimiter->isAllowed($key, $limit, $interval));
    }
}
