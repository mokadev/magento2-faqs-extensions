<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-23 23:54:46
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-01-05 09:03:57
 */

namespace PHPCuong\Faq\Helper;

use Magento\Store\Model\StoreManagerInterface;
use PHPCuong\Faq\Model\ResourceModel\Faq as FaqResourceModel;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Config Helper
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
class Config
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param StoreManagerInterface $storeManager
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    /**
     * Get URL of the category
     *
     * @param $identifier
     * @return string|null
     */
    public function getFaqCategoryFullPath($identifier)
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_CATEGORY_PATH.'/'.$identifier.FaqResourceModel::FAQ_DOT_HTML;
    }

    /**
     * Get URL of the files in pub/media folder
     *
     * @param $path
     * @return string
     */
    public function getFileBaseUrl($path)
    {
        return $this->_storeManager->getStore()->getBaseUrl().DirectoryList::PUB.'/'.DirectoryList::MEDIA.'/'.$path;
    }

    /**
     * Get short description of the question
     *
     * @param $content, $identifier
     * @return string
     */
    public function getFaqShortDescription($content, $identifier)
    {
        $content = strip_tags($content);
        while (stristr($content, '  ')) {
            $content = str_replace('  ', ' ', $content);
        }

        $explode = explode(' ', $content);
        if (count($explode) > 50) {
            $arg = '';
            for ($i=0; $i<count($explode); $i++) {
                if ($i<=50) {
                    $arg .= $explode[$i].' ';
                }
            }
            if (!empty($arg)) {
                $arg = $arg.'... <a href="'.$this->getFaqFullPath($identifier).'">'.__('Read more').'</a>';
            }
            return $arg;
        }
        return $content;
    }

    /**
     * Get URL of the category
     *
     * @param $identifier
     * @return string
     */
    public function getFaqFullPath($identifier)
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_QUESTION_PATH.'/'.$identifier.FaqResourceModel::FAQ_DOT_HTML;
    }

    /**
     * Get URL of the FAQ page
     *
     * @return string
     */
    public function getFaqPage()
    {
        return $this->_storeManager->getStore()->getBaseUrl().FaqResourceModel::FAQ_REQUEST_PATH;
    }
}
