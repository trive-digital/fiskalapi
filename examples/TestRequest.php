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
use Trive\FiskalAPI\Test\Test;
use Trive\FiskalAPI\Request\TestRequest;

$certificatePath = './fiskal1.pfx';
$certificatePassword = 'certpassword';
$client = new Client($certificatePath, $certificatePassword, false, true, true);

$test = new Test();
$test->setMessage('testna poruka');

$testRequest = new TestRequest($test);
$res = $client->sendRequest($testRequest);

echo '<b>Request:</b><pre>', htmlentities($testRequest->toXML()), '</pre>';
echo '<b>Response:</b><pre>', htmlentities($res), '</pre>';
