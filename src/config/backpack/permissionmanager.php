<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Models used in the User, Role and Permission CRUDs.
    |
     */

    'models' => [
        'user' => config('backpack.base.user_model_fqn', \App\Models\User::class),
        'permission' => Backpack\PermissionManager\app\Models\Permission::class,
        'role' => Backpack\PermissionManager\app\Models\Role::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Disallow the user interface for creating/updating permissions or roles.
    |--------------------------------------------------------------------------
    | Roles and permissions are used in code by their name
    | - ex: $user->hasPermissionTo('edit articles');
    |
    | So after the developer has entered all permissions and roles, the administrator should either:
    | - not have access to the panels
    | or
    | - creating and updating should be disabled
     */

    'allow_permission_create' => true,
    'allow_permission_update' => true,
    'allow_permission_delete' => true,
    'allow_role_create' => true,
    'allow_role_update' => true,
    'allow_role_delete' => true,

    /*
    |--------------------------------------------------------------------------
    | Multiple-guards functionality
    |--------------------------------------------------------------------------
    |
     */
    'multiple_guards' => false,

    /*
    |------------
    | PERMISSIONS
    |------------
     */

    // Automatically applies permissions to CRUD controllers. Requires the Backpack/PermissionManager package.
    //
    // Each CRUD controller should have a unique prefix for its permission keys. By default the prefix is automatically
    // derived from the controller's namespace but you can set your own (see the setPermissionsPrefix() method).
    //
    // This prefix will then be used to match the permissions handled by the permission manager.
    //
    'apply_permissions' => false,

    // Creates the CRUD's permissions in database while browsing in admin.
    'create_permissions_while_browsing' => false,

    // Gives the CRUD's permissions to the currently connected user while browsing in admin. Should be disabled in production.
    'give_permissions_to_current_user_while_browsing' => false,

    // Words that are excluded from the auto generated permission prefix (based on route's controller namespace).
    'excluded_words_from_default_permission_prefix' => ['app', 'http', 'controllers', 'controller', 'crud'],
];
