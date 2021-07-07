<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Dezer\FakeGeneratorDataTransferObject\Parameters\Exceptions\ParameterGeneratorInvalidArgumentException;
use Dezer\FakeGeneratorDataTransferObject\Traits\WithFaker;

class DockBlockGenerator implements ParameterGeneratorInterface
{
    use WithFaker;

    private const DOCKBLOCK_REGEX = "/@fakegenerator\s+([\w]+)\s*(?:\((?:(.*))\))*/ix";
    private string $typehint;
    private string $docBlock;
    private ?string $method;
    private array $arguments;

    public function __construct(string $typehint, string $docBlock)
    {
        $this->typehint = $typehint;
        $this->docBlock = $docBlock;

        $this->parseDoc();
    }

    private function parseDoc(): void
    {
        preg_match(
            self::DOCKBLOCK_REGEX,
            $this->docBlock,
            $matches
        );

        $this->method = trim($matches[1] ?? '') ?: null;
        $this->arguments = explode('", "', trim($matches[2] ?? '', '"'));
    }

    public function generate()
    {
        $value = call_user_func_array([$this->getFaker(), $this->method], $this->arguments);

        return $this->modifyByTypehint($value);
    }

    /**
     * @return mixed
     */
    private function modifyByTypehint($fakeValue)
    {
        switch ($this->typehint) {
            case 'int':
                $fakeValue = (int) $fakeValue;
                break;
            case 'string':
                $fakeValue = (string) $fakeValue;
                break;
            case 'bool':
                $fakeValue = (bool) $fakeValue;
                break;
        }

        return $fakeValue;
    }

    public function isPossible(): bool
    {
        return $this->method !== null;
    }

    public static function with(string $type, array $parameters): ParameterGeneratorInterface
    {
        if (!isset($parameters['doc_block'])) {
            throw new ParameterGeneratorInvalidArgumentException('Property doc_block not found.');
        }
        return new self($type, $parameters['doc_block']);
    }
}