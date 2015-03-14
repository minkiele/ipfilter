<?php

namespace Minkiele\IpFilter\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Minkiele\IpFilter\File\Loader;
use Minkiele\IpFilter\File\Saver;
use Minkiele\IpFilter\P2P\Row\Translator as P2PTranslator;
use Minkiele\IpFilter\Dat\Row\Translator as DatTranslator;
use Minkiele\IpFilter\Table;

class Convert extends Command{
    protected function configure(){
        $this->setName('ipfilter:convert')
             ->setDescription('Convert a list from a format to another')
             ->addArgument('files', InputArgument::IS_ARRAY, 'Files to add')
             ->addOption('intype', null, InputOption::VALUE_OPTIONAL, 'The input file format', 'p2p')
             ->addOption('outtype', null, InputOption::VALUE_OPTIONAL, 'The output format', 'dat')
             ->addOption('outfile', 'o', InputOption::VALUE_REQUIRED, 'The output file to write')
             ->addOption('optimize', 'm', InputOption::VALUE_NONE, 'Try to optimize the ip list');
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $dispatcher = new EventDispatcher();
      
        $files = $input->getArgument('files');
        $inFormat = $input->getOption('intype');
        $outFormat = $input->getOption('outtype');
        $outFile = $input->getOption('outfile');
        $optimize = $input->getOption('optimize');

        if(!count($files)){
            $files = ['php://stdin'];
        }

        if($outFile === null){
            $outFile = 'php://stdout';
        }

        switch($inFormat){
            case 'p2p':
                $inTranslator = new P2PTranslator($dispatcher);
                break;
            case 'dat':
                $inTranslator = new DatTranslator($dispatcher);
                break;
            default:
                throw new \Exception('Unrecognized input format');
                break;
        }

        switch($outFormat){
            case 'p2p':
                $outTranslator = new P2PTranslator($dispatcher);
                break;
            case 'dat':
                $outTranslator = new DatTranslator($dispatcher);
                break;
            default:
                throw new \Exception('Unrecognized input format');
                break;
        }

        $saver = new Saver($dispatcher, $outFile);

        foreach($files as $fileName){
            $loader = new Loader($dispatcher, $fileName);
            $table = new Table($dispatcher, $loader, $inTranslator);

            if($optimize){
                $table->merge();
            }

            $table->save($saver, $outTranslator);

        }

        $saver->save();

    }

}
