<?php

namespace mesinhitung\phpcalculator\Commands;

use Illuminate\Console\Command;

class DivideCommand extends Command
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
            '%s {Numbers* : The numbers to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );
        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));
        parent::__construct($this);
    }

    protected function getCommandVerb(): string
    {
        return 'divide';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'divided';
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInput(): array
    {
        return $this->argument('Numbers');
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return '/';
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
        return $number1 / $number2;
    }
}
