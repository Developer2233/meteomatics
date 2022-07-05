<?php

namespace Meteomatics\Core\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use \Magento\Cms\Model\BlockFactory;

class CreateBlock implements
    DataPatchInterface
{
    const BLOCK_IDENTIFIER = 'weather-info';

    /**
     * @var BlockFactory
     */
    protected $blockFactory;

    /**
     * UpdateBlockData constructor.
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        BlockFactory $blockFactory
    ) {
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $content = <<<HTML
                            <div class="weather-wrapper" id="weather-info" data-bind="scope: 'weather-scope'">
                                    <!-- ko template: getTemplate() --><!-- /ko -->
                                </div>
                                <script type="text/x-magento-init">
                                {
                                    "#weather-info": {
                                        "Magento_Ui/js/core/app": {
                                            "components": {
                                                "weather-scope": {
                                                    "component": "Meteomatics_Core/js/weatherInfo"
                                                   }
                                            }
                                        }
                                    }
                                }
                                </script>
                            HTML;
        $cmsBlock = [
            'title' => 'Meteomatics weather info',
            'identifier' => self::BLOCK_IDENTIFIER,
            'content' => $content,
            'stores' => [0],
            'is_active' => 1,
        ];

        /** @var \Magento\Cms\Model\Block $block */
        $block = $this->blockFactory->create();
        $block->setData($cmsBlock)->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
}
