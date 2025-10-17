<?php

use Hwkdo\IntranetAppBase\IntranetAppBase;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = IntranetAppBase::getRequiredPermissionsFromAppConfig(
            config('intranet-app-raumverwaltung')
        );

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = IntranetAppBase::getRolesWithPermissionsFromAppConfig(
            config('intranet-app-raumverwaltung')
        );

        foreach ($roles as $role) {
            Role::create(['name' => $role['name']]);
            $role->givePermissionTo($role['permissions']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = IntranetAppBase::getRequiredPermissionsFromAppConfig(
            config('intranet-app-raumverwaltung')
        );

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }

        $roles = IntranetAppBase::getRequiredRolesFromAppConfig(
            config('intranet-app-raumverwaltung')
        );

        foreach ($roles as $role) {
            Role::where('name', $role['name'])->delete();
        }
    }
};
