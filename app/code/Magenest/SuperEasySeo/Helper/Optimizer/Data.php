<?php
/**
 * Copyright © 2017 Magenest. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Magenest\SuperEasySeo\Helper\Optimizer;

/**
 * Class Data
 * @package Magenest\SuperEasySeo\Helper\Optimizer
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;
    
    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    public $moduleList;
    
    /**
     * @var \Magento\Framework\Filesystem
     */
    public $fileSystem;
    
    /**
     * @var \Magento\Framework\Component\ComponentRegistrarInterface
     */
    public $componentRegistrar;
    
    /**
     * @var \Psr\Log\LoggerInterface
     */
    public $logger;
    
    /**
     * Magento Root full path.
     *
     * @var null|string
     */
    public $baseDir = null;
    
    /**
     * Module Root full path.
     *
     * @var null|string
     */
    public $moduleDir = null;
    
    /**
     * Logging flag.
     *
     * @var null|int
     */
    public $logging = null;
    
    /**
     * Index path.
     *
     * @var null|string $indexPath
     */
    public $indexPath = null;
    
    /**
     * Index array.
     *
     * @var array $index
     */
    public $index = [];

    /**
     * @var \Magenest\SuperEasySeo\Model\OptimizerConfigFactory
     */
    protected $configOptimizer;

    /**
     * @var \Magenest\SuperEasySeo\Model\OptimizerImageFactory
     */
    protected $imageOptimizer;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\Framework\Component\ComponentRegistrarInterface $compReg
     * @param \Magenest\SuperEasySeo\Model\OptimizerConfigFactory $configFactory
     * @param \Magenest\SuperEasySeo\Model\OptimizerImageFactory $imageFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Component\ComponentRegistrarInterface $compReg,
        \Magenest\SuperEasySeo\Model\OptimizerConfigFactory $configFactory,
        \Magenest\SuperEasySeo\Model\OptimizerImageFactory $imageFactory
    ) {
        $this->configOptimizer    = $configFactory;
        $this->imageOptimizer     = $imageFactory;
        $this->scopeConfig        = $context->getScopeConfig();
        $this->logger             = $context->getLogger();
        $this->moduleList         = $moduleList;
        $this->fileSystem         = $fileSystem;
        $this->componentRegistrar = $compReg;
        
        parent::__construct($context);
    }

    /**
     * @param $configPath
     * @return mixed
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue($configPath);
    }
    
    /**
     * Get Root full path.
     *
     * @return string
     */
    public function getBaseDir()
    {
        if ($this->baseDir === null) {
            $dir = $this->fileSystem->getDirectoryRead(
                \Magento\Framework\App\Filesystem\DirectoryList::ROOT
            );
            
            $this->baseDir = $dir->getAbsolutePath();
        }
        
        return $this->baseDir;
    }
    
    /**
     * Returns Module Root full path.
     *
     * @return null|string
     */
    public function getModuleDir()
    {
        if ($this->moduleDir === null) {
            $moduleName = 'Magenest_SuperEasySeo';
    
            $this->moduleDir = $this->componentRegistrar->getPath(
                \Magento\Framework\Component\ComponentRegistrar::MODULE,
                $moduleName
            );
        }
        
        return $this->moduleDir;
    }

    /**
     * Based all paths
     * for images.
     *
     * @return array
     */
    public function getPaths($idForm)
    {
        /** @var \Magenest\SuperEasySeo\Model\OptimizerConfig $modelConfig */
        $modelConfig = $this->configOptimizer->create()->load($idForm);
        $paths = [];
    
        $pathsString = trim(trim($modelConfig->getPath(), ';'));
        
        $rawPaths = explode(';', $pathsString);
    
        foreach ($rawPaths as $p) {
            $trimmed = trim(trim($p), '/');
            $dirs = explode('/', $trimmed);
            $paths[] = implode('/', $dirs);
        }
    
        return array_unique($paths);
    }
    
    /**
     * Optimizers single file.
     *
     * @param string $filePath
     * @return boolean
     */
    public function optimizeFile($filePath, $idForm)
    {
        $info = pathinfo($filePath);
        $output = [];

        switch (strtolower($info['extension'])) {
            case 'jpg':
            case 'jpeg':
                exec($this->getJpgUtil($filePath, $idForm), $output, $returnVar);
                break;
            case 'png':
                exec($this->getPngUtil($filePath, $idForm), $output, $returnVar);
                break;
            case 'gif':
                exec($this->getGifUtil($filePath, $idForm), $output, $returnVar);
                break;
        }
    }
    
    /**
     * Optimization process.
     *
     * @return boolean
     */
    public function optimize($idForm)
    {
        /** @var \Magenest\SuperEasySeo\Model\OptimizerConfig $modelConfig */
        $modelConfig = $this->configOptimizer->create()->load($idForm);
        // Get Bath Size
        $batchSize = $modelConfig->getBathSize();
        // Get array of files for optimization limited by batch size
        $files = $this->getFiles($batchSize, $idForm);
        // Optimizer batch of files
        foreach ($files as $filePath) {
            if (file_exists($filePath)) {
                $this->optimizeFile($filePath, $idForm);
            }
        }
    }
    
    /**
     * Scan image
     *
     * @return boolean
     */
    public function scanImage($id)
    {
        $paths    = $this->getPaths($id);
        // Scan for new files and add them to the index
        foreach ($paths as $path) {
            $this->scanImagesPath($path, $id);
        }
    }
    
    /**
     * Get path image
     *
     * @param string $path
     */
    public function scanImagesPath($path, $idForm)
    {
        $file  = null;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $this->getBaseDir() . $path,
                \RecursiveDirectoryIterator::FOLLOW_SYMLINKS
            )
        );

        foreach ($iterator as $file) {
            if ($file->isFile()
                && preg_match(
                    '/^.+\.(jpe?g|gif|png)$/i',
                    $file->getFilename()
                )
            ) {
                $filePath = trim($file->getRealPath());
                if (!is_writable($filePath)) {
                    continue;
                }
                $modelImage = $this->imageOptimizer->create();
                $models = $modelImage->getCollection()
                    ->addFieldToFilter('optimizer_id', $idForm)
                    ->addFieldToFilter('path_image', $filePath)->getFirstItem();
                $fileInfo = ((int)filesize($filePath))/1000;
                $data = [
                    'path_image' =>  $filePath,
                    'optimizer_id' =>  $idForm,
                    'size_before' => $fileInfo,
                    'status' => 1
                ];
                if (empty($models->getData())) {
                    $modelImage->addData($data)->save();
                }
            }
        }
    }
    
    /**
     * Checks OS
     *
     * @return bool
     */
    public function isWindows()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Alias for getUtil() and .gif
     *
     * @param string $filePath
     * @return string
     */
    public function getGifUtil($filePath, $idForm)
    {
        return $this->getUtil('gif', $filePath, $idForm);
    }
    
    /**
     * Alias for getUtil() and .jpg
     *
     * @param string $filePath
     * @return string
     */
    public function getJpgUtil($filePath, $idForm)
    {
        return $this->getUtil('jpg', $filePath, $idForm);
    }
    
    /**
     * Alias for getUtil() and .png
     *
     * @param string $filePath
     * @return string
     */
    public function getPngUtil($filePath, $idForm)
    {
        return $this->getUtil('png', $filePath, $idForm);
    }

    /**
     * @param $type
     * @param $filePath
     * @param $idForm
     * @return mixed
     */
    public function getUtil($type, $filePath, $idForm)
    {
        /** @var \Magenest\SuperEasySeo\Model\OptimizerConfig $modelConfig */
        $modelConfig = $this->configOptimizer->create()->load($idForm);
        $pathDefault = '';
        $configOption = '';
        if ($type == 'png') {
            $pathDefault = $modelConfig->getPngUtility();
            $configOption = $modelConfig->getPngUtilityOptions();
        }
        if ($type == 'jpg') {
            $pathDefault = $modelConfig->getJpgUtility();
            $configOption = $modelConfig->getJpgUtilityOptions();
        }
        if ($type == 'gif') {
            $pathDefault = $modelConfig->getGifUtility();
            $configOption = $modelConfig->getGifUtilityOptions();
        }
        $cmd = $this->getUtilPath($idForm)
            . '/'
            . $pathDefault
            . $this->getUtilExt();
        $cmd .= ' ' . $configOption;
        
        return str_replace('%filepath%', $filePath, $cmd);
    }

    /**
     * @return string
     */
    public function getUtilExt()
    {
        $typeSoftware = $this->isWindows() ? '.exe' : '';

        return $typeSoftware;
    }

    /**
     * @param $idForm
     * @return string
     */
    public function getUtilPath($idForm)
    {
        $modelConfig = $this->configOptimizer->create()->load($idForm);
        $use64Bit = $modelConfig->getUse64bit();

        if ($use64Bit == 1) {
            $bit = '64';
        } else {
            $bit = '32';
        }
        $os = $this->isWindows() ? 'win' . $bit : 'elf' . $bit;
        $pathString = trim(trim('lib'), '/');
        $dirs       = explode('/', $pathString);
        $path       = implode('/', $dirs);
        $pathFile = $this->getModuleDir() . '/' . $path . '/' . $os;

        return $pathFile;
    }
    
    /**
     * Returns array of files for optimization limited by $batchSize.
     *
     * @param int $batchSize
     */
    public function getFiles($batchSize, $idForm)
    {
        $modelImage = $this->imageOptimizer->create()->getCollection()
            ->addFieldToFilter('optimizer_id', $idForm)
            ->addFieldToFilter('status', 1);
        $files   = [];
        $counter = 0;
    
        foreach ($modelImage as $modelImages) {
            if ($counter == $batchSize) {
                break;
            }
            $files[$counter] = $modelImages->getPathImage();
            $counter++;
        }

        return $files;
    }
}
