<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('esewa_transaction_uuid')->nullable()->after('payment_status');
            $table->string('esewa_reference_id')->nullable()->after('esewa_transaction_uuid');
            $table->timestamp('esewa_paid_at')->nullable()->after('esewa_reference_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['esewa_transaction_uuid', 'esewa_reference_id', 'esewa_paid_at']);
        });
    }
};
