<?php

namespace Meteomatics\Core\Model\Config\Source;

class ListFormats implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'json', 'label' => __('JSON')],
            ['value' => 'csv', 'label' => __('CSV')],
            ['value' => 'xml', 'label' => __('XML')]
        ];
    }
}
