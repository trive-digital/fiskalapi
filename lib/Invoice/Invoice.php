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

class Invoice
{
    /**
     * G – cash
     * K – credit card
     * C – check/money order
     * T – bank transfer
     * O – other
     */
    const PAYMENT_TYPE_CASH = 'G';

    const PAYMENT_TYPE_CC = 'K';

    const PAYMENT_TYPE_CHECKMO = 'C';

    const PAYMENT_TYPE_BANK_TRANSFER = 'T';

    const PAYMENT_TYPE_OTHER = 'O';

    const TAX_TYPE_PDV = 1;

    const TAX_TYPE_PNP = 2;

    const TAX_TYPE_OTHER = 3;

    const TAX_TYPE_MARGIN = 4;

    /**
     * OIB
     *
     * @var string
     */
    public $oib;

    /**
     * Register for PDV
     *
     * @var bool
     */
    public $registeredForPdv;

    /**
     * Datetime of request
     *
     * @var string
     */
    public $dateTime;

    /**
     * Increment type
     *
     * N - on level of payment device
     * P - on level of business location
     *
     * @var string
     */
    public $incrementType = 'P';

    /**
     * Invoice number
     *
     * @var InvoiceNumber
     */
    public $invoiceNumber;

    /**
     * Array of PDV taxes
     *
     * @var array
     */
    public $pdvTaxes;

    /**
     * Array of PNP taxes
     *
     * @var array
     */
    public $pnpTaxes;

    /**
     * Array of other taxes
     *
     * @var array
     */
    public $otherTaxes;

    /**
     * Tax free value
     *
     * @var float
     */
    public $taxFreeValue;

    /**
     * Margin tax value
     *
     * @var float
     */
    public $marginTaxValue;

    /**
     * Tax exempt value
     *
     * @var float
     */
    public $taxExemptValue;

    /**
     * Array of fees
     *
     * @var array
     */
    public $fees;

    /**
     * Total value
     *
     * @var float
     */
    public $totalValue;

    /**
     * Payment type
     *
     * G – cash
     * K – credit card
     * C – check/money order
     * T – bank transfer
     * O – other
     * In case of multiple payment types on same invoice, use 'Other'
     * For all payment types that are not supplied, use 'Other'
     *
     * @var string
     */
    public $paymentType;

    /**
     * OIB of operator on payment device that created the invoice
     *
     * In case of self-served payment devices, use store OIB (oib on the invoice)
     *
     * @var string
     */
    public $operatorOib;

    /**
     * Security code
     *
     * @var string
     */
    public $securityCode;

    /**
     * Send resend flag
     *
     * Resend flag is only sent if the invoice was previously created and sent to
     * customer without JIR (e.g. internet connection issues or issues with
     * payment device)
     *
     * @var bool
     */
    public $resendFlag = false;

    /**
     * Paragon invoice number
     *
     * Used only in case of fatal errors on payment device, when VAT-registered
     * entity has to manually enter and deliver invoices
     *
     * @var string
     */
    public $paragonInvoiceNumber;

    /**
     * Specific purpose
     *
     * @var string
     */
    public $specificPurpose;

    /**
     * Certificate private key
     *
     * @var string
     */
    public $certPrivateKey;

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
     * Get Registered for PDV flag
     *
     * @return string
     */
    public function getRegisteredForPdv()
    {
        return $this->registeredForPdv;
    }

    /**
     * Set Registered for PDV flag
     *
     * @param $registeredForPdv
     *
     * @return $this
     */
    public function setRegisteredForPdv($registeredForPdv)
    {
        $this->registeredForPdv = $registeredForPdv;

        return $this;
    }

    /**
     * Get date/time
     *
     * @return string
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Set date/time
     *
     * @param $dateTime
     *
     * @return $this
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get note of order
     *
     * @return string
     */
    public function getIncrementType()
    {
        return $this->incrementType;
    }

    /**
     * Set increment type
     *
     * @param $incrementType
     *
     * @return $this
     */
    public function setIncrementType($incrementType)
    {
        $this->incrementType = $incrementType;

        return $this;
    }

    /**
     * Get invoice number
     *
     * @return InvoiceNumber
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Set invoice number
     *
     * @param $invoiceNumber
     *
     * @return $this
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get list of PDV taxes
     *
     * @return array
     */
    public function getPdvTaxes()
    {
        return $this->pdvTaxes;
    }

