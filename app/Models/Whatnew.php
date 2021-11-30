<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whatnew extends Model
{
    use HasFactory;

    protected static $whatnew_table = "whatnews";

    protected $fillable = [
        "wn_title",
        "user_id",
        "wn_body",
        "is_public"
    ];

    public function user(){
        return $this->belongsTo(User::class);

    }


    /* ======================= Backup section =================================
     * create on 30 Nov 2021
     * */
    public static function backupWhatnew($wn_id,$cmd=false){
        //table 
        $table = static::$whatnew_table;    

        // file 
        $file = base_path("DB/whatnew_list.sqlite");

        // command 
        $command = "";

        // data 
        $wn = Whatnew::find($wn_id);

        switch($cmd):
        case"insert":
            $command = "
/* ===================== INSERT COMMAND for id {$wn_id} =======================
 *  START on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`user_id`,`wn_title`,`wn_body`,`is_public`,`created_at`,
`updated_at`) VALUES(
    '{$wn->user_id}',
    '{$wn->wn_title}',
    '{$wn->wn_body}',
    '{$wn->is_public}',
    '{$wn->created_at}',
    '{$wn->updated_at}');
/*
 *  END INSERT command for id {$wn_id} on ".date("Y-m-d H:i:s a")."
 * */
";
            break;
        case"edit":
            $command = "
/* ==================== Upadate Command for id {$wn_id} =======================
 * START on ".date("Y-m-d H:i:s a")."
 * 
 * */
UPDATE `{$table}` SET wn_title='{$wn->wn_title}',
wn_body='{$wn->wn_body}',
is_public='{$wn->is_public}',
updated_at='{$wn->updated_at}' WHERE id='{$wn_id}';
/* ============================================================================
*   END UPDATE command for id {$wn_id} on ".date("Y-m-d H:i:s a")."
 * */
";
            break;
        default:
            $command = "
/* ==================== Default delete command for {$wn_id} ===================
 * START on ".date("Y-m-d H:i:s a")."
 * */
/* DELETE FROM `{$table}` WHERE id='{$wn_id}'; */
/* ============================================================================
 * END DELETE command for id {$wn_id} on ".date("Y-m-d H:i:s a")."
 * ============================================================================
 * */
";
            break;
            endswitch;

        write2text($file,$command);
    }
    /* ========================================================================
     *              END of backup section
     * ========================================================================
     * */
}
