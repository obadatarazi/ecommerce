<?php

namespace App\Constant;

enum PermissionType: string {

    public function getSection(): string
    {
        $slices = explode(',', $this->value);
        return $slices[0];
    }

    public function getName(): string
    {
        $slices = explode(',', $this->value);
        return str_replace('_', ' ', $slices[1]);
    }

    public function getDesc(): string
    {
        $slices = explode(',', $this->value);
        return str_replace('_', ' ', $slices[1]);
    }

    public function getPermission(): string
    {
        $slices = explode(',', $this->value);
        return $slices[1];
    }

    public static function getAllPermissions(): array
    {
        return [
            self::PermissionManageUser->getPermission(),

            self::PermissionCreateUser->getPermission(),
            self::PermissionDeleteUser->getPermission(),
            self::PermissionUpdateUser->getPermission(),
            self::PermissionViewUser->getPermission(),

            self::PermissionList->getPermission(),

            self::PermissionManageRole->getPermission(),

            self::PermissionCreateRole->getPermission(),
            self::PermissionDeleteRole->getPermission(),
            self::PermissionUpdateRole->getPermission(),
            self::PermissionViewRole->getPermission(),

            self::PermissionManageMultiTypeSetting->getPermission(),

            self::PermissionCrateMultiTypeSetting->getPermission(),
            self::PermissionDeleteMultiTypeSetting->getPermission(),
            self::PermissionUpdateMultiTypeSetting->getPermission(),
            self::PermissionViewMultiTypeSetting->getPermission(),

            self::PermissionManageVisualSetting->getPermission(),

            self::PermissionCreateVisualSetting->getPermission(),
            self::PermissionDeleteVisualSetting->getPermission(),
            self::PermissionUpdateVisualSetting->getPermission(),
            self::PermissionViewVisualSetting->getPermission(),

            self::PermissionManageCategory->getPermission(),
            self::PermissionCreateCategory->getPermission(),
            self::PermissionDeleteCategory->getPermission(),
            self::PermissionUpdateCategory->getPermission(),
            self::PermissionViewCategory->getPermission(),

            self::PermissionManageProduct->getPermission(),
            self::PermissionCreateProduct->getPermission(),
            self::PermissionDeleteProduct->getPermission(),
            self::PermissionUpdateProduct->getPermission(),
            self::PermissionViewProduct->getPermission(),

            self::PermissionManageBrand->getPermission(),
            self::PermissionCreateBrand->getPermission(),
            self::PermissionDeleteBrand->getPermission(),
            self::PermissionUpdateBrand->getPermission(),
            self::PermissionViewBrand->getPermission(),

            self::PermissionManageReview->getPermission(),
            self::PermissionCreateReview->getPermission(),
            self::PermissionDeleteReview->getPermission(),
            self::PermissionUpdateReview->getPermission(),
            self::PermissionViewReview->getPermission(),

            self::PermissionManageIngredient->getPermission(),
            self::PermissionCreateIngredient->getPermission(),
            self::PermissionDeleteIngredient->getPermission(),
            self::PermissionUpdateIngredient->getPermission(),
            self::PermissionViewIngredient->getPermission(),

            self::PermissionManageCurrency->getPermission(),
            self::PermissionCreateCurrency->getPermission(),
            self::PermissionDeleteCurrency->getPermission(),
            self::PermissionUpdateCurrency->getPermission(),
            self::PermissionViewCurrency->getPermission(),

            self::PermissionManageCart->getPermission(),
            self::PermissionCreateCart->getPermission(),
            self::PermissionDeleteCart->getPermission(),
            self::PermissionUpdateCart->getPermission(),
            self::PermissionViewCart->getPermission(),


        ];
    }

    case PermissionManageUser = 'USER,MANAGE_USER';
    case PermissionCreateUser = 'USER,PERMISSION_CREATE_USER';
    case PermissionDeleteUser = 'USER,PERMISSION_DELETE_USER';
    case PermissionUpdateUser = 'USER,PERMISSION_UPDATE_USER';
    case PermissionViewUser = 'USER,PERMISSION_SHOW_USER';

    case PermissionList = 'Permission_List,PERMISSION_LIST';

    case PermissionManageRole = 'ROLE,MANAGE_ROLE';
    case PermissionCreateRole = 'ROLE,PERMISSION_CREATE_ROLE';
    case PermissionDeleteRole = 'ROLE,PERMISSION_DELETE_ROLE';
    case PermissionUpdateRole = 'ROLE,PERMISSION_UPDATE_ROLE';
    case PermissionViewRole = 'ROLE,PERMISSION_SHOW_ROLE';

