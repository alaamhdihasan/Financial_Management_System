<?php

namespace App\Controllers;

use \Mpdf\Mpdf;
use phpDocumentor\Reflection\PseudoTypes\True_;
use App\Models\Users_M;

class Reports_C extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function index()
    {
        $users = new Users_M();;
        $loggedUserId = session()->get('loggedUser');
        $userinfo = $users->find($loggedUserId);
        $info = new Info_C();

        $data = [
            'title' => 'Reports',
            'WorkShopPlace' => $info->getWorkingPlace(),
            'userName' => $userinfo['U_UserName']
        ];
        return view('reports/reports_index', $data);
    }

    public function dataone()
    {

        $fuelmoneynumber = $this->request->getGet('getfuelmoneynumber');
        $_SESSION['fuelmoneynumber'] = $fuelmoneynumber;
        $title = $this->request->getGet('TitleReport');
        $_SESSION['TitleReport'] = $title;

        $data = [
            'fuelmoneynumber' => $fuelmoneynumber,
            'TitleReport' => $title,

        ];
        return $this->response->setJSON($data);
    }


    public function printFuelMoney()
    {

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $stylesheet = file_get_contents('admin/assets/css/stylereports_001.css');
        // $html_header = $this->myHeader();
        // $html_footer = $this->myfooter();
        // $mpdf->SetHeader($html_header);
        // $mpdf->SetFooter($html_footer);
        $html = $this->getFuelMoneyToPrint($_SESSION['fuelmoneynumber']);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        return redirect()->to($mpdf->Output('filename.pdf', 'I'));
    }

    public function getFuelMoneyToPrint($fuelmoneynumber)
    {
        $info = new Info_C();
        $price = $info->getFuelMoneyTotal($fuelmoneynumber);
        $totaltoword = $this->convert_number_to_words($price[0]->FuelMoneyTotal);
        $query = [
            'getFuelMoneyNumber' => $info->getFuelMoney($fuelmoneynumber),
            'getTotal' => $info->getFuelMoneyTotal2($fuelmoneynumber),
            'getTotalWords' => $totaltoword,
            'ReportTitle' => $_SESSION['TitleReport'],

        ];

        return view('reports/reports_FuelMoney_Print', $query);
    }

    public function dataMaintenance()
    {
        $maintenancenumber = $this->request->getGet('getMaintenanceNumber');
        $title = $this->request->getGet('TitleReport');
        $_SESSION['maintenancenumber'] = $maintenancenumber;
        $_SESSION['TitleReport'] = $title;

        $data = [
            'maintenancenumber' => $maintenancenumber,
            'TitleReport' => $title,
        ];
        return $this->response->setJSON($data);
    }
    public function getMaintenancePrint($maintenancenumber)
    {
        $info = new Info_C();
        $price = $info->getMaintenanceTotal($maintenancenumber);
        $totaltoword = $this->convert_number_to_words($price[0]->MaintenanceTotal);
        $query = [
            'getMaintenanceNumber' => $info->getMaintenance($maintenancenumber),
            'getTotal' => $info->getMaintenanceTotal2($maintenancenumber),
            'getTotalWords' => $totaltoword,
            'ReportTitle' => $_SESSION['TitleReport'],

        ];

        return view('reports/reports_Maintenance_Print', $query);
    }

    public function printMaintenance()
    {

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $stylesheet = file_get_contents('admin/assets/css/stylereports_001.css');
        // $html_header = $this->myHeader();
        // $html_footer = $this->myfooter();
        // $mpdf->SetHeader($html_header);
        // $mpdf->SetFooter($html_footer);
        $html = $this->getMaintenancePrint($_SESSION['maintenancenumber']);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        return redirect()->to($mpdf->Output('filename.pdf', 'I'));
    }











    // Constant Functions....

    public function convert_number_to_words($number)
    {

        $hyphen = ' و ';
        $conjunction = ' و ';
        $separator = ' و ';
        $negative = 'negative ';
        $decimal = ' and Cents ';
        $dictionary = array(
            0 => 'صفر',
            1 => 'واحد',
            2 => 'اثنان',
            3 => 'ثلاثة',
            4 => 'اربعة',
            5 => 'خمسة',
            6 => 'ستة',
            7 => 'سبعة',
            8 => 'ثمانية',
            9 => 'تسعة',
            10 => 'عشرة',
            11 => 'احد عشر',
            12 => 'اثنى عشر',
            13 => 'ثلاثة عشر',
            14 => 'اربعة عشر',
            15 => 'خمسة عشر',
            16 => 'ستة عشر',
            17 => 'سبعة عشر',
            18 => 'ثمانية عشر',
            19 => 'تسعة عشر',
            20 => 'عشرون',
            30 => 'ثلاثون',
            40 => 'اربعون',
            50 => 'خمسون',
            60 => 'ستون',
            70 => 'سبعون',
            80 => 'ثمانون',
            90 => 'تسعون',
            100 => 'مائة',
            1000 => 'الف',
            1000000 => 'مليون',
        );

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;

                if ((int)($number) % 10 == 0) {
                    $string = $dictionary[$tens];
                } else {
                    $string = $dictionary[$units];
                    if ($units) {
                        $string .= $hyphen . $dictionary[$tens];
                    }
                }

                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;

                if ((int)($number / 100) == 1) {
                    $string = $dictionary[100];
                    if ($remainder) {
                        $string .= $conjunction . $this->convert_number_to_words($remainder);
                    }
                } elseif ((int)($number / 100) == 2) {
                    $string = 'مائتان';
                    if ($remainder) {
                        $string .= $conjunction . $this->convert_number_to_words($remainder);
                    }
                } else {
                    $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                    if ($remainder) {
                        $string .= $conjunction . $this->convert_number_to_words($remainder);
                    }
                }



                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                if ((int)($baseUnit) == 1000) {
                    if ((int)($numBaseUnits)  == 1) {
                        $string = $dictionary[$baseUnit];
                        if ($remainder) {
                            $string .= $remainder < 100 ? $conjunction : $separator;
                            $string .= $this->convert_number_to_words($remainder);
                        }
                    } elseif ((int)($numBaseUnits)  == 2) {
                        $string = 'الفان';
                        if ($remainder) {
                            $string .= $remainder < 100 ? $conjunction : $separator;
                            $string .= $this->convert_number_to_words($remainder);
                        }
                    } else {
                        $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                        if ($remainder) {
                            $string .= $remainder < 100 ? $conjunction : $separator;
                            $string .= $this->convert_number_to_words($remainder);
                        }
                    }
                } elseif ((int)($baseUnit) == 1000000) {
                    if ((int)($numBaseUnits)  == 1) {
                        $string = $dictionary[$baseUnit];
                        if ($remainder) {
                            $string .= $remainder < 100 ? $conjunction : $separator;
                            $string .= $this->convert_number_to_words($remainder);
                        }
                    } elseif ((int)($numBaseUnits)  == 2) {
                        $string = 'مليونان';
                        if ($remainder) {
                            $string .= $remainder < 100 ? $conjunction : $separator;
                            $string .= $this->convert_number_to_words($remainder);
                        }
                    } else {
                        $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                        if ($remainder) {
                            $string .= $remainder < 100 ? $conjunction : $separator;
                            $string .= $this->convert_number_to_words($remainder);
                        }
                    }
                }




                // $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                // if ($remainder) {
                //     $string .= $remainder < 100 ? $conjunction : $separator;
                //     $string .= $this->convert_number_to_words($remainder);
                // }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

  
}
