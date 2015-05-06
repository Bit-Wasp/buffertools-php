<?php

namespace BitWasp\Buffertools\Tests;


use BitWasp\Buffertools\TemplateFactory;
use Mdanter\Ecc\EccFactory;

class TemplateFactoryTest extends BinaryTest
{
    /**
     * @return array
     */
    public function getTestVectors()
    {
        $vectors = [];

        for ($i = 8; $i <= 256; $i = $i * 2) {
            foreach (array('', 'le') as $byteOrder) {
                $vectors[] = [
                    'uint' . $i . $byteOrder,
                    '\BitWasp\Binary\Types\Uint' . $i,
                ];
            }
        }

        $vectors[] = [
            'varint',
            '\BitWasp\Binary\Types\VarInt'
        ];

        $vectors[] = [
            'varstring',
            '\BitWasp\Binary\Types\VarString'
        ];

        return $vectors;
    }

    /**
     * @dataProvider getTestVectors
     */
    public function testTemplateUint($function, $eClass)
    {
        $math = EccFactory::getAdapter();
        $factory = new TemplateFactory($math);
        $factory->$function();
        $template = $factory->getTemplate();
        $this->assertEquals(1, count($template));
        $template = $factory->getTemplate()->getItems();
        $this->assertInstanceOf($eClass, $template[0]);
    }

    public function testVector()
    {
        $math = EccFactory::getAdapter();
        $factory = new TemplateFactory($math);
        $factory->vector(
            function () {
                return; 
            }
        );
        $template = $factory->getTemplate();
        $this->assertEquals(1, count($template));
        $template = $factory->getTemplate()->getItems();
        $this->assertInstanceOf('BitWasp\Binary\Types\Vector', $template[0]);
    }
}