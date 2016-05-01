<?php

namespace Cerbero\Workflow\Repositories;

use Cerbero\Workflow\Wrappers\YamlParserInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Pipeline repository using YAML.
 *
 * @author    Andrea Marco Sartori
 */
class YamlPipelineRepository implements PipelineRepositoryInterface
{
    /**
     * @author    Andrea Marco Sartori
     *
     * @var array $pipelines    Pipelines list.
     */
    protected $pipelines;

    /**
     * @author    Andrea Marco Sartori
     *
     * @var Cerbero\Workflow\Wrappers\YamlParserInterface $parser    YAML parser.
     */
    protected $parser;

    /**
     * @author    Andrea Marco Sartori
     *
     * @var Illuminate\Filesystem\Filesystem $files    Filesystem.
     */
    protected $files;

    /**
     * @author    Andrea Marco Sartori
     *
     * @var string $path    The workflows path.
     */
    protected $path;

    /**
     * Set the dependencies.
     *
     * @author    Andrea Marco Sartori
     *
     * @param Cerbero\Workflow\Wrappers\YamlParserInterface $parser
     * @param Illuminate\Filesystem\Filesystem              $files
     * @param string                                        $path
     *
     * @return void
     */
    public function __construct(YamlParserInterface $parser, Filesystem $files, $path)
    {
        $this->parser = $parser;

        $this->files = $files;

        $this->path = $path;

        $this->pipelines = $this->parseYaml();
    }

    /**
     * Parse the YAML file.
     *
     * @author    Andrea Marco Sartori
     *
     * @return array
     */
    private function parseYaml()
    {
        $file = $this->getSource();

        return (array) $this->parser->parse($file);
    }

    /**
     * Retrieve the source of the pipelines.
     *
     * @author    Andrea Marco Sartori
     *
     * @return string
     */
    public function getSource()
    {
        $path = rtrim($this->path, '/');

        return "{$path}/workflows.yml";
    }

    /**
     * Determine whether a given pipeline exists.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $pipeline
     *
     * @return bool
     */
    public function exists($pipeline)
    {
        $this->normalizePipeline($pipeline);

        return array_key_exists($pipeline, $this->pipelines);
    }

    /**
     * Normalize the name of the given pipeline.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $pipeline
     *
     * @return void
     */
    protected function normalizePipeline(&$pipeline)
    {
        $pipeline = ucfirst($pipeline);
    }

    /**
     * Retrieve the pipes of a given pipeline.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $pipeline
     *
     * @return array
     */
    public function getPipesByPipeline($pipeline)
    {
        $this->normalizePipeline($pipeline);

        return $this->pipelines[$pipeline];
    }

    /**
     * Create the pipelines storage.
     *
     * @author    Andrea Marco Sartori
     *
     * @return void
     */
    public function settle()
    {
        $this->files->makeDirectory($this->path, 0755, true, true);

        $this->files->put($this->getSource(), '');
    }

    /**
     * Store the given pipeline and its pipes.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $pipeline
     * @param array  $pipes
     *
     * @return void
     */
    public function store($pipeline, array $pipes)
    {
        $workflow = [$pipeline => $pipes];

        $yaml = $this->parser->dump($workflow);

        $this->files->append($this->getSource(), $yaml);
    }

    /**
     * Update the given pipeline and its pipes.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $pipeline
     * @param array  $attachments
     * @param array  $detachments
     *
     * @return void
     */
    public function update($pipeline, array $attachments, array $detachments)
    {
        $this->detach($this->pipelines[$pipeline], $detachments);

        $this->attach($this->pipelines[$pipeline], $attachments);

        $this->refreshPipelines();
    }

    /**
     * Detach pipes from a given pipeline.
     *
     * @author    Andrea Marco Sartori
     *
     * @param array $pipeline
     * @param array $pipes
     *
     * @return void
     */
    protected function detach(array &$pipeline, array $pipes)
    {
        $pipeline = array_diff($pipeline, $pipes);
    }

    /**
     * Attach pipes to a given pipeline.
     *
     * @author    Andrea Marco Sartori
     *
     * @param array $pipeline
     * @param array $pipes
     *
     * @return void
     */
    protected function attach(array &$pipeline, array $pipes)
    {
        $pipeline = array_merge($pipeline, $pipes);
    }

    /**
     * Refresh the pipelines source.
     *
     * @author    Andrea Marco Sartori
     *
     * @return void
     */
    protected function refreshPipelines()
    {
        $yaml = $this->parser->dump($this->pipelines);

        $this->files->put($this->getSource(), $yaml);
    }

    /**
     * Destroy a given pipeline.
     *
     * @author    Andrea Marco Sartori
     *
     * @param string $pipeline
     *
     * @return void
     */
    public function destroy($pipeline)
    {
        unset($this->pipelines[$pipeline]);

        $this->refreshPipelines();
    }
}
