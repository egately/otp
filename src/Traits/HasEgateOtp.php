<?php

namespace Egate\EgateOtp\Traits;

use Egate\EgateOtp\Classes\TwoFactorAuthenticationProvider as MFA;
use Egate\EgateOtp\Modles\EgateOtp;
use Exception;

trait HasEgateOtp
{


    public function egate_otp()
    {
        return $this->morphOne(EgateOtp::class, 'otpable', 'otpable_type', 'otpable_id');
    }

    public function HasOtp()
    {
        try {
            return $this->has('egate_otp');
        } catch (Exception $e) {
            return false;
        }


    }
    public function GenerateCode(){
        if($this->has('egate_otp')) {

            return app(MFA::class)->getFreshCode($this->egate_otp);
        } else{
            $record =  $this->CreateOtpKey();
            return app(MFA::class)->getFreshCode(decrypt($record->code));
        }
    }
    public function CreateOtpKey()
    {
        if ($this->HasOtp()) return $this->UpdateKey($this->HasOtp());
        $Code = $this->generateKey();

        $QR = encrypt(app(MFA::class)->twoFactorQrCodeSvg($this->GetQrCode($Code)));
        $OtpRecord = $this->egate_otp()->create([

            'code' => encrypt($Code),
            'qr_code' => $QR,

        ]);
        return $OtpRecord;
    }


    public function generateKey()
    {
        return app(MFA::class)->generateSecretKey();

    }


    public function UpdateKey()
    {
        $Code = $this->generateKey();
        $QR = encrypt(app(MFA::class)->twoFactorQrCodeSvg($this->GetQrCode($Code)));
        $OtpRecord = $this->egate_otp()->update([
            'code' => encrypt($Code),
            'qr_code' => $QR,
        ]);
        return $OtpRecord;
    }

    public function GetQrCode($code)
    {
        $strAuthUrl = app(MFA::class)->qrCodeUrl(
           config('egate-otp.app_name'),
            $this->{$this->egate_otp_identifier_attribute ?? config('egate-otp.default_identifier_attribute') ?? 'email'},
            $code
        );

        return $strAuthUrl;
    }

    public function ValidateKey($Code, $Slots)
    {

        $secret = $this->HasOtp();
        if (!$secret) throw new Exception('No User Otp Token found');

        return  app(MFA::class)->verify(decrypt($secret->code), $Code, $Slots);

    }

    private function GetResponse(EgateOtp $OtpRecord)
    {
        return [
            'code' => $OtpRecord->code,
            'qr_image' => $this->GetQrCode($OtpRecord->code),

        ];


    }

    public function ActivateMfa()
    {

        $Code = $this->HasOtp();

        return $Code->update(['active' => 1]);
    }



    public function sendOtpOtpEmail($otp)
    {
        $this->notify(new OtpEmail($otp));
    }

    public function sendOtpOtpSms($otp)
    {
        $this->notify(new OtpEmail($otp));
    }

}
