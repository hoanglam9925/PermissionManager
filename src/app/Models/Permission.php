<?php

namespace Backpack\PermissionManager\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at'];

    public function getItemAttribute($value)
    {
        return ucfirst($this->item());
    }

    public function getDisplayNameAttribute($value)
    {
        return ucfirst($this->prefix()) . " - " . ucfirst($this->item());
    }
    /**
     * Gets the permission prefix (eg. page)
     *
     * @return null|string
     */
    public function prefix()
    {
        if (!str_contains($this->name, '::')) {
            return null;
        }

        list($prefix) = explode('::', $this->name);

        $prefix = str_replace('admin.', "", $prefix);

        $prefix = str_replace('.', " ", $prefix);
        return $prefix;
    }

    /**
     * Gets the permission item (eg. list, create, update...)
     *
     * @return string
     */
    public function item()
    {
        return Str::after($this->name, '::');
    }

    /**
     * Gets the full permission prefix (eg. admin.page)
     *
     * @return null|string
     */
    public function fullPrefix()
    {
        if (!str_contains($this->name, '::')) {
            return null;
        }

        list($prefix) = explode('::', $this->name);
        return $prefix;
    }

}
