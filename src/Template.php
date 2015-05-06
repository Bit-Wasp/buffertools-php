<?php

namespace BitWasp\Buffertools;


use BitWasp\Buffertools\Types\TypeInterface;

class Template implements \Countable
{
    /**
     * @var TypeInterface[]
     */
    private $template = [];

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * {@inheritdoc}
     * @see \Countable::count()
     * @return int
     */
    public function count()
    {
        return count($this->template);
    }

    /**
     * @return Types\TypeInterface[]
     */
    public function getItems()
    {
        return $this->template;
    }

    /**
     * @param TypeInterface $item
     * @return $this
     */
    public function addItem(TypeInterface $item)
    {
        $this->template[] = $item;
        return $this;
    }

    /**
     * @param Parser $parser
     * @return array
     */
    public function parse(Parser & $parser)
    {
        if (0 == count($this->template)) {
            throw new \RuntimeException('No items in template');
        }

        $values = [];
        foreach ($this->template as $reader) {
            $values[] = $reader->read($parser);
        }

        return $values;
    }

    /**
     * @param array $items
     * @return string
     */
    public function write(array $items)
    {
        if (count($items) != count($this->template)) {
            throw new \RuntimeException('Number of items must match template');
        }

        $binary = '';

        foreach ($this->template as $serializer) {
            $item = array_shift($items);
            $binary .= $serializer->write($item);
        }

        return $binary;
    }
}