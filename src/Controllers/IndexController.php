<?php
namespace CM\Controllers;

use CM\Core\Abstracts\Controller;
use CM\Models\Users;
use CM\Models\Exam;

class IndexController extends Controller{

    public function index(){
        // $user = Users::where('name', 'ba')->get();
        $user = Users::all();
        // dd($user);
        return view('index',['users' => $user]);
    }
}