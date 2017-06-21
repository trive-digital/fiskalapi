<?php
/**
 * Trive Fiskal API Library.
 *
 * @category  Trive
 * @package   Trive_FiskalAPI
 * @copyright 2017 Trive d.o.o (http://trive.digital)
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link      http://trive.digital
 */

namespace Trive\FiskalAPI\Request;

use Trive\FiskalAPI\Request;
use Trive\FiskalAPI\Test\Test;
use XMLWriter;

class TestRequest extends Request
{
    /**
     * TestRequest constructor.
     *
     * @param Test $test
     */
    public function __construct(Test $test)
    {
        $this->request = $test;
        $this->requestName = 'EchoRequest';
    }

    /**
     * Generate XML request body
     *
     * @return string
     */
    public function toXML()
    {
        $namespace = 'tns';
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->setIndent(true);
        $writer->setIndentString('    ');
        $writer->startElementNs($namespace, $this->requestName, 'http://www.apis-it.hr/fin/2012/types/f73');
        $writer->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $writer->writeAttribute(
            'xsi:schemaLocation',
            'http://www.apis-it.hr/fin/2012/types/f73 FiskalizacijaSchema.xsd'
        );
        $writer->writeRaw($this->request->toXML());
        $writer->endElement();

        return $writer->outputMemory();
    }
}
