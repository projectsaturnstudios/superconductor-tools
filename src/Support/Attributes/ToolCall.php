<?php

namespace Superconductor\Capabilities\Tools\Support\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ToolCall
{
    public function __construct(
        public readonly string $tool,
        public readonly string $description,
        public readonly array $input_schema = [],
        public readonly ?string $name = null,
    ) {}

    public function toDefinition() : array
    {
        return [
            'name' => $this->tool,
            'title' => $this->name ?? $this->tool,
            'description' => $this->description,
            'inputSchema' => $this->input_schema,
        ];
    }

    public function toValue() : array
    {
        $results = [
            'name' => $this->tool,
            'description' => $this->description,
        ];

        if (!empty($this->input_schema)) {
            $results['input_schema'] = $this->input_schema;
        }

        if (!empty($this->name)) {
            $results['nickname'] = $this->name;
        }

        return $results;
    }

    public function toArray() : array
    {
        return [
            'tool' => $this->tool,
            'description' => $this->description,
            'input_schema' => $this->input_schema,
            'name' => $this->name,
        ];
    }
}
