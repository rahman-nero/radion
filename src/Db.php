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

    public function writeType($type): void
    {
        $content = json_encode(['type' => $type]);
        file_put_contents($this->path, $content);
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
            $this->content = false;
            return;
        }

        $content = json_decode(file_get_contents($this->path));

        $this->content = (array) $content;
    }

}