<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;

class OpayController extends Controller {

    //
    public function test()
    {
//        Log::info(print_r($_POST));
        $myfile = fopen("info.txt", "w") or die("Unable to open file!");
        $txt = print_r($_POST, true);
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function showMenu()
    {
        return view('addValue',
            [
                'items' => ['60 Diamonds', '165 Diamonds', '360 Diamonds', '650 Diamonds', '1500 Diamonds'],
                'price' => [60, 150, 300, 500, 1000],
            ]);

    }

    private function storeOrder(Request $request)
    {


    }

    public function sentOrder(Request $request)
    {
        $name = $request['Name'];
        $price = $request['Price'];
        $currency = $request['Currency'];
        $quantity = $request['Quantity'];

        $merchantID = '2000132';
        $merchantTradeNo = "KaoTest" . time();

        $returnURL = 'http://182b12c9.ngrok.io/api/getresponse';
        $clientBackURL = 'http://182b12c9.ngrok.io/home';
        include('AllPay.Payment.Integration.php');
        try
        {

            $obj = new \AllInOne();

            //服務參數
            $obj->ServiceURL = "https://payment-stage.opay.tw/Cashier/AioCheckOut/V5";         //服務位置
            $obj->HashKey = '5294y06JbISpM5x9';                                            //測試用Hashkey，請自行帶入AllPay提供的HashKey
            $obj->HashIV = 'v77hoKGq4kWxNNIS';                                            //測試用HashIV，請自行帶入AllPay提供的HashIV
            $obj->MerchantID = $merchantID;
            $obj->EncryptType = \EncryptType::ENC_SHA256;                                        //CheckMacValue加密類型，請固定填入1，使用SHA256加密

            //基本參數(請依系統規劃自行調整)
            $obj->Send['ReturnURL'] = $returnURL;   //付款完成通知回傳的網址
            $obj->Send['ClientBackURL'] = $clientBackURL;
            $obj->Send['MerchantTradeNo'] = $merchantTradeNo;                                   //訂單編號
            $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                              //交易時間
            $obj->Send['TotalAmount'] = (int) $price;                                            //交易金額
            $obj->Send['TradeDesc'] = "Good Idea Coin";                                 //交易描述
            $obj->Send['ChoosePayment'] = \PaymentMethod::Credit;                           //付款方式:Credit

            //訂單的商品資料

            array_push($obj->Send['Items'], array('Name' => $name, 'price' => (int) $price,
                'Currency' => $currency, 'Quantity' => (int) $quantity, 'URL' => "none"));

            Order::forceCreate([
                'user_id' => Auth::user()->id,
                'MerchantID' => $merchantID,
                'MerchantTradeNo' => $merchantTradeNo,
                'Merchandise' => $name,
                'Quantity' => (int) $quantity,
                'Unit_price' => (int) $price,
                'TradeAmt' => (int) $price * (int) $quantity,
            ]);

            //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
            //以下參數不可以跟信用卡定期定額參數一起設定
            $obj->SendExtend['CreditInstallment'] = '';    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
            $obj->SendExtend['Redeem'] = false;           //是否使用紅利折抵，預設false
            $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;

            //Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
            //以下參數不可以跟信用卡分期付款參數一起設定
            // $obj->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
            // $obj->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
            // $obj->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
            // $obj->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串

            # 電子發票參數
            /*
            $obj->Send['InvoiceMark'] = InvoiceState::Yes;
            $obj->SendExtend['RelateNumber'] = $MerchantTradeNo;
            $obj->SendExtend['CustomerEmail'] = 'test@opay.tw';
            $obj->SendExtend['CustomerPhone'] = '0911222333';
            $obj->SendExtend['TaxType'] = TaxType::Dutiable;
            $obj->SendExtend['CustomerAddr'] = '台北市南港區三重路19-2號5樓D棟';
            $obj->SendExtend['InvoiceItems'] = array();
            // 將商品加入電子發票商品列表陣列
            foreach ($obj->Send['Items'] as $info)
            {
                array_push($obj->SendExtend['InvoiceItems'],array('Name' => $info['Name'],'Count' =>
                    $info['Quantity'],'Word' => '個','Price' => $info['Price'],'TaxType' => TaxType::Dutiable));
            }
            $obj->SendExtend['InvoiceRemark'] = '測試發票備註';
            $obj->SendExtend['DelayDay'] = '0';
            $obj->SendExtend['InvType'] = InvType::General;
            */


            //產生訂單(auto submit至AllPay)
            $obj->CheckOut();


        } catch (Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
