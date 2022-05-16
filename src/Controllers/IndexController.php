<?php
namespace CM\Controllers;

use CM\Core\Abstracts\Controller;
use CM\Models\Users;
use CM\Models\Exam;

class IndexController extends Controller{

    public function index(){
        // $user = Users::where('name', 'ba')->get();
        // $user = Users::all();
        $user =  new Users();
        $user->name = "ádassssssssss";
        $user->birthday = "aaaaaaaaaaaaa";
        $user->dev = "hehee";
        $return = $user->save();
        // dd($return);
        $user = Users::all();
        dd($user);
        
        return view('index',['users' => $user]);
    }
}