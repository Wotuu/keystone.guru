<?php


namespace App\Service\Cache;

use App\Models\Dungeon;
use Closure;
use DateInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Psr\SimpleCache\InvalidArgumentException;

class CacheService implements CacheServiceInterface
{
    /**
     * @param string $key
     * @return DateInterval|null
     */
    private function _getTtl(string $key): ?DateInterval
    {
        $cacheConfig = config('keystoneguru.cache');

        return isset($cacheConfig[$key]) ? DateInterval::createFromDateString($cacheConfig[$key]['ttl']) : null;
    }

    /**
     * @param string $key
     * @param Closure|mixed $value
     * @param null $ttl
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function remember(string $key, $value, $ttl = null)
    {
        $result = null;

        // Will never get triggered if in debug
        if ($this->has($key)) {
            $result = $this->get($key);
        } // When in debug, don't do any caching
        else {
            // Get the result by calling the closure
            if ($value instanceof Closure) {
                $value = $value();
            }

            // Only write it to cache when we're not local
            if (config('app.env') !== 'local') {
                if (is_string($ttl)) {
                    $ttl = DateInterval::createFromDateString($ttl);
                }
                // If not overridden, get the TTL from config, if it's set anyways
                if ($this->set($key, $value, $ttl ?? $this->_getTtl($key))) {
                    $result = $value;
                }
            } else {
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * @param string $key
     * @param $object
     * @param null $ttl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function set(string $key, $object, $ttl = null): bool
    {
        return Cache::set($key, $object, $ttl);
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function unset(string $key): bool
    {
        return Cache::delete($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     *
     */
    public function dropCaches(): void
    {
        $keys = array_keys(config('keystoneguru.cache'));
        foreach ($keys as $key) {
            $this->unset($key);
        }

        foreach (Dungeon::all() as $dungeon) {
            $this->unset(sprintf('dungeon_%d', $dungeon->id));
        }

        // Clear all view caches for dungeonroutes - use a simple query to prevent loading of all kinds of relations
        $dungeonRouteIds = collect(DB::select('SELECT `id` FROM dungeon_routes'))->pluck('id')->toArray();

        foreach ($dungeonRouteIds as $dungeonRouteId) {
            // Unset for all variants
            $this->unset(sprintf('view:dungeonroute_card_0_0_%d', $dungeonRouteId));
            $this->unset(sprintf('view:dungeonroute_card_0_1_%d', $dungeonRouteId));
            $this->unset(sprintf('view:dungeonroute_card_1_0_%d', $dungeonRouteId));
            $this->unset(sprintf('view:dungeonroute_card_1_1_%d', $dungeonRouteId));
        }
    }
}