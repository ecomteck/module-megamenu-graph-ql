<?php
/**
 * Ecomteck
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the ecomteck.com license that is
 * available through the world-wide-web at this URL:
 * https://ecomteck.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Ecomteck
 * @package     Ecomteck_MegamenuGraphQl
 * @copyright   Copyright (c) 2019 Ecomteck (https://ecomteck.com/)
 * @license     https://ecomteck.com/LICENSE.txt
 */

namespace Ecomteck\MegamenuGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Ecomteck\Megamenu\Api\NodeRepositoryInterface;

/**
 * Class Nodes
 * @package Ecomteck\MegamenuGraphQl\Model\Resolver
 */
class Nodes implements ResolverInterface
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var NodeRepositoryInterface
     */
    private $nodeRepository;

    /**
     * Nodes constructor.
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param NodeRepositoryInterface $nodeRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        NodeRepositoryInterface $nodeRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $searchCriteria = $this->searchCriteriaBuilder->build('di_build_megamenu_menu_node', $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);

        $searchResult = $this->nodeRepository->getList($searchCriteria);
        return [
            'total_count' => $searchResult->getTotalCount(),
            'nodes' => $searchResult->getItems()
        ];
    }
}
