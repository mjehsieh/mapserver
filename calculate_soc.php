<?php
/**
 * Created by PhpStorm.
 * User: ko
 * Date: 2016/8/10
 * Time: 下午 03:36
 */
class CALCULATE_SOC {
    // constructor
    function __construct()
    {
    }
        function Calculate_SOC($BatteryType, $Voltage, $VoltageChannel){
        $soch = 0.0;
        $socm = 0.0;
        $socl = 0.0;
        $soc_scale = 0.0;
        $delta_vol = 0.0;
        $sohoffset = 0;

        // Set soch, socm, socl
        switch ($BatteryType){
            // FLOODED
            case 0:
                $soch = 12.6;
                $socm = 12.2;
                $socl = 11.8;
                break;
            // AGM_FLAT_PLATE
            case 1:
                $soch = 12.9;
                $socm = 12.0;
                $socl = 11.8;
                break;
            // AGM_SPIRAL
            case 2:
                $soch = 12.9;
                $socm = 12.0;
                $socl = 11.8;
                break;
            // VRLA_GEL
            case 3:
                $soch = 12.9;
                $socm = 12.0;
                $socl = 11.8;
                break;
            // EFB
            case 4:
                $soch = 12.8;
                $socm = 12.2;
                $socl = 11.8;
                break;
            default:
                $result['message'] = "Set soch, socm, socl error";
                $result['soc_value'] = 0;
                return $result;
                break;
        }

        // volch decition
        switch ($VoltageChannel){
            // 6V
            case 0:
                $Voltage = $Voltage * 2;
                break;
            // 12V
            case 1:
                $Voltage = $Voltage * 1;
                break;
            default:
                $result['message'] = "volch decition error";
                $result['soc_value'] = 0;
                return $result;
                break;
        }

        if($Voltage >= $soch)
        {
            $result['message'] = "SOC Calculation Succeed";
            $result['soc_value'] = "100";
            return $result;
        }
        elseif($Voltage <= $socl){
            $result['message'] = "SOC Calculation Succeed";
            $result['soc_value'] = "0";
            return $result;
        }
        else{
            if($Voltage >= $socm){
                // SOC calculation procedure
                switch ($BatteryType){
                    // FLOODED
                    case 0:
                        $soc_scale = (50/($soch - $socm));
                        $delta_vol = $Voltage - $socm;
                        $sohoffset = 50;
                        break;
                    // AGM_FLAT_PLATE
                    case 1:
                        $soc_scale = (75/($soch - $socm));
                        $delta_vol = $Voltage - $socm;
                        $sohoffset = 25;
                        break;
                    // AGM_SPIRAL
                    case 2:
                        $soc_scale = (75/($soch - $socm));
                        $delta_vol = $Voltage - $socm;
                        $sohoffset = 25;
                        break;
                    // VRLA_GEL
                    case 3:
                        $soc_scale = (75/($soch - $socm));
                        $delta_vol = $Voltage - $socm;
                        $sohoffset = 25;
                        break;
                    case 4:
                        $soc_scale = (50/($soch - $socm));
                        $delta_vol = $Voltage - $socm;
                        $sohoffset = 50;
                        break;
                    default:
                        $result['message'] = "SOC calculation procedure error";
                        $result['soc_value'] = 0;
                        return $result;
                        break;
                }
                $result['message'] = "SOC Calculation Succeed";
                $result['soc_value'] = floor(($delta_vol * $soc_scale) + $sohoffset);
                return $result;
            }
            else{
                // SOC calculation procedure
                switch ($BatteryType) {
                    // FLOODED
                    case 0:
                        $soc_scale = (50/($socm - $socl));
                        $delta_vol = $Voltage - $socl;
                        $sohoffset = 0;
                        break;
                    // AGM_FLAT_PLATE
                    case 1:
                        $soc_scale = (25/($socm - $socl));
                        $delta_vol = $Voltage - $socl;
                        $sohoffset = 0;
                        break;
                    // AGM_SPIRAL
                    case 2:
                        $soc_scale = (25/($socm - $socl));
                        $delta_vol = $Voltage - $socl;
                        $sohoffset = 0;
                        break;
                    // VRLA_GEL
                    case 3:
                        $soc_scale = (25/($socm - $socl));
                        $delta_vol = $Voltage - $socl;
                        $sohoffset = 0;
                        break;
                    // EFB
                    case 4:
                        $soc_scale = (50/($socm - $socl));
                        $delta_vol = $Voltage - $socl;
                        $sohoffset = 0;
                        break;
                    default:
                        $result['message'] = "SOC calculation procedure error";
                        $result['soc_value'] = 0;
                        return $result;
                        break;
                }
                $result['message'] = "SOC Calculation Succeed";
                $result['soc_value'] = floor(($delta_vol * $soc_scale) + $sohoffset);
                return $result;
            }
        }
    }
}