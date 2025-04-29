<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;
    //boot
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($company) {
            $owner = User::find($company->owner_id);
            if($owner == null){
                throw new \Exception('owner not found');
            }
            $owner->company_id = $company->id;
            $owner->save();
        });
        static::created(function ($company) {
            $owner = User::find($company->owner_id);
            if($owner == null){
                throw new \Exception('owner not found');
            }
            $owner->company_id = $company->id;
            $owner->save();
        });
    }
    
}


