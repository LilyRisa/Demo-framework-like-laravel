<?php
namespace CM\Controllers;

use CM\Libs\Abstracts\Controller;
use CM\Models\Users;
use CM\Models\Exam;

class IndexController extends Controller{

    public function index(){
        $users = Users::find('dev', '=', 'Dev2');
        // var_dump($users);
        foreach($users as $key => &$user){
            $exam = Exam::search([
                ['date_exam', '=', '9/10/2019'],
                ['user_id', '=', (int)$user['id']]
            ]);
            $point = 0;
            if(!empty($exam)){
                foreach($exam as $value){
                    $point += $value['point'];
                }
                $user['point'] = $point;
            }else{
                unset($users[$key]);
            }
            
        }
        usort($users, function($a,$b){
            return $b['point'] - $a['point'];
        });
        return $this->view('index.html',['users' => $users]);
    }
}