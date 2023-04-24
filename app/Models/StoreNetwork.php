<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreNetwork extends Model
{
    protected $table = 'storenetworks';



    //!Public Data
    protected $fillable = ['store_code','previous_ip','current_ip','previous_timestamp','current_timestamp'];
    //!Hidden Data
    protected $hidden = ['bin','created_at','updated_at'];
}
