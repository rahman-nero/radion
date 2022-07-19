<?php

declare(strict_types=1);

namespace Radion;

final class Db
{
    /**
     * @var string
    */
    private readonly string $path;

    /**
     * @var array|false
    */
    private array|false $content;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->parseDb();
    }

    /**
     * Getting value from db-file
     *
     * @param string $key
     * @return false|string|int
     */
    public function get(string $key): false|string|int
    {
        if (!$this->content || !array_key_exists($key, $this->content)) {
            return false;
        }

        return $this->content[$key];
    }

    /**
     * Writting data in db-file, OVERWRITING!
     *
     * Remove all content and writing data
     *
     * @param array $data
     * @return void
     * @throws \JsonException
     */
    public function write(array $data): void
    {
        $content = json_encode($data, \JSON_THROW_ON_ERROR);
        file_put_contents($this->path, $content);
    }

    /**
     * Append data in db-file
     *
     * Not removing content from file, just adding content
     *
     * @param array $data
     * @return void
     * @throws \JsonException
     */
    public function append(array $data)
    {
        $content = json_encode([...$this->content, ...$data], \JSON_THROW_ON_ERROR);
        file_put_contents($this->path, $content);
    }

    /**
     * Parsing db-file
     * @return void
     */
    private function parseDb(): void
    {
        if (!file_exists($this->path)) {
            $this->content = false;
            return;
        }

        $content = json_decode(file_get_contents($this->path));

        $this->content = (array) $content;
    }
}