<?php

declare(strict_types=1);

namespace Radion;

final class Db
{
    private readonly string $path;
    private array|false $content;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->parseDb();
    }

    public function get(string $key): false|string|int
    {
        if (!$this->content || !array_key_exists($key, $this->content)) {
            return false;
        }

        return $this->content[$key];
    }

    public function write(array $data): void
    {
        $content = json_encode($data, \JSON_THROW_ON_ERROR);
        file_put_contents($this->path, $content);
    }

    public function append(array $data)
    {
        $content = json_encode([...$this->content, ...$data], \JSON_THROW_ON_ERROR);
        file_put_contents($this->path, $content);
    }

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