    /**
     * Set list of PDV taxes
     *
     * @param $pdvTaxes
     *
     * @return $this
     */
    public function setPdvTaxes($pdvTaxes)
    {
        $this->pdvTaxes = $pdvTaxes;

        return $this;
    }

    /**
     * Get list of PNP taxes
     *
     * @return array
     */
    public function getPnpTaxes()
    {
        return $this->pnpTaxes;
    }

    /**
     * Set list of PNP taxes
     *
     * @param $pnpTaxes
     *
     * @return $this
     */
    public function setPnpTaxes($pnpTaxes)
    {
        $this->pnpTaxes = $pnpTaxes;

        return $this;
    }

    /**
     * Get list of other taxes
     *
     * @return array
     */
    public function getOtherTaxes()
    {
        return $this->otherTaxes;
    }

    /**
     * Set list of other taxes
     *
     * @param $otherTaxes
     *
     * @return $this
     */
    public function setOtherTaxes($otherTaxes)
    {
        $this->otherTaxes = $otherTaxes;

        return $this;
    }

    /**
     * Get tax-free value
     *
     * @return string
     */
    public function getTaxFreeValue()
    {
        return $this->taxFreeValue;
    }

    /**
     * Set tax-free value
     *
     * @param $taxFreeValue
     *
     * @return $this
     */
    public function setTaxFreeValue($taxFreeValue)
    {
        $this->taxFreeValue = $this->formatPrice($taxFreeValue);

        return $this;
    }

    /**
     * Get margin tax value
     *
     * @return string
     */
    public function getMarginTaxValue()
    {
        return $this->marginTaxValue;
    }

    /**
     * Set margin for tax rate
     *
     * @param $marginTaxValue
     *
     * @return $this
     */
    public function setMarginTaxValue($marginTaxValue)
    {
        $this->marginTaxValue = $this->formatPrice($marginTaxValue);

        return $this;
    }

    /**
     * Get tax exempt value
     *
     * @return string
     */
    public function getTaxExemptValue()
    {
        return $this->taxExemptValue;
    }

    /**
     * Set tax free value
     *
     * @param $taxExemptValue
     *
     * @return $this
     */
    public function setTaxExemptValue($taxExemptValue)
    {
        $this->taxExemptValue = $this->formatPrice($taxExemptValue);

        return $this;
    }

    /**
     * Get list of fees
     *
     * @return array
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * Set list of fees
     *
     * @param $fees
     *
     * @return $this
     */
    public function setFees($fees)
    {
        $this->fees = $fees;

        return $this;
    }

    /**
     * Get total value
     *
     * @return string
     */
    public function getTotalValue()
    {
        return $this->totalValue;
    }

    /**
     * Set total value
     *
     * @param $totalValue
     *
     * @return $this
     */
    public function setTotalValue($totalValue)
    {
        $this->totalValue = $this->formatPrice($totalValue);

        return $this;
    }

    /**
     * Get payment type
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set payment type
     *
     * @param $paymentType
     *
     * @return $this
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get operator OIB
     *
     * @return string
     */
    public function getOperatorOib()
    {
        return $this->operatorOib;
    }

    /**
     * Set operator OIB
     *
     * @param $operatorOib
     *
     * @return $this
     */
    public function setOperatorOib($operatorOib)
    {
        $this->operatorOib = $operatorOib;

        return $this;
    }

    /**
     * Get security code
     *
     * @return string
     */
    public function getSecurityCode()
    {
        if (!$this->securityCode) {
            $this->generateSecurityCode();
        }

        return $this->securityCode;
    }

    /**
     * Set security code
     *
     * @param $securityCode
     *
     * @return $this
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

        return $this;
    }

    /**
     * Get resend flag
     *
     * @return string
     */
    public function getResendFlag()
    {
        return $this->resendFlag;
    }

    /**
     * Set resend flag
     *
     * @param $resendFlag
     *
     * @return $this
     */
    public function setResendFlag($resendFlag)
    {
        $this->resendFlag = $resendFlag;

        return $this;
    }

    /**
     * Get paragon invoice number
     *
     * @return string
     */
    public function getParagonInvoiceNumber()
    {
        return $this->paragonInvoiceNumber;
    }

