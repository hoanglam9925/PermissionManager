<?php

namespace Backpack\PermissionManager\app\Library;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\PermissionManager\app\Models\Role;

class PermissionCrudPanel extends CrudPanel
{
    // load all the default CrudPanel features
    // The following methods are used in CrudController or your EntityCrudController to manipulate the variables above.
    public function shouldShowEditButton($entry)
    {
        if ($entry instanceof Role) {
            if (count(backpack_user()->roles)) {
                return !($entry[$entry->getKeyName()] == backpack_user()->roles[0][backpack_user()->roles[0]->getKeyName()]);
            }
        }
        if (get_class($entry) === config('backpack.permissionmanager.models.user')) {
            return !($entry[$entry->getKeyName()] == backpack_user()[backpack_user()->getKeyName()]);
        }
        return true;
    }
}
