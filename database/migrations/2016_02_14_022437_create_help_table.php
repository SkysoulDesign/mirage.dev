<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;

class CreateHelpTable extends Migration
{
    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    private $schema;

    /**
     * CreateRolesTable constructor.
     */
    public function __construct()
    {
        $this->schema = app(Builder::class);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $this->schema->create('help', function (Blueprint $table) {
            $table->increments('id');
            $table->string('route');
            $table->string('route_parameters')->nullable();
            $table->string('description')->nullable();
            $table->longText('parameters')->nullable();
            $table->longText('response')->nullable();
            $table->longText('response_error')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->drop('help');
    }
}
