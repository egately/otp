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

       
    public function generateOtp()
    {
        return $this->GenerateCode();
    }

    
    public function GenerateCode(){
        if($this?->egate_otp ?? Null) {

            return app(MFA::class)->getFreshCode($this->egate_otp);
        } else{
            $record =  $this->AddKeyToUser();
            return app(MFA::class)->getFreshCode($record);
        }
    }
    public function CreateOtpKey()
    {
        if($this?->egate_otp ?? Null) return $this->UpdateKey($this->HasOtp());
        $Code = $this->generateKey();

        $QR = encrypt(app(MFA::class)->twoFactorQrCodeSvg($this->GetQrCode($Code)));
        $OtpRecord = $this->egate_otp()->create([

            'code' => encrypt($Code),
            'qr_code' => $QR,

        ]);
        return $OtpRecord;
    }

    public function AddKeyToUser(){

        $Code = $this->generateKey();

        $this->egate_otp()->create([
            'code' => encrypt($Code),
        ]);
        $this->refresh();
        $oTpRecord = EgateOtp::where('otpable_id', $this->id)->where('otpable_type', $this->getMorphClass())->first();

        return  $oTpRecord;
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

    public function ValidateOtp($Code, $Slots)
    {

        $secret = $this->egate_otp->code;
        $Slots = $Slots ?? config('egate-otp.default_validation_window');
        $Slots = (int)$Slots * 2;
        if (!$secret) throw new Exception('No User Otp Token found');

        return  app(MFA::class)->verify(decrypt($secret), $Code, $Slots);

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
