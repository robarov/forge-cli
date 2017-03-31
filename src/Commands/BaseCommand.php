<?php

namespace Sven\ForgeCLI\Commands;

use GuzzleHttp\Client;
use Sven\ForgeCLI\Config;
use Themsaid\Forge\Forge;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
{
    /**
     * @var bool
     */
    protected $disableApiKeyCheck = false;

    /**
     * @var Forge
     */
    protected $forge;

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return mixed
     */
    abstract public function perform(InputInterface $input, OutputInterface $output);

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->disableApiKeyCheck) {
            $this->perform($input, $output);

            return;
        }

        $key = (new Config)->get('key');

        $this->forge = new Forge($key, new Client);

        $this->perform($input, $output);
    }
}
