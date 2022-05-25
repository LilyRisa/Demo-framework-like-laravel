<?php

namespace CM\Core\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CM\Core\Command\CommandClass;

use CM\Core\Hash;
use Exception;

class KeyCommand extends Command{
    

    protected function configure()
    {
        $this->setName('key:generate');
    }


    protected function execute(InputInterface $input, OutputInterface $output){

        global $_ENV;

        if(isset($_ENV['APP_KEY']) && !empty($_ENV['APP_KEY'])){
            $output->writeln("\n<fg=green>APP_KEY already exists! </>\n");
            return 0;
        }

        $string = bin2hex(random_bytes(10));
        $string = Hash::genWithoutAppKey()->encrypt($string);
        try{
            $env = file_get_contents(ROOTPATH.'/.env');
            if(strpos($env, 'APP_KEY') !== FALSE){
                $env = str_replace("APP_KEY=","APP_KEY=$string",$env);
            }else{
                $env .="\nAPP_KEY=$string"; 
            }
            file_put_contents(ROOTPATH.'/.env',$env);

        }catch(\Exception $e){
            throw new \Exception('The system was misbehaving!');
        }
        $output->writeln("\n<fg=green>APP_KEY has been generated successfully! </>\n");
        return 0;
        
    }
}

