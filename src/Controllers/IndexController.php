<?php
namespace CM\Controllers;

use CM\Core\Abstracts\Controller;
use CM\Core\Request;
use CM\Core\Abstracts\DB;
use CM\Models\Users;
use CM\Models\Exam;
use CM\Core\Response;

class IndexController extends Controller{

    public function index(){
        // $user = Users::whereLike('name', 'minh')->orWhere('dev', 'dev1')->get();
        // $user = Users::all();
        // $user =  new Users();
        // $user->name = "ádassssssssss";
        // $user->birthday = "aaaaaaaaaaaaa";
        // $user->dev = "hehee";
        // $return = $user->save();
        // $user = Users::all();eqqeqeqeqweqqeqeq
        // dd($user);
        // $user = DB::update('INSERT INTO users (name, birthday, dev) VALUES (:name, :birthday, :dev);', [
        //     'name' => "công minh DB",
        //     'birthday' => '10129912222',
        //     'dev' => 'db insert'
        // ]);
        // dd($user);

        // $user = DB::update('UPDATE users SET name = :name, birthday = :birthday, dev = :dev WHERE id in (26,27,28,29);', [
        //     'name' => "công minh DB update",
        //     'birthday' => '10129912222 update',
        //     'dev' => 'db update'
        // ]);
        // dd($user);

        // $user = DB::select('SELECT * from exam WHERE user_id in (1,3,2);');
        // dd($user);

        // $user = Users::with('Exam')->where('id', 1)->get()->g();
        
        return view('demo');
    }

    public function demo(){
        return (new Response(200))->json(['demo'=>'ghfhgf']);
    }
}