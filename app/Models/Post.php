<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Read;
use DB;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id","p_title","slug",
        "p_excerpt","p_body","p_is_public"
    ];

    protected static $post_table = "posts";
    protected static $post_read_table = "post_read";
    protected static $post_category_table = "category_post";
    protected static $post_tag_table = "post_tag";


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tag(){
        return $this->belongsToMany(Tag::class);
    }


    public function category(){
        return $this->belongsToMany(Category::class);
    }

    public function read(){
        return $this->belongsToMany(Read::class);
    }
    /* ======================= Backup and Custom section =================================
     * 
     * */
    public static function postHasRead($post_id){

        $post = Post::find($post_id);

        $has_read = Read::where("ip",getUserIp())
                        ->whereDate("created_at","=",date("Y-m-d"))
                        ->get();
        if(count($has_read) == 0):
            $read_data = [
                "ip" => getUserIp(),
                "os" => getUserOs(),
                "device" => getUserDevice(),
                "browser" => getUserBrowser()
            ];
            Read::create($read_data);

            // get the last row 
            $r = Read::latest()->first();

            Read::backupRead($r->id,"insert");

            $post->read()->attach($r->id);
            
            static::backupPostReadLink($post_id);
        endif;



    }
    public static function backupPost($post_id,$cmd=false){
        // table
        $table = static::$post_table;

        // file 
        $file = base_path("DB/post_list.sqlite");

        // data 
        $p = Post::find($post_id);

        // command
        $command = "";

        switch($cmd):
            case"insert":
                $command = "
/* ======================= INSERT COMMAND for id {$post_id} ===================
 * START on ".date("Y-m-d H:i:s a")."
 * ============================================================================
 * */
INSERT INTO `{$table}`(`user_id`,`p_title`,`slug`,`p_excerpt`,`p_body`,
`p_is_public`,`created_at`,`updated_at`) VALUES(
    '{$p->user_id}',
    '{$p->p_title}',
    '{$p->slug}',
    '{$p->p_excerpt}',
    '{$p->p_body}',
    '{$p->p_is_public}',
    '{$p->created_at}',
    '{$p->updated_at}');
";

                static::backupPostTagLink($post_id);
                static::backupPostCategoryLink($post_id);
            break;
            case"edit":
                $command = "
/* ============================= UPDATE COMMAND id {$post_id} =================
 * START on ".date("Y-m-d H:i:s a")."
 * */
UPDATE `{$table}` SET p_title='{$p->p_title}',
slug='{$p->slug}',
p_excerpt='{$p->p_excerpt}',
p_body='{$p->p_body}',
p_is_public='{$p->p_is_public}' WHERE id='{$post_id}';
/* ============================================================================
 * END UPDATE COMMAND for id {$post_id}
 * */
";

                static::backupPostTagLink($post_id);
                static::backupPostCategoryLink($post_id);
            break;
            default:
                $command = "
/* ====================== Default DELETE COMMAND for id {$post_id} ============
 * START on ".date("Y-m-d H:i:s a")." 
 * The DELETE command will be commented to prevent Error on migrate:refresh
 * */
/* DELETE FROM `{$table}` WHERE id='{$post_id}'; */
/* ============================================================================
 *
 * */
";
            break;
        endswitch;

        write2text($file,$command);

    }

    public static function backupPostTagLink($post_id){
        // this method will be only insert tag_id with post_id 
        // as post can have many tag and tag can have many post 
        $table = static::$post_tag_table;

        // file 
        $file = base_path("DB/post_tag_list.sqlite");

        // data 
        $po = DB::table($table)
                    ->where("post_id",$post_id)
                    ->get();
        // command 
        $command = "";

        if(count($po) != 0):
            $command = "
/* ===================== Default DELETE command ===============================
 * for post id {$post_id} on ".date("Y-m-d H:i:s a")."
 * 
 * */
DELETE FROM `{$table}` WHERE post_id='{$post_id}';
";
        endif;
        foreach($po as $it):
            $command = "
/* ================= INSERT COMMAND for post id {$post_id} ====================
 * START on  ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`post_id`,`tag_id`)VALUES(
    '$it->post_id',
    '{$it->tag_id}');
";
        endforeach;

        write2text($file,$command);
    }

    public static function backupPostCategoryLink($post_id){
        // table 
        $table = static::$post_category_table;

        // file 
        $file = base_path("DB/post_category_link.sqlite");

        // data 
        $data = DB::table($table)->where("post_id",$post_id)->get();

        $command = '';
        if(count($data) > 1):
            // if more than 1 row need to delete it first just to prevent from 
            // error execution
            $command = "
/* ===================== DEFAULT DELETE METHOD for id {$post_id} ============== 
 * on ".date("Y-m-d H:i:s a")."
 * */
DELETE FROM `{$table}` WHERE post_id='{$post_id}';
";
        endif;
        
        $p_id = '';
        $c_id = '';

        foreach($data as $it):
            $p_id = $it->post_id;
            $c_id = $it->category_id;

            // then re-insert again 
            $command = "
/* ====================== the post id {$p_id} has category id {$c_id} 
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`category_id`,`post_id`) VALUES(
    '{$c_id}',
    '{$p_id}'
);
"; 

        endforeach;

        write2text($file,$command);
    }

    public static function backupPostReadLink($post_id){
        // $table 
        $table = static::$post_read_table;

        // file 
        $file = base_path("DB/post_read_list.sqlite");

        // command 
        $command = '';

        // data 
        $read_data = DB::table($table)
                            ->where("post_id",$post_id)
                            ->get();

        foreach($read_data as $item):
            $command = "
/* ========================= INSERT COMMAND ===================================
 * LINK post id {$post_id} to read id {$item->read_id}
 * on ".date("Y-m-d H:i:s a")."
 * */
INSERT INTO `{$table}`(`post_id`,`read_id`) VALUES(
    '{$item->post_id}',
    '{$item->read_id}');
";
        endforeach;

        write2text($file,$command);

    }

}
