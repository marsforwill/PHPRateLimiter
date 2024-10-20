<?php

namespace PHPRateLimiter\Storage;

use Predis\Client;

class RedisStorage implements RateLimiterStorageInterface
{
    private Client $redis;

    /**
     * Constructor to initialize the Redis client using Predis.
     * @param array $config - Configuration for connecting to Redis.
     */
    public function __construct(array $config = [])
    {
        // Initialize Predis client with the provided configuration.
        $this->redis = new Client($config);
    }

    /**
     * Retrieve a value from Redis by its key.
     * @param string $key - The key to retrieve.
     * @return int - The stored integer value, or 0 if not found.
     */
    public function get(string $key): int
    {
        // Fetch the value from Redis, default to 0 if not found.
        return (int) $this->redis->get($key) ?? 0;
    }

    /**
     * Set a key-value pair in Redis.
     * @param string $key - The key to set.
     * @param int $value - The value to associate with the key.
     */
    public function set(string $key, int $value): void
    {
        // Store the value in Redis.
        $this->redis->set($key, $value);
    }

    /**
     * Retrieve the last request time from Redis.
     * @param string $key - The key representing the client or request.
     * @return int - The timestamp of the last request, or 0 if not found.
     */
    public function getLastRequestTime(string $key): int
    {
        // Fetch the last request time from Redis.
        return (int) $this->redis->get($key . ':time') ?? 0;
    }

    /**
     * Store the last request time in Redis.
     * @param string $key - The key representing the client or request.
     * @param int $time - The timestamp to store.
     */
    public function setLastRequestTime(string $key, int $time): void
    {
        // Store the last request time in Redis.
        $this->redis->set($key . ':time', $time);
    }

    /**
     * Delete a key from Redis.
     * @param string $key - The key to delete.
     */
    public function delete(string $key): void
    {
        // Delete the key from Redis.
        $this->redis->del([$key]);
    }

    /**
     * Check if a key exists in Redis.
     * @param string $key - The key to check.
     * @return bool - True if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        // Check if the key exists in Redis.
        return $this->redis->exists($key) > 0;
    }
}
