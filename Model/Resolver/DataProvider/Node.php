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
declare(strict_types=1);

namespace Ecomteck\MegamenuGraphQl\Model\Resolver\DataProvider;

use Ecomteck\Megamenu\Api\Data\NodeInterface;
use Ecomteck\Megamenu\Api\NodeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Node
 * @package Ecomteck\MegamenuGraphQl\Model\Resolver\DataProvider
 */
class Node
{
    /**
     * @var NodeRepositoryInterface
     */
    private $nodeRepository;

    /**
     * Menu constructor.
     * @param NodeRepositoryInterface $nodeRepository
     */
    public function __construct(NodeRepositoryInterface $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * Get node data
     *
     * @param int $nodeId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(int $nodeId): array
    {
        $node = $this->nodeRepository->getById($nodeId);

        if (false === $node->getIsActive()) {
            throw new NoSuchEntityException();
        }

        $nodeData = [
            NodeInterface::NODE_ID => $node->getNodeId(),
            NodeInterface::MENU_ID => $node->getMenuId(),
            NodeInterface::POSITION => $node->getPosition(),
            NodeInterface::TYPE => $node->getType(),
            NodeInterface::IS_ACTIVE => $node->getIsActive(),
            NodeInterface::TITLE => $node->getTitle(),
            NodeInterface::CONTENT => $node->getContent(),
            NodeInterface::PARENT_ID => $node->getParentId(),
            NodeInterface::LEVEL => $node->getLevel(),
            NodeInterface::CLASSES => $node->getClasses(),
            NodeInterface::TARGET => $node->getTarget(),
            NodeInterface::CREATION_TIME => $node->getCreationTime(),
            NodeInterface::UPDATE_TIME => $node->getUpdateTime()
        ];

        return $nodeData;
    }
}
