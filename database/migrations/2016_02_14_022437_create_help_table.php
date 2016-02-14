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
            $table->string('route_parameters');
            $table->string('description');
            $table->longText('parameters');
            $table->longText('response');
            $table->longText('response_error');
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
