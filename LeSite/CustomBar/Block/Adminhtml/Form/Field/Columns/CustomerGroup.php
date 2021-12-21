<?php
declare(strict_types=1);

namespace LeSite\CustomBar\Block\Adminhtml\Form\Field\Columns;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

class CustomerGroup extends Select
{
    /**
     * @var CollectionFactory
     */
    private $customerGroupColelction;

   /**
    * Constructor
    *
    * @param Context $context
    * @param CollectionFactory $customerGroupColelction
    * @param array $data
    */
    public function __construct(
        Context $context,
        CollectionFactory $customerGroupColelction,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerGroupColelction = $customerGroupColelction;
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $options = $this->customerGroupColelction->create()->toOptionArray();
            $this->setOptions($options);
        }
        return parent::_toHtml();
    }
}
