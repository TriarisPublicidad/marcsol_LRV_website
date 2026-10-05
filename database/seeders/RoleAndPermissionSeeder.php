<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos del sistema
        $permissions = [
            'manage_promotions',
            'manage_events',
            'manage_branches',
            'manage_pages',
            'manage_menus',
            'manage_settings',
            'manage_redirects',
            'edit_sandbox_css',
            'manage_users',
            'view_activity_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'manage_promotions',
            'manage_events',
            'manage_branches',
            'manage_pages',
            'manage_menus',
            'manage_settings',
            'manage_redirects',
            'edit_sandbox_css',
            'view_activity_logs',
        ]);

        $supervisor = Role::firstOrCreate(['name' => 'Supervisor', 'guard_name' => 'web']);
        $supervisor->givePermissionTo([
            'manage_promotions',
            'manage_events',
            'manage_branches',
            'manage_pages',
        ]);

        $operador = Role::firstOrCreate(['name' => 'Operador', 'guard_name' => 'web']);
        $operador->givePermissionTo([
            'manage_promotions',
            'manage_events',
        ]);

        // Usuarios iniciales
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@marcsol.com.ec'],
            [
                'name' => 'Super Admin Marcsol',
                'password' => Hash::make('Marcsol2026!'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole($superAdmin);

        $gerenteUser = User::firstOrCreate(
            ['email' => 'gerente@marcsol.com.ec'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('Marcsol2026!'),
                'email_verified_at' => now(),
            ]
        );
        $gerenteUser->assignRole($admin);

        $supervisorUser = User::firstOrCreate(
            ['email' => 'supervisor@marcsol.com.ec'],
            [
                'name' => 'Supervisor de Tiendas',
                'password' => Hash::make('Marcsol2026!'),
                'email_verified_at' => now(),
            ]
        );
        $supervisorUser->assignRole($supervisor);

        $operadorUser = User::firstOrCreate(
            ['email' => 'operador@marcsol.com.ec'],
            [
                'name' => 'Operador de Contenidos',
                'password' => Hash::make('Marcsol2026!'),
                'email_verified_at' => now(),
            ]
        );
        $operadorUser->assignRole($operador);
    }
}
