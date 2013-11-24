<?php

namespace Starmind\Pygments;

use Starmind\Pygments\Exception\CommandException;

/**
 * Wrapper for the pygmentize cli
 */
class Pygmentize
{
    protected $pygmentize;

    /**
     * @param string $pygmentize
     * @throws \InvalidArgumentException
     */
    public function __construct($pygmentize = '/usr/bin/pygmentize')
    {
        if (! file_exists($pygmentize)) {
            throw new \InvalidArgumentException(sprintf('pygmentize could not be found in %s', $pygmentize));
        }
        
        $this->pygmentize = $pygmentize;
    }

    /**
     * @param $command
     * @param int $expectedReturnValue
     * @return array
     * @throws CommandException
     */
    public function executeCommand($command, $expectedReturnValue = 0)
    {
        $command = sprintf('%s %s', $this->pygmentize, $command);

        $output = $this->exec($command, $expectedReturnValue);

        return join("\n", $output);
    }

    /**
     * @param $command
     * @param $expectedReturnValue
     * @return mixxed
     * @throws Exception\CommandException
     */
    protected function exec($command, $expectedReturnValue)
    {
        $output = null;
        $retVal = -1;
        
        exec($command, $output, $retVal);

        if ($retVal != $expectedReturnValue) {
            throw new CommandException(sprintf(
                'Error executing "%s". Return code %d', $command, $retVal
            ));
        }
        
        return $output;
    }
}
