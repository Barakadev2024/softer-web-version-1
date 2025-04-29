<?php

namespace App\Models;

//
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Encore\Admin\Auth\Database\Administrator;
use GrahamCampbell\ResultType\Success;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Administrator
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'admin_users';

public static function success($data, $message)
{
  
   //set header response to json
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode([
        'code' => '1',
        'data' => null,
        'message' => $message
    ]);
    die();

}
public static function error($message)
{
  
   //set header response to json
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode([
        'code' => '0',
        'message' => $message
    ]);
    die();

}
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
