<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the Migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            // Primary Key and UUID
            $table->id();
            $table->uuid('uuid')->unique();

            // Slug and Name Fields
            $table->string('slug')->unique();
            $table->string('name');

            // Other Fields ( `rank` , `date` , `description` )
            $table->string('rank')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();

            // Foreign Key for `location_id`
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');

            // User Tracking Fields ( `created_by` , `updated_by` , `deleted_by` )
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Timestamps for `created_at` , `updated_at` , and Soft Deletes
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot Table for Institutions ( `achievement_id` , `contact_id` )
        Schema::create('achievement_contact_institutions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achievement_id');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->timestamps();
        });

        // Pivot Table for Related Parties ( `achievement_id` , `contact_id` )
        Schema::create('achievement_contact_related_parties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achievement_id');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
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
        Schema::dropIfExists('achievement_contact_related_parties');
        Schema::dropIfExists('achievement_contact_institutions');
        Schema::dropIfExists('achievements');
    }
}
