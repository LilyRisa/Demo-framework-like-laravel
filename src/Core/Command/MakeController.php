<?php

namespace CM\Core\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class MakeController extends Command{
    

    protected function configure()
    {
        $this
            ->setName('make:controller')
            // configure an argument
            ->addArgument('argument', InputArgument::REQUIRED, 'cache')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output){

        $args = $input->getArgument('argument');        
        create_file($args, 'controller');
        $output->writeln("<fg=green>Controller $args created!</>");
        return 0;
           
    }
}

