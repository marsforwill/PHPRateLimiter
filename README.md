# PHP Rate Limiter

This project implements a flexible and extensible API rate limiter in PHP. It includes memory and Redis storage implementations, and supports two rate-limiting algorithms: Leaky Bucket and Token Bucket.Both Storage and  rate-limiting algorithms implement are easy to extend.

## Project Structure

- **src/**: Contains the main implementation of the rate limiter, including strategies and storage systems.
- **tests/**: Contains PHPUnit test cases for the rate limiter components.
- **storage/**: Defines the `RateLimiterStorageInterface` and provides both in-memory and Redis storage implementations.
- **strategy/**: Implements rate-limiting strategies, such as Leaky Bucket and Token Bucket.

## Storage Implementations

- **MemoryStorage**: A simple in-memory storage used for testing or lightweight scenarios.
- **RedisStorage**: A Redis-based storage using the Predis client for distributed rate limiting.

## Rate Limiting Strategies

- **Leaky Bucket**: Processes requests at a constant rate, allowing bursts but smoothing over time.
- **Token Bucket**: Allows a burst of requests up to a limit and refills at a set rate.

## Running and Testing

To test or run the rate limiter, you can run the test cases located in the `tests/` directory or manually test in the `src/` directory.

### Run PHPUnit tests
in root folder: ./vendor/bin/phpunit tests/RateLimiterTest.php
![image](https://github.com/user-attachments/assets/639bb7c9-d809-4eb0-bb02-4fe333afe1dd)


### Run a sample rate limiter manually
in root folder: php src/test_rate_limiter.php
![image](https://github.com/user-attachments/assets/be6318a6-c7d8-4a2a-9376-98c16d09b248)

