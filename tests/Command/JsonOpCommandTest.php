<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class JsonOpCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:json-op');
        $commandTester = new CommandTester($command);

        $commandTester->execute(['json_path'=>'test.json'
                                 ]);

        $commandTester->assertCommandIsSuccessful();
        // the output of the command in the console
        $output = $commandTester->getDisplay();
    }
}
