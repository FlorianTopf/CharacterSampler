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
     * @param resource $fileResource
     */
    public function __construct($fileResource)
    {
        stream_set_blocking($fileResource, false);
        $this->fileResource = $fileResource;
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
        return (int) floor($this->getFileSize() / static::CHUNK_SIZE);
    }

    /**
     * @return string
     */
    protected function readStreamChunk()
    {
        // problem here is that multi-byte chars might be chopped
        return fread($this->fileResource, static::CHUNK_SIZE);
    }
}
