<?php

namespace Soap\WorkflowStorage;

use Illuminate\Support\Arr;

class WorkflowData
{
    protected string $name;

    protected string $type;

    protected array $supports;

    protected array $marking_store = [];

    protected array $places = [];

    protected array $transitions = [];

    protected array $events_to_dispatch = [];

    public function __construct(string $name, ?string $type = 'workflow', ?array $supports = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->supports = $supports;
    }

    public function addPlace(string $name, bool $initial = false, array $metadata = []): void
    {
        $this->places = Arr::add($this->places, $name, $metadata);
    }

    public function addTransition(string $name, string|array $from, string|array $to, array $metadata = []): void
    {
        if (is_string($from)) {
            $from = [$from];
        }

        foreach ($from as $place) {
            $this->ensurePlaceExists($place);
        }

        if (is_string($to)) {
            $to = [$to];
        }

        foreach ($to as $place) {
            $this->ensurePlaceExists($place);
        }

        $this->transitions = Arr::add($this->transitions, $name, [
            'from' => $from,
            'to' => $to,
            'metadata' => $metadata,
        ]);
    }

    protected function ensurePlaceExists(string $place): void
    {
        if (! array_key_exists($place, $this->places)) {
        }
        $this->addPlace($place);

    }

    public function getPlaces(): array
    {
        return $this->places;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function toArray(): array
    {
        $workflow = [
            $this->name => [
                'type' => $this->type,
                'supports' => $this->supports,
                'marking_store' => $this->marking_store,
                'places' => $this->places,
                'transitions' => $this->transitions,
                'events_to_dispatch' => $this->events_to_dispatch,
            ],
        ];

        return $workflow;
    }
}
