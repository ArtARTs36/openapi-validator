<?php

namespace ArtARTs36\OpenApiValidator\Console;

use ArtARTs36\OpenApiValidator\Drivers\DriverFactory;
use ArtARTs36\OpenApiValidator\Drivers\SwaggerTools;
use ArtARTs36\OpenApiValidator\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ValidOpenApiCommand extends Command
{
    protected static $defaultName = 'openapi:valid';

    protected $rootPath;

    public function setRootPath(string $rootPath): self
    {
        $this->rootPath = $rootPath;

        return $this;
    }

    protected function configure()
    {
        $this
            ->addArgument('file')
            ->addOption('errors-max', null, InputOption::VALUE_OPTIONAL)
            ->addOption('warnings-max', null, InputOption::VALUE_OPTIONAL)
            ->addOption('driver', null, InputOption::VALUE_OPTIONAL, 'Driver', SwaggerTools::NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = (string) $input->getArgument('file');
        $errorsMax = (int) $input->getOption('errors-max');
        $warningsMax = (int) $input->getOption('warnings-max');

        $driver = (string) $input->getOption('driver');

        $info = (new Validator(DriverFactory::instance($driver)))->valid($this->path($file));

        if ($info->isValid($errorsMax, $warningsMax)) {
            return static::SUCCESS;
        }

        foreach ($info->errors() as $error) {
            $this->error($output, $error);
        }

        return static::FAILURE;
    }

    protected function path(string $path): string
    {
        if (! $this->rootPath) {
            return $path;
        }

        return $this->rootPath . DIRECTORY_SEPARATOR . $path;
    }

    protected function error(OutputInterface $output, string $error): void
    {
        $output->writeln('<error>'. $error .'</error>');
    }
}
