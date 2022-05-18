<?php

namespace CM\Core\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CM\Core\Command\CommandClass;


class CacheCommand extends Command{
    

    protected function configure()
    {
        $this
            ->setName('app:cache')
            // configure an argument
            ->addArgument('argument', InputArgument::REQUIRED, 'cache')
            // option
            ->addOption('all', null, InputOption::VALUE_NONE, "all cache")
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output){

        $args = $input->getArgument('argument');
        $option = $input->getOption('all');
        


        switch ($args) {
            case 'clear':
                if((int) $option){
                    clear_file(ROOTPATH.'/src/cache/views');
                }
                remove_dir(ROOTPATH.'/src/cache/system');
                clear_file(ROOTPATH.'/src/config');
                $output->writeln('<fg=green>Cache cleared !</>');
                return 0;
            case 'config':
                if((int) $option){
                    clear_file(ROOTPATH.'/src/cache/views');
                }
                remove_dir(ROOTPATH.'/src/cache/system');
                clear_file(ROOTPATH.'/src/config');
                $output->writeln("\n<fg=green>Cache cleared !</>\n");
                create_config_db();
                create_config_enviroment();
                create_config_middleware();
                $output->writeln("<fg=green>Cache configured !</>");
                return 0;
            default:
                # code...
                break;
        }
    }
}

