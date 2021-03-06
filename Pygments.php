<?php

namespace Starmind\Pygments;

class Pygments
{
    protected $pygmentize;
    protected $formatter;

    /**
     * @param Pygmentize $pygmentize
     */
    public function __construct(Pygmentize $pygmentize)
    {
        $this->pygmentize = $pygmentize;
    }

    /**
     * @param $input
     * @param null $lexer
     * @param Formatter $formatter
     * @return mixed
     */
    public function highlight($input, $lexer, Formatter $formatter)
    {
        // set formatter
        $this->formatter = $formatter;
        
        if (is_file($input)) {
            $outputString = $this->highlightFile($input, $lexer);
        } else {
            $tmpFile = tempnam("/tmp", "pygmentize_");

            $this->createTempFile($tmpFile, $input);

            $outputString = $this->highlightFile($tmpFile, $lexer);

            $this->removeTempFile($tmpFile);
        }
        
        return $outputString;
    }

    /**
     * @param $file
     * @param $lexer
     * @return string
     * @throws \RuntimeException
     */
    protected function highlightFile($file, $lexer)
    {
        if (! file_exists($file)) {
            throw new \RuntimeException(sprintf('File %s does not exist.', $file));
        }
        
        try {
            $outputString = $this->pygmentize->executeCommand($this->getHighlightCommand($lexer, $file));
        } catch (\RuntimeException $e) {
            $outputString = $e->getMessage();
        }
        
        return $outputString;
    }

    /**
     * @param $lexer
     * @param $input
     * @return string
     */
    protected function getHighlightCommand($lexer, $input)
    {
        // if a lexer is given use it, otherwise guess language
        $lexer = $lexer ? '-l ' . $lexer : '-g';

        return sprintf(
            '%s %s %s',
            $this->formatter->getCliParameters(), $lexer, $input
        );
    }

    /**
     * @param $filename
     * @param $content
     * @throws \RuntimeException
     */
    protected function createTempFile($filename, $content)
    {
        $fh = fopen($filename, "w");
        
        if ($fh !== false) {
            fwrite($fh, $content);
            fclose($fh);
            chmod($filename, 0777);
        } else {
            throw new \RuntimeException(sprintf('Could not write %s', $filename));
        }
    }

    /**
     * @param $filename
     */
    protected function removeTempFile($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}
