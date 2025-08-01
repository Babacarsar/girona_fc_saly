<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // Facultatif : titre de l'image ou vidéo
            $table->string('title')->nullable();

            // Type : image ou vidéo
            $table->enum('type', ['image', 'video']);

            // URL sécurisée de Cloudinary
            $table->string('file_path'); // ou `url`

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
