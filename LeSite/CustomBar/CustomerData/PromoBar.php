<?php

namespace LeSite\CustomBar\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Layout;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Cms\Block\Block;

/**
 * PromoBar section
 */
class PromoBar implements SectionSourceInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Layout
     */
    private $layout;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     * @param Layout $layout
     * @param CustomerSession $customerSession
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer,
        Layout $layout,
        CustomerSession $customerSession
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
        $this->layout = $layout;
        $this->customerSession = $customerSession;
    }

    /**
     * Get customer group promo block
     *
     * @return array
     */
    public function getSectionData()
    {
        $customerPromoBar = ['content' => ''];
        if (!$this->isEnable()) {
            return $customerPromoBar;
        }

        $groupId = $this->customerSession->getCustomerGroupId();
        $promoBarMapping = $this->getPromoBlockMapping();
        foreach ($promoBarMapping as $item) {
            if ($item['group'] == $groupId) {
                $customerPromoBar['content'] = $this->layout->createBlock(Block::class)
                    ->setBlockId($item['block_id'])
                    ->toHtml();
                break;
            }
        }
        return $customerPromoBar;
    }

    /**
     * Is module enable
     *
     * @return bool
     */
    private function isEnable()
    {
        return $this->scopeConfig->isSetFlag(
            'customer/promo_bar/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get block mapping
     *
     * @return array
     */
    private function getPromoBlockMapping()
    {
        $promoBar = $this->scopeConfig->getValue(
            'customer/promo_bar/promo_block',
            ScopeInterface::SCOPE_STORE
        );
        if ($promoBar) {
            return $this->serializer->unserialize($promoBar);
        }
        return [];
    }
}
