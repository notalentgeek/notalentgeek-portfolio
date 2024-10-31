<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the Migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            // Primary Key and UUID
            $table->id();
            $table->uuid('uuid')->unique();

            // Slug and Name Fields
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('alias')->nullable();

            // User Tracking Fields ( `created_by` , `updated_by` , `deleted_by` )
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Timestamps for `created_at` , `updated_at` , and Soft Deletes
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot Table for Addresses ( `contact_id` , `address_id` )
        Schema::create('contact_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('address_id');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot Table for Phone Numbers ( `contact_id` , `phone_number_id` )
        Schema::create('contact_phone_number', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('phone_number_id');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('phone_number_id')->references('id')->on('phone_numbers')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot Table for Emails ( `contact_id` , `email_id` )
        Schema::create('contact_email', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('email_id');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot Table for Links ( `contact_id` , `link_id` )
        Schema::create('contact_link', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('link_id');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the Migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_link');
        Schema::dropIfExists('contact_email');
        Schema::dropIfExists('contact_phone_number');
        Schema::dropIfExists('contact_address');
        Schema::dropIfExists('contacts');
    }
};
