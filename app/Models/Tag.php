<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ["tag_name"];

    protected static $tag_table = "tags";
    
    public function post(){
        return $this->belongsToMany(Post::class);
    }

    
    /* =========================== backup Seaction ============================
     * date on 2 Nov 2021
     * */
    public static function backupTag($tag_id,$cmd=false){
        // table
        $table = static::$tag_table;

        // file 
        $file = base_path("DB/tag_list.sqlite");

        // data 
        $ta = Tag::find($tag_id);

        // command
        $command = "";

        switch($cmd):
            case"insert":
            $command = "
/* ==================== INSERT COMMAND for tag id {$tag_id} ===================
 * START on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`tag_name`,`created_at`,`updated_at`)
VALUES(
    '{$ta->tag_name}',
    '{$ta->created_at}',
    '{$ta->updated_at}');
/* ============================================================================
*  INSERT COMMAND for tag id {$tag_id} END 
* */
";
            break;
            case"edit":
    $command = "
/* ================= UPDATE COMMAND for tag id {$tag_id} ======================
 * START on ".date("Y-m-d H:i:s a")."
 * */
UPDATE `{$table}` SET tag_name='{$ta->tag_name}',
updated_at='{$ta->updated_at}' WHERE id='{$tag_id}';
/* ============================================================================
*  UPDATE COMMAND for tag id {$tag_id} END 
* */
";
            break;
            default:

    $command = "
/* ============ DEFAULT DELETE COMMAND for tag id {$tag_id} ===================
 * START on ".date("Y-m-d H:i:s a")."
 * THE DELETE method will be commented just to prevent error on migrate:refresh
 * */
/* DELETE FROM `{$table}` WHERE id='{$tag_id}'; */
/* ============================================================================
*  DELETE COMMAND for tag id {$tag_id} END 
* */
";
            break;
        endswitch;

        write2text($file,$command);
    }
}
