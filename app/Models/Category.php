<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "cat_name"
    ];


    protected static $cat_table = "categories";

    public function post(){
        return $this->belongsToMany(Post::class);
    }


    public static function backupCategory($id,$cmd=false){
        // table 
        $table = static::$cat_table;

        // data 
        $c = Category::find($id);

        // file 
        $file = base_path("DB/category_list.sqlite");

        // command
        $command = "";

        switch($cmd):
        case"insert":
            $command = "
/* =================== INSERT COMMAND for category id {$id} ===================
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`cat_name`,`created_at`,`updated_at`) VALUES(
    '{$c->cat_name}',
    '{$c->created_at}',
    '{$c->updated_at}');
";
        break;
case"edit":
    $command = "
/* =================== UPDATE COMMAND for category in {$id} ===================
 * on ".date("Y-m-d H:i:s a")."
 * */
UPDATE `{$table}` SET cat_name='{$c->cat_name}' WHERE id='{$id}';
";
    break;
default:
    $command = "
/* ===================== DEFAULT DELETE COMMMAND FOR cat id {$id} =============
 * on ".date("Y-m-d H:i:s a")."
 * */
/* DELETE FROM `{$table}` WHERE id='{$id}'; */
";
        break;
        endswitch;

        write2text($file,$command);

    }

}
