<?php

namespace mesinhitung\phpcalculator\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class PowCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;
    /**
     * @var string
     */
    protected $description;

    public function __construct()
    {

        $commandVerb = $this->getCommandVerb();

        $this->signature = sprintf(
            '%s {base : The base number}{exp : The exp number}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );
        $this->description = sprintf('Exponent the given number', ucfirst($commandVerb));
        parent::__construct($this);

    }

    protected function getCommandVerb(): string
    {
        return 'pow';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'number';
    }

    public function handle(): void
    {
        $numbers1 = (array) $this->getInputbase();
        $data = Arr::only($numbers1, ['base', 'exp']);
        $description = $this->generateCalculationDescription($data);
        $result = $this->calculateAll($data);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInputbase(): array
    {
        return $this->arguments();
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return '^';
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculates($this->calculateAll($numbers), $number);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculates($number1, $number2)
    {
        $data = pow($number1,$number2);
        return $data;
    }
}
