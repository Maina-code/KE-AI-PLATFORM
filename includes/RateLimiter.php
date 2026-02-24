<?php
class RateLimiter {
    private $redis;
    private $maxAttempts = 5;
    private $timeWindow = 300; // 5 minutes
    
    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('redis', 6379);
        $this->redis->auth(REDIS_PASSWORD);
    }
    
    public function check($key) {
        $current = $this->redis->get($key);
        
        if ($current && $current >= $this->maxAttempts) {
            $ttl = $this->redis->ttl($key);
            throw new Exception("Rate limit exceeded. Try again in {$ttl} seconds.");
        }
        
        $this->redis->incr($key);
        $this->redis->expire($key, $this->timeWindow);
        
        return true;
    }
}