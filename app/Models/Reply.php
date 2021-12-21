<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "comment_id",
        "r_title",
        "r_body"
    ];

    protected static $reply_table = "replies";
    protected static $comment_reply_link_table = "comment_reply";

    public function comment(){
        return $this->belongsToMany(Comment::class);
    }

    public function post(){
        return $this->belongsToMany(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }



    /* ======================== Backup section ================================
     *
     * */
    public static function backupReply($reply_id,$cmd=false){
        // table 
        $table = static::$reply_table;

        // data 
        $cm = Reply::find($reply_id);

        // file 
        $file = base_path("DB/reply_list.sqlite");

        // command 
        $command = "";

        switch($cmd):
        case"insert":
            $command = "
/* ================== INSERT COMMAND FOR reply id {$reply_id} =============
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`user_id`,`r_title`,`r_body`,`created_at`,
`updated_at`) VALUES(
    '{$cm->user_id}',
    '{$cm->r_title}',
    '{$cm->r_body}',
    '{$cm->created_at}',
    '{$cm->updated_at}'
);
";

        // backup reply link
        static::backupReplyCommentLink($reply_id);

        break;
case"edit":
    $command = "
/* ================== UPDATE COMMAND FOR reply id {$reply_id} =============
 * on ".date("Y-m-d H:i:s a")."
 * */
UPDATE `{$table}` SET r_title='{$cm->r_title}',
r_body='{$cm->r_body}',
updated_at='{$cm->updated_at}'
WHERE id='{$reply_id}';
";
        break;
default:
    $command = "
/* ================== DELETE COMMAND FOR reply id {$reply_id} =============
 * on ".date("Y-m-d H:i:s a")."
 * */
/* DELETE FROM `{$table}` WHERE id='{$reply_id}'; */
";
    break;
    endswitch;

        write2text($file,$command);



    }

    public static function backupReplyCommentLink($reply_id){
        // table 
        $table = static::$comment_reply_link_table;

        // file 
        $file = base_path("DB/comment_reply_link.sqlite");

        // data 
        $cm = DB::table($table)
            ->where("reply_id",$reply_id)
            ->get();

        // command 
        $command = "";

        // delete command just to prevent from error 
        if($cm->count() > 1):
            $command .= "
/* =================== DELETE COMMAND FOR reply id {$reply_id} ============
 * on ".date("Y-m-d H:i:s a")."
 * */
DELETE FROM `{$table}` WHERE reply_id='{$reply_id}';
"; 
        endif;
    
        foreach($cm as $item):
        $command = "
/* =================== INSERT COMMAND FOR reply id {$reply_id} ============
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`reply_id`,`comment_id`)VALUES(
    '{$item->reply_id}',
    '{$item->comment_id}'
);
";
        endforeach;

        // write to file
        write2text($file,$command);
    }
}
