<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('img_url');
            $table->enum('role',['admin','user']);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('DanhMuc',function(Blueprint $table){
            $table->id('MaDM');
            $table->string('TenDM');
            $table->text('MoTa')->nullable();
            $table->foreignId('MaTK')->constrained('users','id')->onDelete('cascade');
            $table->dateTime('NgayTao');

        });
        Schema::create('SanPham', function (Blueprint $table) {
            $table->string('MaSP')->primary();
            $table->string('TenSP');
            $table->string('HinhAnh');
            $table->decimal('DonGia');
            $table->text('MoTa')->nullable();
            $table->foreignId('MaDM')->constrained('DanhMuc','MaDM')->onDelete('cascade');
            $table->foreignId('MaTK')->constrained('users','id')->onDelete('cascade');
            $table->dateTime('NgayTao');

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
};
