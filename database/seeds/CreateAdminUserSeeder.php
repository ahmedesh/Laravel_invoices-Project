<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{

    public function run()
    {
        $user = User::create([ // دا بيانات مستخدم هتنزل تلقائي فالداتابيز ف حاله لو مفيش يوز بيكريتلي يوزر افتراضي بالداتا دي
            'name'      => 'ahmed',
            'email'     => 'ahmedesh199@gmail.com',
            'password'  => bcrypt('123456'),
            'roles_name'=> ['Admin'], // عشان اليوزر ممكن يكون ادمن او ادمن ويوزر وهكذا يعني اكتر من حاجه مش حاجه وحده بس
            'Status'    => 'مفعل',
        ]);

        $role = Role::create(['name' => 'Admin']);  // Admin دا اسم افتراضي

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
