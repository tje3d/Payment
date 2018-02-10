<?php

namespace Tje3d\Payment\Gateways\Nextpay;

use Tje3d\Payment\Contracts\PaymentGateway as BaseGateway;
use Tje3d\Payment\Exceptions\ConnectionFail;
use Tje3d\Payment\Exceptions\OrderException;
use Tje3d\Payment\PaymentGateway;

class Nextpay extends PaymentGateway implements BaseGateway
{
    const ERRORS = [
        -2  => "خطای بانکی یا انصراف از پرداخت",
        -3  => "در انتظار پرداخت بانکی",
        -4  => "انصراف در درگاه بانک",
        -20 => "کلید مجوزدهی ارسال نشده است",
        -21 => "شماره تراکنش ارسال نشده است",
        -22 => "مبلغ ارسال نشده است",
        -23 => "مسیر بازگشت ارسال نشده است",
        -24 => "مبلغ اشتباه است",
        -25 => "شماره تراکنش تکراریست و قادر به ادامه کار نیستید",
        -26 => "توکن ارسال نشده است",
        -30 => "مقدار مبلغ کمتر از ۱۰۰ تومان است",
        -32 => "مسیر بازگشت خطا دارد",
        -33 => "ساختار کلید مجوز دهی صحیح نیست",
        -34 => "شماره تراکنش صحیح نیست",
        -35 => "نوع کلید مجوز دهی صحیح نیست",
        -36 => "شماره سفارش ارسال نشده است",
        -37 => "تراکنش یافت نشد",
        -38 => "توکن یافت نشد",
        -39 => "کلید مجوز دهی یافت نشد",
        -40 => "کلید مجوز دهی مسدود شده است",
        -41 => "پارامتر های ارسالی از بانک مورد تایید نیست",
        -42 => "سیستم پرداخت دچار مشکل شده است",
        -43 => "درگاهی برای پرداخت یافت نشد",
        -44 => "پاسخ بانک صحیح نیست",
        -45 => "سیستم پرداخت غیر فعال شده است",
        -46 => "درخواست اشتباه",
        -48 => "نرخ کمیسیون تعیین نشده است",
        -49 => "تراکنش تکراریست",
        -50 => "حساب کاربری یافت نشد",
        -51 => "کاربر یافت نشد",
        -60 => "ایمیل صحیح نیست",
        -61 => "کد ملی صحیح نیست",
        -62 => "کد پستی صحیح نیست",
        -63 => "آدرس پستی صحیح نیست",
        -64 => "توضیحات صحیح نیست",
        -65 => "نام و نام خانوادگی صحیح نیست",
        -66 => "شماره تلفن صحیح نیست",
        -67 => "نام کاربری صحیح نیست",
        -68 => "نام محصول صحیح نیست",
        -69 => "مسیر بازگشت برای حالت موفق صحیح نیست",
        -70 => "مسیر بازگشت برای حالت ناموفق صحیح نیست",
        -71 => "شماره موبایل صحیح نیست",
        -72 => "بانک عامل پاسخ گو نیست",
    ];

    public function configurations()
    {
        return config('payment.nextpay');
    }

    public function order(array $config)
    {
        try {
            $response = (string) $this->httpClient->request('POST', $this->urlOrder, [
                'form_params' => [
                    'api_key'      => $this->apiKey,
                    'order_id'     => $config['orderId'],
                    'amount'       => $config['amount'],
                    'callback_uri' => isset($config['callBackUrl']) ? $config['callBackUrl'] : $this->callBackUrl,
                ],
            ])->getBody();
        } catch (\Throwable $e) {
            throw new ConnectionFail($e->getMessage());
        }

        $response = json_decode($response);

        if ($response->code !== -1) {
            throw new OrderException($response->code, self::ERRORS[$response->code]);
        }

        return $response->trans_id;
    }

    public function verify(array $config)
    {
        try {
            $response = (string) $this->httpClient->request('POST', $this->urlVerify, [
                'form_params' => [
                    'api_key'  => $this->apiKey,
                    'order_id' => $config['orderId'],
                    'amount'   => $config['amount'],
                    'trans_id' => $config['transId'],
                ],
            ])->getBody();
        } catch (\Throwable $e) {
            throw new ConnectionFail($e->getMessage());
        }

        $response = json_decode($response);

        if ($response->code !== 0) {
            throw new OrderException($response->code, self::ERRORS[$response->code]);
        }

        return true;
    }
}
