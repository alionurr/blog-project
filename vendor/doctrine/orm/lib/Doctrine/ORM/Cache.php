<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM;

use Doctrine\ORM\Cache\QueryCache;
use Doctrine\ORM\Cache\Region;

/**
 * Provides an API for querying/managing the second level cache regions.
 */
interface Cache
{
    public const DEFAULT_QUERY_REGION_NAME = 'query_cache_region';

    public const DEFAULT_TIMESTAMP_REGION_NAME = 'timestamp_cache_region';

    /**
     * May read items from the cache, but will not add items.
     */
    public const MODE_GET = 1;

    /**
     * Will never read items from the cache,
     * but will add items to the cache as it reads them from the database.
     */
    public const MODE_PUT = 2;

    /**
     * May read items from the cache, and add items to the cache.
     */
    public const MODE_NORMAL = 3;

    /**
     * The query will never read items from the cache,
     * but will refresh items to the cache as it reads them from the database.
     */
    public const MODE_REFRESH = 4;

    /**
     * @param string $className The Entity class.
     *
     * @return Region|null
     */
    public function getEntityCacheRegion($className);

    /**
     * @param string $className   The Entity class.
     * @param string $association The field name that represents the association.
     *
     * @return Region|null
     */
    public function getCollectionCacheRegion($className, $association);

    /**
     * Determine whether the cache contains data for the given Entity "instance".
     *
     * @param string $className  The Entity class.
     * @param mixed  $identifier The Entity identifier
     *
     * @return bool true if the underlying cache contains corresponding data; false otherwise.
     */
    public function containsEntity($className, $identifier);

    /**
     * Evicts the Entity data for a particular Entity "instance".
     *
     * @param string $className  The Entity class.
     * @param mixed  $identifier The Entity identifier.
     *
     * @return void
     */
    public function evictEntity($className, $identifier);

    /**
     * Evicts all Entity data from the given region.
     *
     * @param string $className The Entity metadata.
     *
     * @return void
     */
    public function evictEntityRegion($className);

    /**
     * Evict data from all Entity regions.
     *
     * @return void
     */
    public function evictEntityRegions();

    /**
     * Determine whether the cache contains data for the given collection.
     *
     * @param string $className       The Entity class.
     * @param string $association     The field name that represents the association.
     * @param mixed  $ownerIdentifier The identifier of the owning Entity.
     *
     * @return bool true if the underlying cache contains corresponding data; false otherwise.
     */
    public function containsCollection($className, $association, $ownerIdentifier);

    /**
     * Evicts the cache data for the given identified collection instance.
     *
     * @param string $className       The Entity class.
     * @param string $association     The field name that represents the association.
     * @param mixed  $ownerIdentifier The identifier of the owning Entity.
     *
     * @return void
     */
    public function evictCollection($className, $association, $ownerIdentifier);

    /**
     * Evicts all Entity data from the given region.
     *
     * @param string $className   The Entity class.
     * @param string $association The field name that represents the association.
     *
     * @return void
     */
    public function evictCollectionRegion($className, $association);

    /**
     * Evict data from all collection regions.
     *
     * @return void
     */
    public function evictCollectionRegions();

    /**
     * Determine whether the cache contains data for the given query.
     *
     * @param string $regionName The cache name given to the query.
     *
     * @return bool true if the underlying cache contains corresponding data; false otherwise.
     */
    public function containsQuery($regionName);

    /**
     * Evicts all cached query results under the given name, or default query cache if the region name is NULL.
     *
     * @param string|null $regionName The cache name associated to the queries being cached.
     */
    public function evictQueryRegion($regionName = null);

    /**
     * Evict data from all query regions.
     *
     * @return void
     */
    public function evictQueryRegions();

    /**
     * Get query cache by region name or create a new one if none exist.
     *
     * @param string|null $regionName Query cache region name, or default query cache if the region name is NULL.
     *
     * @return QueryCache The Query Cache associated with the region name.
     */
    public function getQueryCache($regionName = null);
}
