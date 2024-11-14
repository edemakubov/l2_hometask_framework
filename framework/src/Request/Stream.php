<?php
declare(strict_types=1);

namespace Src\Request;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    private $stream;
    private $size;
    private $isSeekable;
    private $isReadable;
    private $isWritable;

    public function __construct(string $stream='php://input', string $mode = 'r')
    {
        $this->stream = fopen($stream, $mode);
        $meta = stream_get_meta_data($this->stream);
        $this->isSeekable = $meta['seekable'];
        $this->isReadable = str_contains($meta['mode'], 'r');
        $this->isWritable = str_contains($meta['mode'], 'w') || str_contains($meta['mode'], 'x') || str_contains($meta['mode'], 'c') || str_contains($meta['mode'], 'a');
    }

    public function __toString(): string
    {
        if ($this->stream === null) {
            return '';
        }
        $this->seek(0);
        return $this->getContents();
    }

    public function close(): void
    {
        if ($this->stream !== null) {
            fclose($this->stream);
            $this->stream = null;
        }
    }

    public function detach()
    {
        if ($this->stream === null) {
            return null;
        }
        $result = $this->stream;
        $this->stream = null;
        return $result;
    }

    public function getSize(): ?int
    {
        if ($this->size !== null) {
            return $this->size;
        }
        if ($this->stream === null) {
            return null;
        }
        $stats = fstat($this->stream);
        $this->size = $stats['size'] ?? null;
        return $this->size;
    }

    public function tell(): int
    {
        if ($this->stream === null) {
            throw new \RuntimeException('No resource available; cannot tell position');
        }
        $result = ftell($this->stream);
        if ($result === false) {
            throw new \RuntimeException('Unable to determine stream position');
        }
        return $result;
    }

    public function eof(): bool
    {
        return $this->stream === null || feof($this->stream);
    }

    public function isSeekable(): bool
    {
        return $this->isSeekable;
    }

    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        if (!$this->isSeekable()) {
            throw new \RuntimeException('Stream is not seekable');
        }
        if (fseek($this->stream, $offset, $whence) === -1) {
            throw new \RuntimeException('Unable to seek to stream position');
        }
    }

    public function rewind(): void
    {
        $this->seek(0);
    }

    public function isWritable(): bool
    {
        return $this->isWritable;
    }

    public function write(string $string): int
    {
        if (!$this->isWritable()) {
            throw new \RuntimeException('Stream is not writable');
        }
        $result = fwrite($this->stream, $string);
        if ($result === false) {
            throw new \RuntimeException('Unable to write to stream');
        }
        return $result;
    }

    public function isReadable(): bool
    {
        return $this->isReadable;
    }

    public function read(int $length): string
    {
        if (!$this->isReadable()) {
            throw new \RuntimeException('Stream is not readable');
        }
        $result = fread($this->stream, $length);
        if ($result === false) {
            throw new \RuntimeException('Unable to read from stream');
        }
        return $result;
    }

    public function getContents(): string
    {
        if ($this->stream === null) {
            throw new \RuntimeException('No resource available; cannot get contents');
        }
        $contents = stream_get_contents($this->stream);
        if ($contents === false) {
            throw new \RuntimeException('Unable to read stream contents');
        }
        return $contents;
    }

    public function getMetadata(?string $key = null)
    {
        if ($this->stream === null) {
            return $key === null ? [] : null;
        }
        $meta = stream_get_meta_data($this->stream);
        if ($key === null) {
            return $meta;
        }
        return $meta[$key] ?? null;
    }
}