<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function up()
{
    Schema::table('students', function (Blueprint $table) {
        $table->string('name'); 
    });
}

public function down()
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropColumn('name'); 
    });
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
