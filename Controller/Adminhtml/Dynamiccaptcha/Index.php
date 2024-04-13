<?php
/**
 * Copyright © DnTukadiya All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Adminhtml\Dynamiccaptcha;

class Index extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
    public const ADMIN_RESOURCE = 'DnTukadiya_DynamicGoogleReCaptcha::dynamic_captcha_view';
    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__("Dynamic Captcha"));
            return $resultPage;
    }
}

