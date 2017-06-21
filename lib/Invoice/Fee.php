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

namespace Trive\FiskalAPI\Invoice;

use XMLWriter;

class Fee
{
    /**
     * Fee name
     *
     * @var string
     */
    public $name;

    /**
     * Fee value
     *
     * @var string
     */
    public $value;

    /**
     * Fee constructor.
     *
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get fee name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get fee value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
        $writer->startElementNs($namespace, 'Naknada', null);
        $writer->writeElementNs($namespace, 'NazivN', null, $this->getName());
        $writer->writeElementNs($namespace, 'IznosN', null, $this->getValue());
        $writer->endElement();

        return $writer->outputMemory();
    }
}