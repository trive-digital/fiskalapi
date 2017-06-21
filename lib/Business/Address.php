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

namespace Trive\FiskalAPI\Business;

use XMLWriter;

class Address
{
    /**
     * Street
     *
     * @var string
     */
    public $street;

    /**
     * House number
     *
     * @var string
     */
    public $houseNumber;

    /**
     * House number suffix
     *
     * @var string
     */
    public $houseNumberSuffix;

    /**
     * Zip code
     *
     * @var string
     */
    public $zipCode;

    /**
     * Settlement
     *
     * @var string
     */
    public $settlement;

    /**
     * City
     *
     * @var string
     */
    public $city;

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set street
     *
     * @param $street
     *
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get house number
     *
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set house number
     *
     * @param $houseNumber
     *
     * @return $this
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get extra house number
     *
     * @return string
     */
    public function getHouseNumberSuffix()
    {
        return $this->houseNumberSuffix;
    }

    /**
     * Set house number suffix
     *
     * @param $houseNumberSuffix
     *
     * @return $this
     */
    public function setHouseNumberSuffix($houseNumberSuffix)
    {
        $this->houseNumberSuffix = $houseNumberSuffix;

        return $this;
    }

    /**
     * Get zip code
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set zip code
     *
     * @param $zipCode
     *
     * @return $this
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get settlement
     *
     * @return string
     */
    public function getSettlement()
    {
        return $this->settlement;
    }

    /**
     * Set settlement (naselje)
     *
     * @param $settlement
     *
     * @return $this
     */
    public function setSettlement($settlement)
    {
        $this->settlement = $settlement;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
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
        $writer->startElementNs($namespace, 'Adresa', null);
        $writer->writeElementNs($namespace, 'Ulica', null, $this->getStreet());
        if ($this->getHouseNumber() != null) {
            $writer->writeElementNs($namespace, 'KucniBroj', null, $this->getHouseNumber());
        }
        if ($this->getHouseNumberSuffix() != null) {
            $writer->writeElementNs($namespace, 'KucniBrojDodatak', null, $this->getHouseNumberSuffix());
        }
        $writer->writeElementNs($namespace, 'BrojPoste', null, $this->getZipCode());
        $writer->writeElementNs($namespace, 'Naselje', null, $this->getSettlement());
        $writer->writeElementNs($namespace, 'Opcina', null, $this->getCity());
        $writer->endElement();

        return $writer->outputMemory();
    }
}
