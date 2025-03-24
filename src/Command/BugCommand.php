<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsCommand('serializer:bug')]
class BugCommand extends Command
{
	public function __construct(private readonly NormalizerInterface $serializer)
	{
		parent::__construct(null);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$class = new class
		{
			public string $camelCase = 'value';
		};

		assert(['camel_case' => 'value'] === $this->serializer->normalize($class, 'json'));
		assert(['camelCase' => 'value'] ===$this->serializer->normalize(['camelCase' => 'value'], 'json'));

		return self::SUCCESS;
	}
}