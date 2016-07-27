<?php

namespace Cerbero\Workflow\Console\Drawing;

use Cerbero\Workflow\Repositories\PipelineRepositoryInterface;

/**
 * Class to generate the drawing.
 *
 * @author	Andrea Marco Sartori
 */
class Drawer
{
    const BORDER_X = '║';

    const BORDER_Y = '═';

    const BORDER_NW = '╔';

    const BORDER_NE = '╗';

    const BORDER_SE = '╝';

    const BORDER_SW = '╚';

    const NOCK = '║';

    const PILE = '∇';

    const CROSSROADS = '╬';

    const CROSSROADS_UP = '╩';

    const CROSSROADS_DOWN = '╦';

    /**
     * @author	Andrea Marco Sartori
     *
     * @var Cerbero\Workflow\Repositories\PipelineRepositoryInterface $pipelines	Pipeline repository.
     */
    protected $pipelines;

    /**
     * @author	Andrea Marco Sartori
     *
     * @var Cerbero\Workflow\Console\Drawing\Geometry $geometry	The applied geometry.
     */
    protected $geometry;

    /**
     * @author	Andrea Marco Sartori
     *
     * @var array $pipes	List of pipes.
     */
    protected $pipes;

    /**
     * @author	Andrea Marco Sartori
     *
     * @var string $drawing	The resulting drawing.
     */
    protected $drawing = '';

    /**
     * Set the dependencies.
     *
     * @author	Andrea Marco Sartori
     *
     * @param Cerbero\Workflow\Repositories\PipelineRepositoryInterface $pipelines
     * @param Cerbero\Workflow\Console\Drawing\Geometry                 $geometry
     *
     * @return void
     */
    public function __construct(PipelineRepositoryInterface $pipelines, Geometry $geometry)
    {
        $this->pipelines = $pipelines;

        $this->geometry = $geometry;
    }

    /**
     * Draw the given workflow.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $workflow
     *
     * @return string
     */
    public function draw($workflow)
    {
        $this->geometry->setCore($workflow);

        $this->setPipesOfWorkflow($workflow);

        $this->drawCenteredChar(static::NOCK);

        $this->drawPipesBeginning();

        $this->drawCore();

        $this->drawPipesEnd();

        $this->drawCenteredChar(static::PILE);

        return $this->drawing;
    }

    /**
     * Set the pipes of the given workflow.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $workflow
     *
     * @return void
     */
    protected function setPipesOfWorkflow($workflow)
    {
        $pipes = $this->pipelines->getPipesByPipeline($workflow);

        $this->pipes = array_map(function ($pipe) {
            $chunks = explode('\\', $pipe);

            return end($chunks);
        }, $pipes);

        $this->geometry->setPipes($this->pipes);
    }

    /**
     * Draw a character in the middle of the drawing.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $character
     *
     * @return void
     */
    protected function drawCenteredChar($character)
    {
        $spaces = str_repeat(' ', $this->geometry->getHalfWidth());

        $this->drawRow($spaces.$character);
    }

    /**
     * Draw a row of the drawing.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $row
     *
     * @return void
     */
    protected function drawRow($row)
    {
        $this->drawing .= $row.PHP_EOL;
    }

    /**
     * Draw the beginning of all pipes.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    protected function drawPipesBeginning()
    {
        foreach ($this->pipes as $pipe) {
            $this->drawBorderTop();

            $this->drawBordered(
                $this->geometry->getSpacedPipe($pipe, static::NOCK, 'before()')
            );
        }
    }

    /**
     * Draw content wrapped by borders.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $content
     *
     * @return void
     */
    protected function drawBordered($content)
    {
        $left = $this->geometry->getLeftBordersWith(static::BORDER_X);

        $right = $this->geometry->getRightBordersWith(static::BORDER_X);

        $this->drawRow($left.$content.$right);
    }

    /**
     * Draw the top border.
     *
     * @author	Andrea Marco Sartori
     *
     * @param bool $isCore
     *
     * @return void
     */
    protected function drawBorderTop($isCore = false)
    {
        $crossroads = $isCore ? static::CROSSROADS_UP : static::CROSSROADS;

        $this->drawBorder(static::BORDER_NW, $crossroads, static::BORDER_NE);

        $this->geometry->increaseNesting();
    }

    /**
     * Draw a border with the given bendings.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $left
     * @param string $middle
     * @param string $right
     *
     * @return void
     */
    protected function drawBorder($left, $middle, $right)
    {
        $width = $this->geometry->getWidthButBorders();

        $border = str_repeat(static::BORDER_Y, $width);

        $this->replaceUtf8($border, $left, 0);
        $this->replaceUtf8($border, $middle, floor($width / 2));
        $this->replaceUtf8($border, $right, $width - 1);

        $this->drawBordered($border);
    }

    /**
     * Replace a character in a given position of a string.
     *
     * @author	Andrea Marco Sartori
     *
     * @param string $original
     * @param string $replacement
     * @param int    $position
     *
     * @return void
     */
    private function replaceUtf8(&$original, $replacement, $position)
    {
        $start = mb_substr($original, 0, $position, 'UTF-8');

        $end = mb_substr($original, $position + 1, mb_strlen($original, 'UTF-8'), 'UTF-8');

        $original = $start.$replacement.$end;
    }

    /**
     * Draw the core of the workflow.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    protected function drawCore()
    {
        $this->drawBorderTop(true);

        $this->drawBordered($this->geometry->getSpacedCore());

        $this->drawBorderBottom(true);
    }

    /**
     * Draw the bottom border.
     *
     * @author	Andrea Marco Sartori
     *
     * @param bool $isCore
     *
     * @return void
     */
    protected function drawBorderBottom($isCore = false)
    {
        $this->geometry->decreaseNesting();

        $crossroads = $isCore ? static::CROSSROADS_DOWN : static::CROSSROADS;

        $this->drawBorder(static::BORDER_SW, $crossroads, static::BORDER_SE);
    }

    /**
     * Draw the end of all pipes.
     *
     * @author	Andrea Marco Sartori
     *
     * @return void
     */
    protected function drawPipesEnd()
    {
        $pipes = array_reverse($this->pipes);

        foreach ($pipes as $pipe) {
            $this->drawBordered(
                $this->geometry->getSpacedPipe($pipe, static::NOCK, 'after()')
            );

            $this->drawBorderBottom();
        }
    }
}