    case PermissionManageMultiTypeSetting = 'MULTI_TYPE_SETTING,MANAGE_MULTI_TYPE_SETTING';
    case PermissionCrateMultiTypeSetting = 'MULTI_TYPE_SETTING,PERMISSION_CREATE_MULTI_TYPE_SETTING';
    case PermissionDeleteMultiTypeSetting = 'MULTI_TYPE_SETTING,PERMISSION_DELETE_MULTI_TYPE_SETTING';
    case PermissionUpdateMultiTypeSetting = 'MULTI_TYPE_SETTING,PERMISSION_UPDATE_MULTI_TYPE_SETTING';
    case PermissionViewMultiTypeSetting = 'MULTI_TYPE_SETTING,PERMISSION_SHOW_MULTI_TYPE_SETTING';

    case PermissionManageVisualSetting = 'VISUAL_SETTING,MANAGE_VISUAL_SETTING';
    case PermissionCreateVisualSetting = 'VISUAL_SETTING,PERMISSION_CREATE_VISUAL_SETTING';
    case PermissionDeleteVisualSetting = 'VISUAL_SETTING,PERMISSION_DELETE_VISUAL_SETTING';
    case PermissionUpdateVisualSetting = 'VISUAL_SETTING,PERMISSION_UPDATE_VISUAL_SETTING';
    case PermissionViewVisualSetting = 'VISUAL_SETTING,PERMISSION_SHOW_VISUAL_SETTING';


    case PermissionManageCategory = 'CATEGORY,MANAGE_CATEGORY';
    case PermissionCreateCategory = 'CATEGORY,PERMISSION_CREATE_CATEGORY';
    case PermissionDeleteCategory = 'CATEGORY,PERMISSION_DELETE_CATEGORY';
    case PermissionUpdateCategory = 'CATEGORY,PERMISSION_UPDATE_CATEGORY';
    case PermissionViewCategory = 'CATEGORY,PERMISSION_SHOW_CATEGORY';

    case PermissionManageProduct = 'PRODUCT,MANAGE_PRODUCT';
    case PermissionCreateProduct = 'PRODUCT,PERMISSION_CREATE_PRODUCT';
    case PermissionDeleteProduct = 'PRODUCT,PERMISSION_DELETE_PRODUCT';
    case PermissionUpdateProduct = 'PRODUCT,PERMISSION_UPDATE_PRODUCT';
    case PermissionViewProduct = 'PRODUCT,PERMISSION_SHOW_PRODUCT';

    case PermissionManageBrand = 'BRAND,MANAGE_BRAND';
    case PermissionCreateBrand = 'BRAND,PERMISSION_CREATE_BRAND';
    case PermissionDeleteBrand = 'BRAND,PERMISSION_DELETE_BRAND';
    case PermissionUpdateBrand = 'BRAND,PERMISSION_UPDATE_BRAND';
    case PermissionViewBrand = 'BRAND,PERMISSION_SHOW_BRAND';

    case PermissionManageReview = 'REVIEW,MANAGE_REVIEW';
    case PermissionCreateReview = 'REVIEW,PERMISSION_CREATE_REVIEW';
    case PermissionDeleteReview = 'REVIEW,PERMISSION_DELETE_REVIEW';
    case PermissionUpdateReview = 'REVIEW,PERMISSION_UPDATE_REVIEW';
    case PermissionViewReview= 'REVIEW,PERMISSION_SHOW_REVIEW';
    case PermissionManageIngredient = 'INGREDIENT,MANAGE_INGREDIENT';
    case PermissionCreateIngredient = 'INGREDIENT,PERMISSION_CREATE_INGREDIENT';
    case PermissionDeleteIngredient = 'INGREDIENT,PERMISSION_DELETE_INGREDIENT';
    case PermissionUpdateIngredient = 'INGREDIENT,PERMISSION_UPDATE_INGREDIENT';
    case PermissionViewIngredient= 'INGREDIENT,PERMISSION_SHOW_INGREDIENT';

    case PermissionManageCurrency = 'CURRENCY,MANAGE_CURRENCY';
    case PermissionCreateCurrency = 'CURRENCY,PERMISSION_CREATE_CURRENCY';
    case PermissionDeleteCurrency = 'CURRENCY,PERMISSION_DELETE_CURRENCY';
    case PermissionUpdateCurrency = 'CURRENCY,PERMISSION_UPDATE_CURRENCY';
    case PermissionViewCurrency= 'CURRENCY,PERMISSION_SHOW_CURRENCY';

    case PermissionManageCart = 'CART,MANAGE_CART';
    case PermissionCreateCart = 'CART,PERMISSION_CREATE_CART';
    case PermissionDeleteCart = 'CART,PERMISSION_DELETE_CART';
    case PermissionUpdateCart = 'CART,PERMISSION_UPDATE_CART';
    case PermissionViewCart= 'CART,PERMISSION_SHOW_CART';


}
