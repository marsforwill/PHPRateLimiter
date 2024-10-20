<?php
// 引入 Composer 的自动加载器
require_once __DIR__ . '/../vendor/autoload.php';

use PHPRateLimiter\RateLimiter;
use PHPRateLimiter\Strategy\LeakyBucketStrategy;
use PHPRateLimiter\Storage\MemoryStorage;

// 创建存储类
$storage = new MemoryStorage();

// 创建策略类
$strategy = new LeakyBucketStrategy();

// 创建 RateLimiter 实例
$rateLimiter = new RateLimiter($strategy, $storage);

// 测试限流
$key = 'user_1';
$limit = 5;  // 5次请求
$interval = 60;  // 在60秒内

// 第一次请求应通过
if ($rateLimiter->isAllowed($key, $limit, $interval)) {
    echo "Request 1: Allowed\n";
} else {
    echo "Request 1: Denied\n";
}

// 模拟多次请求
for ($i = 2; $i <= 6; $i++) {
    if ($rateLimiter->isAllowed($key, $limit, $interval)) {
        echo "Request $i: Allowed\n";
    } else {
        echo "Request $i: Denied\n";
    }
}
