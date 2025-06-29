<?php
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table -> id();
            $table -> string('title');
            $table -> text('description');
            $table -> enum('status', ['pending', 'in_progress', 'completed']) -> default('pending');
            $table -> foreignIdFor(User::class);
            $table -> timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
