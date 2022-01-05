<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // https://www.youtube.com/channel/UCTuplgOBi6tJIlesIboymGA/community?lb=UgkxLNkKYViKHJki4N-C1Xh7WkfQARugYNXE
    public static function getSelectDropDownOptions(): \Illuminate\Support\Collection
    {
        return Category::pluck('name','id')->prepend('Please select...', '');
    }

    public static function getSelectDropDownFilterOptions(): \Illuminate\Support\Collection
    {
        return Category::pluck('name','id')->prepend('All', '');
    }
}
