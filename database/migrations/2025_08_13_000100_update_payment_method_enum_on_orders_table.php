<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update enum to allow esewa and khalti without requiring doctrine/dbal
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cod','esewa','khalti') NOT NULL DEFAULT 'cod'");
    }

    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE `orders` MODIFY `payment_method` ENUM('cod') NOT NULL DEFAULT 'cod'");
    }
};
