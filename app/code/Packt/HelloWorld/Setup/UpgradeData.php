<?php
namespace Packt\HelloWorld\Setup;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class UpgradeData implements UpgradeDataInterface {
    protected $categorySetupFactory;
    public function
    __construct(\Magento\Catalog\Setup\CategorySetupFactory
    $categorySetupFactory) {
        $this->categorySetupFactory = $categorySetupFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        if (version_compare($context->getVersion(), '2.0.3') < 0) {
            $categorySetup = $this->categorySetupFactory->create(['setup' =>
            $setup]);
            $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $categorySetup->addAttribute($entityTypeId, 'helloworld_label',
            array(
                'type' => 'varchar',
                'label' => 'HeloWorld label',
                'input' => 'text',
                'required' => false,
                'visible_on_front' => true,
                'apply_to' =>
                'simple,configurable,virtual,bundle,downloadable',
                'unique' => false,
                'group' => 'HelloWorld'
            ));
        }
    }
}