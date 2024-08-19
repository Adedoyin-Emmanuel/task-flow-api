<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Project extends Model
{
    use HasFactory;
    use HasUuids;


    public function up(){
        Schema::create("projects", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name", 50);
            $table->string("description", 5000);
            $table->date("start_date");
            $table->date("end_date");
            $table->timestamps();

        });

    }

    public function down(){
        Schema::dropIfExists("projects");
    }
}
