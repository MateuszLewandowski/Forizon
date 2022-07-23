<?php

namespace App\Forizon\Parameters;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use InvalidArgumentException;

/**
 * @see https://laravel.com/docs/9.x/logging
 * @see https://datatracker.ietf.org/doc/html/rfc5424
 */
class Attribute {

    /**
     * @var string $uuid
     */
    public string $uuid;

    /**
     * @var mixed $type
     */
    public mixed $type;

    /**
     * @var mixed $value
     */
    public mixed $value;

    /**
     * @var array $history
     */
    public array $history;

    public function __construct(mixed $value) {
        $this->uuid = Str::uuid();
        $this->type = gettype($value);
        $this->value = $value;
    }

    /**
     * @param mixed $value
     * @return self
     * @throws InvalidArgumentException
     */
    public function update(mixed $value): self {
        if (gettype($value) !== $this->type) {
            $type = gettype($value);
            Log::critical("Invalid attribute type. New: $($type), correct: $($this->type)", 'attribute');
            throw new InvalidArgumentException('Invalid attribute type', Response::HTTP_BAD_REQUEST);
        }
        $this->preserveHistory();
        $this->value = $value;
        return $this;
    }

    /**
     * @return self
     */
    public function loadLastState(): self {
        if (count($this->history) < 1) {
            return $this;
        }
        $last_key = array_key_last($this->history);
        $this->value = $this->history[$last_key]['value'];
        unset($this->history[$last_key]);
        return $this;
    }

    /**
     * @return void
     */
    private function preserveHistory(): void {
        $this->history[] = [
            'value' => $this->value,
            'timestamp' => Carbon::now(),
        ];
        return;
    }
}
