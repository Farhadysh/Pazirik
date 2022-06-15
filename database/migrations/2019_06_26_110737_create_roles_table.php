<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->default(0);
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Permission::create([
            'parent_id' => 0,
            'name' => 'show-customers',
            'label' => 'مشاهده مشتریان'
        ]);
        Permission::create([
            'parent_id' => 1,
            'name' => 'add-customer',
            'label' => 'افزودن مشتری'
        ]);
        Permission::create([
            'parent_id' => 1,
            'name' => 'edit-customer',
            'label' => 'ویرایش مشتری'
        ]);
        Permission::create([
            'parent_id' => 1,
            'name' => 'detail-customer',
            'label' => 'جزییات مشتری'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-handFactor',
            'label' => 'نمایش فاکتور دستی'
        ]);
        Permission::create([
            'parent_id' => 5,
            'name' => 'edit-handFactor',
            'label' => 'ویرایش فاکتور دستی'
        ]);
        Permission::create([
            'parent_id' => 5,
            'name' => 'add-handFactor',
            'label' => 'افزودن فاکتور دستی'
        ]);
        Permission::create([
            'parent_id' => 5,
            'name' => 'delete-handFactor',
            'label' => 'حذف فاکتور دستی'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-waitingList',
            'label' => 'نمایش لیست انتظار'
        ]);
        Permission::create([
            'parent_id' => 9,
            'name' => 'address-transport',
            'label' => 'انتقال آدرس'
        ]);
        Permission::create([
            'parent_id' => 9,
            'name' => 'delete-waitingList',
            'label' => 'حذف لیست انتظار'
        ]);
        Permission::create([
            'parent_id' => 9,
            'name' => 'edit-waitingList',
            'label' => 'ویرایش لیست انتظار'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-orders',
            'label' => 'نمایش سفارشات'
        ]);
        Permission::create([
            'parent_id' => 13,
            'name' => 'edit-orders',
            'label' => 'ویرایش سفارشات'
        ]);
        Permission::create([
            'parent_id' => 13,
            'name' => 'delete-orders',
            'label' => 'حذف سفارشات'
        ]);
        Permission::create([
            'parent_id' => 13,
            'name' => 'show-detail-orders',
            'label' => 'نمایش جزئیات سفارشات'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-costs',
            'label' => 'نمایش هزینه ها'
        ]);
        Permission::create([
            'parent_id' => 17,
            'name' => 'delete-costs',
            'label' => 'حذف هزینه ها'
        ]);
        Permission::create([
            'parent_id' => 17,
            'name' => 'add-costs',
            'label' => 'افزودن هزینه ها'
        ]);
        Permission::create([
            'parent_id' => 17,
            'name' => 'edit-cost',
            'label' => 'ویرایش هزینه ها'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-notes',
            'label' => 'نمایش یادداشت ها'
        ]);
        Permission::create([
            'parent_id' => 21,
            'name' => 'edit-notes',
            'label' => 'ویرایش یادداشت ها'
        ]);
        Permission::create([
            'parent_id' => 21,
            'name' => 'add-notes',
            'label' => 'افزودن یادداشت ها'
        ]);
        Permission::create([
            'parent_id' => 21,
            'name' => 'delete-notes',
            'label' => 'حذف یادداشت ها'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-accounting',
            'label' => 'نمایش قسمت مالی'
        ]);
        Permission::create([
            'parent_id' => 25,
            'name' => 'edit-installment',
            'label' => 'ویرایش صورتحساب'
        ]);
        Permission::create([
            'parent_id' => 25,
            'name' => 'show-product-list',
            'label' => 'نمایش لیست کالاها'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'SMS',
            'label' => 'نمایش پنل پیامکی'
        ]);
        Permission::create([
            'parent_id' => 28,
            'name' => 'edit-Sms',
            'label' => 'ویرایش پیام ها'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-products',
            'label' => 'نمایش کالاها'
        ]);
        Permission::create([
            'parent_id' => 30,
            'name' => 'edit-products',
            'label' => 'ویرایش کالاها'
        ]);
        Permission::create([
            'parent_id' => 30,
            'name' => 'add-product',
            'label' => 'افزودن کالا'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-shift',
            'label' => 'نمایش شیفت ها'
        ]);
        Permission::create([
            'parent_id' => 33,
            'name' => 'edit-shift',
            'label' => 'ویرایش شیفت ها'
        ]);
        Permission::create([
            'parent_id' => 33,
            'name' => 'add-shift',
            'label' => 'افزودن شیفت ها'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-users',
            'label' => 'نمایش کاربران'
        ]);
        Permission::create([
            'parent_id' => 36,
            'name' => 'edit-users',
            'label' => 'ویرایش کاربران'
        ]);
        Permission::create([
            'parent_id' => 36,
            'name' => 'add-users',
            'label' => 'افزودن کاربران'
        ]);
        Permission::create([
            'parent_id' => 36,
            'name' => 'add-roles',
            'label' => 'افزودن نقش و سطح دسترسی'
        ]);
        Permission::create([
            'parent_id' => 5,
            'name' => 'show-changes',
            'label' => 'نمایش فاکتورهای تغییر داده شده'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'driver-locations',
            'label' => 'نمایش محل راننده'
        ]);
        Permission::create([
            'parent_id' => 0,
            'name' => 'show-office',
            'label' => 'نمایش دفتر و کارخانه'
        ]);
        Permission::create([
            'parent_id' => 42,
            'name' => 'add-office',
            'label' => 'افزودن دفتر و کارخانه'
        ]);
        Permission::create([
            'parent_id' => 25,
            'name' => 'admin_accounting',
            'label' => 'نمایش غیر نقدی'
        ]);

        Schema::create('permission_role', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->bigInteger('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);
        });

        $role = new Role();
        $role->name = 'مدیر کل';
        $role->save();

        $permission_id = Permission::pluck('id')->toArray();
        $role->permissions()->sync($permission_id);

        $user = User::whereId(1)->first();
        $user->roles()->sync(1);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
    }
}
