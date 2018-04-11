<?php 
namespace Yaoli\Tracking\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class TrackorderActions extends \Magento\Ui\Component\Listing\Columns\Column
{
	/**
     * Edit Action Url
     */
    const URL_PATH_EDIT = 'yaoli_tracking/trackorder/edit';

    /**
     * Delete Action Url
     */
    const URL_PATH_DELETE = 'yaoli_tracking/trackorder/delete';

    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * constructor
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(\Magento\Framework\UrlInterface $urlBuilder, ContextInterface $context, UiComponentFactory $uiComponentFactory, array $components = [], array $data = [])
    {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $item[$this->getData('entity_id')] = [
                        'edit' => [
                            'href' => $this->_urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->_urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.entity_id }"'),
                                'message' => __('Are you sure you wan\'t to delete the Post "${ $.$data.entity_id }" ?')
                            ]
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}