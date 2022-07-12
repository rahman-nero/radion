<?php

declare(strict_types=1);

namespace Radion;

final class Db
{
    private readonly string $path;
    private array $content;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->parseDb();
    }


    public function getType(): string|false
    {
        if (!$this->content) {
            return false;
        }

        return $this->content['type'];
    }

    private function parseDb(): void
    {
        if (!file_exists($this->path)) {
            return;
        }

        $content = json_decode(file_get_contents($this->path));

        $this->content = $content;
    }

}