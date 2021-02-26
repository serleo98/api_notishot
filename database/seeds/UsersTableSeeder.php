<?php

use App\Entities\User\Role;
use App\Entities\User\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $SUPER_ROLE = Role::where('key', Role::superAdminKey())->first();
        if (is_null($SUPER_ROLE)) {
            $SUPER_ROLE = Role::create([
                'name' => "Super usuario",
                'key' => Role::superAdminKey()
            ]);
        }
        $ADMIN_ROLE = Role::where('key', Role::adminKey())->first();
        if (is_null($ADMIN_ROLE)) {
            $ADMIN_ROLE = Role::create([
                'name' => "Administrador",
                'key' => Role::adminKey()
            ]);
        }
        $MODERATOR_ROLE = Role::where('key', Role::moderatorKey())->first();
        if (is_null($MODERATOR_ROLE)) {
            $MODERATOR_ROLE = Role::create([
                'name' => "Moderador",
                'key' => Role::moderatorKey()
            ]);
        }
        $READER_ROLE = Role::where('key', Role::readerKey())->first();
        if (is_null($READER_ROLE)) {
            $READER_ROLE = Role::create([
                'name' => "Lector",
                'key' => Role::readerKey()
            ]);
        }
        $WRITER_ROLE = Role::where('key', Role::writerKey())->first();
        if (is_null($WRITER_ROLE)) {
            $WRITER_ROLE = Role::create([
                'name' => "Redactor",
                'key' => Role::writerKey()
            ]);
        }


        $USER_SUPER_ADMIN = User::where('email', 'superadmin@apibase.com')->first();
        if (!isset($USER_SUPER_ADMIN)) {
            $USER_SUPER_ADMIN = User::create([
                'nick_name' => 'SuperMan',
                'email' => 'superadmin@apibase.com',
                'password' => bcrypt('apibase'),
                'role_id' => $SUPER_ROLE->id,
                'email_verified_at' => Carbon::now(),
            ]);
        }
        $created_user_super = User::where('email', 'superadmin@apibase.com')->first();
        $created_user_super->profile()->create([
                'name' => 'Super',
                'last_name'=> 'AdminBase',
                'cel_phone'=> null,
                'phone'=> null,
                'profile_photo'=> null,
                'facebook_url'=> null,
                'instagram_url'=> null,
                'twitter_url'=> null,
                'blog_personal_url'=> null,
                'city'=> 'Rosario',
                'province'=> 'Santa Fé',
                'country'=> 'Argentina',
                'postal_code'=> 2000,
                'accepted' => true,
                'accepted_by' => null,
                'accepted_at'=> Carbon::now()
            ]);


        $USER_ADMIN = User::where('email', 'admin@apibase.com')->first();
        if (!isset($USER_ADMIN)) {
            $USER_ADMIN = User::create([
                'nick_name' => 'Administrador nick name',
                'email' => 'admin@apibase.com',
                'password' => bcrypt('apibase'),
                'role_id' => $ADMIN_ROLE->id,
                'email_verified_at' => Carbon::now()
            ]);
        }
        $created_user_admin = User::where('email', 'admin@apibase.com')->first();
        $created_user_admin->profile()->create([
                'name' => 'elAdmin',
                'last_name'=> 'AdminBase',
                'cel_phone'=> null,
                'phone'=> null,
                'profile_photo'=> null,
                'facebook_url'=> null,
                'instagram_url'=> null,
                'twitter_url'=> null,
                'blog_personal_url'=> null,
                'city'=> 'Rosario',
                'province'=> 'Santa Fé',
                'country'=> 'Argentina',
                'postal_code'=> 2000,
                'accepted' => true,
                'accepted_by' => null,
                'accepted_at'=> Carbon::now()
            ]);


        $USER_MODERATOR = User::where('email', 'moderador@apibase.com')->first();
        if (!isset($USER_MODERATOR)) {
            $USER_MODERATOR = User::create([
                'nick_name' => 'Moderador nick name',
                'email' => 'moderador@apibase.com',
                'password' => bcrypt('apibase'),
                'role_id' => $MODERATOR_ROLE->id,
                'email_verified_at' => Carbon::now()
            ]);
        }
        $created_user_moderator = User::where('email', 'moderador@apibase.com')->first();
        $created_user_moderator->profile()->create([
                'name' => 'ModeradorNombre',
                'last_name'=> 'ModeradorApellido',
                'cel_phone'=> 3415994003,
                'phone'=> null,
                'profile_photo'=> null,
                'facebook_url'=> null,
                'instagram_url'=> null,
                'twitter_url'=> null,
                'blog_personal_url'=> null,
                'city'=> 'Rosario',
                'province'=> 'Santa Fé',
                'country'=> 'Argentina',
                'postal_code'=> 2000,
                'accepted' => true,
                'accepted_by' => null,
                'accepted_at'=> Carbon::now()
            ]);

        $USER_READER = User::where('email', 'lector@apibase.com')->first();
        if (!isset($USER_READER)) {
            $USER_READER = User::create([
                'nick_name' => 'Lector nick name',
                'email' => 'lector@apibase.com',
                'password' => bcrypt('apibase'),
                'role_id' => $READER_ROLE->id,
                'email_verified_at' => Carbon::now()
            ]);
        }
        $created_user_reader = User::where('email', 'lector@apibase.com')->first();
        $created_user_reader->profile()->create([
                'name' => 'LectorNombre',
                'last_name'=> 'LectorApellido',
                'cel_phone'=> 3415994003,
                'phone'=> null,
                'profile_photo'=> null,
                'facebook_url'=> null,
                'instagram_url'=> null,
                'twitter_url'=> null,
                'blog_personal_url'=> null,
                'city'=> 'Rosario',
                'province'=> 'Santa Fé',
                'country'=> 'Argentina',
                'postal_code'=> 2000,
                'accepted' => true,
                'accepted_by' => null,
                'accepted_at'=> Carbon::now()
            ]);

        $USER_WRITER = User::where('email', 'redactor@apibase.com')->first();
        if (!isset($USER_WRITER)) {
            $USER_WRITER = User::create([
                'nick_name' => 'Redactor nick name',
                'email' => 'redactor@apibase.com',
                'password' => bcrypt('apibase'),
                'role_id' => $WRITER_ROLE->id,
                'email_verified_at' => Carbon::now()
            ]);
        }
        $created_user_redactor = User::where('email', 'redactor@apibase.com')->first();
        $created_user_redactor->profile()->create([
                'name' => 'RedactorNombre',
                'last_name'=> 'RedactorApellido',
                'cel_phone'=> 3415994003,
                'phone'=> null,
                'profile_photo'=> null,
                'facebook_url'=> null,
                'instagram_url'=> null,
                'twitter_url'=> null,
                'blog_personal_url'=> null,
                'city'=> 'Rosario',
                'province'=> 'Santa Fé',
                'country'=> 'Argentina',
                'postal_code'=> 2000,
                'accepted' => true,
                'accepted_by' => null,
                'accepted_at'=> Carbon::now()
            ]);

    }
    
}
