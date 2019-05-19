<?php declare(strict_types=1);

use App\Models\AdminMenu;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $admin = AdminRole::create(['name' => AdminRole::ADMIN, 'slug' => 'administrator']);
        $moderator = AdminRole::create(['name' => AdminRole::MODERATOR, 'slug' => 'judge']);
        $user = AdminRole::create(['name' => AdminRole::USER, 'slug' => 'user']);

        for ($i = 0; $i < 10; ++$i)
        {
            $user = new User();
            $user->name = "user{$i}";
            $user->password = Hash::make('qweqwe');
            $user->save();
            $user->roles()->attach($admin->id);
        }

        AdminPermission::insert([
            [
                'name' => 'All permission',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
            ],
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
            ],
            [
                'name' => 'Login',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => "/auth/login\r\n/auth/logout",
            ],
            [
                'name' => 'User setting',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
            ],
            [
                'name' => 'Auth management',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
            ],
        ]);

        AdminRole::first()->permissions()->save(AdminPermission::first());

        AdminMenu::insert([
            [
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Dashboard',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
            ],
            [
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
            ],
            [
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
            ],
            [
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
            ],
            [
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
            ],
            [
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
            ],
            [
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
            ],
            [
                'parent_id' => 2,
                'order' => 8,
                'title' => 'Tournaments',
                'icon' => 'fa-bars',
                'uri' => 'tournaments',
            ],
            [
                'parent_id' => 2,
                'order' => 9,
                'title' => 'Problems',
                'icon' => 'fa-bars',
                'uri' => 'problems',
            ],
            [
                'parent_id' => 2,
                'order' => 10,
                'title' => 'Solutions',
                'icon' => 'fa-bars',
                'uri' => 'solutions',
            ],
        ]);

        // TODO setup permissions for other roles;
        AdminMenu::find(2)->roles()->save(AdminRole::first());
    }
}
