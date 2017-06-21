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

class InvoiceNumber
{
    /**
     * Number note invoice
     *
     * @var string
     */
    public $invoiceNumber;

    /**
     * Note of business location
     *
     * @var string
     */
    public $businessLocationCode;

    /**
     * Note of exchange device
     *
     * @var string
     */
    public $paymentDeviceCode;

    /**
     * InvoiceNumber constructor.
     *
     * @param $invoiceNumber
     * @param $businessLocationCode
     * @param $paymentDeviceCode
     */
    public function __construct($invoiceNumber, $businessLocationCode, $paymentDeviceCode)
    {
        $this->invoiceNumber = $invoiceNumber;
        $this->businessLocationCode = $businessLocationCode;
        $this->paymentDeviceCode = $paymentDeviceCode;
    }

    /**
     * Get invoice number
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
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
     * Get payment device code
     *
     * @return string
     */
    public function getPaymentDeviceCode()
    {
        return $this->paymentDeviceCode;
    }

    /**
     * Get full invoice number
     *
     * @return string
     */
    public function getFullInvoiceNumber()
    {
        return sprintf(
            '%s/%s/%s',
            $this->getInvoiceNumber(),
            $this->getBusinessLocationCode(),
            $this->getPaymentDeviceCode()
        );
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
        $writer->startElementNs($namespace, 'BrRac', null);
        $writer->writeElementNs($namespace, 'BrOznRac', null, $this->getInvoiceNumber());
        $writer->writeElementNs($namespace, 'OznPosPr', null, $this->getBusinessLocationCode());
        $writer->writeElementNs($namespace, 'OznNapUr', null, $this->getPaymentDeviceCode());
        $writer->endElement();

        return $writer->outputMemory();
    }
}
