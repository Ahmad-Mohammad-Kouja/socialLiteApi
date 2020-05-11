<?php


use App\Enums\Clients\GenderTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('users', function (Blueprint $table) {
                       $table->bigIncrements('id');
                       $table->string('username')->unique();
                       $table->string('password');
                       $table->string('name');
                       $table->string('image')->nullable();
                       $table->enum('gender',GenderTypes::getValues())->default(GenderTypes::male);
                       $table->string('email')->unique();
                       $table->timestamp('email_verified_at')->nullable();
                       $table->rememberToken();
                       $table->timestamps();
                       $table->softDeletes();
                     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
