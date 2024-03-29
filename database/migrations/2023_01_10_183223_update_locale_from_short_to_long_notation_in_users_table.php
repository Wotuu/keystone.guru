<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::update('UPDATE `users` SET `locale` = "en-US" WHERE `locale` = "en"');
        DB::update('UPDATE `users` SET `locale` = "ru-RU" WHERE `locale` = "ru"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::update('UPDATE `users` SET `locale` = "en" WHERE `locale` = "en-US"');
        DB::update('UPDATE `users` SET `locale` = "ru" WHERE `locale` = "ru-RU"');
    }
};
