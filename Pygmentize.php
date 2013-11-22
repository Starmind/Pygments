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
        $exists = file_exists($pygmentize);
        if (! $exists || ($exists && ! is_executable($pygmentize))) {
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
        $output = array();
        $retVal = -1;
        
        $command = sprintf('%s %s', $this->pygmentize, $command);

        exec($command, $output, $retVal);

        if ($retVal != $expectedReturnValue) {
            throw new CommandException(sprintf(
                'Error executing "%s". Return code %d', $command, $retVal
            ));
        }

        return join("\n", $output);
    }
}
