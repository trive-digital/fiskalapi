<?php
/**
 * Trive Fiskal API Library
 *
 * @category  Trive
 * @package   Trive_FiskalAPI
 * @author    Petar Sambolek <petar@trive.digital>
 * @copyright 2017 Trive d.o.o (http://trive.digital)
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link      http://trive.digital
 */

namespace Trive\FiskalAPI\Invoice;

use XMLWriter;

class TaxRate
{
    /**
     * Tax rate name
     *
     * @var string
     */
    public $name;

    /**
     * Tax rate rate
     *
     * @var string
     */
    public $rate;

    /**
     * Tax rate base value
     *
     * @var string
     */
    public $baseValue;

    /**
     * Tax rate value
     *
     * @var string
     */
    public $value;

    /**
     * TaxRate constructor.
     *
     * @param $rate
     * @param $baseValue
     * @param $value
     * @param $name
     */
    public function __construct($rate, $baseValue, $value, $name)
    {
        $this->name = $name;
        $this->rate = $this->formatPrice($rate);
        $this->baseValue = $this->formatPrice($baseValue);
        $this->value = $this->formatPrice($value);
    }

    /**
     * Format price for request
     *
     * @param $price
     *
     * @return string
     */
    public function formatPrice($price)
    {
        return number_format($price, 2, '.', '');
    }

    /**
     * Get tax rate name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get tax rate rate
     *
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Get tax rate base value
     *
     * @return string
     */
    public function getBaseValue()
    {
        return $this->baseValue;
    }

    /**
     * Get tax rate value
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
        $writer->startElementNs($namespace, 'Porez', null);
        if ($this->getName()) {
            $writer->writeElementNs($namespace, 'Naziv', null, $this->getName());
        }
        $writer->writeElementNs($namespace, 'Stopa', null, $this->getRate());
        $writer->writeElementNs($namespace, 'Osnovica', null, $this->getBaseValue());
        $writer->writeElementNs($namespace, 'Iznos', null, $this->getValue());
        $writer->endElement();

        return $writer->outputMemory();
    }
}
