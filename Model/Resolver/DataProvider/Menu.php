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

use Ecomteck\Megamenu\Api\Data\MenuInterface;
use Ecomteck\Megamenu\Api\MenuRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Menu
 * @package Ecomteck\MegamenuGraphQl\Model\Resolver\DataProvider
 */
class Menu
{
    /**
     * @var MenuRepositoryInterface
     */
    private $menuRepository;

    /**
     * Menu constructor.
     * @param MenuRepositoryInterface $menuRepository
     */
    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Get menu data
     *
     * @param int $menuId
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(int $menuId): array
    {
        $menu = $this->menuRepository->getById($menuId);

        if (false === $menu->getIsActive()) {
            throw new NoSuchEntityException();
        }

        $menuData = [
            MenuInterface::MENU_ID => $menu->getId(),
            MenuInterface::TITLE => $menu->getTitle(),
            MenuInterface::IDENTIFIER => $menu->getIdentifier(),
            MenuInterface::CSS_CLASS => $menu->getCssClass(),
            MenuInterface::CREATION_TIME => $menu->getCreationTime(),
            MenuInterface::UPDATE_TIME => $menu->getUpdateTime(),
            MenuInterface::IS_ACTIVE => $menu->getIsActive()
        ];

        return $menuData;
    }
}
