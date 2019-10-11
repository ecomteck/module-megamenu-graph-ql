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

namespace Ecomteck\MegamenuGraphQl\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Ecomteck\MegamenuGraphQl\Model\Resolver\DataProvider\Menu as MenuDataProvider;

/**
 * Class Menu
 * @package Ecomteck\MegamenuGraphQl\Model\Resolver
 */
class Menu implements ResolverInterface
{
    /**
     * @var MenuDataProvider
     */
    private $menuDataProvider;

    /**
     * Menu constructor.
     * @param MenuDataProvider $menuDataProvider
     */
    public function __construct(MenuDataProvider $menuDataProvider)
    {
        $this->menuDataProvider = $menuDataProvider;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     * @throws GraphQlNoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $menuId = $this->getMenuId($args);
        $menuData = $this->getMenuData($menuId);

        return $menuData;
    }

    /**
     * @param array $args
     * @return int
     * @throws GraphQlInputException
     */
    private function getMenuId(array $args): int
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"Menu id should be specified'));
        }

        return (int)$args['id'];
    }

    /**
     * @param int $menuId
     * @return array
     * @throws GraphQlNoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getMenuData(int $menuId): array
    {
        try {
            $menuData = $this->menuDataProvider->getData($menuId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $menuData;
    }
}
