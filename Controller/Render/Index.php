<?php

namespace DnTukadiya\DynamicGoogleReCaptcha\Controller\Render;

use DnTukadiya\DynamicGoogleReCaptcha\Model\ResourceModel\DynamicCaptcha\CollectionFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    private $formKeyValidator;
    private $collectionFactory;
    protected $logger;
    private $scopeConfig;
    private $moduleStatus;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        CollectionFactory $collectionFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->collectionFactory = $collectionFactory;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->moduleStatus = $this->scopeConfig->getValue('dntukadiya_dynamicgooglerecaptcha/module/status');
    }

    public function execute()
    {
        try {
            if ($this->moduleStatus) {
                $request = $this->getRequest();
                if (!($this->formKeyValidator->validate($request))) {
                    echo $this->getInvalidRequestResponse();
                    return;
                }
                if (!(strtolower($request->getMethod()) == "post")) {
                    echo $this->getInvalidActionMethodResponse();
                    return;
                }
                $collection = $this->collectionFactory->create();
                $collection->addFieldToFilter('show_controller_path', [trim($request->getParam('controller') ?? ""), trim(rtrim($request->getParam('controller') ?? "", '/')), trim(ltrim($request->getParam('controller') ?? "", '/'))]);
                $collection->addFieldToFilter('action_method', 'post');
                $collection->addFieldToFilter('status', true);
                if ($collection->count()) {
                    $reCaptchaArray = [];
                    foreach ($collection as $item) {
                        $reCaptchaArray[] = [
                            "target_element_id" => $item->getTargetElementId(),
                            "sitekey" => $this->getGoogleRecaptchaSiteKey($item->getCaptchaType()),
                            "captcha_version" => $this->getGoogleCaptchaVersion($item->getCaptchaType())
                        ];
                    }
                    echo $this->getResponseWithCaptcha($reCaptchaArray);
                    return;
                }
                echo $this->getNullResponse();
                return;
            } else {
                echo $this->getNullResponse();
                return;
            }
        } catch (\Exception $e) {
            $this->logger->critical(__($e->getMessage()));
            echo $this->getErrorReponse();
            return;
        }
    }
    public function getGoogleRecaptchaSiteKey($captchaVersion)
    {
        $siteKey = $this->scopeConfig->getValue(
            'recaptcha_frontend/type_' . $captchaVersion . '/public_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $siteKey;
    }
    public function getGoogleCaptchaVersion($identifier)
    {
        if ($identifier == "recaptcha_v3") {
            return "3i";
        } else if ($identifier == "recaptcha") {
            return "2v";
        } else if ($identifier == "invisible") {
            return "2i";
        } else {
            return "2v";
        }
    }
    public function getInvalidRequestResponse(): string
    {
        return json_encode(["error_code" => "invalid_request", "error_description" => "Invalid Form Key!"]);
    }
    public function getInvalidActionMethodResponse(): string
    {
        return json_encode(["error_code" => "invalid_action_method", "error_description" => "Invalid Action Method!"]);
    }
    public function getResponseWithCaptcha($array): string
    {
        return json_encode(['success' => true, "data" => $array]);
    }
    public function getNullResponse(): string
    {
        return json_encode(['success' => false, "data" => ""]);
    }
    public function getErrorReponse(): string
    {
        return json_encode(["error_code" => "server_error", "error_description" => "Server Side Error Occured!!"]);
    }
}
