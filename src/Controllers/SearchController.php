<?php
namespace CM\Controllers;

use CM\Core\Abstracts\Controller;
use CM\Core\Request;
use CM\Core\Response;
use CM\Models\Users;
use CM\Models\Exam;

class SearchController extends Controller{

    public function search(Request $request){
        $dev = $request->input('dev');
        $date = $request->input('date_exam');

        $users = Users::find('dev', '=', $dev);
        // var_dump($users);
        foreach($users as $key => &$user){
            $exam = Exam::search([
                ['date_exam', '=', $date],
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

        return (new Response(200))->json($users);
    }


    public function bonus(){
        $users = Users::all();
        foreach($users as $key => &$user){
            $exam = Exam::search([
                ['user_id', '=', (int)$user['id']]
            ]);
            $point = 0;
            if(!empty($exam)){
                foreach($exam as $value){
                    $point += $value['point'];
                }
                $user['point'] = $point;
                $user['bonus'] = number_format($this->calc_bonus($point)).' VND';
            }
            
        }
        return (new Response(200))->json($users);

    }

    public function hehe(Request $request,$id,$c_id){
        $a1 = $request->input('bvminh');
        return '->'.$id.'|'.$c_id."|".$a1; 
    }
    public function hehe2($id,$c_id){
        $a1 = $request->input('bvminh');
        return '->'.$id.'|'.$c_id."|".$a1; 
    }

    public function tesst2($id, $c_id){
        return '->'.$id.'|'.$c_id; 
    }

    private function calc_bonus($point){
        if($point >= 150){
            return 15000000;
        }
        if($point >= 120){
            return 10000000;
        }
        if($point >= 100){
            return 5000000;
        }
        return 0;
    }
}