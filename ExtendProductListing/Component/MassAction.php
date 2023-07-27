<?php

namespace Magenest\ExtendProductListing\Component;

use Magento\Framework\App\ObjectManager;
use Magento\Ui\Component\AbstractComponent;

class MassAction extends AbstractComponent
{
    const NAME = 'massaction';
    /**
     * @inheritDoc
     */
    public function prepare()
    {
        $config = $this->getConfiguration();

        foreach ($this->getChildComponents() as $actionComponent) {
            $config['actions'][] = $actionComponent->getConfiguration();
        };

        $origConfig = $this->getConfiguration();
        if ($origConfig !== $config) {
            $config = array_replace_recursive($config, $origConfig);
        }
        $this->setData('config', $config);
        $this->components = [];

        parent::prepare();
    }
    /**
     * Get component name
     *
     * @return string
     */
    public function getComponentName()
    {
        return static::NAME;
    }
}
