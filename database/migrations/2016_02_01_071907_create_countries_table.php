<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Builder;

class CreateCountriesTable extends Migration
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

        $this->schema->create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->drop('countries');
    }

}
