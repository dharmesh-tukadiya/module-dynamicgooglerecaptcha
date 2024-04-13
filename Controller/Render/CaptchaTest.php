<?php

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Render;

class CaptchaTest extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{

    public function __construct(
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
    }
    public function execute()
    {
        echo "Captcha Verification Successful!";
    }
}
