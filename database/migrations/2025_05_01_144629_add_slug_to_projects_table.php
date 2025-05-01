<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_add_slug_to_projects_table.php

public function up()
{
    Schema::table('projects', function (Blueprint $table) {
        $table->string('slug')->unique()->after('title');
    });
}

public function down()
{
    Schema::table('projects', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}

};
