<?php

namespace Minkiele\IpFilter\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Convert extends Command{
    protected function configure(){
        $this->setName('ipfilter:convert')
             ->setDescription('Convert a list from a format to another')
             ->addArgument('files', InputArgument::IS_ARRAY, 'Files to add')
             ->addOption('in', null, InputOption::VALUE_OPTIONAL, 'The input file format', 'p2p')
             ->addOption('out', null, InputOption::VALUE_OPTIONAL, 'The output format', 'dat')
             ->addOption('outfile', 'o', InputOption::VALUE_REQUIRED, 'The output file to write')
             ->addOption('optimize', 'm', InputOption::VALUE_NONE, 'Try to optimize the ip list');
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $files = $input->getArgument('files');
        $inFormat = $input->getOption('in');
        $outFormat = $input->getOption('out');
        $outFile = $input->getOption('outfile');
        $optimize = $input->getOption('optimize');

    }

}
