<?php
namespace LeSite\CustomBar\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class PromoBlock
 * System config form field render
 */
class PromoBlock extends AbstractFieldArray
{
    /**
     * @var Columns\CustomerGroup
     */
    private $groupRenderer;

    /**
     * @var Columns\CmsBlock
     */
    private $cmsBlockRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('group', [
            'label' => __('Customer Group'),
            'class' => 'required-entry',
            'renderer' => $this->getGroupRenderer()
        ]);
        $this->addColumn('block_id', [
            'label' => __('CMS Block'),
            'class' => 'required-entry',
            'renderer' => $this->getCmsBlockRenderer()
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $group = $row->getGroup();
        if ($group !== null) {
            $options['option_' . $this->getGroupRenderer()->calcOptionHash($group)] = 'selected="selected"';
        }

        $blockId = $row->getBlockId();
        if ($group !== null) {
            $options['option_' . $this->getCmsBlockRenderer()->calcOptionHash($blockId)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return Columns\CustomerGroup
     * @throws LocalizedException
     */
    private function getGroupRenderer()
    {
        if (!$this->groupRenderer) {
            $this->groupRenderer = $this->getLayout()->createBlock(
                Columns\CustomerGroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->groupRenderer;
    }

    /**
     * @return Columns\CmsBlock
     * @throws LocalizedException
     */
    private function getCmsBlockRenderer()
    {
        if (!$this->cmsBlockRenderer) {
            $this->cmsBlockRenderer = $this->getLayout()->createBlock(
                Columns\CmsBlock::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->cmsBlockRenderer;
    }
}
