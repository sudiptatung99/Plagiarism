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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('document')->nullable();
            $table->string('doc_id')->nullable();
            $table->string('doc_status')->nullable();
            $table->longText('doc_text')->nullable();
            $table->string('report_url')->nullable();
            $table->string('inTextCount')->nullable();
            $table->string('outTextCount')->nullable();
            $table->string('outSentenceCount')->nullable();
            $table->string('inSentenceCount')->nullable();
            $table->string('inDeductDocument')->nullable();
            $table->string('outDeductDocument')->nullable();
            $table->string('originality')->nullable();
            $table->longText('text')->nullable();
            $table->enum('isDoc',['0', '1'])->default(1);
            $table->enum('is_index', ['0', '1'])->default('0');
            $table->enum('is_delete', ['0', '1'])->default('0');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('folder_id')->references('id')->on('folders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
