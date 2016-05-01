<?php

namespace Cerbero\Workflow\Console\Drawing;

/**
 * Geometry applied to the drawing.
 *
 * @author	Andrea Marco Sartori
 */
class Geometry
{
    const BORDER_WIDTH = 1;

    const MIN_SPACE_FROM_BORDER_X = 1;

    const MIN_SPACE_FROM_BORDER_Y = 0;

    const ARROW_WIDTH = 1;

    const MIN_PIPE_LENGTH = 8;

    const SPACE_FROM_ARROW = 1;

    /**
     * @author	Andrea Marco Sartori
     *
     * @var string $core	The name of the core.
     */
    protected $core;

    /**
     * @author	Andrea Marco Sartori
     *
     * @var array $pipes	List of pipes.
     */
    protected $pipes;

    /**
     * @author	Andrea Marco Sartori
     *
     * @var int $nesting	Nesting level.
     */
    protected $nesting = 0;

    /**
     * Set the name of the core.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $core
     *
     * @return void
     */
    public function setCore($core)
    {
        $this->core = $core;
    }

    /**
     * Set the pipes.
     *
     * @author	Andrea Marco Sartori
     *
     * @param array $pipes
     *
     * @return void
     */
    public function setPipes(array $pipes)
    {
        $this->pipes = $pipes;
    }

    /**
     * Calculate the half width of the drawing.
     *
     * @author	Andrea Marco Sartori
     *
     * @param bool $up
     *
     * @return int
     */
    public function getHalfWidth($up = false)
    {
        $number = $this->getTotalWidth();

        return $this->roundHalf($number, $up);
    }

    /**
     * Round the half of a number, either up or down.
     *
     * @author	Andrea Marco Sartori
     *
     * @param int  $number
     * @param bool $up
     *
     * @return int
     */
    private function roundHalf($number, $up)
    {
        $round = $up ? 'ceil' : 'floor';

        return $round($number / 2);
    }

    /**
     * Calculate the total width of the drawing.
     *
     * @author	Andrea Marco Sartori
     *
     * @return int
     */
    protected function getTotalWidth()
    {
        $borders = (static::BORDER_WIDTH + static::MIN_SPACE_FROM_BORDER_X) * 2;

        if (empty($this->pipes)) {
            return $borders + $this->getCoreLength();
        }

        $borders *= count($this->pipes);

        $name = ($this->getLongestPipeLength() + static::SPACE_FROM_ARROW) * 2;

        return $borders + $name + static::ARROW_WIDTH;
    }

    /**
     * Calculate the length of the core name.
     *
     * @author	Andrea Marco Sartori
     *
     * @return int
     */
    protected function getCoreLength()
    {
        return strlen($this->core);
    }

    /**
     * Calculate the length of the longest pipe name.
     *
     * @author	Andrea Marco Sartori
     *
     * @return int
     */
    protected function getLongestPipeLength()
    {
        if (empty($this->pipes)) {
            return 0;
        }

        return array_reduce($this->pipes, function ($carry, $pipe) {
            return strlen($pipe) > $carry ? strlen($pipe) : $carry;

        }, static::MIN_PIPE_LENGTH);
    }

    /**
     * Retrieve the spaced pipe and method pair.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $pipe
     * @param string $arrow
     * @param string $method
     *
     * @return string
     */
    public function getSpacedPipe($pipe, $arrow, $method)
    {
        $left = $this->getSpacesByWord($pipe);

        $arrow = $this->addSpacesToArrow($arrow);

        $right = $this->getSpacesByWord($method);

        return $left.$pipe.$arrow.$method.$right;
    }

    /**
     * Retrieve the blank spaces close to a word.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $word
     *
     * @return string
     */
    protected function getSpacesByWord($word)
    {
        $length = $this->getSideBordersLength() + static::SPACE_FROM_ARROW + static::ARROW_WIDTH;

        $extra = $this->getHalfWidth(true) - $length - strlen($word);

        return $extra > 0 ? str_repeat(' ', $extra) : '';
    }

    /**
     * Retrieve the length of the borders of a side.
     *
     * @author	Andrea Marco Sartori
     *
     * @return int
     */
    protected function getSideBordersLength()
    {
        $border = (static::BORDER_WIDTH + static::MIN_SPACE_FROM_BORDER_X);

        return $border * $this->nesting;
    }

    /**
     * Add spaces around the given arrow.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $arrow
     *
     * @return string
     */
    protected function addSpacesToArrow($arrow)
    {
        $spaces = str_repeat(' ', static::SPACE_FROM_ARROW);

        return "{$spaces}{$arrow}{$spaces}";
    }

    /**
     * Retrieve the left borders formatted with the given border.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $border
     *
     * @return string
     */
    public function getLeftBordersWith($border)
    {
        $border = str_repeat($border, static::BORDER_WIDTH);

        $space = str_repeat(' ', static::MIN_SPACE_FROM_BORDER_X);

        return str_repeat("{$border}{$space}", $this->nesting);
    }

    /**
     * Retrieve the right borders formatted with the given border.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $border
     *
     * @return string
     */
    public function getRightBordersWith($border)
    {
        $space = str_repeat(' ', static::MIN_SPACE_FROM_BORDER_X);

        $border = str_repeat($border, static::BORDER_WIDTH);

        return str_repeat("{$space}{$border}", $this->nesting);
    }

    /**
     * Increase the nesting level.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function increaseNesting()
    {
        $this->nesting++;
    }

    /**
     * Calculate the width of the drawing without the borders.
     *
     * @author	Andrea Marco Sartori
     *
     * @return int
     */
    public function getWidthButBorders()
    {
        return $this->getTotalWidth() - $this->getBordersLength();
    }

    /**
     * Calculate the length of the borders.
     *
     * @author	Andrea Marco Sartori
     *
     * @return int
     */
    protected function getBordersLength()
    {
        return $this->getSideBordersLength() * 2;
    }

    /**
     * Retrieve the spaced core name.
     *
     * @author	Andrea Marco Sartori
     *
     * @return string
     */
    public function getSpacedCore()
    {
        $left = $this->getSpacesByCore();

        $right = $this->getSpacesByCore(true);

        return $left.$this->core.$right;
    }

    /**
     * Retrieve the blank spaces close to the core.
     *
     * @author	Andrea Marco Sartori
     *
     * @param bool $up
     *
     * @return string
     */
    protected function getSpacesByCore($up = false)
    {
        $free = $this->getTotalWidth() - $this->getBordersLength() - $this->getCoreLength();

        return $free < 1 ? '' : str_repeat(' ', $this->roundHalf($free, $up));
    }

    /**
     * Decrease the nesting level.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    public function decreaseNesting()
    {
        $this->nesting--;
    }
}
