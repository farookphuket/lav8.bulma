<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "t_title","t_method",
        "t_excerpt",
        "t_body"
    ];

    protected static $template_table = "templates";

    public function user(){
        return $this->belongsTo(User::class);
    }

    /* ================================================
     * backup START
     * */
    public static function backupTemplate($id,$cmd=false){
        // table 
        $table = static::$template_table;

        // file 
        $file = base_path("DB/template_list.sqlite");

        // data 
        $tm = Template::find($id);

        // command
        $command = "";

        switch($cmd):
        case"insert":
            $command = "
/* ==================== INSERT COMMAND id {$id}
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`user_id`,`t_title`,`t_method`,
`t_excerpt`,`t_body`,`created_at`,`updated_at`) VALUES(
    '{$tm->user_id}',
    '{$tm->t_title}',
    '{$tm->t_method}',
    '{$tm->t_excerpt}',
    '{$tm->t_body}',
    '{$tm->created_at}',
    '{$tm->updated_at}');
";
        break;
        case"edit":
    $command = "
/* ==================== UPDATE COMMAND id {$id}
 * on ".date("Y-m-d H:i:s a")."
 * */
UPDATE `{$table}` SET t_title='{$tm->t_title}',
t_method='{$tm->t_method}',
t_excerpt='{$tm->t_excerpt}',
t_body='{$tm->t_body}',
updated_at='{$tm->updated_at}' WHERE id='{$id}';
";
        break;
        default:
        $command = "
    /* ==================== DEFAULT DELETE COMMAND id {$id}
     * on ".date("Y-m-d H:i:s a")."
     * */
    /* DELETE FROM `{$table}` WHERE id='{$id}';*/
    ";
        break;
    endswitch;

    write2text($file,$command);

    }

    /* ================================================
     * backup END 14 Jan 2022
     * */
}
