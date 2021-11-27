<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    protected static $user_table = "users";
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public static function backupUser($user_id,$cmd=false){
        // table 
        $table = static::$user_table;

        // file 
        $file = base_path("DB/user_list.sqlite");

        // data 
        $u = User::find($user_id);

        // command 
        $command = '';

        // default to delete command
        switch($cmd):
        case"insert":
            $command = " 
/* =========================== Insert new id {$user_id} ======================
 * on ".date("Y-m-d H:i:s a")." START 
 * */
INSERT INTO `{$table}`(`name`,`email`,`password`,`email_verified_at`,`is_admin`,
`created_at`,`updated_at`)VALUES(
    '{$u->name}',
    '{$u->email}',
    '$u->password',
    '{$u->email_verified_at}',
    '{$u->is_admin}',
    '{$u->created_at}',
    '{$u->updated_at}');
/* ============================================================================
 *                  END OF INSERT COMMAND FOR user id {$user_id}
 * ============================================================================
 * */
";
            break;
        case"edit":
            $command = "
/* =========================== Update id {$user_id} ===========================
 * on ".date("Y-m-d H:i:s a")."
 * ============================================================================
 * */
UPDATE `{$table}` SET name='{$u->name}',
password='{$u->password}', 
email='{$u->email}',
email_verified_at='{$u->email_verified_at}',
updated_at='{$u->updated_at}' WHERE id='{$user_id}';
/* ============================================================================
 *                      END UPDATE COMMAND FOR user id {$user_id}
 * ============================================================================
 * */
";
            break;
        default:
            $command = "
/* ========================== delete user {$user_id} =========================
 * on ".date("Y-m-d H:i:s a")."
 * will be comment delete command just to prevent from having Error
 * */
/* DELETE FROM {$table} WHERE id={$user_id}; */
/* ============================================================================
 *                  END OF DELETE COMMAND FOR user id {$user_id}
 * ============================================================================
 * */
";
            break;
            endswitch;
        write2text($file,$command);
    }

}
