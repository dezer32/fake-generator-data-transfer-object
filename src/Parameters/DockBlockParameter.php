<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Faker\Generator;

class DockBlockParameter extends AbstractParameter
{
    private const DOCKBLOCK_REGEX = "/@fakegenerator\s+([\w]+)\s*(?:\((?:(.*))\))*/ix";
    private string $docBlock;
    private string $typehint;
    private ?string $method;
    private array $arguments;

    /**
     */
    public function __construct(string $docBlock, string $typehint)
    {
        $this->docBlock = $docBlock;
        $this->typehint = $typehint;
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

    public function isPossible(): bool
    {
        return $this->method !== null;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    /**
     * @return mixed
     */
    public function getFakeValue(?Generator $faker = null)
    {
        $fakeValue = call_user_func_array([$this->getFaker($faker), $this->method], $this->arguments);
        return $this->modifyByTypehint($fakeValue);
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
}