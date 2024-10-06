<?php

namespace Backpack\PermissionManager\app\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\PermissionManager\PanelTraits\Permissions;

class BasePermissionCrudController extends CrudController
{
    use Permissions;
    public $baseAdditionalPermissions = [];
    public function __construct()
    {
        {

            //Auto get all operation permission
            preg_match_all('/(?<=^|;)unique([^;]+?)Permission(;|$)/', implode(';', get_class_methods($this)), $matches);

            if (count($matches[1])) {
                foreach ($matches[1] as $methodName) {
                    $permission = $this->{'unique' . $methodName . 'Permission'}();
                    in_array($permission, $this->baseAdditionalPermissions) || $this->baseAdditionalPermissions[] = $permission;
                }
            }
            //Allow to have non-operation permission
            $class = get_called_class();
            if (isset(get_class_vars($class)['additionalPermissions'])) {
                $this->baseAdditionalPermissions = array_unique(array_merge($this->baseAdditionalPermissions, get_class_vars($class)['additionalPermissions']), SORT_REGULAR);
            }

            if ($this->crud) {
                return;
            }
            $this->crud = app()->make('crud');
            $this->addAdditionalPermissions($this->allAdditionalPermissions());

            // ---------------------------
            // Create the CrudPanel object
            // ---------------------------
            // Used by developers inside their ProductCrudControllers as
            // $this->crud or using the CRUD facade.
            //
            // It's done inside a middleware closure in order to have
            // the complete request inside the CrudPanel object.
            $this->middleware(function ($request, $next) {
                $this->crud = app()->make('crud');
                $this->crud->setRequest($request);

                $this->setupDefaults();
                $this->setup();
                $this->setupConfigurationForCurrentOperation();
                if (method_exists($this, 'initPermissions')) {
                    $this->initPermissions();
                }
                return $next($request);
            });
        }
    }

    protected function allAdditionalPermissions()
    {
        return $this->baseAdditionalPermissions;
    }
}
