<?php

namespace CM\Core\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CM\Core\Command\CommandClass;


class ServeCommand extends Command{

    protected function configure()
    {
        $this
            ->setName('serve')
            // configure an argument
            ->addArgument('argument', InputArgument::REQUIRED, 'server')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $args = $input->getArgument('argument');
        if($args == 'localhost' || filter_var($args, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)){
            $out = null;
            $code = null;
            exec("php -S ".$args.":8000 ".ROOTPATH.'/src/index.php', $out, $code);
            $output->writeln("\n $out");
        }else{
            $output->writeln("\n<fg=red>Invalid ip address !</>\n");
        }
        
        
        return 0;
    }
}