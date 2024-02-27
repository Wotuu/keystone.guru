<?php

namespace App\Service\Cache;

interface CacheServiceInterface
{
    public function setCacheEnabled(bool $cacheEnabled): self;

    public function rememberWhen(bool $condition, string $key, $value, ?string $ttl = null): mixed;

    public function remember(string $key, $value, ?string $ttl = null): mixed;

    public function get(string $key): mixed;

    public function set(string $key, $object, ?string $ttl = null): bool;

    public function has(string $key): bool;

    public function dropCaches(): void;
}
