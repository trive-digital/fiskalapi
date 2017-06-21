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

use Trive\FiskalAPI\Client;
use Trive\FiskalAPI\Invoice\Invoice;
use Trive\FiskalAPI\Invoice\Fee;
use Trive\FiskalAPI\Invoice\InvoiceNumber;
use Trive\FiskalAPI\Invoice\TaxRate;
use Trive\FiskalAPI\Request\InvoiceCheckRequest;

$certificatePath = './fiskal1.pfx';
$certificatePassword = 'certpassword';
$client = new Client($certificatePath, $certificatePassword, false, true, true);

$pdvTaxes = array();
$pdvTaxes[] = new TaxRate(25.1, 400.1, 20.1, null);
$pdvTaxes[] = new TaxRate(10.1, 500.1, 15.444, null);

$pnpTaxes = array();
$pnpTaxes[] = new TaxRate(30.1, 100.1, 10.1, null);
$pnpTaxes[] = new TaxRate(20.1, 200.1, 20.1, null);

$otherTaxes = array();
$otherTaxes[] = new TaxRate(40.1, 453.3, 12.1, 'Naziv1');
$otherTaxes[] = new TaxRate(27.1, 445.1, 50.1, 'Naziv2');

$fees = array();
$fees[] = new Fee('Naziv1', 0);

$invoiceNumber = new InvoiceNumber(1, 'ODV1', '1');
$invoice = (new Invoice())->setCertificatePrivateKey($client->getCertificatePrivateKey())
                          ->setOib('15004568361')
                          ->setRegisteredForPDV(true)
                          ->setDateTime((new \DateTime())->format('d.m.Y\TH:i:s'))
                          ->setInvoiceNumber($invoiceNumber)
                          ->setPdvTaxes($pdvTaxes)
                          ->setPnpTaxes($pnpTaxes)
                          ->setOtherTaxes($otherTaxes)
                          ->setTaxExemptValue(23.5)
                          ->setMarginTaxValue(32.0)
                          ->setTaxFreeValue(5.1)
                          ->setFees($fees)
                          ->setTotalValue(456.1)
                          ->setPaymentType(Invoice::PAYMENT_TYPE_CASH)
                          ->setOperatorOib('15004568361')
                          ->setResendFlag(false);

$invoiceCheckRequest = new InvoiceCheckRequest($invoice);
$res = $client->sendRequest($invoiceCheckRequest);

echo '<b>Request:</b><pre>', htmlentities($invoiceCheckRequest->toXML()), '</pre>';
echo '<b>Response:</b><pre>', htmlentities($res), '</pre>';
