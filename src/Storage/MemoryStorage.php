<?php
namespace PHPRateLimiter\Storage;

class MemoryStorage implements RateLimiterStorageInterface {
    private array $storage = [];

    public function get(string $key): int {
        return $this->storage[$key] ?? 0;
    }

    public function set(string $key, int $value): void {
        $this->storage[$key] = $value;
    }

    public function getLastRequestTime(string $key): int {
        return $this->storage[$key . ':time'] ?? 0;
    }

    public function setLastRequestTime(string $key, int $time): void {
        $this->storage[$key . ':time'] = $time;
    }
}
