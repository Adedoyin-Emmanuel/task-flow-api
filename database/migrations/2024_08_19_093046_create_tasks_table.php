<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignId("assignee")->constrained("users")->onDelete("set null");
            $table->foreignId("project_id")->constrained()->onDelete("cascade");
            $table->string("name");
            $table->string("description");
            $table->date("start_date");
            $table->date("end_date");
            $table->enum("status", ["pending", "in progress", "completed", "overdue"])->default("pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
