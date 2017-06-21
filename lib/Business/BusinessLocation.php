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

class BusinessLocation
{
    /**
     * Business location closing code
     *
     * @var string
     */
    const CLOSING_CODE_CLOSED = 'Z';

    /**
     * OIB
     *
     * @var string
     */
    public $oib;

    /**
     * Business location code
     *
     * @var string
     */
    public $businessLocationCode;

    /**
     * Business address data
     *
     * @var AddressData
     */
    public $addressData;

    /**
     * Business address business hours
     *
     * @var string
     */
    public $businessHours;

    /**
     * Business address date of usage
     *
     * @var string
     */
    public $dateOfUsage;

    /**
     * Business location closing code
     *
     * After business location is closed, invoices should not be send under the same
     * business location code.
     *
     * Z - code to send to close the business location
     *
     * @var null|string
     */
    public $closingCode = null;

    /**
     * Business address specific purpose
     *
     * @var string
     */
    public $specificPurpose;

    /**
     * Get address data
     *
     * @return AddressData
     */
    public function getAddressData()
    {
        return $this->addressData;
    }

    /**
     * Set address data
     *
     * @param $addressData
     *
     * @return $this
     */
    public function setAddressData($addressData)
    {
        $this->addressData = $addressData;

        return $this;
    }

    /**
     * Get business location date of usage
     *
     * @return string
     */
    public function getDateOfUsage()
    {
        return $this->dateOfUsage;
    }

    /**
     * Set business location date of usage
     *
     * @param $dateOfUsage
     *
     * @return $this
     */
    public function setDateOfUsage($dateOfUsage)
    {
        $this->dateOfUsage = $dateOfUsage;

        return $this;
    }

    /**
     * Get business location code
     *
     * @return string
     */
    public function getBusinessLocationCode()
    {
        return $this->businessLocationCode;
    }

    /**
     * Set business location code
     *
     * @param $businessLocationCode
     *
     * @return $this
     */
    public function setBusinessLocationCode($businessLocationCode)
    {
        $this->businessLocationCode = $businessLocationCode;

        return $this;
    }

    /**
     * Get OIB
     *
     * @return string
     */
    public function getOib()
    {
        return $this->oib;
    }

    /**
     * Set OIB
     *
     * @param $oib
     *
     * @return $this
     */
    public function setOib($oib)
    {
        $this->oib = $oib;

        return $this;
    }

    /**
     * Get closing code
     *
     * @return string
     */
    public function getClosingCode()
    {
        return $this->closingCode;
    }

    /**
     * Set closing code
     *
     * @param $closingCode
     *
     * @return $this
     */
    public function setClosingCode($closingCode)
    {
        $this->closingCode = $closingCode;

        return $this;
    }

    /**
     * Get specific purpose
     *
     * @return string
     */
    public function getSpecificPurpose()
    {
        return $this->specificPurpose;
    }

    /**
     * Set specific purpose
     *
     * @param $purpose
     *
     * @return $this
     */
    public function setSpecificPurpose($purpose)
    {
        $this->specificPurpose = $purpose;

        return $this;
    }

    /**
     * Get business hours
     *
     * @return string
     */
    public function getBusinessHours()
    {
        return $this->businessHours;
    }

    /**
     * Set business hours
     *
     * @param $businessHours
     *
     * @return $this
     */
    public function setBusinessHours($businessHours)
    {
        $this->businessHours = $businessHours;

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
        $writer->startElementNs($namespace, 'PoslovniProstor', null);
        $writer->writeElementNs($namespace, 'Oib', null, $this->getOib());
        $writer->writeElementNs($namespace, 'OznPoslProstora', null, $this->getBusinessLocationCode());
        if ($this->getAddressData()) {
            $writer->writeRaw($this->getAddressData()->toXML());
        }
        $writer->writeElementNs($namespace, 'RadnoVrijeme', null, $this->getBusinessHours());
        $writer->writeElementNs($namespace, 'DatumPocetkaPrimjene', null, $this->getDateOfUsage());
        if ($this->getClosingCode() != null) {
            $writer->writeElementNs($namespace, 'OznakaZatvaranja', null, $this->getClosingCode());
        }
        if ($this->getSpecificPurpose() != null) {
            $writer->writeElementNs($namespace, 'SpecNamj', null, $this->getSpecificPurpose());
        }
        $writer->endElement();

        return $writer->outputMemory();
    }

}
