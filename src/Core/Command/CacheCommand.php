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
            ->setName('cache:config')
            // configure an argument
            ->addArgument('option', InputArgument::REQUIRED, 'cache config option')
            // ...
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output){

        $name = $input->getArgument('option');
        $output->writeln($name);

        return 0;

        // switch ($name) {
        //     case 'value':
        //         # code...
        //         break;
            
        //     default:
        //         # code...
        //         break;
        // }
    }
}

