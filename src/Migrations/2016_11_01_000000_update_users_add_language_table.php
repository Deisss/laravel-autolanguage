<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersAddLanguageTable extends Migration
{
    /**
     * Run the Migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = \Config::get('autolanguage.Migrations.table', 'users');
        Schema::table($name, function (Blueprint $table) {
            $table->string('language', 8)->after('remember_token');
        });
    }

    /**
     * Reverse the Migrations.
     *
     * @return void
     */
    public function down()
    {
        $name = \Config::get('autolanguage.Migrations.table', 'users');
        Schema::table($name, function (Blueprint $table) {
            $table->dropColumn('language');
        });
    }
}
