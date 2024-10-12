<?php

namespace GeoffTech\LaravelNanoId;

use Hidehalo\Nanoid\Client;

trait HasNanoId
{
    protected static function bootHasNanoId(): void
    {
        static::creating(function (self $model) {
            $model->checkKey();
        });
    }

    public function checkKey(): void
    {
        if (!$this->{$this->getKeyName()}) {
            $this->{$this->getKeyName()} = $this->generateNanoId();
        }
    }

    /**
     * Generate a nanoid.
     */
    public function generateNanoId(): string
    {
        return $this->getNanoIdPrefix() . $this->newNanoId();
    }

    protected function newNanoId(): string
    {
        $client = new Client;

        if ($alphabet = $this->getNanoIdAlphabet()) {
            return $client->formattedId($alphabet, $this->getNanoIdLength());
        }

        return $client->generateId($this->getNanoIdLength(), Client::MODE_DYNAMIC);
    }

    protected function getNanoIdPrefix(): string
    {
        if (property_exists($this, 'nanoidPrefix')) {
            return $this->nanoidPrefix;
        }

        if (method_exists($this, 'nanoidPrefix')) {
            return $this->nanoidPrefix();
        }

        return '';
    }

    /**
     * Get the nanoid length.
     */
    protected function getNanoIdLength(): ?int
    {
        $nanoIdLength = null;

        if (property_exists($this, 'nanoidLength')) {
            $nanoIdLength = $this->nanoidLength;
        }

        if (method_exists($this, 'nanoidLength')) {
            $nanoIdLength = $this->nanoidLength();
        }

        if (is_array($nanoIdLength)) {
            return random_int($nanoIdLength[0], $nanoIdLength[1]);
        }

        return $nanoIdLength;
    }

    protected function getNanoIdAlphabet(): ?string
    {
        if (property_exists($this, 'nanoidAlphabet')) {
            return $this->nanoidAlphabet;
        }

        if (method_exists($this, 'nanoidAlphabet')) {
            return $this->nanoidAlphabet();
        }

        // don't use '-' or '_' - just clean characters
        return '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // return null;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
}
