<?php

namespace DnTukadiya\DynamicGoogleReCaptcha\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Websites implements OptionSourceInterface
{
    private $websiteCollectionFactory;
    public function __construct(
        \Magento\Store\Model\ResourceModel\Website\CollectionFactory $websiteCollectionFactory
    ) {
        $this->websiteCollectionFactory = $websiteCollectionFactory;
    }
    public function toOptionArray()
    {
        $websiteCollection = $this->websiteCollectionFactory->create();
        $websiteArray = [];
        $websiteArray[] = ['value' => 0, 'label' => __('All Websites')];
        foreach ($websiteCollection as $website) {
            $websiteArray[] = ['value' => $website->getId(), 'label' => __($website->getName())];
        }
        return $websiteArray;
    }
}
