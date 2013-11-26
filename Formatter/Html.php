<?php

namespace Starmind\Pygments\Formatter;

use Starmind\Pygments\Exception\CommandException;
use Starmind\Pygments\Formatter;
use Starmind\Pygments\Pygmentize;

/**
 * @see http://pygments.org/docs/formatters/#htmlformatter
 */
class Html extends Formatter
{
    protected $format = 'html';

    protected $cssClass;
    protected $style;
    protected $linenos;

    /**
     * @param string $style
     * @param string $linenos
     * @param string $cssClass
     */
    public function __construct($style = 'default', $linenos = '1', $cssClass = 'highlight')
    {
        $this->style = $style;
        $this->linenos = $linenos;
        $this->cssClass = $cssClass;
    }

    /**
     * @return string
     */
    public function getCliParameters()
    {
        return sprintf(
            '-f %s %s',
            $this->format, $this->getExtraOptionsString()
        );
    }

    /**
     * @return string
     */
    protected function getExtraOptionsString()
    {
        $options = array();
        $options['style'] = $this->style;
        $options['cssclass'] = $this->cssClass;

        if (! is_null($this->linenos)) {
            $options['linenos'] = $this->linenos;
        }

        return $this->buildExtraOptionsString($options);
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param Pygmentize $pygmentize
     * @param bool $includeStyleTags
     * @return string
     */
    public function generateStyles(Pygmentize $pygmentize, $includeStyleTags = false)
    {
        $command = $this->getStylesCommand();
        
        try {
            $styles = $pygmentize->executeCommand($command);
            
            if ($includeStyleTags) {
                return sprintf("<style>\n%s\n</style>", $styles);
            }

            return $styles;
        } catch (CommandException $e) {
            return '/* Could not generate Styles */';
        }
    }

    /**
     * @return string
     */
    protected function getStylesCommand()
    {
        return sprintf(
            '-f %s -S %s -a .%s',
            $this->format, $this->style, $this->cssClass
        );
    }
}
