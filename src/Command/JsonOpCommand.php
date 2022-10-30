<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\JsonOperations\ReadJsonFile;
use App\JsonOperations\JsonOperations;

class JsonOpCommand extends Command
{
    protected static $defaultName = 'json-op';
    protected static $defaultDescription = 'PHP Cli app that runs multiple json I/O operations';


    protected function configure(): void
    {
        $this
            ->addArgument('json_path', InputArgument::REQUIRED, 'Absolute path of your file')
            ->addArgument('int_filter_argument', InputArgument::IS_ARRAY, 'Filters input array by given range(integer)')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'Show Json as array output format')
            ->addOption('schematize', 's', InputOption::VALUE_NONE, 'Schematize Json File')
            ->addOption('keys', 'k', InputOption::VALUE_NONE, 'Returns JSON Array Keys')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $json_path= $input->getArgument('json_path');
        $filterParams= $input->getArgument('int_filter_argument');
        $schematize= $input->getOption('schematize');
        $keys= $input->getOption('keys');
        $all= $input->getOption('all');

        $io->note(sprintf('Json path passed as: %s', $json_path));
        $jsonOperations = new JsonOperations(new ReadJsonFile($json_path));

        if($all)
        {
            print_r($jsonOperations->jsonReader->jsonArray);

        }
        
        if ($schematize)
        {
            $io->note('Schematize option will add empty key-value pairs to every element in your json file');
            $jsonOperations->operateJson("schematize");
            print_r($jsonOperations->jsonReader->jsonArray);
        }

        if ($keys)
        {
            $io->note('All available keys will be printed out');
            $jsonOperations->operateJson("schematize");
            print_r($jsonOperations->jsonKeys);
        }
        
        if(!empty($filterParams[1]))
        {
            $jsonOperations->setFilterParams($filterParams)->operateJson("applyFilter");
            print_r($jsonOperations->jsonReader->jsonArray);

        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
