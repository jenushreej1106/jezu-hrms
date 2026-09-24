<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_documents', function (Blueprint $table) {
            $table->foreignId('employee_id')
                ->after('id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->string('document_name')
                ->after('employee_id');

            $table->string('document_type')
                ->nullable()
                ->after('document_name');

            $table->string('file_path')
                ->after('document_type');
        });
    }

    public function down(): void
    {
        Schema::table('employee_documents', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn([
                'employee_id',
                'document_name',
                'document_type',
                'file_path',
            ]);
        });
    }
};
