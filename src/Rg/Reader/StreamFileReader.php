<?php
namespace Rg\Reader;

class StreamFileReader
{
    const CHUNK_SIZE = 1024;

    /**
     * @var resource
     */
    protected $fileResource;

    /**
     * @param resource $fileStreamResource
     */
    public function __construct($fileStreamResource)
    {
        stream_set_blocking($fileStreamResource, false);
        $this->fileResource = $fileStreamResource;
    }

    /**
     * @return bool|string
     */
    public function read()
    {
        $chunk = $this->readStreamChunk();

        if (empty($chunk)) {
            fclose($this->fileResource);
            return false;
        } else {
            return $chunk;
        }
    }

    /**
     * @return int
     */
    public function getFileSize()
    {
        return (int) fstat($this->fileResource)['size'];
    }

    /**
     * @return int
     */
    public function getReadIterations()
    {
        return (int) round($this->getFileSize() / static::CHUNK_SIZE);
    }

    /**
     * @return string
     */
    protected function readStreamChunk()
    {
        return trim(fgets($this->fileResource, static::CHUNK_SIZE));
    }
}
