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
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->string('document_prefix')->default('INV'); // คำนำหน้าเลขที่เอกสาร
            $table->integer('document_number')->default(1); // เลขที่เอกสารเริ่มต้น
            $table->string('primary_color')->default('#0ea5e9');
            $table->string('secondary_color')->default('#0369a1');
            $table->string('font_family')->default('Sarabun');
            $table->text('footer_text')->nullable();
            $table->boolean('show_tax')->default(true);
            $table->decimal('tax_rate', 5, 2)->default(7.00); // VAT 7%
            $table->string('line_channel_token')->nullable();
            $table->string('promptpay_id')->nullable();
            $table->string('promptpay_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};
