<?Php
require_once  'GoogleAuthenticator.php' ;
 
$ga = new PHPGangsta_GoogleAuthenticator();
 
$secret  = $ga->createSecret();
echo  "Secret is:" . $secret . "<BR><BR>" ;

$qrCodeUrl  = $ga->getQRCodeGoogleUrl( 'remember-my-bills' , $secret );
echo  "Google Charts URL for the QR code:" . $qrCodeUrl . "<BR><BR>" ;
echo "<img src='".$qrCodeUrl."'><br>";
 
$OneCode  = $ga->getCode( $secret );

$OneCode = '632675';
$secret = '637SPPDQY352NGO4';

echo  "Checking code '$OneCode' and Secret '$secret':\n" ;

$checkResult  = $ga->verifyCode( $secret , $OneCode , 2);     // 2 = 2 * 30sec clock tolerance
if  ( $checkResult ) {
    echo  'OK' ;
} else  {
    echo  'FAILED' ;
}
?>
