<?php
declare(strict_types=1);

namespace LeSite\CustomBar\Block\Adminhtml\Form\Field\Columns;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;

class CmsBlock extends Select
{
    /**
     * @var CollectionFactory
     */
    private $blockColelction;

   /**
    * Constructor
    *
    * @param Context $context
    * @param CollectionFactory $blockColelction
    * @param array $data
    */
    public function __construct(
        Context $context,
        CollectionFactory $blockColelction,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blockColelction = $blockColelction;
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
            $options = $this->blockColelction->create()->toOptionArray();
            $this->setOptions($options);
        }
        return parent::_toHtml();
    }
}
