<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Model;

use DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterface;
use DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaInterfaceFactory;
use DnTukadiya\DynamicGoogleReCaptcha\Api\Data\DynamicCaptchaSearchResultsInterfaceFactory;
use DnTukadiya\DynamicGoogleReCaptcha\Api\DynamicCaptchaRepositoryInterface;
use DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha as ResourceDynamicCaptcha;
use DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha\CollectionFactory as DynamicCaptchaCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class DynamicCaptchaRepository implements DynamicCaptchaRepositoryInterface
{

    /**
     * @var ResourceDynamicCaptcha
     */
    protected $resource;

    /**
     * @var DynamicCaptchaInterfaceFactory
     */
    protected $dynamicCaptchaFactory;

    /**
     * @var DynamicCaptchaCollectionFactory
     */
    protected $dynamicCaptchaCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var DynamicCaptcha
     */
    protected $searchResultsFactory;


    /**
     * @param ResourceDynamicCaptcha $resource
     * @param DynamicCaptchaInterfaceFactory $dynamicCaptchaFactory
     * @param DynamicCaptchaCollectionFactory $dynamicCaptchaCollectionFactory
     * @param DynamicCaptchaSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceDynamicCaptcha $resource,
        DynamicCaptchaInterfaceFactory $dynamicCaptchaFactory,
        DynamicCaptchaCollectionFactory $dynamicCaptchaCollectionFactory,
        DynamicCaptchaSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->dynamicCaptchaFactory = $dynamicCaptchaFactory;
        $this->dynamicCaptchaCollectionFactory = $dynamicCaptchaCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(DynamicCaptchaInterface $dynamicCaptcha)
    {
        try {
            $this->resource->save($dynamicCaptcha);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the dynamicCaptcha: %1',
                $exception->getMessage()
            ));
        }
        return $dynamicCaptcha;
    }

    /**
     * @inheritDoc
     */
    public function get($dynamicCaptchaId)
    {
        $dynamicCaptcha = $this->dynamicCaptchaFactory->create();
        $this->resource->load($dynamicCaptcha, $dynamicCaptchaId);
        if (!$dynamicCaptcha->getId()) {
            throw new NoSuchEntityException(__('dynamic_captcha with id "%1" does not exist.', $dynamicCaptchaId));
        }
        return $dynamicCaptcha;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->dynamicCaptchaCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(DynamicCaptchaInterface $dynamicCaptcha)
    {
        try {
            $dynamicCaptchaModel = $this->dynamicCaptchaFactory->create();
            $this->resource->load($dynamicCaptchaModel, $dynamicCaptcha->getDynamicCaptchaId());
            $this->resource->delete($dynamicCaptchaModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the dynamic_captcha: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($dynamicCaptchaId)
    {
        return $this->delete($this->get($dynamicCaptchaId));
    }
}

