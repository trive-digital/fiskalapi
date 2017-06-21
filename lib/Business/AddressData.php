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

class AddressData
{
    /**
     * Address
     *
     * @var Address
     */
    public $address;

    /**
     * Other type of business location
     *
     * @var string
     */
    public $otherTypeOfBusinessLocation;

    /**
     * Get address
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param Address $address
     *
     * @return $this
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get other type of business location
     *
     * @return string
     */
    public function getOtherTypeOfBusinessLocation()
    {
        return $this->otherTypeOfBusinessLocation;
    }

    /**
     * Set other type of business location
     *
     * @param $otherTypeOfBusinessLocation
     *
     * @return $this
     */
    public function setOtherTypeOfBusinessLocation($otherTypeOfBusinessLocation)
    {
        $this->otherTypeOfBusinessLocation = $otherTypeOfBusinessLocation;

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

        $writer->startElementNs($namespace, 'AdresniPodatak', null);
        if ($this->getAddress()) {
            $writer->writeRaw($this->getAddress()->toXML());
        }
        if ($this->getOtherTypeOfBusinessLocation()) {
            $writer->writeElementNs($namespace, 'OstaliTipoviPP', null, $this->getOtherTypeOfBusinessLocation());
        }
        $writer->endElement();

        return $writer->outputMemory();
    }
}
