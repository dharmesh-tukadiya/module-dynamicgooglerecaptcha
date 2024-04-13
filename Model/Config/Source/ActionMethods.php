<?php

namespace DnTukadiya\DynamicGoogleReCaptcha\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ActionMethods implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'POST', 'label' => __('POST')],
            ['value' => 'GET', 'label' => __('GET')],
            ['value' => 'PUT', 'label' => __('PUT')],
            ['value' => 'DELETE', 'label' => __('DELETE')],
            ['value' => 'HEAD', 'label' => __('HEAD')],
            ['value' => 'OPTIONS', 'label' => __('OPTIONS')],
            ['value' => 'PATCH', 'label' => __('PATCH')],
            ['value' => 'TRACE', 'label' => __('TRACE')],
            ['value' => 'CONNECT', 'label' => __('CONNECT')]
        ];
    }
}
