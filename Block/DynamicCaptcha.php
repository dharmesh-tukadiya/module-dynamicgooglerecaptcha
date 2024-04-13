<?php

namespace DnTukadiya\DynamicGoogleReCaptcha\Block;

class DynamicCaptcha extends \Magento\Framework\View\Element\Template
{

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formKey = $formKey;
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
