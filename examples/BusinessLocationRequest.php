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
use Trive\FiskalAPI\Business\Address;
use Trive\FiskalAPI\Business\AddressData;
use Trive\FiskalAPI\Business\BusinessLocation;
use Trive\FiskalAPI\Request\BusinessLocationRequest;

$certificatePath = './fiskal1.pfx';
$certificatePassword = 'certpassword';
$client = new Client($certificatePath, $certificatePassword, false, true, true);

$address = (new Address())->setStreet('Kapucinska')
                          ->setHouseNumber('33')
                          ->setHouseNumberSuffix('')
                          ->setZipCode('31000')
                          ->setSettlement('Osijek')
                          ->setCity('Osijek');

$addressData = (new AddressData())->setAddress($address);

$date = (new \DateTime())->format('d.m.Y');
$businessLocation = (new BusinessLocation())->setAddressData($addressData)
                                            ->setDateOfUsage($date)
                                            ->setBusinessLocationCode('ODV1')
                                            ->setOib('15004568361')
                                            ->setSpecificPurpose('spec namjena')
                                            ->setBusinessHours('Pon:08-11h Uto:15-17');

$businessLocationRequest = new BusinessLocationRequest($businessLocation);
$res = $client->sendRequest($businessLocationRequest);

echo '<b>Request:</b><pre>', htmlentities($businessLocationRequest->toXML()), '</pre>';
echo '<b>Response:</b><pre>', htmlentities($res), '</pre>';
