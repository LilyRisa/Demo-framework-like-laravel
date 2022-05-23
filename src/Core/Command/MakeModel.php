<?php

namespace CM\Core\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class MakeModel extends Command{
    

    protected function configure()
    {
        $this
            ->setName('make:model')
            // configure an argument
            ->addArgument('argument', InputArgument::REQUIRED, 'cache')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output){

        $args = $input->getArgument('argument');        
        create_file($args, 'model');
        $output->writeln("<fg=green>Model $args created!</>");
        return 0;
           
    }
}

