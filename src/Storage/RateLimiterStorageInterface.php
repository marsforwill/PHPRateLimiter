<?php
namespace RateLimiter\Storage;

interface RateLimiterStorageInterface {
    public function get(string $key): int;
    public function set(string $key, int $value): void;
    public function getLastRequestTime(string $key): int;
    public function setLastRequestTime(string $key, int $time): void;
}
