<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // 保存を許可するカラムを指定
    protected $fillable = ['title', 'description','due_date','is_completed','sort_order','is_completed',];
}