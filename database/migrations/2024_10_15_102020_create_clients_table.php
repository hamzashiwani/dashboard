<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('surgery_name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('are_you_pregnant')->nullable();
            $table->string('any_allergies')->nullable();
            $table->string('reciving_medical_treatment')->nullable();
            $table->string('pacemaker')->nullable();
            $table->string('dnr')->nullable();
            $table->string('blood_thinner')->nullable();
            $table->string('current_medications')->nullable();
            $table->string('patient_signature')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
