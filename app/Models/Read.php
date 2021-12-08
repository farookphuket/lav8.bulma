<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
    use HasFactory;

    protected $fillable = [
        "ip",
        "os",
        "browser",
        "device"
    ];

    // table 
    protected static $read_table = "reads";

    public function post(){
        return $this->belongsToMany(Post::class);
    }

    /* ========================================================================
     * Backup Section START 
     * */
    public static function backupRead($read_id,$cmd=false){
        // table 
        $table = static::$read_table;

        // data 
        $r_data = Read::find($read_id);

        // command
        $command = "";

        // file 
        $file = base_path("DB/read_list.sqlite");

        // switch case 
        switch($cmd):
        case"insert":
            $command = "
/* ======================= Insert command for read id {$read_id} ==============
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`ip`,`os`,`browser`,`device`,`created_at`,`updated_at`) 
VALUES(
'{$r_data->ip}',
'{$r_data->os}',
'{$r_data->browser}',
'{$r_data->device}',
'{$r_data->created_at}',
'{$r_data->updated_at}');
/* ============================================================================
 *
 * */
";
        break;
case"edit":
    $command = "

/* ======================= Update command for read id {$read_id} ==============
 * on ".date("Y-m-d H:i:s a")."
 * */
UPDATE `{$table}` SET ip='{$r_data->ip}',
os='{$r_data->os}',
browser='{$r_data->browser}',
device='{$r_data->device}',
updated_at='{$r_data->updated_at}' WHERE id='{$read_id}';
/* ============================================================================
 * */
";
        break;
default:
    $command = "
/* ================== DEFAULT DELETE command for read id {$read_id} ============
 * on ".date("Y-m-d H:i:s a")."
 * */
/* DELETE FROM `{$table}` WHERE id='{$read_id}'; */
";
    break;
    endswitch;

        write2text($file,$command);
    }


    /* ========================================================================
     * Backup Section END 
     * */
}