    /**
     * Set paragon invoice number
     *
     * @param $paragonInvoiceNumber
     *
     * @return $this
     */
    public function setParagonInvoiceNumber($paragonInvoiceNumber)
    {
        $this->paragonInvoiceNumber = $paragonInvoiceNumber;

        return $this;
    }

    /**
     * Set specific purpose
     *
     * @param $specificPurpose
     *
     * @return $this
     */
    public function setSpecificPurpose($specificPurpose)
    {
        $this->specificPurpose = $specificPurpose;

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
     * Get certificate private key
     *
     * @return string
     */
    public function getCertificatePrivateKey()
    {
        return $this->certPrivateKey;
    }

    /**
     * Set certificate private key
     *
     * @param $certPrivateKey
     *
     * @return $this
     */
    public function setCertificatePrivateKey($certPrivateKey)
    {
        $this->certPrivateKey = $certPrivateKey;

        return $this;
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
     * Generate security code
     *
     * @return string  md5 hash
     */
    public function generateSecurityCode()
    {
        $result = $this->getCertificatePrivateKey();
        $result .= $this->getOib();
        $result .= $this->getDateTime();
        $result .= $this->getInvoiceNumber()->getInvoiceNumber();
        $result .= $this->getInvoiceNumber()->getBusinessLocationCode();
        $result .= $this->getInvoiceNumber()->getPaymentDeviceCode();
        $result .= $this->getTotalValue();

        $this->setSecurityCode(md5($result));

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
        $writer->startElementNs($namespace, 'Racun', null);
        $writer->writeElementNs($namespace, 'Oib', null, $this->getOib());
        $writer->writeElementNs($namespace, 'USustPdv', null, $this->getRegisteredForPdv() ? 'true' : 'false');
        $writer->writeElementNs($namespace, 'DatVrijeme', null, $this->getDateTime());
        $writer->writeElementNs($namespace, 'OznSlijed', null, $this->getIncrementType());
        $writer->writeRaw($this->invoiceNumber->toXML());

        /********** PDV **********/
        if (!empty($this->getPdvTaxes())) {
            $writer->startElementNs($namespace, 'Pdv', null);
            foreach ($this->getPdvTaxes() as $pdv) {
                $writer->writeRaw($pdv->toXML());
            }
            $writer->endElement();
        }

        /********** PNP **********/
        if (!empty($this->getPnpTaxes())) {
            $writer->startElementNs($namespace, 'Pnp', null);
            foreach ($this->getPnpTaxes() as $pnp) {
                $writer->writeRaw($pnp->toXML());
            }
            $writer->endElement();
        }

        /********** Other Tax **********/
        if (!empty($this->getOtherTaxes())) {
            $writer->startElementNs($namespace, 'OstaliPor', null);
            foreach ($this->getOtherTaxes() as $otherTax) {
                $writer->writeRaw($otherTax->toXML());
            }
            $writer->endElement();
        }

        $writer->writeElementNs($namespace, 'IznosOslobPdv', null, $this->getTaxFreeValue());
        $writer->writeElementNs($namespace, 'IznosMarza', null, $this->getMarginTaxValue());
        $writer->writeElementNs($namespace, 'IznosNePodlOpor', null, $this->getTaxExemptValue());

        /********** Fee **********/
        if (!empty($this->getFees())) {
            $writer->startElementNs($namespace, 'Naknade', null);
            foreach ($this->getFees() as $fee) {
                $writer->writeRaw($fee->toXML());
            }
            $writer->endElement();
        }
        $writer->writeElementNs($namespace, 'IznosUkupno', null, $this->getTotalValue());
        $writer->writeElementNs($namespace, 'NacinPlac', null, $this->getPaymentType());
        $writer->writeElementNs($namespace, 'OibOper', null, $this->getOperatorOib());
        $writer->writeElementNs($namespace, 'ZastKod', null, $this->getSecurityCode());
        $writer->writeElementNs($namespace, 'NakDost', null, $this->getResendFlag() ? 'true' : 'false');
        if ($this->getParagonInvoiceNumber()) {
            $writer->writeElementNs($namespace, 'ParagonBrRac', null, $this->getParagonInvoiceNumber());
        }
        if ($this->getSpecificPurpose()) {
            $writer->writeElementNs($namespace, 'SpecNamj', null, $this->getSpecificPurpose());
        }
        $writer->endElement();

        return $writer->outputMemory();
    }

}
