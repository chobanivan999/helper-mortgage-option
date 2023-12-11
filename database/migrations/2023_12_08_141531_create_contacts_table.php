<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('bankname');
            $table->string('name');
            $table->string('whatsapp');
            $table->timestamps();
        });

        DB::table('contacts')->insert(
            array(
                [
                    'bankname' => 'Maybank',
                    'name'     => 'Kunze',
                    'whatsapp' => '+6592338972',
                ],
                [
                    'bankname' => 'OCBC',
                    'name'     => 'Jessica Keh',
                    'whatsapp' => '+6597696656',
                ],
                [
                    'bankname' => 'DBS',
                    'name'     => 'Ken Leong',
                    'whatsapp' => '+6591897980',
                ],
                [
                    'bankname' => 'HSBC',
                    'name'     => 'Ashley Woo',
                    'whatsapp' => '+6596669468',
                ],
                [
                    'bankname' => 'Citibank',
                    'name'     => 'Sam Ng',
                    'whatsapp' => '+6598782887',
                ],
                [
                    'bankname' => 'SCB',
                    'name'     => 'Chng Poo Heng',
                    'whatsapp' => '+6598448255',
                ],
                [
                    'bankname' => 'CIMB',
                    'name'     => 'Zhen Rong',
                    'whatsapp' => '+6594503034',
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
