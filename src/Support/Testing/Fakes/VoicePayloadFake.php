<?php

namespace DefStudio\Telegraph\Support\Testing\Fakes;

use DefStudio\Telegraph\Concerns\FakesRequests;
use DefStudio\Telegraph\ScopedPayloads\VoicePayload;

class VoicePayloadFake extends VoicePayload
{
    use FakesRequests;

    public function caption(string $caption): static
    {
        $telegraph = clone $this;

        $telegraph->data['caption'] = $caption;

        return $telegraph;
    }

    public function duration(int $duration): static
    {
        $telegraph = clone $this;

        $telegraph->data['duration'] = $duration;

        return $telegraph;
    }
}
