<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_info', function (Blueprint $table) {
            $table->id();
            $table->integer('aday_no')->unsigned()->unique();
            $table->string('aday_resim')->unique();
            $table->string('basvuru_tarihi', 20)->nullable();
            $table->string('onay_tarihi', 20)->nullable();
            $table->string('kimlik_no')->unique();
            $table->string('ad_soyad', 50);
            $table->string('baba_adi', 50);
            $table->string('dogum_yeri', 50);
            $table->string('dogum_tarihi', 20);
            $table->string('uyruk', 50);
            $table->string('cinsiyet', 50);
            $table->string('tel_no', 15)->unique();
            $table->string('email', 50)->unique();
            $table->string('mezuniyet_tarihi', 20)->nullable();

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
        Schema::dropIfExists('student_info');
    }
}
