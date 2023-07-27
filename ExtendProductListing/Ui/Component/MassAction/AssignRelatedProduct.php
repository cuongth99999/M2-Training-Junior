<?php

namespace Magenest\ExtendProductListing\Ui\Component\MassAction;

use Magento\Ui\Component\MassAction;

class AssignRelatedProduct extends MassAction
{
    public function prepare()
    {
        parent::prepare();

        if ($this->isEnabled()) {
            $config = $this->getConfiguration();
            $config['actions'][] = [
                'component' => 'uiComponent',
                'type' => 'text',
                'label' => 'Custom',
                'url' => 'magenest_assrelatedproduct'
            ];
            $this->setData('config', $config);
        }
    }

    public function isEnabled()
    {
        return true; // access your configuration here
    }
}
