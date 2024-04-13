<?php

namespace DnTukadiya\DynamicGoogleReCaptcha\Model;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class CacheCleaner
{
    protected $cacheTypeList;
    protected $cacheFrontendPool;
    public function __construct(
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool
    ) {

        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
    }

    public function cacheClean(array $identifiers = ['config'])
    {
        foreach ($identifiers as $identifier) {
            $this->cacheTypeList->cleanType($identifier);
        }
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}
