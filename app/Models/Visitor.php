<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        "ip","os","browser","device","visited_at"
    ];

    protected static $visitor_table = "visitors";

    public static function backupVisitor($v_id,$cmd=false){
        // table
        $table = static::$visitor_table;

        // data 
        $v = Visitor::find($v_id);

        // file 
        $file = base_path("DB/visitor_list.sqlite");

        // command 
        $command = "";

        switch($cmd):
        case"insert":
            $command = "
/* ============================ Insert Command for {$v_id} ====================
 *  on date ".date("Y-m-d H:i:s a")."
 *  START
 * ============================================================================
 * */
INSERT INTO `{$table}`(`ip`,`os`,`browser`,`device`,`visited_at`,`created_at`,
`updated_at`)VALUES(
'{$v->ip}',
'{$v->os}',
'{$v->browser}',
'{$v->device}',
'{$v->visited_at}',
'{$v->created_at}',
'{$v->updated_at}');

/* ============================================================================
 *      END OF INSERT COMMAND ID {$v_id}
 * */
";
            break;
            default:
                /* 
                 * don't need the update case as it unnecessary
                 * */
            $command = "
/* ================================== Delete command as default ===============
 * START on ".date("Y-m-d H:i:s a")."
 * */
/* DELETE FROM `{$table}` WHERE id='{$v_id}';*/
/* ============================================================================
 * Delete command just command out as it is may cause an error on migrate-refresh
 * ============================================================================
 * */
";
            break;
        endswitch;

        write2text($file,$command);
    }
}
