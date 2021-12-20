<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "c_title",
        "c_body"
    ];

    protected static $comment_table = "comments";
    protected static $post_comment_link = "comment_post";

    public function post(){
        return $this->belongsToMany(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reply(){
        return $this->belongsToMany(Reply::class);
    }

    /* ======================== Backup section ================================
     *
     * */
    public static function backupComment($comment_id,$cmd=false){
        // table 
        $table = static::$comment_table;

        // data 
        $cm = Comment::find($comment_id);

        // file 
        $file = base_path("DB/comment_list.sqlite");

        // command 
        $command = "";

        switch($cmd):
        case"insert":
            $command = "
/* ================== INSERT COMMAND FOR comment id {$comment_id} =============
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`user_id`,`c_title`,`c_body`,`created_at`,
`updated_at`) VALUES(
    '{$cm->user_id}',
    '{$cm->c_title}',
    '{$cm->c_body}',
    '{$cm->created_at}',
    '{$cm->updated_at}');
";
        break;
case"edit":
    $command = "
/* ================== UPDATE COMMAND FOR comment id {$comment_id} =============
 * on ".date("Y-m-d H:i:s a")."
 * */
UPDATE `{$table}` SET c_title='{$cm->c_title}',
c_body='{$cm->c_body}',
updated_at='{$cm->updated_at}'
WHERE id='{$comment_id}';
";
        break;
default:
    $command = "
/* ================== DELETE COMMAND FOR comment id {$comment_id} =============
 * on ".date("Y-m-d H:i:s a")."
 * */
/* DELETE FROM `{$table}` WHERE id='{$comment_id}'; */
";
    break;
    endswitch;

        write2text($file,$command);

        // backup comment link
        static::backupPostCommentLink($comment_id);

    }

    public static function backupPostCommentLink($comment_id){
        // table 
        $table = static::$post_comment_link;

        // file 
        $file = base_path("DB/post_comment_link.sqlite");

        // data 
        $cm = DB::table($table)
            ->where("comment_id",$comment_id)
            ->get();

        // command 
        $command = "";

        // delete command just to prevent from error 
        if($cm->count() > 1):
            $command .= "
/* =================== DELETE COMMAND FOR comment id {$comment_id} ============
 * on ".date("Y-m-d H:i:s a")."
 * */
DELETE FROM `{$table}` WHERE comment_id='{$comment_id}';
"; 
        endif;
    
        foreach($cm as $item):
        $command = "
/* =================== INSERT COMMAND FOR comment id {$comment_id} ============
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`comment_id`,`post_id`)VALUES(
    '{$item->comment_id}',
    '{$item->post_id}'
);
";
        endforeach;

        // write to file
        write2text($file,$command);
    }


}
