<?php
namespace App\Libs;

use DateTime;


class ArithmeticScienceClass
{
    function yearList(){
        $list = array();
        for($i=1873;$i<=date('Y');$i++){
            if($i==1873){
                $a = '明治';
                $b = 6;
            }elseif($i==1912) {
                $a = '大正';
                $b = 1;
            }elseif($i==1926) {
                $a = '昭和';
                $b = 1;
            }elseif($i==1989) {
                $a = '平成';
                $b = 1;
            }elseif($i==2019) {
                $a = '平成/令和';
                $b = '31/1';
            }elseif($i==2020) {
                $a = '令和';
                $b = '2';
            }

            $list[$i] = $i."（".$a.$b."）";
            if($i!=2019) {
                $b++;
            }
        }

        return $list;

    }
    function array_equal_set( $a, $b )
    {
        $diff_a_to_b = array_diff($a, $b);
        $diff_b_to_a = array_diff($b, $a);
        return empty($diff_a_to_b) && empty($diff_b_to_a);
    }

    /* 切り捨て型・整数化 */
    function cint($x) {
        if (($x-0.5)<0){
            return ceil($x-0.5);   // 負なら0
        } else {
            return round($x-0.5);  // 正なら切り上げ
       }
    }
    
    /* 特殊mod */
    function cmod($x, $y) {
        $t=0;
        $a=0;

        $t=$x/$y;
        $a=round(($t-round($t-0.5))*$y);
        if ($a==0) {
            $a=$y;
        }
        return $a;
    }

    /* 日数計算 */
    function cdate($y, $m, $d) {
        if ($m<3) {
            $m=$m+12;
            $y=$y-1;
        }
        $x=$this->cint($y*365.25)+$this->cint($y/400)-$this->cint($y/100)+$this->cint(($m-2)*30.59)+$d-21;
        return $x;
    }
    
    /* 月の末日 */
    function calc_maxdte($y, $m) {
        if ($y%400==0 || ($y%100>0 && $y%4==0)) {
            $s="312931303130313130313031";
        } else {
            $s="312831303130313130313031";
        }
        $x=(int)substr($s,($m-1)*2,2);

        return $x;
    }
    
    /* 干支　　1912年基準年　年干＝壬(9)　年支＝子(1)　*/

    function calc_nenkan1912($x) {
        $a=0;
        $a=(($x-1912)+9)%10;
        if($a==0){
            $a=10;
        }
        return $a;
    }

    function calc_nenshi1912($y) {     //y=西暦
        $b=0;
        $b=(($y-1912)+1)%12;
        if($b==0){
            $b=12;
        }

        return $b;
    }

    /* ２８元 */
    function calc_zokan($sno, $dte) {
     
        switch ($sno) {
            /* 0 1 2 3 4 5 6 7 8 9 0 1 2 3 4 5 6 7 8 9 20 */
            case  1:$s="101010101010101010101010101010101010101010"; break;
            case  2:$s="101010101010101010108 8 8 6 6 6 6 6 6 6 6 "; break;
            case  3:$s="5 5 5 5 5 5 5 5 3 3 3 3 3 3 3 1 1 1 1 1 1 "; break;
            case  4:$s="2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 2 "; break;
            case  5:$s="2 2 2 2 2 2 2 2 2 2 1010105 5 5 5 5 5 5 5 "; break;
            case  6:$s="5 5 5 5 5 5 7 7 7 7 7 7 7 7 7 3 3 3 3 3 3 "; break;
            case  7:$s="6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 6 4 "; break;
            case  8:$s="4 4 4 4 4 4 4 4 4 4 2 2 2 6 6 6 6 6 6 6 6 "; break;
            case  9:$s="5 5 5 5 5 5 5 5 5 5 5 9 9 9 7 7 7 7 7 7 7 "; break;
            case 10:$s="8 8 8 8 8 8 8 8 8 8 8 8 8 8 8 8 8 8 8 8 8 "; break;
            case 11:$s="8 8 8 8 8 8 8 8 8 8 4 4 4 5 5 5 5 5 5 5 5 "; break;
            case 12:$s="1 1 1 1 1 1 1 1 1 1 1 1 1 9 9 9 9 9 9 9 9 "; break;
            default:$s="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ";
        }
        if ($dte>20) $dte=20;
        $x=(int)substr($s,$dte*2,2);
        return $x;
    }
    
    /* １０大主星 */
    function calc_10shu($n, $k) {
    
        switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 10 */
            case  1:$s="0 1 2 3 4 5 6 7 8 9 10"; break;
            case  2:$s="0 2 1 4 3 6 5 8 7 109 "; break;
            case  3:$s="0 9 101 2 3 4 5 6 7 8 "; break;
            case  4:$s="0 109 2 1 4 3 6 5 8 7 "; break;
            case  5:$s="0 7 8 9 101 2 3 4 5 6 "; break;
            case  6:$s="0 8 7 109 2 1 4 3 6 5 "; break;
            case  7:$s="0 5 6 7 8 9 101 2 3 4 "; break;
            case  8:$s="0 6 5 8 7 109 2 1 4 3 "; break;
            case  9:$s="0 3 4 5 6 7 8 9 101 2 "; break;
            case 10:$s="0 4 3 6 5 8 7 109 2 1 "; break;
            default:$s="0 0 0 0 0 0 0 0 0 0 0 ";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
    }

    /* １２大従星 */
    function calc_12jyu($n, $k) {
        switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 101112 */
            case  1:$s="9 7 1011128 4 2 5 1 3 6 9 "; break;
            case  2:$s="2 4 8 1211107 9 6 3 1 5 2 "; break;
            case  3:$s="1 3 6 9 7 1011128 4 2 5 1 "; break;
            case  4:$s="3 1 5 2 4 8 1211107 9 6 3 "; break;
            case  5:$s="1 3 6 9 7 1011128 4 2 5 1 "; break;
            case  6:$s="3 1 5 2 4 8 1211107 9 6 3 "; break;
            case  7:$s="4 2 5 1 3 6 9 7 1011128 4 "; break;
            case  8:$s="7 9 6 3 1 5 2 4 8 1211107 "; break;
            case  9:$s="11128 4 2 5 1 3 6 9 7 1011"; break;
            case 10:$s="1211107 9 6 3 1 5 2 4 8 12"; break;
            default:$s="0 0 0 0 0 0 0 0 0 0 0 0 0 ";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
    }

    /* 合法・散法表 */
    function calc_gousan($n, $k) {        
        //　01半会　02支合　03方三位　04対冲　05刑　06破　07害　08支合・破　09刑・冲　10刑・害　11刑・破　12刑・支合・破　　 　　　　　　　　　　　　　5/10 支合　半会　に化水などを入れる
        switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 101112  */
            case  1:$s="00000200050100040701060000"; break;
            case  2:$s="00020000000601070400010500"; break;
            case  3:$s="00000000000010010009000108"; break;
            case  4:$s="00050000000700060100040201"; break;
            case  5:$s="00010600070500000001020400"; break;
            case  6:$s="00000110000000000012010004"; break;
            case  7:$s="00040701060000050200000100"; break;
            case  8:$s="00070900010000020000001101"; break;
            case  9:$s="00010009000112000000000007"; break;
            case 10:$s="00060100040201000000050700"; break;
            case 11:$s="00000501020400011100070000"; break;
            case 12:$s="00000002010004000107000005"; break;
            default:$s="00000000000000000000000000";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
    }

    /* ⑧三柱：複数支が支合/半会/三合会局で孤立なく繋がるか
     * 三柱（日支・月支・年支）の中だけで成立する関係はカウントしない */
    function calc_sanchu_branches(array $branches) {
        $branches = array_map('intval', $branches);
        $count = count($branches);
        if ($count < 4) {
            return '';
        }
        $base_three = array($branches[0], $branches[1], $branches[2]);
        $shigou_pairs = array(array(1, 2), array(3, 12), array(4, 11), array(5, 10), array(6, 9), array(7, 8));
        $sangou_triads = array(array(1, 5, 9), array(2, 6, 10), array(3, 7, 11), array(4, 8, 12));

        $is_within_base_only = function ($a, $b) use ($base_three) {
            return in_array($a, $base_three, true) && in_array($b, $base_three, true);
        };

        $is_shigou_pair = function ($a, $b) use ($shigou_pairs) {
            if ($a === $b) {
                return false;
            }
            foreach ($shigou_pairs as $pair) {
                if (in_array($a, $pair, true) && in_array($b, $pair, true)) {
                    return true;
                }
            }
            return false;
        };

        $is_valid_shigou = function ($a, $b) use ($is_within_base_only, $is_shigou_pair) {
            return !$is_within_base_only($a, $b) && $is_shigou_pair($a, $b);
        };

        $is_valid_hankai = function ($a, $b) use ($is_within_base_only) {
            return !$is_within_base_only($a, $b)
                && $a !== $b
                && $this->calc_gousan($a, $b) == 1;
        };

        $is_sangou_kai = false;
        foreach ($sangou_triads as $triad) {
            $all_in_triad = true;
            foreach ($branches as $branch) {
                if (!in_array($branch, $triad, true)) {
                    $all_in_triad = false;
                    break;
                }
            }
            if (!$all_in_triad) {
                continue;
            }
            $has_all_three = true;
            foreach ($triad as $member) {
                if (!in_array($member, $branches, true)) {
                    $has_all_three = false;
                    break;
                }
            }
            if (!$has_all_three) {
                continue;
            }
            $triad_in_base_only = true;
            foreach ($triad as $member) {
                if (!in_array($member, $base_three, true)) {
                    $triad_in_base_only = false;
                    break;
                }
            }
            if (!$triad_in_base_only) {
                $is_sangou_kai = true;
                break;
            }
        }

        $has_hankai = false;
        $has_shigou = false;
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if ($is_valid_hankai($branches[$i], $branches[$j])) {
                    $has_hankai = true;
                }
                if ($is_valid_shigou($branches[$i], $branches[$j])) {
                    $has_shigou = true;
                }
            }
        }

        $all_covered = true;
        for ($i = 0; $i < $count; $i++) {
            $covered = $is_sangou_kai;
            if (!$covered) {
                for ($j = 0; $j < $count; $j++) {
                    if ($i === $j) {
                        continue;
                    }
                    if ($is_valid_shigou($branches[$i], $branches[$j])
                        || $is_valid_hankai($branches[$i], $branches[$j])) {
                        $covered = true;
                        break;
                    }
                }
            }
            if (!$covered) {
                $all_covered = false;
                break;
            }
        }

        if (!$all_covered) {
            return '';
        }

        $labels = array();
        if ($is_sangou_kai) {
            $labels[] = '三合会局';
        }
        if ($has_shigou) {
            $labels[] = '支合';
        }
        if ($has_hankai) {
            $labels[] = '半会';
        }

        return implode('・', $labels);
    }

    /* ⑧三柱（年運）：日支・月支・年支・年運支 */
    function calc_sanchu_nenun($im_sd, $im_sm, $im_sy, $nenun_shi) {
        return $this->calc_sanchu_branches(array((int)$im_sd, (int)$im_sm, (int)$im_sy, (int)$nenun_shi));
    }
    
    /* 日干用　大半会　合法散法　天剋　洩天 検査　ルーチン　*/
    function calc_isoho($a,$b,$c,$d) {
        $d_gousan=array(" ","半会","支合","方三位","冲","刑","破","害","支合・破","刑・冲","刑・害","刑・破","支合・刑・破");
        $x="";

        if (($a==$c) && ($this->calc_gousan($b,$d)==1)){ //　年干=月干で年月日のどれかが半会
            $x="大半会";
        }else{
            $x=$d_gousan[$this->calc_gousan($b,$d)];
       }

        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="02") {$x="干合支合";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="07") {$x="干合支害";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="05") {$x="干合支刑";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="08") {$x="干支合・破";}

        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="09") {$x="干合合・干刑・冲";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="10") {$x="干害・干刑";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="11") {$x="干刑・破";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="12") {$x="干合合・干刑・破";}
        if (($this->calc_soukoku($a,$c)==03 || $this->calc_soukoku($a,$c)==04) && $this->calc_gousan($b,$d)=="04") {$x="天剋";}
        if (($this->calc_soukoku($a,$c)==03 || $this->calc_soukoku($a,$c)==04) && $this->calc_gousan($b,$d)=="09") {$x="天剋・刑";}
        if (($this->calc_soukoku($a,$c)==01 || $this->calc_soukoku($a,$c)==02) && $this->calc_gousan($b,$d)=="05" ) {$x="洩天・刑";}
        if ((($this->calc_soukoku($a,$c)==01 || $this->calc_soukoku($a,$c)==02) && ($b==$d)) && $this->calc_gousan($b,$d)!="05") {$x="洩天";}
        if (($a==$c) && ($b==$d)) {$x="律音";}
        if (($a==$c) && (abs($b-$d)==6)) {$x="納音";}
        if  ($x=="") {$x="";}

        return $x;
   }


    /* 月干・年干用　大半会　合法散法　天剋　洩天 検査　ルーチン　　　（洩天地支は日干のみ表示だから）　*/
    function calc_isoho2($a,$b,$c,$d) {
        $d_gousan=array(" ","半会","支合","方三位","冲","刑","破","害","支合・破","刑・冲","刑・害","刑・破","支合・刑・破");
        $x=0;
        if (($a==$c) && ($this->calc_gousan($b,$d)==1)) {  //　年干=月干で年月日のどれかが半会
            $x="大半会";
        }else {
            $x=$d_gousan[$this->calc_gousan($b,$d)];
        }

        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="02") {$x="干合支合";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="07") {$x="干合支害";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="05") {$x="干合支刑";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="08") {$x="干合合・破";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="09") {$x="干合合・干刑・冲";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="10") {$x="干合合・干害・干刑";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="11") {$x="干合合・干刑・破";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="12") {$x="干合合・干刑・破";}
        if (($this->calc_soukoku($a,$c)==03 || $this->calc_soukoku($a,$c)==04) && $this->calc_gousan($b,$d)=="04") {$x="天剋";}
        if (($this->calc_soukoku($a,$c)==03 || $this->calc_soukoku($a,$c)==04) && $this->calc_gousan($b,$d)=="09") {$x="天剋・刑";}

        if (($a==$c) && ($b==$d)) {$x="律音";}
        if (($a==$c) && (abs($b-$d)==6)) {$x="納音";}
        if  ($x=="") {$x="";}

        return $x;
    }

    /* 大運初旬用　大半会　合法散法 検査　ルーチン　　　　　大運初旬は律音が　戊＝丙　己＝丁　*/
    function calc_isoho3($a,$b,$c,$d) {
        $d_gousan=array(" ","半会","支合","方三位","冲","刑","破","害","支合・破","刑・冲","刑・害","刑・破","支合・刑・破");
       $x=0;
        if (($a==$c) && ($this->calc_gousan($b,$d)==1)) {  //　年干=月干で年月日のどれかが半会
            $x="大半会";
        }else {
            $x=$d_gousan[$this->calc_gousan($b,$d)];
       }

        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="02") {$x="干合支合";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="07") {$x="干合支害";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="05") {$x="干合支合";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="08") {$x="干支合・破";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="09") {$x="干合合・干刑・冲";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="10") {$x="干害・干刑";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="11") {$x="干刑・破";}
        if  (abs($a-$c)==5 && $this->calc_gousan($b,$d)=="12") {$x="干合合・干刑・破";}
        if (($this->calc_soukoku($a,$c)==03 || $this->calc_soukoku($a,$c)==04) && $this->calc_gousan($b,$d)=="04") {$x="天剋";}
        if (($this->calc_soukoku($a,$c)==03 || $this->calc_soukoku($a,$c)==04) && $this->calc_gousan($b,$d)=="09") {$x="天剋・刑";}
        if (($this->calc_soukoku($a,$c)==01 || $this->calc_soukoku($a,$c)==02) && $this->calc_gousan($b,$d)=="05") {$x="洩天・刑";}
        if ((($this->calc_soukoku($a,$c)==01 || $this->calc_soukoku($a,$c)==02) && ($b==$d)) && $this->calc_gousan($b,$d)!="05") {$x="洩天";}

        if (($a==$c) && ($b==$d)) {$x="律音";}
        if ((($a==5) && ($c==3)) || (($a==3) && ($c==5)) || (($a==6) && ($c==4)) || (($a==4) && ($c==6))) {$x=="律音";}
        if (($a==$c) && (abs($b-$d)==6)) {$x="納音";}
        if  ($x=="") {$x="";}

        return $x;
    }
    /* 五行変化表 */
    function calc_gogyo_cng($n, $k) {
        //01化木　02化火　03化土　04化金　05化水　06化金・土　07化木・土(半会で子・卯・午・酉を含まない組合せは化けない,支合は化ける)
        switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 101112  */
            case  1:$s="00000500000500000005000000"; break;
            case  2:$s="00050000000000000000040000"; break;
            case  3:$s="00000000000000020000000001"; break;
            case  4:$s="00000000000000000100000701"; break;
            case  5:$s="00050000000000000000060000"; break;
            case  6:$s="00000000000000000004040000"; break;
            case  7:$s="00000002000000000200000200"; break;
            case  8:$s="00000000010000020000000000"; break;
            case  9:$s="00050000000004000000000000"; break;
            case 10:$s="00000400000604000000000000"; break;
            case 11:$s="00000000070000020000000000"; break;
            case 12:$s="00000001010000000000000000"; break;
            default:$s="00000000000000000000000000";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
   }

    /* 半会変化表 */
    function calc_gogyo_hankai($n, $k) {
        //01化木　02化火　03化土　04化金　05化水　06化金・土　07化木・土(半会で子・卯・午・酉を含まない組合せは化けない,支合は化ける)
        switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 101112  */
            case  1:$s="00000000000500000005000000"; break;
            case  2:$s="00000000000000000000040000"; break;
            case  3:$s="00000000000000020000000000"; break;
            case  4:$s="00000000000000000100000001"; break;
            case  5:$s="00050000000000000000000000"; break;
            case  6:$s="00000000000000000000040000"; break;
            case  7:$s="00000002000000000000000200"; break;
            case  8:$s="00000000010000000000000000"; break;
            case  9:$s="00050000000000000000000000"; break;
            case 10:$s="00000400000004000000000000"; break;
            case 11:$s="00000000000000020000000000"; break;
            case 12:$s="00000000010000000000000000"; break;
            default:$s="00000000000000000000000000";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
   }

    /* 支合変化表 */
    function calc_gogyo_shigo($n, $k) {
        //01化木　02化火　03化土　04化金　05化水　06化金・土　07化木・土(半会で子・卯・午・酉を含まない組合せは化けない,支合は化ける)
        switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 101112  */
            case  1:$s="00000500000000000000000000"; break;
            case  2:$s="00050000000000000000000000"; break;
            case  3:$s="00000000000000000000000001"; break;
            case  4:$s="00000000000000000000000700"; break;
            case  5:$s="00000000000000000000060000"; break;
            case  6:$s="00000000000000000004000000"; break;
            case  7:$s="00000000000000000200000000"; break;
            case  8:$s="00000000000000020000000000"; break;
            case  9:$s="00000000000004000000000000"; break;
            case 10:$s="00000000000600000000000000"; break;
            case 11:$s="00000000070000000000000000"; break;
            case 12:$s="00000001000000000000000000"; break;
            default:$s="00000000000000000000000000";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
   }

    /* 剋線 算出表*/
    function calc_kokusen($n, $k) {
        switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 10 */
            case  1:$s="0 00000101020202020101"; break;
            case  2:$s="0 00000101020202020101"; break;
            case  3:$s="0 01010000010102020202"; break;
            case  4:$s="0 01010000010102020202"; break;
            case  5:$s="0 02020101000001010202"; break;
            case  6:$s="0 02020101000001010202"; break;
            case  7:$s="0 02020202010100000101"; break;
            case  8:$s="0 02020202010100000101"; break;
            case  9:$s="0 01010202020201010000"; break;
            case 10:$s="0 01010202020201010000"; break;
            default:$s="0 0 0 0 0 0 0 0 0 0 0 ";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
    }

    /* 相生・相剋 算出表 干支*/
    function calc_soukoku($n, $k) {
      switch ($n) {
            /* 0 1 2 3 4 5 6 7 8 9 10 */
            case  1:$s="0 00000100030004000200"; break;
            case  2:$s="0 00000001000300040002"; break;
            case  3:$s="0 02000000010003000400"; break;
            case  4:$s="0 00020000000100030004"; break;
            case  5:$s="0 04000200000001000300"; break;
            case  6:$s="0 00040002000000010003"; break;
            case  7:$s="0 03000400020000000100"; break;
            case  8:$s="0 00030004000200000001"; break;
            case  9:$s="0 01000300040002000000"; break;
            case 10:$s="0 00010003000400020000"; break;
            default:$s="0 0 0 0 0 0 0 0 0 0 0 ";
       }
        $x=(int)substr($s,$k*2,2);
        return $x;
    }
    /*　四天運と剋線の順位 表*/
    function calc_juni($n, $k){
        switch ($n){
            /* 01234 */
            case  1:$s="04421"; break;
            case  2:$s="03412"; break;
            case  3:$s="02143"; break;
            case  4:$s="01234"; break;
            case  5:$s="04321"; break;
            case  6:$s="03412"; break;
            case  7:$s="04321"; break;
            case  8:$s="03412"; break;
            case  9:$s="02143"; break;
            case 10:$s="01234"; break;
            default:$s="00000";
       }
        $x=(int)substr($s,$k,1);
        return $x;
   }

    /*　蔵干表　裏 数理エネルギー計算用　*/
    function calc_ura_zokan($n,$k) {
        switch ($n) {
            /* 0 1 2 3 */
            case  1:$s="00100000"; break;
            case  2:$s="00100806"; break;
            case  3:$s="00050301"; break;
            case  4:$s="00020000"; break;
            case  5:$s="00021005"; break;
            case  6:$s="00050703"; break;
            case  7:$s="00060400"; break;
            case  8:$s="00040206"; break;
            case  9:$s="00050907"; break;
            case 10:$s="00080000"; break;
            case 11:$s="00080405"; break;
            case 12:$s="00010900"; break;
            default:$s="00000000";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
    }

    //　数理エネルギー     01:木　02:火　03:土　04:金　05:水
    function calc_suri_gogyo($n,$k) {
        switch ($n) {
            /* 0 1 2 3 4 */
            case  1:$s="0105030204"; break;
            case  2:$s="0105030204"; break;
            case  3:$s="0201040305"; break;
            case  4:$s="0201040305"; break;
            case  5:$s="0302050401"; break;
            case  6:$s="0302050401"; break;
            case  7:$s="0403010502"; break;
            case  8:$s="0403010502"; break;
            case  9:$s="0504020103"; break;
            case 10:$s="0504020103"; break;
            default:$s="0000000000";
        }
        $x=(int)substr($s,$k*2,2);
        return $x;
    }

    /* 干の五行　*/

    function calc_gogyo_kan($k) {
        $x=0;

        if ($k==1 || $k==2) {
            $x=1;
        }else if ($k==3 || $k==4){
            $x=2;
        }else if ($k==5 || $k==6){
            $x=3;
        }else if ($k==7 || $k==8){
            $x=4;
        }else if ($k==9 || $k==10){
            $x=5;
        }

        return $x;
   }

    /* 節入り日 */
    function calc_setsu($y, $m) {
        switch ($y) {
            case 1873:$s="545566778877"; break;
            case 1874:$s="546566788877"; break;
            case 1875:$s="646566888987"; break;
            case 1876:$s="645455777877"; break;
            case 1877:$s="545556777877"; break;
            case 1878:$s="546566788877"; break;
            case 1879:$s="646566788987"; break;
            case 1880:$s="645455777877"; break;
            case 1881:$s="545556777877"; break;
            case 1882:$s="546566788877"; break;
            case 1883:$s="646566788987"; break;
            case 1884:$s="645455777877"; break;
            case 1885:$s="545556777877"; break;
            case 1886:$s="546566788877"; break;
            case 1887:$s="646566788987"; break;
            case 1888:$s="645455777877"; break;
            case 1889:$s="535555777877"; break;
            case 1890:$s="546566788877"; break;
            case 1891:$s="646566788987"; break;
            case 1892:$s="645455777877"; break;
            case 1893:$s="535455777877"; break;
            case 1894:$s="545556778877"; break;
            case 1895:$s="546566788887"; break;
            case 1896:$s="645455777876"; break;
            case 1897:$s="535455777877"; break;
            case 1898:$s="545556778877"; break;
            case 1899:$s="546566788877"; break;
            case 1900:$s="646566888987"; break;
            case 1901:$s="646566888988"; break;
            case 1902:$s="656667888988"; break;
            case 1903:$s="657677899988"; break;
            case 1904:$s="756566788987"; break;
            case 1905:$s="646566888988"; break;
            case 1906:$s="656667888988"; break;
            case 1907:$s="657677899988"; break;
            case 1908:$s="756566788987"; break;
            case 1909:$s="646566888988"; break;
            case 1910:$s="656666888988"; break;
            case 1911:$s="657677899988"; break;
            case 1912:$s="756566788987"; break;
            case 1913:$s="646566888988"; break;
            case 1914:$s="656666888988"; break;
            case 1915:$s="657677899988"; break;
            case 1916:$s="756566788987"; break;
            case 1917:$s="646566888988"; break;
            case 1918:$s="646566888988"; break;
            case 1919:$s="657667889988"; break;
            case 1920:$s="656566788887"; break;
            case 1921:$s="646566888988"; break;
            case 1922:$s="646566888988"; break;
            case 1923:$s="656667889988"; break;
            case 1924:$s="656566788887"; break;
            case 1925:$s="646566888987"; break;
            case 1926:$s="646566888988"; break;
            case 1927:$s="656667889988"; break;
            case 1928:$s="656566788887"; break;
            case 1929:$s="646566888987"; break;
            case 1930:$s="646566888988"; break;
            case 1931:$s="656667889988"; break;
            case 1932:$s="656566788877"; break;
            case 1933:$s="646566788987"; break;
            case 1934:$s="646566888988"; break;
            case 1935:$s="656667888988"; break;
            case 1936:$s="656566788877"; break;
            case 1937:$s="646566788987"; break;
            case 1938:$s="646566888988"; break;
            case 1939:$s="656666888988"; break;
            case 1940:$s="656566788877"; break;
            case 1941:$s="646566788987"; break;
            case 1942:$s="646566888988"; break;
            case 1943:$s="656666888988"; break;
            case 1944:$s="656566788877"; break;
            case 1945:$s="646566788987"; break;
            case 1946:$s="646566888988"; break;
            case 1947:$s="656666888988"; break;
            case 1948:$s="656556788877"; break;
            case 1949:$s="646566788987"; break;
            case 1950:$s="646566888988"; break;
            case 1951:$s="656566888988"; break;
            case 1952:$s="656556778877"; break;
            case 1953:$s="646566788887"; break;
            case 1954:$s="646566888988"; break;
            case 1955:$s="646566888988"; break;
            case 1956:$s="655556778877"; break;
            case 1957:$s="546566788887"; break;
            case 1958:$s="646566888987"; break;
            case 1959:$s="646566888988"; break;
            case 1960:$s="655556778877"; break;
            case 1961:$s="546566788887"; break;
            case 1962:$s="646566788987"; break;
            case 1963:$s="646566888988"; break;
            case 1964:$s="655556777877"; break;
            case 1965:$s="546566788887"; break;
            case 1966:$s="646566788987"; break;
            case 1967:$s="646566888988"; break;
            case 1968:$s="655556777877"; break;
            case 1969:$s="546566788877"; break;
            case 1970:$s="646566788987"; break;
            case 1971:$s="646566888988"; break;
            case 1972:$s="655555777877"; break;
            case 1973:$s="546566788877"; break;
            case 1974:$s="646566788987"; break;
            case 1975:$s="646566888988"; break;
            case 1976:$s="655555777877"; break;
            case 1977:$s="546556788877"; break;
            case 1978:$s="646566788987"; break;
            case 1979:$s="646566888988"; break;
            case 1980:$s="655455777877"; break;
            case 1981:$s="546556778877"; break;
            case 1982:$s="646566788887"; break;
            case 1983:$s="646566888987"; break;
            case 1984:$s="645455777877"; break;
            case 1985:$s="545556778877"; break;
            case 1986:$s="546566788887"; break;
            case 1987:$s="646566888987"; break;
            case 1988:$s="645455777877"; break;
            case 1989:$s="545556778877"; break;
            case 1990:$s="546566788987"; break;
            case 1991:$s="646566788987"; break;
            case 1992:$s="645455777877"; break;
            case 1993:$s="545556778877"; break;
            case 1994:$s="546566788877"; break;
            case 1995:$s="646566788987"; break;
            case 1996:$s="645455777877"; break;
            case 1997:$s="545556777877"; break;
            case 1998:$s="546566788877"; break;
            case 1999:$s="646566788987"; break;
            case 2000:$s="645455777877"; break;
            case 2001:$s="545555777877"; break;
            case 2002:$s="546566788877"; break;
            case 2003:$s="646566788987"; break;
            case 2004:$s="645455777877"; break;
            case 2005:$s="545555777877"; break;
            case 2006:$s="546566788877"; break;
            case 2007:$s="646566788987"; break;
            case 2008:$s="645455777877"; break;
            case 2009:$s="545555777877"; break;
            case 2010:$s="546556778877"; break;
            case 2011:$s="646566788987"; break;
            case 2012:$s="645455777877"; break;
            case 2013:$s="545555777877"; break;
            case 2014:$s="546556778877"; break;
            case 2015:$s="646566788887"; break;
            case 2016:$s="645455777877"; break;
            case 2017:$s="545455777877"; break;
            case 2018:$s="546556778877"; break;
            case 2019:$s="646566788887"; break;
            case 2020:$s="645455777877"; break;
            case 2021:$s="535455777877"; break;
            case 2022:$s="545556778877"; break;
            case 2023:$s="646566788887"; break;
            case 2024:$s="645455677877"; break;
            case 2025:$s="535455777877"; break;
            case 2026:$s="545556777877"; break;
            case 2027:$s="546566788887"; break;
            case 2028:$s="645455677876"; break;
            case 2029:$s="535455777877"; break;
            case 2030:$s="545555777877"; break;
            case 2031:$s="546566788887"; break;
            case 2032:$s="645455677876"; break;
            case 2033:$s="535455777877"; break;
            case 2034:$s="545555777877"; break;
            case 2035:$s="546566788877"; break;
            case 2036:$s="645455677876"; break;
            case 2037:$s="535455777877"; break;
            case 2038:$s="545555777877"; break;
            case 2039:$s="546566788877"; break;
            case 2040:$s="645455677876"; break;
            case 2041:$s="535455777877"; break;
            case 2042:$s="545555777877"; break;
            case 2043:$s="546556778877"; break;
            case 2044:$s="645455677876"; break;
            case 2045:$s="535455777877"; break;
            case 2046:$s="545455777877"; break;
            case 2047:$s="546556778877"; break;
            case 2048:$s="645455677776"; break;
            case 2049:$s="535455777877"; break;
            case 2050:$s="545455777877"; break;
            case 2051:$s="546556778877"; break;
            default  :
                if ($this->cmod($y, 4)==3) {
                    $s="646566788887";
                } else {
                    $s="546556778877";
                }
        }
        $m=$this->cmod($m, 12);
        $x=(int)substr($s,$m-1,1);
        return $x;
    }

    /*  本日年度　計算　関数 */
    function nowYear(){
        $date = new DateTime();

        /*本日日付*/
        $this_year = $date->format("Y");
        $this_month = $date->format("n");
        $this_day = $date->format("d");

        /*本日年度*/
        $arr = ["2021", "2025", "2029", "2033", "2037", "2041", "2045", "2049"];
        $key = in_array($this_year, $arr);

        if ($key){
            $first_day = 3;
        }else{
            $first_day = 4;
        }

        if ($this_month < 2){         // 1月は前年
            $now_year = $this_year - 1;
        } else if ($this_month > 2){  // 3月以降は今年
            $now_year = $this_year;
        } else {                     // 2月　節入日までは前年　　節入日以降は今年
            if ($this_day < $first_day){
                $now_year = $this_year - 1;
            } else {
                $now_year = $this_year;
            }
        }
        return $now_year;
    }

    function calc_nenkan($x){
        $date = new DateTime();
        $a=0;
        $this_year = $date->format("Y");
        $a=(($x + $this_year-2016)+3)%10;
        if ($a==0) {$a=10;}
        return $a;
    }

    function calc_nenshi($y) {
        $date = new DateTime();
        $b=0;
        $this_year = $date->format("Y");
        $b=(($y + $this_year-2016)+9)%12;
        if ($b==0) {$b=12;}
        return $b;
    }

    function calc_ttl_energy($a,$inData){
        $im_kd = $inData['im_kd'];
        $im_km = $inData['im_km'];
        $im_ky = $inData['im_ky'];
        $im_sd = $inData['im_sd'];
        $im_sm = $inData['im_sm'];
        $im_sy = $inData['im_sy'];
        $taiun_shi_arr = $inData['taiun_shi_arr'];
        $zero_y = $inData['zero_y'];
        $taiun_kan = $inData['taiun_kan'];

        /* 命式と裏蔵干と大運干と年運干から出した甲から癸までの個数　 [甲,乙,丙,丁,戊,己,庚,辛,壬,癸] */
        $no_of_kan=[0,0,0,0,0,0,0,0,0,0,0];
        $no_of_kan[$im_kd]=$no_of_kan[$im_kd]+1;//命式日干
        $no_of_kan[$im_km]=$no_of_kan[$im_km]+1;//命式月干
        $no_of_kan[$im_ky]=$no_of_kan[$im_ky]+1;//命式年干

        /* 裏蔵干の干の合計　*/
        for ($i = 1; $i < 4; $i++) {               //日支から
            $no_of_kan[$this->calc_ura_zokan($im_sd,$i)]++ ;
        }

        for ($i = 1; $i < 4; $i++) {//月支から
            $no_of_kan[$this->calc_ura_zokan($im_sm,$i)]++ ;
        }

        for ($i = 1; $i < 4; $i++) {                //年支から
            $no_of_kan[$this->calc_ura_zokan($im_sy,$i)]++;
        }

        /* 大運支からの干の算出 */
        for ($i = 1; $i < 4; $i++) {
            $no_of_kan[$this->calc_ura_zokan($taiun_shi_arr[$a],$i)]++ ;
        }

        /* 年運支からの干の算出 */
        for ($i = 1; $i < 4; $i++) {
            $no_of_kan[$this->calc_ura_zokan($this->calc_nenshi1912($zero_y+$a),$i)]++ ;
        }
        /* 年運　干を足す */
        $no_of_kan[$this->calc_nenkan1912($zero_y+$a)]++;

        /* 大運　干を算出　*/

        $no_of_kan[$taiun_kan[$a]]++;

        $x=0;
        $y=0;
        $energy_year=0;
        $ar_energy=[[0,0,0,0,0,0,0,0,0],       //[日支,月支,年支,大運支,年運支,小計,個数,干計,五行毎エネルギー（2,4,6,8,10列)]
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0]];
        for ($k=1; $k<11; $k++) {;
            $ar_energy[$k][0]=$this->calc_12jyu($k,$im_sd);                           //日支
            $ar_energy[$k][1]=$this->calc_12jyu($k,$im_sm);//月支
            $ar_energy[$k][2]=$this->calc_12jyu($k,$im_sy); //年支
            $ar_energy[$k][3]=$this->calc_12jyu($k,$taiun_shi_arr[$a]);                    //大運支
            $ar_energy[$k][4]=$this->calc_12jyu($k,$this->calc_nenshi1912($zero_y+$a)); //年運支
            $ar_energy[$k][5]=$ar_energy[$k][0]+$ar_energy[$k][1]+$ar_energy[$k][2]+$ar_energy[$k][3]+$ar_energy[$k][4];//小計
           $ar_energy[$k][6]=$no_of_kan[$k];//個数
           $ar_energy[$k][7]=$no_of_kan[$k]*$ar_energy[$k][5];//干計
           $energy_year=$energy_year+$ar_energy[$k][7];//エネルギー足し算
       }
        $gogyo_energy=[$ar_energy[1][7]+$ar_energy[2][7],$ar_energy[3][7]+$ar_energy[4][7],$ar_energy[5][7]+$ar_energy[6][7],$ar_energy[7][7]+$ar_energy[8][7],$ar_energy[9][7]+$ar_energy[10][7]];
        $x=$energy_year;
        //@todo 本間下あってる？gogyo_energyを逆順にして計算してると思われるのでphpでresortを使う
        //y=round((gogyo_energy.sort(sortNumber)[4]-gogyo_energy.sort(sortNumber)[0])/energy_year*1000)/1000;
        sort($gogyo_energy);

        $y=round(($gogyo_energy[4]-$gogyo_energy[0])/$energy_year*1000)/1000;

        return [$x,$y,$ar_energy];      // x:その年のエネルギー
    }

    function sortNumber($a, $b)
    {
        return $a - $b;
    }
    function multi_d_sort_($a, $b)
    {

        return ($a[1]-$b[1])*1;
    }

    function multi_d_sort($arr){
        usort($arr, array($this, "multi_d_sort_"));
        return $arr;

    }

    function multi_d_sort2_($a, $b)
    {

        return ($a[1]-$b[1])*-1;
    }

    function multi_d_sort2($arr){
        usort($arr, array($this, "multi_d_sort2_"));
        return $arr;

    }

    /***
     * 命式
     * @param $post
     * @return array
     */
    function arithmeticScienceResult($post){
        $date = new DateTime();
        $ar_input = array();
        $ar_param = array('y_inp', 'm_inp', 'd_inp', 'mei', 'sei', 'radio');

        foreach ($ar_param as $num => $v) {
            $ar_input[$v] = $post[$v];
        }

        if ($post['radio'] == "f") {
            $gender = "女";
        } else if ($post['radio'] == "m") {
            $gender = "男";
        } else {
            $gender = "";
        }

        ////  postデータをセット
        $b_y0 = $post['y_inp'];
        $b_m0 = $post['m_inp'];
        $b_d0 = $post['d_inp'];
        if ($post['sei'] == ""){
            $b_sei = "";
        }else{
            $b_sei = $post['sei'];
        }

        if ($post['mei'] == ""){
            $b_mei = "";
        }else{
            $b_mei = $post['mei'];
        }
        $your_sex = $gender;

////  本日日付
        $this_year = $date->format("Y");
        $this_month = $date->format("n");
        $this_day = $date->format("d");

        //print '<br>'.$this_year.'年'.$this_month.'月'.$this_day.'日';

        /* テーブル作成 */
        $d_10kan=array("癸","甲","乙","丙","丁","戊","己","庚","辛","壬","癸");
        $d_10kan1=array("","甲","乙","丙","丁","戊","己","庚","辛","壬","癸");
        $d_10kangg=array("　","木","木","火","火","土","土","金","金","水","水");
        $d_12shi=array(" ","子","丑","寅","卯","辰","巳","午","未","申","酉","戌","亥");
        $d_12shigg=array("　","水","土","木","木","土","火","火","土","金","金","土","水");
        $d_12shiggno=array(0,5,3,1,1,3,2,2,3,4,4,3,5);
        $d_10shu=array("　　","貫索","石門","鳳閣","調舒","祿存","司祿","車騎","牽牛","龍高","玉堂");
        $d_10urashu=array("　　","貫索","石門","龍高","玉堂","車騎","牽牛","祿存","司祿","鳳閣","調舒");
        $d_12jyuen=array("　　","天馳 1","天極 2","天報 3","天胡 4","天庫 5","天印 6","天恍 7","天堂 8","天貴 9","天南 10","天祿 11","天将 12");
        $d_12jyu=array("　　","馳","極","報","胡","庫","印","恍","堂","貴","南","祿","将");
        $d_12jyuenergy=array(" ","1","2","3","4","5","6","7","8","9","10","11","12");
        $d_gousan=array(" ","半会","支合","方三位","冲","刑","破","害","支合・破","刑・冲","刑・害","刑・破","支合・刑・破");
        $d_gogyo=array("","木","火","土","金","水");
        $d_nikan=array("","裏に引っ込む","自分から動かない","自立","人生のどこかで爆発的幸運","しぶとい・晩成型","耐久力","情の中の理","スケールが大か小か","気楽な人生","大器・度胸あり",
            "人を育てるのがうまい","感性がよい","頭の回転がいい","先祖の因縁を受ける","カッコつける","さわやか","進み上手","感性が強い","情があるが自分中心","堅実・まじめ",
            "自己犠牲","冷静","血濁","念が強い","たくましい","他力運・動かない","変化上手","お人好し","頭の回転がいい","風流人・趣味人",
            "人を犠牲にする","マイペース","隠れてコソコソする","人を巻き込む","血濁","度胸がいい","裏方が吉","自道・マイペース","感性が強い","一代で大成",
            "表に出たがる","情が厚い","波乱万丈","見かけと中身が違う","究極の救い","自力運・開拓者","逃げ上手","独特の感性","知的攻撃・画策する","忍耐強い",
            "人を育てない","自分から動く","晩成型・着実","１つの世界で頑張る","変化上手","他力運・もらい上手","はっきりしない","おとなしい自我","家柄の古さ","変化を好まない");

        $d_z_shugo=array([[0,0],[0,0],[0,0],[0,0],[0,0],[0,0]],
            [[0,0],["火、金","水、木"],["水","火、土"],["木、水","土、火"],["水","金、土"],["土、木","金、水"]],
            [[0,0],["金","水、木"],["土、金","木、火"],["木、金","土、火"],["木、火","金、水"],["木","金、水"]],
            [[0,0],["火、土","木、水"],["金、水","火、土"],["木、金","土、火"],["火","金"],["土、火","水、金"]],
            [[0,0],["金","木、水"],["金、水","火、木"],["木、金","土、火"],["水、火","金、土"],["土、木、火","水、金"]],
            [[0,0],["金","木"],["金","火、土"],["木、金","火、土"],["火、水","金"],["土、木","水、金"]]);

        /* 裏蔵干 */
        $d_10uraten=array(" ","癸","癸","戊","乙","乙","戊","己","丁","戊","辛","辛","甲");
        $d_10uratengg=array("　","水","水","土","木","木","土","土","火","土","金","金","木");
        $d_10urachi=array("　","癸","辛","丙","乙","癸","庚","己","乙","壬","辛","丁","甲");
        $d_10urachigg=array("　","水","金","火","木","水","金","土","木","水","金","金","木");
        $d_10urazou=array("　","癸","己","甲","乙","戊","丙","丁","己","庚","辛","戊","壬");
        $d_10urazougg=array("　","水","土","木","木","土","火","火","土","金","金","土","水");

        $shugosin_ar = array(["","丁丙庚","丁丙庚","丙癸","庚丙丁戊己","庚丁壬","癸丁庚","癸丁庚","癸庚丁","丁庚壬","丁庚丙","丁甲庚壬癸","庚丁丙戊"]
        ,["","丙","丙","丙癸","丙癸","癸丙戊","癸","癸丙","癸丙","丙癸己","癸丙丁","癸辛","丙戊"]
        ,["","壬戊己","壬甲","壬庚","壬庚","壬甲","壬庚癸","壬庚","壬庚","壬戊","壬癸","甲壬","甲戊庚壬"]
        ,["","甲庚","甲庚","甲庚","庚甲","甲庚","甲庚壬","壬庚癸","甲庚壬","甲庚丙戊","甲丙戊庚","甲戊庚","甲庚"]
        ,["","丙甲","丙甲","丙甲癸","丙甲癸","甲丙癸","癸甲丙","壬甲丙","癸甲丙","丙甲癸","丙癸","甲丙癸","甲丙"]
        ,["","丙甲戊","丙甲戊","丙甲庚","甲癸丙","丙甲癸","癸丙辛","壬丙辛","癸丙","丙癸","丙癸","甲丙癸","丙甲戊"]
        ,["","丁甲丙","丙丁甲","丙甲壬丁戊","丁甲丙庚","甲丁壬癸","壬丙戊丁","壬癸","丁甲","丁甲","丁甲丙","甲壬","丙丁甲"]
        ,["","丙壬甲戊","丙壬戊己","己壬庚","壬甲","壬甲","壬癸庚","壬己癸","壬甲庚","壬甲戊","壬甲","壬甲","壬甲丙"]
        ,["","戊丙","丙甲丁","戊庚丙","戊庚辛","甲庚","壬庚癸辛","癸庚辛","庚甲癸辛","戊丁","甲庚","甲丙","戊丙庚"]
        ,["","丙辛","丙丁","辛丙","庚辛","辛丙甲","辛","庚辛壬癸","庚辛壬癸","丁","辛丙","辛甲壬癸","庚辛丁戊"]
        );

        $baseData['d_10kan'] = $d_10kan;
        $baseData['d_10kan1'] = $d_10kan1;
        $baseData['d_10kangg'] = $d_10kangg;
        $baseData['d_12shi'] = $d_12shi;
        $baseData['d_12shigg'] = $d_12shigg;
        $baseData['d_12shiggno'] = $d_12shiggno;
        $baseData['d_10shu'] = $d_10shu;
        $baseData['d_10urashu'] = $d_10urashu;
        $baseData['d_12jyuen'] = $d_12jyuen;
        $baseData['d_12jyu'] = $d_12jyu;
        $baseData['d_12jyuenergy'] = $d_12jyuenergy;
        $baseData['d_gousan'] = $d_gousan;
        $baseData['d_gogyo'] = $d_gogyo;
        $baseData['d_nikan'] = $d_nikan;
        $baseData['d_z_shugo'] = $d_z_shugo;
        $baseData['d_10uraten'] = $d_10uraten;
        $baseData['d_10uratengg'] = $d_10uratengg;
        $baseData['d_10urachi'] = $d_10urachi;
        $baseData['d_10urachigg'] = $d_10urachigg;
        $baseData['d_10urazou'] = $d_10urazou;
        $baseData['d_10urazougg'] = $d_10urazougg;
        $baseData['shugosin_ar'] = $shugosin_ar;


        $s="312931303130313130313031";
        $x=(int)substr($s,($ar_input['m_inp']-1)*2,2);

        /*年齢計算*/
        $your_age=0;
        if($b_m0==$this_month && $b_d0 <= $this_day) {
            $your_age=$this_year-$b_y0;
        }else if ($b_m0==$this_month && $b_d0 > $this_day) {
            $your_age=$this_year-$b_y0-1;
        }else if ($b_m0 >$this_month)  {
            $your_age=$this_year-$b_y0-1;
        }else if ($b_m0 <$this_month)  {
            $your_age=$this_year-$b_y0;
        }else{
            $your_age="error";
        }

        //////// 異常干支　*/

        $dt2 = strtotime("1912-01-01");
        $dt1 = strtotime($post['y_inp']."-".($post['m_inp']-1)."-".$post['d_inp']);
        $diff = $dt1 - $dt2;
        $reki_d = $diff / 86400;    //1日は86400秒

        /* 日干支番号　算出　*/
        $nikkan_n=$reki_d%60;

        if($nikkan_n<17){
            $nikkan_n=$nikkan_n+44;
        }else if ($nikkan_n>=17){
            $nikkan_n=$nikkan_n-16;
        }else{
            $nikkan_n="error";
        }

        $x=$this->calc_setsu($b_y0, $b_m0);

        $y1=$b_y0;
        $m1=$b_m0;
        if ($x>$b_d0) {
            $c_sflg=1;
            $m1=$m1-1;
            if ($m1<1) {
                $m1=$m1+12;
                $y1=$y1-1;
            }
            $c_sdte=$this->calc_maxdte($y1, $m1)- $this->calc_setsu($y1, $m1) + $b_d0;
        } else {
            $c_sflg=0;
            $c_sdte=$b_d0-$x;
        }

        $im_py=$b_y0;
        if ($b_m0<2 || ($b_m0==2 && $c_sflg==1)) {
            $im_py=$im_py-1;
        }
        $im_py=$this->cmod($im_py-3, 60);
        $im_ky=$this->cmod($im_py, 10);
        $im_sy=$this->cmod($im_py, 12);
        $im_zy=$this->calc_zokan($im_sy, $c_sdte);
        $im_pm=$b_y0*12+$b_m0;
        if ($c_sflg==1) {
            $im_pm=$im_pm-1;
        }
        $im_pm=$this->cmod($im_pm-47, 60);
        $im_km=$this->cmod($im_pm, 10);
        $im_sm=$this->cmod($im_pm, 12);
        $im_zm=$this->calc_zokan($im_sm, $c_sdte);
        $x=$this->cdate($b_y0, $b_m0, $b_d0);
        $im_pd=$this->cmod($x, 60);
        $im_kd=$this->cmod($im_pd, 10);
        $im_sd=$this->cmod($im_pd, 12);
        $im_zd=$this->calc_zokan($im_sd, $c_sdte);
        $im_tx=11-$this->cint(($im_pd-1)/10)*2;

        $ym_sc=$this->calc_10shu($im_kd, $im_zm);
        $ym_se=$this->calc_10shu($im_kd, $im_zy);
        $ym_sw=$this->calc_10shu($im_kd, $im_zd);
        $ym_sn=$this->calc_10shu($im_kd, $im_ky);
        $ym_ss=$this->calc_10shu($im_kd, $im_km);
        $ym_jy=$this->calc_12jyu($im_kd, $im_sy);
        $ym_jm=$this->calc_12jyu($im_kd, $im_sm);
        $ym_jd=$this->calc_12jyu($im_kd, $im_sd);

        //////////////////  上記　正しいです　2018/1/10

        /* 異常干支　検査　日*/
        $ar1=[11,12,18,19,23,24,25,30,35,36,37,48,54];
        $ijoflag1 = 0;
        if (in_array($im_pd, $ar1)) {
            $ijoflag1 = 1;
        }

        /* 異常干支　検査　月*/
        $ar2=[11,12,18,19,23,24,25,30,35,36,37,48,54];
        $ijoflag2 = 0;
        if (in_array($im_pm, $ar2)) {
            $ijoflag2 = 1;
        }

        /* 異常干支　検査　年*/
        $ar3=[11,12,18,19,23,24,25,30,35,36,37,48,54];
        $ijoflag3 = 0;
        if (in_array($im_py, $ar3)) {
            $ijoflag3 = 1;
        }

        /* 次の節入日までの日数*/
        $yoku_setsu = 0;

        if($b_d0<=$this->calc_setsu($b_y0,$b_m0)){
            $yoku_setsu = $this->calc_setsu($b_y0,$b_m0)-$b_d0;
        }else if ($b_m0==12){
            $yoku_setsu = $this->calc_setsu($b_y0+1,1)+$this->calc_maxdte($b_y0,12)-$b_d0;
        }else{
            $yoku_setsu = $this->calc_setsu($b_y0,$b_m0+1)+$this->calc_maxdte($b_y0,$b_m0)-$b_d0;
        }

        /* 前の節入日までの日数*/
        $mae_setsu = 0;

        if($b_d0>=$this->calc_setsu($b_y0,$b_m0)){
            $mae_setsu = $b_d0-$this->calc_setsu($b_y0,$b_m0);
        }else if ($b_m0==1){
            $mae_setsu = $b_d0+$this->calc_maxdte($b_y0,12)-$this->calc_setsu($b_y0-1,12);
        }else{
            $mae_setsu = $b_d0-$this->calc_setsu($b_y0,$b_m0-1)+$this->calc_maxdte($b_y0,$b_m0-1);
        }

        /* 順行運初旬*/
        $j_shojun = 0;
        if($b_d0==$this->calc_setsu($b_y0,$b_m0)){
            $j_shojun = 10;
        }else if (intval($yoku_setsu/3)>=10){
            $j_shojun = 10;
        }else if (intval($yoku_setsu/3)<=1) {
            $j_shojun = 1;
        }else if ($yoku_setsu%3>=2) {
            $j_shojun = 1+intval($yoku_setsu/3);
        }else if ($yoku_setsu%3==1) {
            $j_shojun = intval($yoku_setsu/3);
        }else {
            $j_shojun = intval($yoku_setsu/3);
        }

        /* 逆行運初旬*/
        $g_shojun = 0;
        if($b_d0==$this->calc_setsu($b_y0,$b_m0)){
            $g_shojun = 1  ;
        }else if (intval($mae_setsu/3)>=10)  {
            $g_shojun = 10  ;
        }else if (intval($mae_setsu/3)<=1)  {
            $g_shojun = 1  ;
        }else if ($mae_setsu%3==2)        {
            $g_shojun = 1+intval($mae_setsu/3);
        }else if ($mae_setsu%3==1)        {
            $g_shojun = intval($mae_setsu/3);
        }else  {
            $g_shojun = intval($mae_setsu/3);
        }

        /*　性別チェック */
        $your_sex = $gender;

        /* 大運方向 */
        $sei_flag = 0 ;
        if($your_sex == "女"){
            $sei_flag = -1;
        }else if ($your_sex == "男"){
            $sei_flag = 1;
        }else{
            $sei_flag = "error" ;
        }

        $nen_inyou = 0 ;
        if     ($im_ky%2 == 0){
            $nen_inyou = -1;
        }else if ($im_ky%2 == 1){
            $nen_inyou = 1;
        }else{
            $nen_inyou = 0;
        }

        $taiunhoukou = 0  ;
        $taiunhoukou = $nen_inyou*$sei_flag  ;

        /* 初旬決定 */
        $shojun = 0;
        if($taiunhoukou == 1){
            $shojun = $j_shojun ;
        }else if ($taiunhoukou ==-1){
            $shojun = $g_shojun ;
        }else {
            $shojun = "error" ;
        }

        // /* 干支　*/
        $nenkan = 3;     //2016年基準年　年干＝丙(3)　年支＝申(9)
        $nenshi = 9;

        $nenkan = (($this_year-2016)+3)%10;

        if ($nenkan==0) {$nenkan=10;}
        $nenshi = (($this_year-2016)+9)%12;

        if ($nenshi==0) {$nenshi=12;}

        $moku=0;
        $ka=0;
        $dou=0;
        $gon=0;
        $sui=0;

        /*日干の五行*/
        if ($im_kd==1 || $im_kd==2) {
            $moku=$moku+1;
        }else if ($im_kd==3 || $im_kd==4){
            $ka=$ka+1;
        }else if ($im_kd==5 || $im_kd==6){
            $dou=$dou+1;
        }else if ($im_kd==7 || $im_kd==8){
            $gon=$gon+1;
        }else if ($im_kd==9 || $im_kd==10){
            $sui=$sui+1;
        }

        /*月干の五行*/
        if ($im_km==1 || $im_km==2) {
            $moku=$moku+1;
        }else if ($im_km==3 || $im_km==4){
            $ka=$ka+1;
        }else if ($im_km==5 || $im_km==6){
            $dou=$dou+1;
        }else if ($im_km==7 || $im_km==8){
            $gon=$gon+1;
        }else if ($im_km==9 || $im_km==10){
            $sui=$sui+1;
        }

        /*年干の五行*/
        if ($im_ky==1 || $im_ky==2) {
            $moku=$moku+1;
        }else if ($im_ky==3 || $im_ky==4){
            $ka=$ka+1;
        }else if ($im_ky==5 || $im_ky==6){
            $dou=$dou+1;
        }else if ($im_ky==7 || $im_ky==8){
            $gon=$gon+1;
        }else if ($im_ky==9 || $im_ky==10){
            $sui=$sui+1;
        }

        /*日支の五行*/
        if ($im_sd==3 || $im_sd==4) {
            $moku=$moku+1;
        }else if ($im_sd==6 || $im_sd==7){
            $ka=$ka+1;
        }else if ($im_sd==2 || $im_sd==5 || $im_sd==8 || $im_sd==11){
            $dou=$dou+1;
        }else if ($im_sd==9 || $im_sd==10){
            $gon=$gon+1;
        }else if ($im_sd==1 || $im_sd==12){
            $sui=$sui+1;
        }


        /*月支の五行*/
        if ($im_sm==3 || $im_sm==4) {
            $moku=$moku+2;
        }else if ($im_sm==6 || $im_sm==7){
            $ka=$ka+2;
        }else if ($im_sm==2 || $im_sm==5 || $im_sm==8 || $im_sm==11){
            $dou=$dou+2;
        }else if ($im_sm==9 || $im_sm==10){
            $gon=$gon+2;
        }else if ($im_sm==1 || $im_sm==12){
            $sui=$sui+2;
        }

        /*年支の五行*/
        if ($im_sy==3 || $im_sy==4) {
            $moku=$moku+1;
        }else if ($im_sy==6 || $im_sy==7){
            $ka=$ka+1;
        }else if ($im_sy==2 || $im_sy==5 || $im_sy==8 || $im_sy==11){
            $dou=$dou+1;
        }else if ($im_sy==9 || $im_sy==10){
            $gon=$gon+1;
        }else if ($im_sy==1 || $im_sy==12){
            $sui=$sui+1;
        }

        /* 三合会局　 　　　　　sangou_flag=1,2,3,4 なら　三合会局*/

        $sangou = array($im_sy,$im_sm,$im_sd);
        $sangou_flag=0;
        if ($this->array_equal_set($sangou,[1,5,9])){
            //水局
            $sangou_flag=1;
        }
        if ($this->array_equal_set($sangou,[2,6,10])){
            //金局
            $sangou_flag=2;
        }
        if ($this->array_equal_set($sangou,[3,7,11])){
            //火局
            $sangou_flag=3;
        }
        if ($this->array_equal_set($sangou,[4,8,12])){
            //木局
            $sangou_flag=4;
        }

        if ($sangou_flag==1 || $sangou_flag==2 || $sangou_flag==3 || $sangou_flag==4){
            if ($sangou_flag==1){
                // 化水で月支が子（水）なら
                if ($im_sm==1){
                    $sui=$sui+2;
                    $dou=$dou-1;
                    $gon=$gon-1;
                }
                if ($im_sm==5){
                    $sui=$sui+3;
                    $dou=$dou-2;
                    $gon=$gon-1;
                }
                if ($im_sm==9){
                    $sui=$sui+3;
                    $dou=$dou-1;
                    $gon=$gon-2;
                }
            }

            if ($sangou_flag==2){
                if ($im_sm==2){
                    $gon=$gon+3;
                    $dou=$dou-2;
                    $ka=$ka-1;
                }
                if ($im_sm==6){
                    $gon=$gon+3;
                    $dou=$dou-1;
                    $ka=$ka-2;
                }
                // 化金で月支が酉（金）なら
                if ($im_sm==10){
                    $gon=$gon+2;
                    $dou=$dou-1;
                    $ka=$ka-1;
                }
            }

            if ($sangou_flag==3){
                if ($im_sm==3){
                    $ka=$ka+3;
                    $moku=$moku-2;
                    $dou=$dou-1;
                }
                // 化火で月支が午（火）なら
                if ($im_sm==7){
                    $ka=$ka+2;
                    $moku=$moku-1;
                    $dou=$dou-1;
                }
                if ($im_sm==11){
                    $ka=$ka+3;
                    $moku=$moku-1;
                    $dou=$dou-2;
                }
            }

            if ($sangou_flag==4){
                // 化木で月支が卯（木）なら
                if ($im_sm==4){
                    $moku=$moku+2;
                    $dou=$dou-1;
                    $sui=$sui-1;
                }
                if ($im_sm==8){
                    $moku=$moku+3;
                    $dou=$dou-2;
                    $sui=$sui-1;
                }
                if ($im_sm==12){
                    $moku=$moku+3;
                    $dou=$dou-1;
                    $sui=$sui-2;
                }
            }
        }
        /* 方三位  sangou_flag=5,6,7,8 なら　方三位*/
        if ($this->array_equal_set($sangou,array(1,2,12))){
            //水局
            $sangou_flag=5;
        }
        if ($this->array_equal_set($sangou,array(3,4,5))){
            //木局
            $sangou_flag=6;
        }
        if ($this->array_equal_set($sangou,array(6,7,8))){
            //火局
            $sangou_flag=7;
        }
        if ($this->array_equal_set($sangou,array(9,10,11))){
            //金局
            $sangou_flag=8;
        }

        if ($sangou_flag==5 || $sangou_flag==6 || $sangou_flag==7 || $sangou_flag==8){
            if ($sangou_flag==5){
                if ($im_sm==1){
                    $sui=$sui+1;
                    $dou=$dou-1;
                }
                if ($im_sm==2){
                    $sui=$sui+2;
                    // 化水で月支が丑（土）なら 2個増減
                    $dou=$dou-2;
                }
                if ($im_sm==12){
                    $sui=$sui+1;
                    $dou=$dou-1;
                }
            }

            if ($sangou_flag==6){
                if ($im_sm==3){
                    $moku=$moku+1;
                    $dou=$dou-1;
                }
                if ($im_sm==4){
                    $moku=$moku+1;
                    $dou=$dou-1;
                }
                if ($im_sm==5){
                    $moku=$moku+2;
                    // 化木で月支が辰（土）なら  2個増減
                    $dou=$dou-2;
                }
            }

            if ($sangou_flag==7){
                if ($im_sm==6){
                    $ka=$ka+1;
                    $dou=$dou-1;
                }
                if ($im_sm==7){
                    $ka=$ka+1;
                    $dou=$dou-1;
                }
                if ($im_sm==8){
                    $ka=$ka+2;
                    // 化火で月支が未（土）なら  2個増減
                    $dou=$dou-2;
                }
            }

            if ($sangou_flag==8){
                if ($im_sm==9){
                    $gon=$gon+1;
                    $dou=$dou-1;
                }
                if ($im_sm==10){
                    $gon=$gon+1;
                    $dou=$dou-1;
                }
                if ($im_sm==11){
                    $gon=$gon+2;
                    // 化金で月支が戌（土）なら  2個増減
                    $dou=$dou-2;
                }
            }
        }

        /* 位相法表による五行の調整 */
        // d_12shiggno=[0,5,3,1,1,3,2,2,3,4,4,3,1];  支五行
        $isho_flag1=0;
        $isho_flag2=0;
        $isho_flag3=0;
        // 五行位相法表での増減array 初期化
        $gg_adj_isho=array(0,0,0,0,0,0,0,0,0,0,0,0);

        if ($this->calc_gogyo_shigo($im_sd,$im_sm)!=0){
            // 日月　支合
            $isho_flag1=1;
        }
        if ($this->calc_gogyo_hankai($im_sd,$im_sm)!=0) {
            // 日月　半会
            $isho_flag1=2;
        }
        if ($this->calc_gogyo_shigo($im_sd,$im_sy)!=0){
            // 日年　支合
            $isho_flag2=1;
        }
        if ($this->calc_gogyo_hankai($im_sd,$im_sy)!=0) {
            // 日年　半会
            $isho_flag2=2;
        }
        if ($this->calc_gogyo_shigo($im_sm,$im_sy)!=0)  {
            // 月年　支合
            $isho_flag3=1;
        }
        if ($this->calc_gogyo_hankai($im_sm,$im_sy)!=0) {
            // 月年　半会
            $isho_flag3=2;
        }

        /////////  五行特殊パターンフラグ設定 $special_flag //////////////////////////////////////////////

        $special_flag = 0;
        if ($this->array_equal_set($sangou,[1,6,9])) {
            //子申巳 月支が申
            if($im_sm==9){
                $special_flag=1;
            }else{
                $special_flag=2;
            }

        }
        if ($this->array_equal_set($sangou,[4,7,8])) {
            if ($im_sm==8){     //卯未牛 月支が未
                $special_flag=3;
            }else{
                $special_flag=4;
            }
        }

        if ($this->array_equal_set($sangou,[3,7,12])) {
            if($im_sm==3){    //牛寅亥 月支が寅
                $special_flag=5;
            }else{
                $special_flag=6;
            }

        }

        if ($this->array_equal_set($sangou,[1,2,10])) {
            if ($im_sm==2){     //酉丑子 月支が丑
                $special_flag=7;
            }else{
                $special_flag=8;
            }
        }

        ///  上記の変形
        if ($this->array_equal_set($sangou,[1,5,10])) {
            if($im_sm==5){      //酉辰子
                $special_flag=9;
            }else{
                $special_flag=10;
            }
        }

        if ($this->array_equal_set($sangou,[4,7,11])) {
            if($im_sm==11){     //卯戌牛
                $special_flag=11;
            }else{
                $special_flag=12;
            }
        }

        ///  １つの支が半会・支合する
        if ($this->array_equal_set($sangou,[6,9,10])) {
            if($im_sm==6){       //酉巳申
                $special_flag=13;
            }else{
                $special_flag=14;
            }
        }

        if ($this->array_equal_set($sangou,[3,4,12])) {
            if($im_sm==12){       //卯亥寅
                $special_flag=15;
            }else{
                $special_flag=16;
            }
        }
//////////////////////////////////////////////////   五行特殊パターン　設定　end

///////////    五行特殊パターン　処理　$special_flag != 0 ///////////////////////


        if ($sangou_flag==0 && $special_flag!=0){

            switch($special_flag){
                case 1:
                    // 月支が申 （金-2、水+1、金+1）
                    $gg_adj_isho[4]=$gg_adj_isho[4]-2;
                    $gg_adj_isho[4]=$gg_adj_isho[4]+2;
                    $gg_adj_isho[5]=$gg_adj_isho[5]+2;
                    break;

                case 2:
                    // 日年支が申 （金-1、水+1、金+1）
                    $gg_adj_isho[4]--;
                    $gg_adj_isho[4]++;
                    $gg_adj_isho[5]++;
                    break;

                case 3:
                    // 月支が未 （土-2、木+1、火+1）
                    $gg_adj_isho[3]=$gg_adj_isho[3]-2;
                    $gg_adj_isho[1]=$gg_adj_isho[1]+2;
                    $gg_adj_isho[2]=$gg_adj_isho[2]+2;
                    break;

                case 4:
                    // 月支が未 （土-1、木+1、火+1）
                    $gg_adj_isho[3]--;
                    $gg_adj_isho[1]++;
                    $gg_adj_isho[2]++;
                    break;

                case 5:
                    // 牛寅亥 月支が寅 （金-2、木+1、火+1）
                    $gg_adj_isho[4]=$gg_adj_isho[4]-2;
                    $gg_adj_isho[1]=$gg_adj_isho[1]+2;
                    $gg_adj_isho[2]=$gg_adj_isho[2]+2;
                    break;

                case 6:
                    // 日年支が寅 （金-1、木+1、火+1）
                    $gg_adj_isho[4]--;
                    $gg_adj_isho[1]++;
                    $gg_adj_isho[2]++;
                    break;

                case 7:
                    // 酉丑子 月支が丑 （土-2、水+1、金+1）
                    $gg_adj_isho[3]=$gg_adj_isho[3]-2;
                    $gg_adj_isho[1]=$gg_adj_isho[1]+2;
                    $gg_adj_isho[2]=$gg_adj_isho[2]+2;
                    break;

                case 8:
                    // 日年支が丑 （土-1、水+1、金+1）
                    $gg_adj_isho[3]--;
                    $gg_adj_isho[1]++;
                    $gg_adj_isho[2]++;
                    break;

                case 9:
                    // 酉辰子 月支が辰
                    $gg_adj_isho[3]=$gg_adj_isho[3]-2;
                    if ($dou>=3){       // 土>=3 （土+1）
                        $gg_adj_isho[3]=$gg_adj_isho[3]+2;
                    }else{             // 土<3 （金+1）
                        $gg_adj_isho[4]=$gg_adj_isho[4]+2;
                    }
                    $gg_adj_isho[5]=$gg_adj_isho[5]+2;
                    break;

                case 10:
                    // 日年支が辰 （土-1、水+1、金+1）
                    $gg_adj_isho[3]--;
                    if ($dou>=3){
                        $gg_adj_isho[3]++;
                    }else{
                        $gg_adj_isho[4]++;
                    }
                    $gg_adj_isho[5]++;
                    break;

                case 11:
                    // 卯戌牛 月支が戌
                    $gg_adj_isho[3]=$gg_adj_isho[3]-2;
                    if ($dou>=3){       // 土>=3 （土+1）
                        $gg_adj_isho[3]=$gg_adj_isho[3]+2;
                    }else{             // 土<3 （金+1）
                        $gg_adj_isho[1]=$gg_adj_isho[1]+2;
                    }
                    $gg_adj_isho[2]=$gg_adj_isho[2]+2;
                    break;

                case 12:
                    // 日年支が戌 （土-1、木+1、火+1）
                    $gg_adj_isho[3]--;
                    if ($dou>=3){
                        $gg_adj_isho[3]++;
                    }else{
                        $gg_adj_isho[1]++;
                    }
                    $gg_adj_isho[2]++;
                    break;

                case 13:
                    // 酉巳申 月支が巳
                    $gg_adj_isho[2]=$gg_adj_isho[2]-2;
                    $gg_adj_isho[4]=$gg_adj_isho[4]+2;

                    break;

                case 14:
                    // 酉巳申 日年支が巳
                    $gg_adj_isho[2]--;
                    $gg_adj_isho[4]++;

                    break;

                case 15:
                    // 卯亥寅 月支が亥
                    $gg_adj_isho[5]=$gg_adj_isho[5]-2;
                    $gg_adj_isho[1]=$gg_adj_isho[1]+2;
                    break;

                case 16:
                    // 日年支が亥
                    $gg_adj_isho[5]--;
                    $gg_adj_isho[1]++;

                    break;

                default:
                    break;
            }

        }
//////////////////////  五行特殊パターン　処理　end   ////////////
        if ($sangou_flag==0 && $special_flag==0){
            if ($isho_flag1+$isho_flag2+$isho_flag3==0) {
                $gg_adj_isho=array(0,0,0,0,0,0,0,0);
            }

            // 支合１個　-----------------------------------
            if ($isho_flag1+$isho_flag2+$isho_flag3==1){
                //日支・月支　
                if($isho_flag1==1){
                    if (($this->calc_gogyo_shigo($im_sd,$im_sm)==1) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==2) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==3) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==4) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==5)){
                        //日支!=化ける支　→　化ける　、　日支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_shigo($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]+1;
                        }
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_shigo($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]+2;
                        }
                    }
                }else if($isho_flag2==1){
                    // 日支・年支　
                    if (($this->calc_gogyo_shigo($im_sd,$im_sy)==1) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==2) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==3) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==4) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==5)){
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_shigo($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]+1;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_shigo($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]+1;
                        }
                    }else if(($this->calc_gogyo_shigo($im_sd,$im_sy)==6) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==7)){  // 木+1 土-1
                        $gg_adj_isho[1] = $gg_adj_isho[1]+1;
                        $gg_adj_isho[3] = $gg_adj_isho[3]-1;
                    }
                }else if($isho_flag3==1){
                    // 月支・年支　
                    if (($this->calc_gogyo_shigo($im_sm,$im_sy)==1) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==2) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==3) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==4) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==5)){
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_shigo($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]+2;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_shigo($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]+1;
                        }
                    }
                }
            }

            // 半会１個　----------------------------------------
            if (($isho_flag1==2 || $isho_flag2==2 || $isho_flag3==2) && ($isho_flag1+$isho_flag2+$isho_flag3==2)){
                // 日支・月支　
                if     ($isho_flag1==2){
                    if (($this->calc_gogyo_hankai($im_sd,$im_sm)==1) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==2) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==3) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==4) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==5)){
                        //日支!=化ける支　→　化ける　、　日支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_hankai($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]+1;
                        }
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_hankai($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]+2;
                        }
                    }
                }else if($isho_flag2==2){
                    // 日支・年支　
                    if (($this->calc_gogyo_hankai($im_sd,$im_sy)==1) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==2) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==3) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==4) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==5)){
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_hankai($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]+1;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_hankai($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]+1;
                        }
                    }
                }else if($isho_flag3==2){
                    // 月支・年支　
                    if (($this->calc_gogyo_hankai($im_sm,$im_sy)==1) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==2) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==3) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==4) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==5)){
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_hankai($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]+2;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_hankai($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]+1;
                        }
                    }
                }
            }

            // 支合１個　半会１個　(酉巳申、卯亥寅　以外）　---------------------------------------
            if ($isho_flag1+$isho_flag2+$isho_flag3==3){;
                // 支合1個--------
                // 日支・月支　
                if     ($isho_flag1==1){
                    if (($this->calc_gogyo_shigo($im_sd,$im_sm)==1) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==2) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==3) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==4) || ($this->calc_gogyo_shigo($im_sd,$im_sm)==5)){
                        //日支!=化ける支　→　化ける　、　日支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_shigo($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]+1;
                        }
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_shigo($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]+2;
                        }
                    }
                }else if($isho_flag2==1){
                    // 日支・年支　
                    if (($this->calc_gogyo_shigo($im_sd,$im_sy)==1) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==2) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==3) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==4) || ($this->calc_gogyo_shigo($im_sd,$im_sy)==5)){
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_shigo($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]+1;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_shigo($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]+1;
                        }
                    }
                }else if($isho_flag3==1){
                    // 月支・年支　
                    if (($this->calc_gogyo_shigo($im_sm,$im_sy)==1) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==2) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==3) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==4) || ($this->calc_gogyo_shigo($im_sm,$im_sy)==5)){
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_shigo($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]+2;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_shigo($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]+1;
                        }
                    }
                }

                // 半会1個　---------
                // 日支・月支　
                if     ($isho_flag1==2){;
                    if (($this->calc_gogyo_hankai($im_sd,$im_sm)==1) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==2) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==3) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==4) || ($this->calc_gogyo_hankai($im_sd,$im_sm)==5)){
                        //日支!=化ける支　→　化ける　、　日支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_hankai($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]+1;
                        }
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_hankai($im_sd,$im_sm)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]+2;
                        }
                    }
                }else if($isho_flag2==2){
                    // 日支・年支　
                    if (($this->calc_gogyo_hankai($im_sd,$im_sy)==1) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==2) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==3) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==4) || ($this->calc_gogyo_hankai($im_sd,$im_sy)==5)){
                        if ($d_12shiggno[$im_sd]!=$this->calc_gogyo_hankai($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]+1;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_hankai($im_sd,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]+1;
                        }
                    }
                }else if($isho_flag3==2){
                    // 月支・年支　
                    if (($this->calc_gogyo_hankai($im_sm,$im_sy)==1) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==2) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==3) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==4) || ($this->calc_gogyo_hankai($im_sm,$im_sy)==5)){
                        //月支!=化ける支　→　化ける（月支が化けるときは２個増減）　、　月支=化ける支　→　変化なし
                        if ($d_12shiggno[$im_sm]!=$this->calc_gogyo_hankai($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]+2;
                        }
                        if ($d_12shiggno[$im_sy]!=$this->calc_gogyo_hankai($im_sm,$im_sy)) {
                            $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                            $gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]+1;
                        }
                    }
                }

            }


            // 半会2個　-------------------------------------------------
            if (($isho_flag1+$isho_flag2+$isho_flag3==4) && ($isho_flag1==0 || $isho_flag2==0 || $isho_flag3==0)){
                if ($isho_flag1==2){
                    $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                    $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                    $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                    $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sm)]+4;
                }else if($isho_flag2==2){
                    $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                    $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                    $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                    $gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sd,$im_sy)]+4;
                }else if($isho_flag3==2){
                    $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                    $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                    $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                    $gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_hankai($im_sm,$im_sy)]+4;
                }
            }

            // 支合2個　------------------------------------------------------
            if (($isho_flag1==1 || $isho_flag2==1 || $isho_flag3==1) && ($isho_flag1+$isho_flag2+$isho_flag3==2)){;
                if ($isho_flag1==0){
                    if ($this->calc_gogyo_shigo($im_sd,$im_sy)==6 || $this->calc_gogyo_shigo($im_sd,$im_sy)==7){
                    }else{
                        $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                        $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                        $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                        $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sy)]+4;
                    }
                }else if($isho_flag2==0){
                    if ($this->calc_gogyo_shigo($im_sd,$im_sy)==6 || $this->calc_gogyo_shigo($im_sd,$im_sy)==7){
                    }else{
                        $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                        $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                        $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                        
                        $gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sm,$im_sy)]+4;
                    }
                }else if($isho_flag3==0){
                    if ($this->calc_gogyo_shigo($im_sd,$im_sy)==6 || $this->calc_gogyo_shigo($im_sd,$im_sy)==7){
                    }else{
                        $gg_adj_isho[$d_12shiggno[$im_sd]]=$gg_adj_isho[$d_12shiggno[$im_sd]]-1;
                        $gg_adj_isho[$d_12shiggno[$im_sm]]=$gg_adj_isho[$d_12shiggno[$im_sm]]-2;
                        $gg_adj_isho[$d_12shiggno[$im_sy]]=$gg_adj_isho[$d_12shiggno[$im_sy]]-1;
                        $gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]=$gg_adj_isho[$this->calc_gogyo_shigo($im_sd,$im_sm)]+4;
                    }
                }
            }
        }
        /* 干合表による五行の調整 */
        // 天干の変化前五行を配列に
        $gg_adj_kango_base=array(0,0,0,0,0,0);
        ++$gg_adj_kango_base[$this->calc_gogyo_kan($im_kd)];
        ++$gg_adj_kango_base[$this->calc_gogyo_kan($im_km)];
        ++$gg_adj_kango_base[$this->calc_gogyo_kan($im_ky)];
        $im_kd_c=$im_kd;
        $im_km_c=$im_km;
        $im_ky_c=$im_ky;
        // 干合表での五行調整array 初期化
        $gg_adj_kango=array(0,0,0,0,0,0);


        // 日支・月支　間
        if (abs($im_kd-$im_km)==5) {
            if ($im_kd==1 && $d_12shiggno[$im_sm]==3){;
                $im_kd_c=5; // 甲己干合（化土）で月支五行が土なら化ける
                $im_km_c=6;
            }else if ($im_kd==6 && $d_12shiggno[$im_sm]==3){;
                $im_kd_c=6;
                $im_km_c=5;
            }else if ($im_kd==2 && $d_12shiggno[$im_sm]==4){;
                $im_kd_c=8;  //　庚乙干合（化金）で月支五行が金なら化ける
                $im_km_c=7;
            }else if ($im_kd==7 && $d_12shiggno[$im_sm]==4){;
                $im_kd_c=7;
                $im_km_c=8;
            }else if ($im_kd==3 && $d_12shiggno[$im_sm]==5){;
                $im_kd_c=9;  // 丙辛干合（化水）で月支五行が水なら化ける　　　　　　　
                $im_km_c=10;
            }else if ($im_kd==8 && $d_12shiggno[$im_sm]==5){;
                $im_kd_c=10;
                $im_km_c=9;
            }else if ($im_kd==4 && $d_12shiggno[$im_sm]==1){;
                $im_kd_c=2;   // 壬丁干合（化木）で月支が木なら化ける
                $im_km_c=1;
            }else if ($im_kd==9 && $d_12shiggno[$im_sm]==1){;
                $im_kd_c=1;
                $im_km_c=2;
            }else if ($im_kd==5 && $d_12shiggno[$im_sm]==2){;
                $im_kd_c=3;   //　戊癸干合（化火）で月支が火なら化ける
                $im_km_c=4;
            }else if ($im_kd==10 && $d_12shiggno[$im_sm]==2){;
                $im_kd_c=4;
                $im_km_c=3;
            }
        }

        // 日支・年支　間
        if(abs($im_kd-$im_ky)==5) {
            //←干合条件
            if ($im_kd==1 && $d_12shiggno[$im_sm]==3){;
                $im_kd_c=5;// 甲己干合（化土）で月支五行が土なら化ける
                $im_ky_c=6;
            }else if ($im_kd==6 && $d_12shiggno[$im_sm]==3){
                $im_kd_c=6;
                $im_ky_c=5;
            }else if ($im_kd==2 && $d_12shiggno[$im_sm]==4){
                $im_kd_c=8;//　庚乙干合（化金）で月支五行が金なら化ける
                $im_ky_c=7;
            }else if ($im_kd==7 && $d_12shiggno[$im_sm]==4){;
                $im_kd_c=7;
                $im_ky_c=8;
            }else if ($im_kd==3 && $d_12shiggno[$im_sm]==5){;
                $im_kd_c=9;// 丙辛干合（化水）で月支五行が水なら化ける
                $im_ky_c=10;
            }else if ($im_kd==8 && $d_12shiggno[$im_sm]==5){;
                $im_kd_c=10;
                $im_ky_c=9;
            }else if ($im_kd==4 && $d_12shiggno[$im_sm]==1){;
                $im_kd_c=2;// 壬丁干合（化木）で月支が木なら化ける
                $im_ky_c=1;
            }else if ($im_kd==9 && $d_12shiggno[$im_sm]==1){;
                $im_kd_c=1;
                $im_ky_c=2;
            }else if ($im_kd==5 && $d_12shiggno[$im_sm]==2){;
                $im_kd_c=3;//　戊癸干合（化火）で月支が火なら化ける
                $im_ky_c=4;
            }else if ($im_kd==10 && $d_12shiggno[$im_sm]==2){;
                $im_kd_c=4;
                $im_ky_c=3;
            }
        }

        // 月支・年支　間
        if(abs($im_km-$im_ky)==5) {
            if  ($im_km==1 && $d_12shiggno[$im_sm]==3){;// 甲己干合（化土）で月支五行が土なら化ける
                $im_km_c=5;
                $im_ky_c=6;
            }else if ($im_km==6 && $d_12shiggno[$im_sm]==3){;
                $im_km_c=6;
                $im_ky_c=5;
            }else if ($im_km==2 && $d_12shiggno[$im_sm]==4){;//　庚乙干合（化金）で月支五行が金なら化ける
                $im_km_c=8;
                $im_ky_c=7;
            }else if ($im_km==7 && $d_12shiggno[$im_sm]==4){;
                $im_km_c=7;
                $im_ky_c=8;
            }else if ($im_km==3 && $d_12shiggno[$im_sm]==5){;// 丙辛干合（化水）で月支五行が水なら化ける　　　　　　　
                $im_km_c=9;
                $im_ky_c=10;
            }else if ($im_km==8 && $d_12shiggno[$im_sm]==5){;
                $im_km_c=10;
                $im_ky_c=9;
            }else if ($im_km==4 && $d_12shiggno[$im_sm]==1){;// 壬丁干合（化木）で月支が木なら化ける
                $im_km_c=2;
                $im_ky_c=1;
            }else if ($im_km==9 && $d_12shiggno[$im_sm]==1){;
                $im_km_c=1;
                $im_ky_c=2;
            }else if ($im_km==5 && $d_12shiggno[$im_sm]==2){;//　戊癸干合（化火）で月支が火なら化ける
                $im_km_c=3;
                $im_ky_c=4;
            }else if ($im_km==10 && $d_12shiggno[$im_sm]==2){;
                $im_km_c=4;
                $im_ky_c=3;
            }
        }
        ++$gg_adj_kango[$this->calc_gogyo_kan($im_kd_c)];
        ++$gg_adj_kango[$this->calc_gogyo_kan($im_km_c)];
        ++$gg_adj_kango[$this->calc_gogyo_kan($im_ky_c)];
        //   基本の五行に三合会局・方三位・位相法・干合表を考慮して　五行を調整する
        $gogyo_base=array(0,$moku,$ka,$dou,$gon,$sui);     //←　基本五行に三合会局・方三位を加味してます
        $gogyo_last=array(0,0,0,0,0,0);

        for ($i = 0; $i < 6; $i++){
            $gogyo_last[$i]=$gogyo_base[$i]+$gg_adj_isho[$i]-$gg_adj_kango_base[$i]+$gg_adj_kango[$i];
        }
        /// 位相法表で酉辰(化金・土)、卯戌(化木・土) 調整後五行に土>=3あれば。
        $toritatu_flag=0;
        // 酉辰　組合せ個数
        if ($this->calc_gogyo_cng($im_sd,$im_sm)==6) {

            ++$toritatu_flag;
        }
        if ($this->calc_gogyo_cng($im_sd,$im_sy)==6) {
            ++$toritatu_flag;
        }
        if ($this->calc_gogyo_cng($im_sm,$im_sy)==6) {
            ++$toritatu_flag;
        }
        if (($im_sd+$im_sm+$im_sy==20) && ($toritatu_flag==2)) {
            $toritatu_flag=3;    // flag=3なら金１個と土2個　　　　flag=2なら金２個と土１個
        }

        $uinu_flag=0;
        if ($this->calc_gogyo_cng($im_sd,$im_sm)==7) {// 卯戌　組合せ個数
            ++$uinu_flag;
        }
        if ($this->calc_gogyo_cng($im_sd,$im_sy)==7) {
            ++$uinu_flag;
        }
        if ($this->calc_gogyo_cng($im_sm,$im_sy)==7) {
            ++$uinu_flag;
        }
        if (($im_sd+$im_sm+$im_sy==26) && ($uinu_flag==2)) {
            $uinu_flag=3;    //土2個
        }

        // 酉（金）辰（土）調整
        if (($sangou_flag==0) && ($toritatu_flag==1) && ($special_flag==0)){;        // １組の場合
            if ($gogyo_last[3]>=3){;
                if ($im_sm==10){;
                    $gogyo_last[3]=$gogyo_last[3]+2;
                    $gogyo_last[4]=$gogyo_last[4]-2;     // 土>=３　しかも　月支が酉（金）なので　土+2　金-2
                }
                if ($im_sm==5){;
                    ++$gogyo_last[3];
                    --$gogyo_last[4];
                }
            }else{;
                if ($im_sm==5){;
                    $gogyo_last[3]=$gogyo_last[3]-2;
                    $gogyo_last[4]=$gogyo_last[4]+2;
                }
                if ($im_sm==10){;
                    --$gogyo_last[3];
                    ++$gogyo_last[4];
                }
            }
        }

        if (($sangou_flag==0) && ($toritatu_flag==2) && ($special_flag==0)){;        // 地支に金２個と土１個の場合
            if ($gogyo_last[3]>=3){;
                if ($im_sm==10){;
                    $gogyo_last[3]=$gogyo_last[3]+3;
                    $gogyo_last[4]=$gogyo_last[4]-3;     // 土>=３　しかも　月支が酉（金）で残りが酉（金）辰（土）なので　土+3　金-3
                }
                if ($im_sm==5)  {
                    $gogyo_last[3]=$gogyo_last[3]+2;
                    $gogyo_last[4]=$gogyo_last[4]-2;  // 月支が辰（土）なので　土+2 金-2
                }
            }else{;
                if ($im_sm==5)  {
                    $gogyo_last[3]=$gogyo_last[3]-2;
                    $gogyo_last[4]=$gogyo_last[4]+2;  //月支が辰（土）で化金なので　土-2 金+2
                }
                if ($im_sm==10) {
                    $gogyo_last[3]--;
                    $gogyo_last[4]++;                //月支が酉（金）で残りが酉（金）辰（土）で化金なので　土-1金+1
                }
            }
        }

        if (($sangou_flag==0) && ($toritatu_flag==3) && ($special_flag==0)){;        // 地支に金１個と土２個の場合
            if ($gogyo_last[3]>=3){;
                if ($im_sm==10){;
                    $gogyo_last[3]=$gogyo_last[3]+2;
                    $gogyo_last[4]=$gogyo_last[4]-2;     // 土>=３　しかも　月支が酉（金）なので　土+2　金-2
                }
                if ($im_sm==5)  {
                    ++$gogyo_last[3];
                    --$gogyo_last[4];
                }                                         // 月支が辰（土）なので　土+1 金-1
            }else{;
                if ($im_sm==5)  {
                    $gogyo_last[3]=$gogyo_last[3]-3;
                    $gogyo_last[4]=$gogyo_last[4]+3;     //月支が辰（土）で残りが辰（土）酉（金）で化金なので　土-3 金+3
                }
                if ($im_sm==10) {
                    $gogyo_last[3]=$gogyo_last[3]-2;
                    $gogyo_last[4]=$gogyo_last[4]+2;           //月支が酉（金）で残りが辰（土）２個で化金なので　土-2金+2
                }
            }
        }

        // 卯（木）戌（土）調整
        if (($sangou_flag==0) && ($uinu_flag==1) && ($special_flag==0)){;        // １組の場合
            if ($gogyo_last[3]>=3){;
                if ($im_sm==4){;
                    $gogyo_last[3]=$gogyo_last[3]+2;
                    $gogyo_last[1]=$gogyo_last[1]-2;     // 土>=３　しかも　月支が卯（木）なので　土+2　木-2
                }
                if ($im_sm==11)  {
                    ++$gogyo_last[3];
                    --$gogyo_last[1];
                }
            }else{;
                if ($im_sm==11)  {
                    $gogyo_last[3]=$gogyo_last[3]-2;
                    $gogyo_last[1]=$gogyo_last[1]+2;
                }
                if ($im_sm==4)   {
                    --$gogyo_last[3];
                    ++$gogyo_last[1];
                }
            }
        }

        if (($sangou_flag==0) && ($uinu_flag==2) && ($special_flag==0)){;        // 地支に木２個と土１個の場合
            if ($gogyo_last[3]>=3){;
                if ($im_sm==4){;
                    $gogyo_last[3]=$gogyo_last[3]+3;
                    $gogyo_last[1]=$gogyo_last[1]-3;   // 土>=３　しかも　月支が卯（木）で残りが卯（木）戌（土）なので　土+3　木-3
                }
                if ($im_sm==11)  {
                    $gogyo_last[3]=$gogyo_last[3]+2;
                    $gogyo_last[1]=$gogyo_last[1]-2;   // 月支が戌（土）で残りが卯（木）２個なので　土+2 木-2
                }
            }else{;
                if ($im_sm==11)  {
                    $gogyo_last[3]=$gogyo_last[3]-2;
                    $gogyo_last[1]=$gogyo_last[1]+2;    //月支が戌（土）で残りが卯（木）２個で化木なので　土-2 木+2
                }
                if ($im_sm==4)   {
                    --$gogyo_last[3];
                    ++$gogyo_last[1];                   //月支が卯（木）で残りが卯（木）戌（土）で化木なので　土-1木+1
                }
            }
        }

        if (($sangou_flag==0) && ($uinu_flag==3) && ($special_flag==0)){;        // 地支に木１個と土２個の場合
            if ($gogyo_last[3]>=3){;
                if ($im_sm==4){;
                    $gogyo_last[3]=$gogyo_last[3]+2;
                    $gogyo_last[1]=$gogyo_last[1]-2;        // 土>=３　しかも　月支が卯（木）残りが戌(土）２個なので　土+2　木-2
                }
                if ($im_sm==11)  {
                    ++$gogyo_last[3];
                    --$gogyo_last[1];                   // 月支が戌（土）残りが卯（木）戌（土）なので　土+1 木-1
                }
            }else{;
                if ($im_sm==11)  {
                    $gogyo_last[3]=$gogyo_last[3]-3;
                    $gogyo_last[1]=$gogyo_last[1]+3;    //月支が戌（土）で残りが戌（土）卯（木）で化木なので　土-3 木+3
                }
                if ($im_sm==4)   {
                    $gogyo_last[3]-2;
                    $gogyo_last[1]=$gogyo_last[1]+2;                  //月支が卯（木）で残りが戌（土）２個で化木なので　土-2木+2
                }
            }
        }
        $moku=$gogyo_last[1];
        $ka=$gogyo_last[2];
        $dou=$gogyo_last[3];
        $gon=$gogyo_last[4];
        $sui=$gogyo_last[5];


        /* 全体守護神　計算　*/
        $z_shugoshin_flag=0;
        $z_shugoshin=0;
        $imigami=0;
        $max_gogyo=0;
        $nikkan_gogyo=round($im_kd/2);

        if (max($gogyo_last)>=4){;     // 五行のどれかが４以上あるなら全体守護神
            $max_gogyo = array_search(max($gogyo_last),$gogyo_last);
            $z_shugoshin_flag=1;
            $z_shugoshin=$d_z_shugo[$nikkan_gogyo][$max_gogyo][0];       //全体守護神　決定
            $imigami=$d_z_shugo[$nikkan_gogyo][$max_gogyo][1];           //忌神　決定

        }

        /* 伴星　算出　*/
        $bansei=0;
        if ($im_ky<=5) {
            $bansei=$im_ky+5;
        }
        if ($im_ky>=6) {
            $bansei=$im_ky-5;
        }

        $bansei = $this->calc_10shu($im_kd,$bansei) ;
        $bansei = $d_10shu[$bansei];

        /* 才能　　1:北天運　 2:西天運　 3:東天運　 4:南天運  */

        $tenun=array(3,4,9,10);
        $tenun_flag = 0;
        $tenunmei = "";
        if(in_array($ym_sn,$tenun)==false && in_array($ym_se,$tenun)==false && in_array($ym_sc,$tenun)==false && in_array($ym_sw,$tenun)==false && in_array($ym_ss,$tenun)==false) {
            $tenunmei="南天運";
            $tenun_flag=4;
        }else if ((in_array($ym_sn,$tenun)==false && in_array($ym_sc,$tenun)==false && in_array($ym_ss,$tenun)==false)&&(in_array($ym_se,$tenun)==true ||  in_array($ym_sw,$tenun)==true)){
            $tenunmei="東天運";
            $tenun_flag=3;
        }else if ((in_array($ym_se,$tenun)==false && in_array($ym_sc,$tenun)==false && in_array($ym_sw,$tenun)==false)&&(in_array($ym_sn,$tenun)==true ||  in_array($ym_ss,$tenun)==true)){
            $tenunmei="西天運";
            $tenun_flag=2;
        }else{
            $tenunmei="北天運";
            $tenun_flag=1;
        }

        /* 剋線占技　　剋線個数　と　従星算出　*/
        $chishi=array(0,0,0,0,0,0,0,0,0,0,0);     //地支の数　集計
        $chishi[$ym_sn]=$chishi[$ym_sn]+1;
        $chishi[$ym_sw]=$chishi[$ym_sw]+1;
        $chishi[$ym_sc]=$chishi[$ym_sc]+1;
        $chishi[$ym_se]=$chishi[$ym_se]+1;
        $chishi[$ym_ss]=$chishi[$ym_ss]+1;


        $kokusen=array(0,0,0,0,0,0,0,0,0,0,0);

        if ($this->calc_kokusen($ym_sn,$ym_sw)==2){
            $kokusen[$ym_sn]=$kokusen[$ym_sn]+1;
            $kokusen[$ym_sw]=$kokusen[$ym_sw]+1;
        }
        if ($this->calc_kokusen($ym_sn,$ym_sc)==2){
            $kokusen[$ym_sn]=$kokusen[$ym_sn]+1;
            $kokusen[$ym_sc]=$kokusen[$ym_sc]+1;
        }
        if ($this->calc_kokusen($ym_sn,$ym_se)==2){
            $kokusen[$ym_sn]=$kokusen[$ym_sn]+1;
            $kokusen[$ym_se]=$kokusen[$ym_se]+1;
        }
        if ($this->calc_kokusen($ym_sn,$ym_ss)==2){
            $kokusen[$ym_sn]=$kokusen[$ym_sn]+1;
            $kokusen[$ym_ss]=$kokusen[$ym_ss]+1;
        }
        if ($this->calc_kokusen($ym_sw,$ym_sc)==2){
            $kokusen[$ym_sw]=$kokusen[$ym_sw]+1;
            $kokusen[$ym_sc]=$kokusen[$ym_sc]+1;
        }
        if ($this->calc_kokusen($ym_sw,$ym_se)==2){
            $kokusen[$ym_sw]=$kokusen[$ym_sw]+1;
            $kokusen[$ym_se]=$kokusen[$ym_se]+1;
        }
        if ($this->calc_kokusen($ym_sw,$ym_ss)==2){
            $kokusen[$ym_sw]=$kokusen[$ym_sw]+1;
            $kokusen[$ym_ss]=$kokusen[$ym_ss]+1;
        }
        if ($this->calc_kokusen($ym_sc,$ym_se)==2){
            $kokusen[$ym_sc]=$kokusen[$ym_sc]+1;
            $kokusen[$ym_se]=$kokusen[$ym_se]+1;
        }
        if ($this->calc_kokusen($ym_sc,$ym_ss)==2){
            $kokusen[$ym_sc]=$kokusen[$ym_sc]+1;
            $kokusen[$ym_ss]=$kokusen[$ym_ss]+1;
        }
        if ($this->calc_kokusen($ym_se,$ym_ss)==2){
            $kokusen[$ym_se]=$kokusen[$ym_se]+1;
            $kokusen[$ym_ss]=$kokusen[$ym_ss]+1;
        }


        for ($i = 0; $i < 11; $i++) {
            if ($chishi[$i]!=0) {
                $kokusen[$i]=$kokusen[$i]/$chishi[$i];
            }
        }

        /* 数理エネルギー　算出　*/
        $kan_no = array(0,0,0,0,0,0,0,0,0,0,0);

        $kan_no[$im_kd]=$kan_no[$im_kd]+1;//命式日干
        $kan_no[$im_km]=$kan_no[$im_km]+1;//命式月干
        $kan_no[$im_ky]=$kan_no[$im_ky]+1;//命式年干

        /* 支　合計算出　ルーチン　　　　　裏蔵干の支の合計　*/
        for ($i = 1; $i < 4; $i++) {;                   //日支から
            ++$kan_no[$this->calc_ura_zokan($im_sd,$i)];
        }

        for ($i = 1; $i < 4; $i++) {;                   //月支から
            ++$kan_no[$this->calc_ura_zokan($im_sm,$i)];
        }

        for ($i = 1; $i < 4; $i++) {;                   //年支から
            ++$kan_no[$this->calc_ura_zokan($im_sy,$i)];
        }

        /* エネルギー値　小計　合計*/
        $energy_sum1=array(0,0,0,0,0,0,0,0,0,0,0);
        for ($i = 1; $i < 11; $i++) {;
            $energy_sum1[$i]=$this->calc_12jyu($i,$im_sd)+$this->calc_12jyu($i,$im_sm)+$this->calc_12jyu($i,$im_sy) ;
        }

        $energy_sum2 = array(0,0,0,0,0,0);

        for ($i = 0; $i < 5; $i++) {;
            $energy_sum2[$i+1]=$energy_sum1[$i*2+1]*$kan_no[$i*2+1]+$energy_sum1[$i*2+2]*$kan_no[$i*2+2];
        }

        /* エネルギー値総合計　*/
        $energy_sum0=0;
        for ($i = 1; $i < 6; $i++) {;
            $energy_sum0=$energy_sum0+$energy_sum2[$i];
        } ;

        /* 数理エネルギー　五行　*/
        $suri_gogyo=[0,0,0,0,0];

        for ($i = 0; $i < 5; $i++) {;
            $suri_gogyo[$i]=$this->calc_suri_gogyo($im_kd,$i);
        }

        /* 0歳の西暦　*/
        $zero_y = 0;
        if ($b_m0==1 || ($b_m0==2 && $b_d0 < $this->calc_setsu($b_y0,2))){
            $zero_y = $b_y0-1;
        }else{
            $zero_y=$b_y0;
        }

        //////  動力占技　平力占技　準備　///////////////////////////////////////////////////////////////////////

        $zero_jun_kanshi = 0;
        $zero_jun_kanshi = $im_pm;

        $zero_jun_kan=0;
        if    ($zero_jun_kanshi%10==0) $zero_jun_kan=10;
        else                            $zero_jun_kan=$zero_jun_kanshi%10;

        $zero_jun_shi=0 ;
        if    ($zero_jun_kanshi%12==0) $zero_jun_shi=12;
        else                            $zero_jun_shi=$zero_jun_kanshi%12;


        /*　i歳時の大運干*/
        //@todo taiun_kanと変数が被るのでtaiun_kan_arrayに変更
        $taiun_kan_array=[$zero_jun_kan];          //　左記には宣言してないが１０１個要素を書き出してる
        $k=0;
        for ($i=1; $i<101; $i++){;
            if ($i<$shojun+$k*10){;
                $taiun_kan_array[$i]=$taiun_kan_array[$i-1];
            }else{
                if ($taiunhoukou==1 && $taiun_kan_array[$i-1]==10) $taiun_kan_array[$i]=1;
                if ($taiunhoukou==1 && $taiun_kan_array[$i-1]!=10) $taiun_kan_array[$i]=$taiun_kan_array[$i-1]+1;
                if ($taiunhoukou==-1 && $taiun_kan_array[$i-1]==1) $taiun_kan_array[$i]=10;
                if ($taiunhoukou==-1 && $taiun_kan_array[$i-1]!=1) $taiun_kan_array[$i]=$taiun_kan_array[$i-1]-1;
                $k=$k+1;
            }
        }

        /*　i歳時の大運支*/
        $taiun_shi_arr=[$zero_jun_shi];

        //　上記には宣言してないが１０１個要素を書き出してる
        $s=0;

        for ($i=1; $i<101; $i++){;
            if ($i<$shojun+$s*10){;
                $taiun_shi_arr[$i]=$taiun_shi_arr[$i-1];
            }else{
                if ($taiunhoukou==1 && $taiun_shi_arr[$i-1]==12) $taiun_shi_arr[$i]=1;
                if ($taiunhoukou==1 && $taiun_shi_arr[$i-1]!=12) $taiun_shi_arr[$i]=$taiun_shi_arr[$i-1]+1;
                if ($taiunhoukou==-1 && $taiun_shi_arr[$i-1]==1) $taiun_shi_arr[$i]=12;
                if ($taiunhoukou==-1 && $taiun_shi_arr[$i-1]!=1) $taiun_shi_arr[$i]=$taiun_shi_arr[$i-1]-1;
                $s=$s+1;
            }
        }


        $ct_100nen_01 = 0;
        $calc_ttl_energy_a = 0;

        // ←　　ここまでがその年の総エネルギー計算　　ルーチン
        //  エネルギー値各配列をjavascript に渡す
        $kan_no_json = json_encode($kan_no);
        // print_r($kan_no);
        $energy_sum1_json = json_encode($energy_sum1);
        $energy_sum2_json = json_encode($energy_sum2);
        $suri_gogyo_json = json_encode($suri_gogyo);

        /* 気心体　検査　*/
        $kst_ar=array($ym_sn,$ym_sw,$ym_sc,$ym_se,$ym_ss);
        $kst_kan=array(0,0,0,0,0);
        $k=0;
        if  (in_array(1,$kst_ar)==true && in_array(4,$kst_ar)==true && in_array(5,$kst_ar)==true) {
            $kst_kan[$k]=4;
            $k=$k+1;
        }
        if  (in_array(2,$kst_ar)==true && in_array(3,$kst_ar)==true && in_array(6,$kst_ar)==true) {
            $kst_kan[$k]=3;
            $k=$k+1;
        }
        if  (in_array(3,$kst_ar)==true && in_array(6,$kst_ar)==true && in_array(7,$kst_ar)==true) {
            $kst_kan[$k]=6;
            $k=$k+1;
        }
        if  (in_array(4,$kst_ar)==true && in_array(5,$kst_ar)==true && in_array(8,$kst_ar)==true) {
            $kst_kan[$k]=5;
            $k=$k+1;
        }
        if  (in_array(5,$kst_ar)==true && in_array(8,$kst_ar)==true && in_array(9,$kst_ar)==true) {
            $kst_kan[$k]=8;
            $k=$k+1;
        }
        if  (in_array(6,$kst_ar)==true && in_array(7,$kst_ar)==true && in_array(10,$kst_ar)==true) {
            $kst_kan[$k]=7;
            $k=$k+1;
        }
        if  (in_array(7,$kst_ar)==true && in_array(10,$kst_ar)==true && in_array(1,$kst_ar)==true) {
            $kst_kan[$k]=10;
            $k=$k+1;
        }
        if  (in_array(8,$kst_ar)==true && in_array(9,$kst_ar)==true && in_array(2,$kst_ar)==true)  {
            $kst_kan[$k]=9;
            $k=$k+1;
        }
        if  (in_array(9,$kst_ar)==true && in_array(2,$kst_ar)==true && in_array(3,$kst_ar)==true)  {
            $kst_kan[$k]=2;
            $k=$k+1;
        }
        if  (in_array(10,$kst_ar)==true && in_array(1,$kst_ar)==true && in_array(4,$kst_ar)==true) {
            $kst_kan[$k]=1;
            $k=$k+1;
        }


        $kst_array=array(0,0,0,0,0);
        for ($i=0; $i<5; $i++){
            $kst_array[$i]=$d_10shu[$kst_kan[$i]];
        }

        //  気心体配列をjavascript に渡す
        $kst_kan_json=json_encode($kst_kan);
        //$kst_array_json=json_encode($kst_array);
        ///////////////////////////////////////////////

        $sainou = 0;
        $sainou_flag = 0;    //剋線数1位が2星ある場合　  sainou_flag==1 kokusen配列の中で一番剋線の多い星＝Math.max.apply(null,kokusen)

        $kokusen_reversed = array_reverse($kokusen);  // 剋線配列の逆順配列(indexは前から0になる)
        $ct = count($kokusen)-1;   //  剋線配列要素数マイナス１(この場合は１０)

        if ((array_sum($kokusen)) != 0){; //刻線が全くない人は才能の星はない。
            if ((array_search(max($kokusen),$kokusen) + array_search(max($kokusen),$kokusen_reversed)) != $ct ) {; ///   $kokusen配列中にmax値が2個以上存在する場合は剋線が1個
                $sainou_flag=1;
            }
            //$this->calc_juni = 四天運と剋線の順位
            if ( ($sainou_flag==1) && ($this->calc_juni(array_search(max($kokusen),$kokusen), $tenun_flag) <= $this->calc_juni($ct-array_search(max($kokusen),$kokusen_reversed), $tenun_flag))) {;
                $sainou_flag=2;
            }   //$sainou_flag=2 配列の左側から表示

            if (($sainou_flag==1)&& ($this->calc_juni(array_search(max($kokusen),$kokusen),$tenun_flag) > $this->calc_juni($ct-array_search(max($kokusen),$kokusen_reversed),$tenun_flag))){
                $sainou_flag=3;
            }   //$sainou_flag=3 配列の右側から表示

            if ($sainou_flag==0) {
                $sainou = $d_10shu[array_search(max($kokusen),$kokusen)].'('.$this->calc_juni(array_search(max($kokusen),$kokusen),$tenun_flag).')';
            }
            if ($sainou_flag==2) {

                $sainou = $d_10shu[array_search(max($kokusen),$kokusen)].'('.$this->calc_juni(array_search(max($kokusen),$kokusen),$tenun_flag).'),'.$d_10shu[$ct-array_search(max($kokusen),$kokusen_reversed)].'('.$this->calc_juni($ct-array_search(max($kokusen),$kokusen_reversed),$tenun_flag).')';
            }
            if ($sainou_flag==3) {
                $sainou = $d_10shu[$ct-array_search(max($kokusen),$kokusen_reversed)].'('.$this->calc_juni($ct-array_search(max($kokusen),$kokusen_reversed),$tenun_flag).'),'.$d_10shu[array_search(max($kokusen),$kokusen)].'('.$this->calc_juni(array_search(max($kokusen),$kokusen),$tenun_flag).')';
            }
        }else{;
            $sainou="";
        }

        // エネルギー値　　1:最身強　2:身強　3:身中　4:身弱　5:最身弱
        $energy = intval($d_12jyuenergy[$ym_jm])+intval($d_12jyuenergy[$ym_jy])+intval($d_12jyuenergy[$ym_jd]);
        $mikyo_flag = 0;
        $energy_ar=array($ym_jd,$ym_jm,$ym_jy);
        $tensho_ct = 0;
        $tenpou_ct = 0;
        $mikyo_ar=array("","最身強","身強","身中","身弱","最身弱");
        $baseData['mikyo'] = $mikyo_ar;

        //   天将２個
        for ($i=0; $i<3; $i++){
            if ($energy_ar[$i]==12){
                ++$tensho_ct;
            }
        }
        //   天報2個
        for ($i=0; $i<3; $i++){
            if ($energy_ar[$i]==3){
                ++$tenpou_ct;
            }
        }


        if ($energy>=31 || $tensho_ct>=2 ) {;
            $mikyo_flag=1;
        }else if (($energy<=30 && $energy>=27) || ($tensho_ct>=1) || ($tenpou_ct>=2)) {
            $mikyo_flag=2;
        }else if (($energy<=26 && $energy>=13)){
            $mikyo_flag=3;
        }else if (($energy<=12 && $energy>=9)){
            $mikyo_flag=4;
        }else{
            $mikyo_flag=5;
        }

        // 年運表修正　2018/1/3 $this->nowYear()は算命学的本日の年度(1/1から2/3までは昨年度扱い)　this_yearは実本日年度

        if ($this->nowYear() == $this_year){
            $nct = 0;
        } else {
            $nct = -1;
        }

        // print '<br>nct = '.$nct;

        ///////////* 大運表　全干支算出　*/////////////////////////////////////////////
        $im_pm_t = 0;
        if  ($taiunhoukou == 1) {   //順行運　本人月干支の次の干支
            $im_pm_t = $im_pm+1;
        }else if ($taiunhoukou == -1) {  //逆行運　本人月干支の前の干支
            $im_pm_t = $im_pm-1;
        }else{
            //print "大運方向error";
        }

        $taiun_kan=0;
        $taiun_kan1=0;
        $taiun_kan2=0;
        $taiun_kan3=0;
        $taiun_kan4=0;
        $taiun_kan5=0;
        $taiun_kan6=0;
        $taiun_kan7=0;

        if($im_pm_t%10==0) {
            $taiun_kan=10;
        }else {
            $taiun_kan=$im_pm_t%10;
        }

        if ($taiunhoukou==1) {
            $taiun_kan1=($taiun_kan+1)%10;
            $taiun_kan2=($taiun_kan+2)%10;
            $taiun_kan3=($taiun_kan+3)%10;
            $taiun_kan4=($taiun_kan+4)%10;
            $taiun_kan5=($taiun_kan+5)%10;
            $taiun_kan6=($taiun_kan+6)%10;
            $taiun_kan7=($taiun_kan+7)%10;
        }


        if ($taiunhoukou==-1) {
            $taiun_kan1=($taiun_kan+9)%10;
            $taiun_kan2=($taiun_kan+8)%10;
            $taiun_kan3=($taiun_kan+7)%10;
            $taiun_kan4=($taiun_kan+6)%10;
            $taiun_kan5=($taiun_kan+5)%10;
            $taiun_kan6=($taiun_kan+4)%10;
            $taiun_kan7=($taiun_kan+3)%10;
        }

        if ($taiun_kan==0) {
            $taiun_kan=10;
        }
        if ($taiun_kan1==0) {
            $taiun_kan1=10;
        }
        if ($taiun_kan2==0) {
            $taiun_kan2=10;
        }
        if ($taiun_kan3==0) {
            $taiun_kan3=10;
        }
        if ($taiun_kan4==0) {
            $taiun_kan4=10;
        }
        if ($taiun_kan5==0) {
            $taiun_kan5=10;
        }
        if ($taiun_kan6==0) {
            $taiun_kan6=10;
        }
        if ($taiun_kan7==0) {
            $taiun_kan7=10;
        }

        $taiun_shi=$im_pm_t%12;
        $taiun_shi1=0;
        $taiun_shi2=0;
        $taiun_shi3=0;
        $taiun_shi4=0;
        $taiun_shi5=0;
        $taiun_shi6=0;
        $taiun_shi7=0;

        if ($taiunhoukou==1) {
            $taiun_shi1=($taiun_shi+1)%12;
            $taiun_shi2=($taiun_shi+2)%12;
            $taiun_shi3=($taiun_shi+3)%12;
            $taiun_shi4=($taiun_shi+4)%12;
            $taiun_shi5=($taiun_shi+5)%12;
            $taiun_shi6=($taiun_shi+6)%12;
            $taiun_shi7=($taiun_shi+7)%12;
        }
        if ($taiunhoukou==-1) {
            $taiun_shi1=($taiun_shi+11)%12;
            $taiun_shi2=($taiun_shi+10)%12;
            $taiun_shi3=($taiun_shi+9)%12;
            $taiun_shi4=($taiun_shi+8)%12;
            $taiun_shi5=($taiun_shi+7)%12;
            $taiun_shi6=($taiun_shi+6)%12 ;
            $taiun_shi7=($taiun_shi+5)%12;
        }

        if ($taiun_shi==0) {
            $taiun_shi=12;
        }
        if ($taiun_shi1==0) {
            $taiun_shi1=12;
        }
        if ($taiun_shi2==0) {
            $taiun_shi2=12;
        }
        if ($taiun_shi3==0) {
            $taiun_shi3=12;
        }
        if ($taiun_shi4==0) {
            $taiun_shi4=12;
        }
        if ($taiun_shi5==0) {
            $taiun_shi5=12;
        }
        if ($taiun_shi6==0) {
            $taiun_shi6=12;
        }
        if ($taiun_shi7==0) {
            $taiun_shi7=12;
        }

        /* 天中殺表示 */
        $y1=$this_year;
        $m1=$this_month;
        $d1=$this_day;
        $x1=$y1*10000 + $m1*100 + $d1;
        $yx=$y1;
        if ($m1==1 || ($m1==2 && $this->calc_setsu($y1, $m1) > $d1)) {
            $yx=$yx-1;
        }
        $ys=$this->cmod($yx-3, 12);
        $tys=$im_tx-$ys;
        if ($tys<-1) {
            $tys=$tys+12;
        }
        $tys=$tys+$yx;
        $tms=2;
        $tds=$this->calc_setsu($tys,2);
        $txs=$tys*10000 + $tms*100 + $tds;
        $tye=$tys+2;
        $tme=2;
        $tde=$this->calc_setsu($tye,2)-1;
        $txe=$tye*10000 + $tme*100 + $tde;

        $yx=$y1;
        $mx=$m1;
        if ($this->calc_setsu($yx, $mx) > $d1) {
            $mx=$mx-1;
            if ($mx<1) {
                $mx=$mx+12;
                $yx=$yx-1;
            }
        }
        if ($im_tx==1) {
            /* 子丑天中殺 */
            $tms=12;
            $tys=$yx;
            if ($mx==1) {
                $tys=$tys-1;
            }
        } else {
            /* 子丑天中殺以外 */
            $tms=$im_tx-1;
            $tys=$yx;
            if ($tms-$mx<-1) {
                $tys=$tys+1;
            }
        }
        $tds=$this->calc_setsu($tys, $tms);
        $txs=$tys*10000 + $tms*100 + $tds;
        $tye=$tys;
        $tme=$tms+2;
        if ($tme>12) {
            $tye=$tye+1;
            $tme=$tme-12;
        }
        $tde=$this->calc_setsu($tye,$tme)-1;
        $txe=$tye*10000 + $tme*100 + $tde;
        $nikan = $d_nikan[$im_pd];


        $resultData['zero_jun_shi'] = $zero_jun_shi;
        $resultData['nowYear'] = $this->nowYear(); /*　算命学　年度 */
        $resultData['this_year'] = $this_year;  /* 実本日年度 */
        $resultData['this_month'] = $this_month; /*実本日月 */
        $resultData['this_day'] = $this_day; /* 実本日日 */
        $resultData['your_sex'] = $your_sex;
        $resultData['your_age'] = $your_age;
        $resultData['b_sei'] = $b_sei;
        $resultData['b_mei'] = $b_mei;
        $resultData['energy'] = $energy;
        $resultData['mikyo_flag'] = $mikyo_flag;
        $resultData['b_y_inp'] = $b_y0; /* 入力年 */
        $resultData['b_y0'] = $b_y0;      /* 西暦年 */
        $resultData['b_m0'] = $b_m0;      /* 月 */
        $resultData['b_d0'] = $b_d0;      /* 日 */
        $resultData['c_sflg'] = $c_sflg;
        $resultData['c_sdte'] = $c_sdte;       /* 節入り */
        $resultData['im_py'] = $im_py;  /* 干支番号 */
        $resultData['im_pm'] = $im_pm;
        $resultData['im_pd'] = $im_pd;
        $resultData['im_ky'] = $im_ky; /* 干支番号 */
        $resultData['im_km'] = $im_km;
        $resultData['im_kd'] = $im_kd;  /* 天干  （年干　月干　日干）*/
        $resultData['im_sy'] = $im_sy;
        $resultData['im_sm'] = $im_sm;
        $resultData['im_sd'] = $im_sd;  /* 地支 　（年支　月支　日支）*/
        $resultData['im_zy'] = $im_zy;
        $resultData['im_zm'] = $im_zm;
        $resultData['im_zd'] = $im_zd;  /* 蔵干 */
        $resultData['im_tx'] = $im_tx;  /* 天中殺 */
        $resultData['ym_sc'] = $ym_sc;
        $resultData['ym_se'] = $ym_se;
        $resultData['ym_sw'] = $ym_sw;
        $resultData['ym_sn'] = $ym_sn;
        $resultData['ym_ss'] = $ym_ss;  /* 主星 */
        $resultData['ym_jy'] = $ym_jy;
        $resultData['ym_jm'] = $ym_jm;
        $resultData['ym_jd'] = $ym_jd;  /* 従星 */
        $resultData['moku'] =$moku;   /*木火土金水*/
        $resultData['ka'] = $ka;
        $resultData['dou'] = $dou;
        $resultData['gon'] = $gon;
        $resultData['sui'] = $sui;
        $resultData['nct'] = $nct;  /*年運表　スタートカウンター */
        $resultData['ijoflag1'] = $ijoflag1; /* 異常干支　フラグ */

        $resultData['ijoflag2'] = $ijoflag2;
        $resultData['ijoflag3'] = $ijoflag3;
        $resultData['nikan'] = $nikan;   /* 特徴 */
        $resultData['bansei'] = $bansei;  /* 伴星 */
        $resultData['shojun'] = $shojun;   /* 初旬 */
        $resultData['taiunhoukou'] = $taiunhoukou; /* 大運方向 */
        $resultData['sangou_flag'] = $sangou_flag; /* 三合flag */
        $resultData['z_shugoshin_flag'] = $z_shugoshin_flag; /* 全体守護神フラグ */
        $resultData['z_shugoshin'] = $z_shugoshin; /* 全体守護神 */
        $resultData['imigami'] = ($imigami); /* 忌神　*/
        $resultData['tenunmei'] = ($tenunmei); /* 天運命 */
        $resultData['sainou'] = ($sainou); /* 才能　*/
        $resultData['tys'] = $tys;  /* 月の天中殺表示用　変数 */
        $resultData['tms'] = $tms;
        $resultData['tds'] = $tds;
        $resultData['tye'] = $tye;
        $resultData['tme'] = $tme;
        $resultData['tde'] = $tde;

        $resultData['taiun_shi'] = $taiun_shi;
        $resultData['taiun_shi1'] = $taiun_shi1;
        $resultData['taiun_shi2'] = $taiun_shi2;
        $resultData['taiun_shi3'] = $taiun_shi3;
        $resultData['taiun_shi4'] = $taiun_shi4;
        $resultData['taiun_shi5'] = $taiun_shi5;
        $resultData['taiun_shi6'] = $taiun_shi6;
        $resultData['taiun_shi7'] = $taiun_shi7;

        $resultData['taiun_kan0'] = $taiun_kan;
        $resultData['taiun_kan1'] = $taiun_kan1;
        $resultData['taiun_kan2'] = $taiun_kan2;
        $resultData['taiun_kan3'] = $taiun_kan3;
        $resultData['taiun_kan4'] = $taiun_kan4;
        $resultData['taiun_kan5'] = $taiun_kan5;
        $resultData['taiun_kan6'] = $taiun_kan6;
        $resultData['taiun_kan7'] = $taiun_kan7;

        $resultData['ura_zokan_1_1'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sd,1)];
        $resultData['ura_zokan_1_2'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sm,1)];
        $resultData['ura_zokan_1_3'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sy,1)];
        $resultData['ura_zokan_2_1'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sd,2)];
        $resultData['ura_zokan_2_2'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sm,2)];
        $resultData['ura_zokan_2_3'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sy,2)];
        $resultData['ura_zokan_3_1'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sd,3)];
        $resultData['ura_zokan_3_2'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sm,3)];
        $resultData['ura_zokan_3_3'] = $baseData['d_10kan1'][$this->calc_ura_zokan($im_sy,3)];

        // 初旬　干支　背景色　
        $resultData['bg_flag'] = 0;
        if($this->calc_isoho3($im_kd,$im_sd,$taiun_kan,$taiun_shi) == "大半会" || $this->calc_isoho3($im_kd,$im_sd,$taiun_kan,$taiun_shi) == "天剋" || $this->calc_isoho3($im_kd,$im_sd,$taiun_kan,$taiun_shi) == "納音" || $this->calc_isoho3($im_kd,$im_sd,$taiun_kan,$taiun_shi) == "律音" || $this->calc_isoho3($im_kd,$im_sd,$taiun_kan,$taiun_shi) == "天剋・刑"){

            $resultData['bg_flag'] = 1;
        }
        // 月干と大運干支
        if($this->calc_isoho3($im_km,$im_sm,$taiun_kan,$taiun_shi) == "大半会" || $this->calc_isoho3($im_km,$im_sm,$taiun_kan,$taiun_shi) == "天剋" || $this->calc_isoho3($im_km,$im_sm,$taiun_kan,$taiun_shi) == "納音" || $this->calc_isoho3($im_km,$im_sm,$taiun_kan,$taiun_shi) == "律音" || $this->calc_isoho3($im_km,$im_sm,$taiun_kan,$taiun_shi) == "天剋・刑") {
            $resultData['bg_flag'] = 1;
        }
        // 年干と大運干支
        if($this->calc_isoho3($im_ky,$im_sy,$taiun_kan,$taiun_shi) == "大半会" || $this->calc_isoho3($im_ky,$im_sy,$taiun_kan,$taiun_shi) == "天剋" || $this->calc_isoho3($im_ky,$im_sy,$taiun_kan,$taiun_shi) == "納音" || $this->calc_isoho3($im_ky,$im_sy,$taiun_kan,$taiun_shi) == "律音" || $this->calc_isoho3($im_ky,$im_sy,$taiun_kan,$taiun_shi) == "天剋・刑") {
            $resultData['bg_flag'] = 1;
        }

        if  (($taiun_shi == $im_tx || $taiun_shi == $im_tx+1) && ($resultData['bg_flag']==1)) {
            $resultData['bg_flag']=2;                                                               //紫
        }else if(($taiun_shi == $im_tx || $taiun_shi == $im_tx+1) && ($resultData['bg_flag']!=1)){
            $resultData['bg_flag']=3;                                                               //ピンク
        }else if(($taiun_shi != $im_tx && $taiun_shi != $im_tx+1) && ($resultData['bg_flag']==1)){
            $resultData['bg_flag']=4;                                                               //青
        }else{
            $resultData['bg_flag']=0;
        }

        /* 納音　検査　*/
        $resultData['nachin_flag'] = 0;
        if (($im_ky==$im_km && abs($im_sy-$im_sm)==6) || ($im_ky==$im_kd && abs($im_sy-$im_sd)==6) || ($im_kd==$im_km && abs($im_sd-$im_sm)==6)){
            $resultData['nachin_flag'] = 1;
        }

        /* 大半会　検査　*/
        $resultData['daihankai'] = 0;
        if ($im_ky==$im_km && $this->calc_gousan($im_sy,$im_sm)==1){
            $resultData['daihankai'] = 1;
        }
        //　年干=月干で年月日のどれかが半会
        if($im_ky==$im_kd && $this->calc_gousan($im_sy,$im_sd) ==1 ){
            $resultData['daihankai'] = 2;
        }
        // 年干＝日干で年月日のどれかが半会　
        if($im_km == $im_kd && $this->calc_gousan($im_sm,$im_sd) ==1){
            $resultData['daihankai'] = 3;
        }
        // 月干＝日干で年月日のどれかが半会

        /* 律音　検査 */
        $resultData['richin_flag'] = 0;
        if($im_py == $im_pd){
            $resultData['richin_flag'] = 1;
        }
        if($im_pm == $im_pd){
            $resultData['richin_flag'] = 2;
        }
        if($im_py == $im_pm){
            $resultData['richin_flag'] = 3;
        }

        /* 納音　検査　*/
        $resultData['nachin_flag'] = 0;
        if (($im_ky==$im_km && abs($im_sy-$im_sm)==6) || ($im_ky==$im_kd && abs($im_sy-$im_sd)==6) || ($im_kd==$im_km && abs($im_sd-$im_sm)==6)) {
            $resultData['nachin_flag'] = 1;
        }
        /*　合法・散法　算出　   →　01半会　02支合　03方三位　04対冲　05刑　06破　07害　08支合・破　09刑・冲　10刑・害　11刑・破　12刑・支合・破　　*/

        /* 干合　算出　*/
        $resultData['kangou_flag'] = 0;
        if(abs($im_kd-$im_km)==5 || abs($im_kd-$im_ky)==5 || abs($im_km-$im_ky)==5){
            $resultData['kangou_flag'] = 1;
        }
        /* 天剋地冲 検査　*/
        $resultData['tenkoku_flag'] = 0;
        if(($this->calc_soukoku($im_kd,$im_ky) ==3 || $this->calc_soukoku($im_kd,$im_ky) ==4) && abs($im_sy-$im_sd)==6 ){
            $resultData['tenkoku_flag'] = 1;
        }  //年・日
        if(($this->calc_soukoku($im_kd,$im_km) ==3 || $this->calc_soukoku($im_kd,$im_km) ==4 ) && abs($im_sm-$im_sd)==6){
            $resultData['tenkoku_flag'] = 2;
        }//日・月
        if(($this->calc_soukoku($im_km,$im_ky) ==3 || $this->calc_soukoku($im_km,$im_ky) ==4) && abs($im_sm-$im_sy) == 6){
            $resultData['tenkoku_flag'] = 2;
        }  //年・月

        /* 洩天地支　検査 */
        $resultData['eiten_flag'] = 0;
        if(($this->calc_soukoku($im_kd,$im_ky) == 1 || $this->calc_soukoku($im_kd,$im_ky) == 2) && $im_sy == $im_sd){
            $resultData['eiten_flag'] = 1;
        }  //年・日
        if(($this->calc_soukoku($im_kd,$im_km) ==1 || $this->calc_soukoku($im_kd,$im_km) == 2) && $im_sm == $im_sd){
            $resultData['eiten_flag'] = 2;
        } //日・月
        if(($this->calc_soukoku($im_km,$im_ky) ==1 || $this->calc_soukoku($im_km,$im_ky) ==2) && $im_sm == $im_sy){
            $resultData['eiten_flag'] = 2;
        }//年・月
        /* 宿命天中殺　計算　  shukumei_flag (1:生年　2:生月　3:生日)　shukumei_flag1 (4:日座　5:二中殺　6:全天中殺)　  gokan_flag 1:互換　      nichii_flag 1:日居　　*/
        $baseData['shukumei_ar'] = array("","生年","生月","生日","日座","二中殺","全天中殺");

        $nen_tx = 11-($this->cint(($im_py-1)/10)*2);//年干支から算出した宿命天中殺の支

        $resultData['shukumei_flag']= 0;
        $resultData['shukumei_flag1'] = 0;
        $resultData['nichii_flag'] = 0;
        $resultData['gokan_flag'] = 0;
        if(($im_tx==$im_sy || $im_tx+1==$im_sy) && ($im_tx==$im_sm || $im_tx+1==$im_sm) && ($im_pd==11 || $im_pd==12)) {
            $resultData['shukumei_flag1']=6;
        }else if(($im_tx==$im_sy || $im_tx+1==$im_sy) && ($im_tx==$im_sm || $im_tx+1==$im_sm)){
            $resultData['shukumei_flag1']=5;
        }else if($im_tx==$im_sy || $im_tx+1==$im_sy){
            $resultData['shukumei_flag']=1;
        }else if($im_tx==$im_sm || $im_tx+1==$im_sm){
            $resultData['shukumei_flag']=2;
        }else{
            $resultData['shukumei_flag']=0;
        }
        if($im_tx==$im_sd || $im_tx+1==$im_sd){
            $resultData['shukumei_flag1'] = 3;
        }
        if($im_pd==11 || $im_pd==12){
            $resultData['shukumei_flag1'] = 4;
        }
        if(($im_tx==$im_sy || $im_tx+1==$im_sy) && ($im_sd==$nen_tx || $im_sd==$nen_tx+1)){
            $resultData['gokan_flag'] = 1;
        }
        if($im_pd==41 || $im_pd==42){
            $resultData['nichii_flag'] = 1;
        }


        /*　特殊な組合せ　算出　 1:傷相　2病相　3罪相　4抗相・精相　5独相　6情相　7色相　8団相　9破相　10消相　11三奇星　12七殺　*/
        $baseData['ar_12jyu'] = array($ym_jy,$ym_jm,$ym_jd);
        $baseData['ar_10shu'] = array($ym_sn,$ym_sw,$ym_sc,$ym_se,$ym_ss);
        $baseData['ar_10shu_reverse'] = array_reverse($baseData['ar_10shu']);

        $resultData['tokushu_flag'] = -1 ;
        $resultData['tokushu_ar'] = array();
        if(in_array(3,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu']) && in_array(2,$baseData['ar_12jyu'])) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="傷相";
        }
        if((in_array(4,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu']) && in_array(1,$baseData['ar_12jyu'])) || (in_array(4,$baseData['ar_10shu']) && in_array(8,$baseData['ar_10shu']) && in_array(1,$baseData['ar_12jyu']))) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="病相";
        }
        if(in_array(2,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu']) && in_array(8,$baseData['ar_12jyu'])) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="罪相";
        }
        if((in_array(4,$baseData['ar_10shu']) && in_array(7,$baseData['ar_10shu'])) && (in_array(2,$baseData['ar_12jyu']) || in_array(8,$baseData['ar_12jyu']))) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="抗相";
        }

        //@todo ここ怪しいSG　lastIndexOf をphpに変えた場合の処理
        /**
         * if  ((ar_10shu.indexOf(1)>=0 && ar_10shu.indexOf(1)!=ar_10shu.lastIndexOf(1)) && (ar_12jyu.indexOf(1)>=0)) {
         */
        /**
         * ar_10shu.indexOf(1)!=ar_10shu.lastIndexOf(1))の計算方法
         *  ar_10shu.indexOf(1):ar_10shuを最初から調べて1があればそのindexNoを返す
         * 　ar_10shu.lastIndexOf(1)):ar_10shuの最後から調べて1があればそのindexNoを返す
         *
         */
        $ar_10shu_indexOf_1 = array_search(1,$baseData['ar_10shu']);
        if($ar_10shu_indexOf_1){
            foreach ($baseData['ar_10shu_reverse'] as $k=>$d){
                if($d==1){
                    $ar_10shu_lastIndexOf_1 = 4-$k;
                    break;
                }
            }
        }else{
            $ar_10shu_lastIndexOf_1 = false;
        }
        if((in_array(1,$baseData['ar_10shu']) && $ar_10shu_indexOf_1 != $ar_10shu_lastIndexOf_1) && (in_array(1,$baseData['ar_12jyu']))) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="独相";
        }
        if((in_array(5,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu']) && in_array(7,$baseData['ar_12jyu'])) || (in_array(5,$baseData['ar_10shu']) && in_array(4,$baseData['ar_10shu']) && in_array(7,$baseData['ar_12jyu']))) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="情相";
        }
        if((in_array(5,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu']) && in_array(7,$baseData['ar_12jyu'])) || (in_array(3,$baseData['ar_10shu']) && in_array(6,$baseData['ar_10shu']) && in_array(7,$baseData['ar_12jyu']))) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="色相";
        }
        if(in_array(4,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu']) && in_array(2,$baseData['ar_10shu']) && in_array(8,$baseData['ar_12jyu'])) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="団相";
        }
        if(in_array(5,$baseData['ar_10shu']) && in_array(6,$baseData['ar_10shu']) && in_array(12,$baseData['ar_12jyu'])) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="破相";
        }
        if(in_array(2,$baseData['ar_10shu']) && in_array(6,$baseData['ar_10shu']) && in_array(7,$baseData['ar_12jyu'])){
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="消相";
        }
        if ((in_array(4,$baseData['ar_10shu']) && in_array(7,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu'])) && in_array(8,$baseData['ar_12jyu'])) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="三奇星";
        }
        if((in_array(3,$baseData['ar_10shu']) && in_array(9,$baseData['ar_10shu'])) || (in_array(4,$baseData['ar_10shu']) && in_array(7,$baseData['ar_10shu']))) {
            $resultData['tokushu_flag']++;
            $resultData['tokushu_ar'][$resultData['tokushu_flag']]="七殺";
        }
        /* 大半会なので　半会を表示しない */
        $resultData['hankai1'] = 0;
        $resultData['hankai2'] = 0;
        $resultData['hankai3'] = 0;
        if (($resultData['daihankai'] ==1 || $resultData['daihankai'] ==2 || $resultData['daihankai'] ==3) && $this->calc_gousan($im_sy,$im_sm) ==1) {
            $resultData['hankai1'] = 1;
        }
        if (($resultData['daihankai'] ==1 || $resultData['daihankai'] ==2 || $resultData['daihankai'] ==3) && $this->calc_gousan($im_sy,$im_sd)==1) {
            $resultData['hankai2'] = 1;
        }
        if (($resultData['daihankai'] ==1 || $resultData['daihankai'] ==2 || $resultData['daihankai'] ==3) && $this->calc_gousan($im_sm,$im_sd)==1) {
            $resultData['hankai3'] = 1;
        }

        $resultData['yearMonthEq'] = $this->calc_gousan($im_sy,$im_sm);
        $resultData['yearDayEq'] = $this->calc_gousan($im_sy,$im_sd);
        $resultData['monthDayEq'] = $this->calc_gousan($im_sm,$im_sd);
        $resultData['shugosin'] = $baseData['shugosin_ar'][$im_kd-1][$im_sm];
        $resultData['kst_kan'] = $kst_kan;
        $resultData['kst_array'] = $kst_array;

        //動力占技
        $ar_dou_isoho= array();
        $ar_hei_isoho = array();

        $ar_100nen=[[0,0,0,0,0,0],            // [年齢,エネルギー値,平均との差,前年との差,容力]
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],
            [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]];
        $ttl_energy = 0;
        //100年表
        $inData = array();
        $inData['im_kd'] = $im_kd;
        $inData['im_km']=$im_km ;
        $inData['im_ky']=$im_ky;
        $inData['im_sd']=$im_sd;
        $inData['im_sm']=$im_sm;
        $inData['im_sy']=$im_sy;
        $inData['taiun_shi_arr']=$taiun_shi_arr;
        $inData['zero_y']=$zero_y;
        $inData['taiun_kan']=$taiun_kan_array;

        //
        $resultData['taiun_kan'] = $taiun_kan_array;
        $resultData['taiun_shi_arr']=$taiun_shi_arr;
        $resultData['zero_y']=$zero_y;

        for ($i = 0; $i < count($ar_100nen); $i++) {
            $ar_100nen[$i][0]=$i;
            $ar_100nen[$i][1]=$this->calc_ttl_energy($i,$inData)[0];
            //@todoここ調査
            //dump($i." ".$ar_100nen[$i][1]);
            $ttl_energy=$ttl_energy+$ar_100nen[$i][1];
        }

        for ($i = 0; $i < 101; $i++) {;
            $ar_100nen[$i][2]=floor(($ar_100nen[$i][1]-$ttl_energy/101)*10)/10;

            if ($i==0) {
                $ar_100nen[0][3]="";
            }else{
                $ar_100nen[$i][3]=$ar_100nen[$i][1]-$ar_100nen[$i-1][1];
            }
        }
        for ($i=20; $i<71; $i++){
            $t=array(
                $i,
                $ar_100nen[$i][1],
                $ar_100nen[$i][2],
                $this->calc_nenshi1912($zero_y+$i),
                0,0,0,0,0,0,0
            );
            $ar_dou_isoho[] = $t;
            $t=array(
                $i,$ar_100nen[$i][1],$ar_100nen[$i][2],$this->calc_nenshi1912($zero_y+$i),0,0,0,0,0,0,0

            );
            $ar_hei_isoho[] = $t;
        }

        $j=0;
        // ２旬
        for($i=0; $i<$shojun; $i++){
            $ar_dou_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan1,$taiun_shi1);//大運西
            $ar_dou_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan1,$taiun_shi1);        //大運中央
            $ar_dou_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan1,$taiun_shi1);        //大運東
            $j++;
        }
        //　３旬
        for($i=$j; $i<$shojun+10; $i++){
            $ar_dou_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan2,$taiun_shi2);        //大運西
            $ar_dou_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan2,$taiun_shi2);        //大運中央
            $ar_dou_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan2,$taiun_shi2);        //大運東
            $j++;
        }
        //　４旬
        for ($i=$j; $i<$shojun+20; $i++){
            $ar_dou_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan3,$taiun_shi3);        //大運西
            $ar_dou_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan3,$taiun_shi3);        //大運中央
            $ar_dou_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan3,$taiun_shi3);        //大運東
            $j++;
        }
        //　５旬
        for ($i=$j; $i<$shojun+30; $i++){
            $ar_dou_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan4,$taiun_shi4);        //大運西
            $ar_dou_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan4,$taiun_shi4);        //大運中央
            $ar_dou_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan4,$taiun_shi4);        //大運東
            $j++;
        }
        //　６旬
        for ($i=$j; $i<$shojun+40; $i++){
            $ar_dou_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan5,$taiun_shi5);        //大運西
            $ar_dou_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan5,$taiun_shi5);       //大運中央
            $ar_dou_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan5,$taiun_shi5);        //大運東
            $j++;
        }
        //　７旬
        for ($i=$j; $i<51; $i++){
            $ar_dou_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan6,$taiun_shi6);        //大運西
            $ar_dou_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan6,$taiun_shi6);        //大運中央
            $ar_dou_isoho[$i][6] =$this->calc_isoho2($im_ky,$im_sy,$taiun_kan6,$taiun_shi6);        //大運東
            $j++;
        }
        // 年運　西、中央、東　代入
        for ($i=0; $i<51; $i++){
            $ar_dou_isoho[$i][7] = $this->calc_isoho($im_kd,$im_sd,$this->calc_nenkan1912($zero_y+$i+20),$this->calc_nenshi1912($zero_y+$i+20));        //年運西
            $ar_dou_isoho[$i][8] = $this->calc_isoho2($im_km,$im_sm,$this->calc_nenkan1912($zero_y+$i+20),$this->calc_nenshi1912($zero_y+$i+20));        //年運中央
            $ar_dou_isoho[$i][9] = $this->calc_isoho2($im_ky,$im_sy,$this->calc_nenkan1912($zero_y+$i+20),$this->calc_nenshi1912($zero_y+$i+20));        //年運東
        }

        // 動力①：1〜19歳・71歳〜を除く（20〜70歳のみ）
        $douryoku_step1 = array();
        for ($i = 0; $i < 51; $i++) {
            $age = $ar_dou_isoho[$i][0];
            $year = $zero_y + $age;
            $nenun_shi = $this->calc_nenshi1912($year);
            $taiun_shi = $taiun_shi_arr[$age];
            $is_nenun_tenchusatsu = ($nenun_shi == $im_tx || $nenun_shi == ($im_tx + 1));
            $sanchu_nenun = $this->calc_sanchu_nenun($im_sd, $im_sm, $im_sy, $nenun_shi);
            $sanchu_taiun = $this->calc_sanchu_nenun($im_sd, $im_sm, $im_sy, $taiun_shi);
            $sanchu_nenun_taiun = $this->calc_sanchu_branches(array((int)$im_sd, (int)$im_sm, (int)$im_sy, (int)$nenun_shi, (int)$taiun_shi));
            $douryoku_step1[] = array(
                'age' => $age,
                'kanshi' => $d_10kan[$this->calc_nenkan1912($year)] . $d_12shi[$nenun_shi],
                'year' => $year,
                'energy' => $ar_dou_isoho[$i][1],
                'avg_diff' => $ar_dou_isoho[$i][2],
                'nenun_tenchusatsu' => $is_nenun_tenchusatsu ? '天中殺' : '',
                'sangou_kai' => '',
                'hankai_nenun' => ($this->calc_gousan($im_sy, $nenun_shi) == 1) ? '半会' : '',
                'hankai_taiun' => ($this->calc_gousan($im_sy, $taiun_shi) == 1) ? '半会' : '',
                'shigou_nenun' => ($this->calc_gousan($im_sy, $nenun_shi) == 2) ? '支合' : '',
                'shigou_taiun' => ($this->calc_gousan($im_sy, $taiun_shi) == 2) ? '支合' : '',
                'taichu_nenun' => ($this->calc_gousan($im_sy, $nenun_shi) == 4) ? '対冲' : '',
                'taichu_taiun' => ($this->calc_gousan($im_sy, $taiun_shi) == 4) ? '対冲' : '',
                'gai_nenun' => ($this->calc_gousan($im_sy, $nenun_shi) == 7) ? '害' : '',
                'gai_taiun' => ($this->calc_gousan($im_sy, $taiun_shi) == 7) ? '害' : '',
                'nichi_taichu_nenun' => ($this->calc_gousan($im_sd, $nenun_shi) == 4 || $this->calc_gousan($im_sd, $nenun_shi) == 9) ? '対冲' : '',
                'nichi_taichu_taiun' => ($this->calc_gousan($im_sd, $taiun_shi) == 4 || $this->calc_gousan($im_sd, $taiun_shi) == 9) ? '対冲' : '',
                'sanchu_nenun' => $sanchu_nenun,
                'sanchu_taiun' => $sanchu_taiun,
                'sanchu_nenun_taiun' => $sanchu_nenun_taiun,
            );
        }
        $resultData['douryoku_step1'] = $douryoku_step1;

        //********　　　　←　　動力占技テーブル　準備完了　　　　　
        //  ６、エネルギー昇順にソートして下位81個は除外フラグON
        // d_sorted_arr100 [年齢,エネルギー値,平均との差,前年との差,容力]
        // ar_dou_isoho[0年齢、1エネルギー、2平均との差、3大運支、4大運西、5大運中央、6大運東、7年運西、8年運中央、9年運東 10削除フラグ]
        $select_n = 30;// 対象上位人数　select_n　　（対象人数を変えたいときはここを変更）
        $d_sorted_arr100 = $this->multi_d_sort($ar_100nen);

        for($i=0; $i<(count($d_sorted_arr100)-$select_n); $i++){
            if($d_sorted_arr100[$i][0]>=20 && $d_sorted_arr100[$i][0]<=70){
                for ($j=0; $j<count($ar_dou_isoho); $j++){
                    if($ar_dou_isoho[$j][0]==$d_sorted_arr100[$i][0]){
                        $ar_dou_isoho[$j][10]=1;
                    }
                }
            }
        }


        // １１、上記テーブルで残ってる年から天中殺の年齢分を除外
        for ($i=0; $i<51; $i++){
            if ($ar_dou_isoho[$i][10]==0){
                if ($ar_dou_isoho[$i][3]==$im_tx || $ar_dou_isoho[$i][3]==($im_tx+1)){
                    $ar_dou_isoho[$i][10]=1;
                }
            }
        }

        // ７、上記テーブルで残ってる年から大運東方が半会または支合なら残し、それ以外なら除外（ただし、年運東方が半会なたは支合ならその1年は残す）
        //indexOf in_array 配列ではない場合は
        for ($i=0; $i<51; $i++){
            if ($ar_dou_isoho[$i][10]==0){
                //含まない
                if(strpos($ar_dou_isoho[$i][6], '半会') === false && strpos($ar_dou_isoho[$i][6], '支合') === false && strpos($ar_dou_isoho[$i][6], '干合合') === false){
                    $ar_dou_isoho[$i][10]=1;

                    if(strpos($ar_dou_isoho[$i][9], '半会') !== false || strpos($ar_dou_isoho[$i][9], '支合') !== false || strpos($ar_dou_isoho[$i][9], '干合合') !== false){
                        $ar_dou_isoho[$i][10]=0;

                    }
                }
            }
        }

        // ８、上記テーブルで残ってる年から大運東方が冲、天剋、納音、害なら除外、年運東方が冲、天剋、納音、害なら除外　

        for ($i=0; $i<51; $i++){
            if ($ar_dou_isoho[$i][10]==0){
                //含含む　ar_dou_isoho[i][6].indexOf("冲")!==-1
                if(strpos($ar_dou_isoho[$i][6], '冲') !== false || strpos($ar_dou_isoho[$i][6], '天剋') !== false || strpos($ar_dou_isoho[$i][6], '納音') !== false || strpos($ar_dou_isoho[$i][6], '害') !== false){
                    $ar_dou_isoho[$i][10]=1;
                }
                if(strpos($ar_dou_isoho[$i][9], '冲') !== false || strpos($ar_dou_isoho[$i][9], '天剋') !== false || strpos($ar_dou_isoho[$i][9], '納音') !== false || strpos($ar_dou_isoho[$i][9], '害') !== false){
                    $ar_dou_isoho[$i][10]=1;
                }
            }
        }

        // ９、上記テーブルで残ってる年からで大運西方が天剋、冲、納音なら除外、年運西方が天剋、冲、納音なら除外
        //todo ar_dou_isoho[i][4].indexOf("d_sorted_arr100")!==-1これ謎
        for ($i=0; $i<51; $i++){
            if ($ar_dou_isoho[$i][10]==0){
                //含含む　ar_dou_isoho[i][6].indexOf("冲")!==-1
                if(strpos($ar_dou_isoho[$i][4], '冲') !== false || strpos($ar_dou_isoho[$i][4], '納音') !== false ){
                    $ar_dou_isoho[$i][10]=1;
                }
                if(strpos($ar_dou_isoho[$i][7], '冲') !== false || strpos($ar_dou_isoho[$i][7], '天剋') !== false || strpos($ar_dou_isoho[$i][7], '納音') !== false){
                    $ar_dou_isoho[$i][10]=1;
                }
            }
        }
        // １０、上記テーブルで残ってる年からで大運西方、中央、東が半会、支合の組合せ8通りのどれかなら除外

        //@todo ここ間違えている
        for ($i=0; $i<51; $i++) {
            if ($ar_dou_isoho[$i][10] == 0) {
                if ((strpos($ar_dou_isoho[$i][4], '半会') !== false || strpos($ar_dou_isoho[$i][4], '支合') !== false || strpos($ar_dou_isoho[$i][4], '干合合') !== false ) &&  (strpos($ar_dou_isoho[$i][5], '半会') !== false || strpos($ar_dou_isoho[$i][5], '支合') !== false || strpos($ar_dou_isoho[$i][5], '干合合') !== false) && (strpos($ar_dou_isoho[$i][6], '半会') !== false || strpos($ar_dou_isoho[$i][6], '支合') !== false || strpos($ar_dou_isoho[$i][6], '干合合') !== false)) {
                    $ar_dou_isoho[$i][10] = 1;
                } else if ((strpos($ar_dou_isoho[$i][4], '半会') !== false || strpos($ar_dou_isoho[$i][4], '支合') !== false || strpos($ar_dou_isoho[$i][4], '干合合') !== false) && (strpos($ar_dou_isoho[$i][5], '半会') !== false || strpos($ar_dou_isoho[$i][5], '支合') !== false || strpos($ar_dou_isoho[$i][5], '干合合') !== false)) {
                    if (strpos($ar_dou_isoho[$i][9], '半会') !== false || strpos($ar_dou_isoho[$i][9], '支合') !== false || strpos($ar_dou_isoho[$i][9], '干合合') !== false) {
                        $ar_dou_isoho[$i][10] = 1;
                    }

                } else if ((strpos($ar_dou_isoho[$i][4], '半会') !== false || strpos($ar_dou_isoho[$i][4], '支合') !== false || strpos($ar_dou_isoho[$i][4], '干合合') !== false) && (strpos($ar_dou_isoho[$i][6], '半会') !== false || strpos($ar_dou_isoho[$i][6], '支合') !== false || strpos($ar_dou_isoho[$i][6], '干合合') !== false)) {
                    if (strpos($ar_dou_isoho[$i][8], '半会') !== false || strpos($ar_dou_isoho[$i][8], '支合') !== false || strpos($ar_dou_isoho[$i][8], '干合合') !== false) {
                        $ar_dou_isoho[$i][10] = 1;
                    }
                } else if ((strpos($ar_dou_isoho[$i][5], '半会') !== false || strpos($ar_dou_isoho[$i][5], '支合') !== false || strpos($ar_dou_isoho[$i][5], '干合合') !== false) && (strpos($ar_dou_isoho[$i][6], '半会') !== false || strpos($ar_dou_isoho[$i][6], '支合') !== false || strpos($ar_dou_isoho[$i][6], '干合合') !== false)) {
                    if (strpos($ar_dou_isoho[$i][7], '半会') !== false || strpos($ar_dou_isoho[$i][7], '支合') !== false || strpos($ar_dou_isoho[$i][7], '干合合') !== false) {
                        $ar_dou_isoho[$i][10] = 1;
                    }
                } else if (strpos($ar_dou_isoho[$i][4], '半会') !== false || strpos($ar_dou_isoho[$i][4], '支合') !== false || strpos($ar_dou_isoho[$i][4], '干合合') !== false) {
                    if ((strpos($ar_dou_isoho[$i][8], '半会') !== false || strpos($ar_dou_isoho[$i][8], '支合') !== false || strpos($ar_dou_isoho[$i][8], '干合合') !== false) && (strpos($ar_dou_isoho[$i][9], '半会') !== false || strpos($ar_dou_isoho[$i][9], '支合') !== false || strpos($ar_dou_isoho[$i][9], '干合合') !== false)) {
                        $ar_dou_isoho[$i][10] = 1;
                    }
                } else if (strpos($ar_dou_isoho[$i][5], '半会') !== false || strpos($ar_dou_isoho[$i][5], '支合') !== false || strpos($ar_dou_isoho[$i][5], '干合合') !== false) {
                    if ((strpos($ar_dou_isoho[$i][7], '半会') !== false || strpos($ar_dou_isoho[$i][7], '支合') !== false || strpos($ar_dou_isoho[$i][7], '干合合') !== false) && (strpos($ar_dou_isoho[$i][9], '半会') !== false || strpos($ar_dou_isoho[$i][9], '支合') !== false || strpos($ar_dou_isoho[$i][9], '干合合') !== false)) {
                        $ar_dou_isoho[$i][10] = 1;
                    }
                } else if (strpos($ar_dou_isoho[$i][6], '半会') !== false || strpos($ar_dou_isoho[$i][6], '支合') !== false || strpos($ar_dou_isoho[$i][6], '干合合') !== false) {
                    if ((strpos($ar_dou_isoho[$i][7], '半会') !== false || strpos($ar_dou_isoho[$i][7], '支合') !== false || strpos($ar_dou_isoho[$i][7], '干合合') !== false) && (strpos($ar_dou_isoho[$i][8], '半会') !== false || strpos($ar_dou_isoho[$i][8], '支合') !== false || strpos($ar_dou_isoho[$i][8], '干合合') !== false)) {
                        $ar_dou_isoho[$i][10] = 1;
                    }
                } else if ((strpos($ar_dou_isoho[$i][4], '半会') !== false || strpos($ar_dou_isoho[$i][4], '支合') !== false || strpos($ar_dou_isoho[$i][4], '干合合') !== false) && (strpos($ar_dou_isoho[$i][5], '半会') !== false || strpos($ar_dou_isoho[$i][5], '支合') !== false || strpos($ar_dou_isoho[$i][5], '干合合') !== false) && (strpos($ar_dou_isoho[$i][6], '半会') !== false || strpos($ar_dou_isoho[$i][6], '支合') !== false || strpos($ar_dou_isoho[$i][6], '干合合') !== false)) {
                    if ((strpos($ar_dou_isoho[$i][7], '半会') !== false || strpos($ar_dou_isoho[$i][7], '支合') !== false || strpos($ar_dou_isoho[$i][7], '干合合') !== false) && (strpos($ar_dou_isoho[$i][8], '半会') !== false || strpos($ar_dou_isoho[$i][8], '支合') !== false || strpos($ar_dou_isoho[$i][8], '干合合') !== false) && (strpos($ar_dou_isoho[$i][9], '半会') !== false || strpos($ar_dou_isoho[$i][9], '支合') !== false || strpos($ar_dou_isoho[$i][9], '干合合') !== false)) {
                        $ar_dou_isoho[$i][10] = 1;
                    }
                }
            }
        }

// 平力占技テーブルに大運東、中、西を代入     平占技判定テーブル作成
// taiun_shiは20歳未満になる、20歳代のtaiun_shi1は初旬の値と同数
        // ２旬
        $j=0;
        for ($i=0; $i<$shojun; $i++){
            $ar_hei_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan1,$taiun_shi1);        //大運西
            $ar_hei_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan1,$taiun_shi1);        //大運中央
            $ar_hei_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan1,$taiun_shi1);        //大運東
            $j++;
        }
        //　３旬
        for ($i=$j; $i<$shojun+10; $i++){
            $ar_hei_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan2,$taiun_shi2);        //大運西
            $ar_hei_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan2,$taiun_shi2);        //大運中央
            $ar_hei_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan2,$taiun_shi2);        //大運東
            $j++;
        }
        //　４旬
        for ($i=$j; $i<$shojun+20; $i++){
            $ar_hei_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan3,$taiun_shi3);       //大運西
            $ar_hei_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan3,$taiun_shi3);       //大運中央
            $ar_hei_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan3,$taiun_shi3);       //大運東
            $j++;
        }

        //　５旬
        for ($i=$j; $i<$shojun+30; $i++){
            $ar_hei_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan4,$taiun_shi4);       //大運西
            $ar_hei_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan4,$taiun_shi4);       //大運中央
            $ar_hei_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan4,$taiun_shi4);       //大運東
            $j++;
        }

        //　６旬
        for ($i=$j; $i<$shojun+40; $i++){
            $ar_hei_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan5,$taiun_shi5);       //大運西
            $ar_hei_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan5,$taiun_shi5);      //大運中央
            $ar_hei_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan5,$taiun_shi5);       //大運東
            $j++;
        }

        //　７旬
        for ($i=$j; $i<51; $i++){
            $ar_hei_isoho[$i][4] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan6,$taiun_shi6);       //大運西
            $ar_hei_isoho[$i][5] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan6,$taiun_shi6);       //大運中央
            $ar_hei_isoho[$i][6] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan6,$taiun_shi6);       //大運東
            $j++;
        }
        // 年運　西、中央、東　代入
        for ($i=0; $i<51; $i++){
            $ar_hei_isoho[$i][7] = $this->calc_isoho($im_kd,$im_sd,$this->calc_nenkan1912($zero_y+$i+20),$this->calc_nenshi1912($zero_y+$i+20));        //年運西
            $ar_hei_isoho[$i][8] = $this->calc_isoho2($im_km,$im_sm,$this->calc_nenkan1912($zero_y+$i+20),$this->calc_nenshi1912($zero_y+$i+20));        //年運中央
            $ar_hei_isoho[$i][9] = $this->calc_isoho2($im_ky,$im_sy,$this->calc_nenkan1912($zero_y+$i+20),$this->calc_nenshi1912($zero_y+$i+20));        //年運東
        }
        //平力占技テーブル　準備完了
//  ６、エネルギー降順にソートして下位81個は除外フラグON
// sorted_arr100 [年齢,エネルギー値,平均との差,前年との差,容力]
// ar_hei_isoho[0年齢、1エネルギー、2平均との差、3大運支、4大運西、5大運中央、6大運東、7年運西、8年運中央、9年運東 10削除フラグ]
        $select_n = 30;// 対象上位人数　select_n　　（対象人数を変えたいときはここを変更）
        $h_sorted_arr100 = $this->multi_d_sort2($ar_100nen);
        //（配列、二次元配列のカラム位置、降順）

        for ($i=0; $i<(count($h_sorted_arr100)-$select_n); $i++){
            if ($h_sorted_arr100[$i][0]>=20 && $h_sorted_arr100[$i][0]<=70){
                for ($j=0; $j<count($ar_hei_isoho); $j++){
                    if($ar_dou_isoho[$j][0]==$h_sorted_arr100[$i][0]){
                        $ar_hei_isoho[$j][10]=1;

                    }
                }
            }
        }

        // １１、上記テーブルで残ってる年から天中殺の年齢分を除外
        for ($i=0; $i<51; $i++){
            if ($ar_hei_isoho[$i][10]==0){
                if ($ar_hei_isoho[$i][3]==$im_tx || $ar_hei_isoho[$i][3]==($im_tx+1)){
                    $ar_hei_isoho[$i][10]=1;
                }
            }
        }
        // ７、上記テーブルで残ってる年から大運東方が冲、天剋、納音、刑、害なら残す、それ以外なら除外（ただし、年運東方が冲、天剋、納音、刑、害ならその1年は残す）
        // test.indexOf("半会")  は　文字列test　のなかに  半会が存在しなければ、-1　を返す
        //strpos($str, '半会')=== false phpはこれで文字列を含まない
        //strpos($str, '半会')!== false こちらは文字列含む
        //
        for ($i=0; $i<51; $i++){
            if ($ar_hei_isoho[$i][10]==0){
                if (strpos($ar_hei_isoho[$i][6],'冲') === false && strpos($ar_hei_isoho[$i][6],'天剋') === false  && strpos($ar_hei_isoho[$i][6],'納音') === false && strpos($ar_hei_isoho[$i][6],'刑') === false && strpos($ar_hei_isoho[$i][6],'害') === false){
                    $ar_hei_isoho[$i][10]=1;
                    if(strpos($ar_hei_isoho[$i][9],'冲') !== false || strpos($ar_hei_isoho[$i][9],'天剋') !== false || strpos($ar_hei_isoho[$i][9],'納音') !== false || strpos($ar_hei_isoho[$i][9],'刑') !== false || strpos($ar_hei_isoho[$i][9],'害') !== false){
                        $ar_hei_isoho[$i][10]=0;
                    }
                }
            }
        }
        //８、上記テーブルで残ってる年から大運東方が半会なら除外、年運東方が半会なら除外　　　　　　　**************** 2017/5/6 -->
        for ($i=0; $i<51; $i++){
            if ($ar_hei_isoho[$i][10]==0){
                if (strpos($ar_hei_isoho[$i][6],'半会') !== false){
                    $ar_hei_isoho[$i][10]=1;
                }
                if (strpos($ar_hei_isoho[$i][9],'半会') !== false){
                    $ar_hei_isoho[$i][10]=1;
                }
            }
        }
        // ９、上記テーブルで残ってる年からで大運西方が天剋、冲、納音なら除外、年運西方が天剋、冲、納音なら除外
        for ($i=0; $i<51; $i++){
            if ($ar_hei_isoho[$i][10]==0){
                if (strpos($ar_hei_isoho[$i][4],'冲') !== false || strpos($ar_hei_isoho[$i][4],'天剋') !== false || strpos($ar_hei_isoho[$i][4],'納音') !== false){
                    $ar_hei_isoho[$i][10]=1;
                }

                if (strpos($ar_hei_isoho[$i][7],'冲') !== false || strpos($ar_hei_isoho[$i][7],'天剋') !== false || strpos($ar_hei_isoho[$i][7],'納音') !== false){
                    $ar_hei_isoho[$i][10]=1;
                }
            }
        }

        for ($i=0; $i<51; $i++){
            if ($ar_hei_isoho[$i][10]==0){

                if ((strpos($ar_hei_isoho[$i][4],'冲') !== false || strpos($ar_hei_isoho[$i][4],'刑') !== false || strpos($ar_hei_isoho[$i][4],'害') !== false) && (strpos($ar_hei_isoho[$i][5],'冲') !== false || strpos($ar_hei_isoho[$i][5],'刑') !== false || strpos($ar_hei_isoho[$i][5],'害') !== false) && (strpos($ar_hei_isoho[$i][6],'冲') !== false || strpos($ar_hei_isoho[$i][6],'刑') !== false || strpos($ar_hei_isoho[$i][6],'害') !== false)){
                    $ar_hei_isoho[$i][10]=1;
                } else if ((strpos($ar_hei_isoho[$i][4],'冲') !== false || strpos($ar_hei_isoho[$i][4],'刑') !== false || strpos($ar_hei_isoho[$i][4],'害') !== false) &&
                    (strpos($ar_hei_isoho[$i][5],'冲') !== false || strpos($ar_hei_isoho[$i][5],'刑') !== false || strpos($ar_hei_isoho[$i][5],'害') !== false)){
                    if (strpos($ar_hei_isoho[$i][9],'冲') !== false || strpos($ar_hei_isoho[$i][9],'刑') !== false || strpos($ar_hei_isoho[$i][9],'害') !== false){
                        $ar_hei_isoho[$i][10]=1;
                    }

                } else if ((strpos($ar_hei_isoho[$i][4],'冲') !== false || strpos($ar_hei_isoho[$i][4],'刑') !== false || strpos($ar_hei_isoho[$i][4],'害') !== false) &&
                    (strpos($ar_hei_isoho[$i][6],'冲') !== false || strpos($ar_hei_isoho[$i][6],'刑') !== false || strpos($ar_hei_isoho[$i][6],'害') !== false)){
                    if (strpos($ar_hei_isoho[$i][8],'冲') !== false || strpos($ar_hei_isoho[$i][8],'刑') !== false || strpos($ar_hei_isoho[$i][8],'害') !== false){
                        $ar_hei_isoho[$i][10]=1;
                    }

                } else if ((strpos($ar_hei_isoho[$i][5],'冲') !== false || strpos($ar_hei_isoho[$i][5],'刑') !== false || strpos($ar_hei_isoho[$i][5],'害') !== false) &&
                    (strpos($ar_hei_isoho[$i][6],'冲') !== false || strpos($ar_hei_isoho[$i][6],'刑') !== false || strpos($ar_hei_isoho[$i][6],'害') !== false)){
                    if (strpos($ar_hei_isoho[$i][7],'冲') !== false || strpos($ar_hei_isoho[$i][7],'刑') !== false || strpos($ar_hei_isoho[$i][7],'害') !== false){
                        $ar_hei_isoho[$i][10]=1;
                    }
                } else if (strpos($ar_hei_isoho[$i][4],'冲') !== false || strpos($ar_hei_isoho[$i][4],'刑') !== false || strpos($ar_hei_isoho[$i][4],'害') !== false){
                    if ((strpos($ar_hei_isoho[$i][8],'冲') !== false || strpos($ar_hei_isoho[$i][8],'刑') !== false || strpos($ar_hei_isoho[$i][8],'害') !== false) &&
                        (strpos($ar_hei_isoho[$i][9],'冲') !== false || strpos($ar_hei_isoho[$i][9],'刑') !== false || strpos($ar_hei_isoho[$i][9],'害') !== false)) {
                        $ar_hei_isoho[$i][10]=1;
                    }
                } else if (strpos($ar_hei_isoho[$i][5],'冲') !== false || strpos($ar_hei_isoho[$i][5],'刑') !== false || strpos($ar_hei_isoho[$i][5],'害') !== false){
                    if ((strpos($ar_hei_isoho[$i][7],'冲') !== false || strpos($ar_hei_isoho[$i][7],'刑') !== false || strpos($ar_hei_isoho[$i][7],'害') !== false) &&
                        (strpos($ar_hei_isoho[$i][9],'冲') !== false || strpos($ar_hei_isoho[$i][9],'刑') !== false || strpos($ar_hei_isoho[$i][9],'害') !== false)) {
                        $ar_hei_isoho[$i][10]=1;
                    }
                } else if (strpos($ar_hei_isoho[$i][6],'冲') !== false || strpos($ar_hei_isoho[$i][6],'刑') !== false || strpos($ar_hei_isoho[$i][6],'害') !== false){
                    if ((strpos($ar_hei_isoho[$i][7],'冲') !== false || strpos($ar_hei_isoho[$i][7],'刑') !== false || strpos($ar_hei_isoho[$i][7],'害') !== false) &&
                        (strpos($ar_hei_isoho[$i][8],'冲') !== false || strpos($ar_hei_isoho[$i][8],'刑') !== false || strpos($ar_hei_isoho[$i][8],'害') !== false)) {
                        $ar_hei_isoho[$i][10]=1;
                    }
                } else if ((strpos($ar_hei_isoho[$i][4],'冲') !== false || strpos($ar_hei_isoho[$i][4],'刑') !== false || strpos($ar_hei_isoho[$i][4],'害') !== false) &&
                    (strpos($ar_hei_isoho[$i][5],'冲') !== false || strpos($ar_hei_isoho[$i][5],'刑') !== false || strpos($ar_hei_isoho[$i][5],'害') !== false) &&
                    (strpos($ar_hei_isoho[$i][6],'冲') !== false || strpos($ar_hei_isoho[$i][7],'刑') !== false || strpos($ar_hei_isoho[$i][7],'害') !== false)) {
                    if ((strpos($ar_hei_isoho[$i][7],'冲') !== false || strpos($ar_hei_isoho[$i][7],'刑') !== false || strpos($ar_hei_isoho[$i][7],'害') !== false) &&
                        (strpos($ar_hei_isoho[$i][8],'冲') !== false || strpos($ar_hei_isoho[$i][8],'刑') !== false || strpos($ar_hei_isoho[$i][8],'害') !== false) &&
                        (strpos($ar_hei_isoho[$i][9],'冲') !== false || strpos($ar_hei_isoho[$i][9],'刑') !== false || strpos($ar_hei_isoho[$i][9],'害') !== false)){
                        $ar_hei_isoho[$i][10]=1;
                    }
                } else {

                }

            }    // if end

        }

        $douryoku_age = array();
        for ($i=0; $i<51; $i++){
            if ($ar_dou_isoho[$i][10]==0){
                $douryoku_age[] = $ar_dou_isoho[$i][0];
            }
        }
        $resultData['douryoku_age'] = $douryoku_age;

        $heiryoku_age=array();
        for ($i=0; $i<51; $i++){
            if ($ar_hei_isoho[$i][10]==0){
                $heiryoku_age[] = $ar_hei_isoho[$i][0];
            }
        }
        $resultData['heiryoku_age'] = $heiryoku_age;
//ちょっと寄り道SGここまで終わり中js
        $resultData['nen_tx']=$nen_tx;
        $resultData['sei_flag']=$sei_flag;
        //大運表計算が必要な一部
        $resultData['daiUnFirst1'] = $d_10shu[$this->calc_10shu($im_kd,$taiun_kan)];
        $resultData['daiUnFirst2'] = $d_12jyu[$this->calc_12jyu($im_kd,$taiun_shi)];
        $resultData['daiUnFirst3'] = $this->calc_isoho3($im_kd,$im_sd,$taiun_kan,$taiun_shi);
        $resultData['daiUnFirst4'] = $this->calc_isoho2($im_km,$im_sm,$taiun_kan,$taiun_shi);
        $resultData['daiUnFirst5'] = $this->calc_isoho2($im_ky,$im_sy,$taiun_kan,$taiun_shi);

        for($i=1;$i<=7;$i++){
            $resultData['daiUn_'.$i.'_1'] = $d_10shu[$this->calc_10shu($im_kd,$resultData['taiun_kan'.$i])];
            $resultData['daiUn_'.$i.'_2'] = $d_12jyu[$this->calc_12jyu($im_kd, $resultData['taiun_shi'.$i])];
            $resultData['daiUn_'.$i.'_3'] =$this->calc_isoho($im_kd,$im_sd,$resultData['taiun_kan'.$i],$resultData['taiun_shi'.$i]);
            $resultData['daiUn_'.$i.'_4'] =$this->calc_isoho2($im_km,$im_sm,$resultData['taiun_kan'.$i],$resultData['taiun_shi'.$i]);
            $resultData['daiUn_'.$i.'_5'] =$this->calc_isoho2($im_ky,$im_sy,$resultData['taiun_kan'.$i],$resultData['taiun_shi'.$i]);
        }
        //年運表
        //for($i=0;$i<=7;$i++){
        //2024.05.01 年運を過去も表示したいとのことなのでi=0を−5にして５年前から表示
        //過去に生まれているか確認
        $bdif = $this->nowYear() - $b_y0;
        $startI = -5;
        if($bdif < 5){
            $startI = ($bdif-1) * -1;
        }

        for($i=$startI;$i<=7;$i++){
            $index = $i+$startI*-1;//マイナス分プラスにする
            $nct_ = $nct + $i;
            $resultData['nenUn'][$index]['year'] = $this->nowYear() + $i;
            $resultData['nenUn'][$index][1]['bg'] = '#fff';
            if($this->calc_nenshi($nct_) == $im_tx || $this->calc_nenshi($nct_) == $im_tx + 1){
                $resultData['nenUn'][$index][1]['bg'] = '#FFBBFF';
            }
            $resultData['nenUn'][$index][1]['str'] = $d_10kan[$this->calc_nenkan($nct_)].$d_12shi[$this->calc_nenshi($nct_)];
            $resultData['nenUn'][$index][2] = $d_10shu[$this->calc_10shu($im_kd,$this->calc_nenkan($nct_))];
            $resultData['nenUn'][$index][3] = $d_12jyu[$this->calc_12jyu($im_kd, $this->calc_nenshi($nct_))];
            $resultData['nenUn'][$index][4] = $this->calc_isoho($im_kd,$im_sd,$this->calc_nenkan($nct_),$this->calc_nenshi($nct_));
            $resultData['nenUn'][$index][5] = $this->calc_isoho2($im_km,$im_sm,$this->calc_nenkan($nct_),$this->calc_nenshi($nct_));
            $resultData['nenUn'][$index][6] = $this->calc_isoho2($im_ky,$im_sy,$this->calc_nenkan($nct_),$this->calc_nenshi($nct_));
        }

        //エネルギー表
        $j=1;
        for($i=1;$i<=10;$i++){
            $resultData['energyVal'][$i][1] = $d_10shu[$this->calc_10shu($im_kd, $i)];
            $resultData['energyVal'][$i][3] = $this->calc_12jyu($i,$im_sd);
            $resultData['energyVal'][$i][4] = $this->calc_12jyu($i,$im_sm);
            $resultData['energyVal'][$i][5] = $this->calc_12jyu($i,$im_sy);
            $resultData['energyVal'][$i][6] = $energy_sum1[$i];
            $resultData['energyVal'][$i][7] = $kan_no[$i];
            if($i % 2 != 0){
                $resultData['energyVal'][$i][8] = $energy_sum2[$j];
                $j++;
            }
            //
        }
        $resultData['engUp']['val'] = $energy_sum2[$suri_gogyo[1]];
        $resultData['engUp']['str'] = $d_gogyo[$suri_gogyo[1]];
        $resultData['engMd'][1]['val'] = $energy_sum2[$suri_gogyo[4]];
        $resultData['engMd'][2]['val'] = $energy_sum2[$suri_gogyo[0]];
        $resultData['engMd'][3]['val'] = $energy_sum2[$suri_gogyo[2]];
        $resultData['engMd'][1]['str'] = $d_gogyo[$suri_gogyo[4]];
        $resultData['engMd'][2]['str'] = $d_10kan[$im_kd];
        $resultData['engMd'][3]['str'] = $d_gogyo[$suri_gogyo[2]];
        $resultData['engUd'][1]['val'] = $energy_sum2[$suri_gogyo[3]];
        $resultData['engUd'][2]['val'] = $energy_sum0;
        $resultData['engUd'][1]['str'] = $d_gogyo[$suri_gogyo[3]];

        $output['resultData'] = $resultData;
        $output['baseData'] = $baseData;

        return $output;
    }

    /****
     * ここから六親図
     */
    function rokushinResult($post){
        $meishiki = $this->arithmeticScienceResult($post);

        $resultData = $meishiki['resultData'];
        $baseData = $meishiki['baseData'];
        $im_kd = $resultData['im_kd'];
        $im_km = $resultData['im_km'];
        $im_ky = $resultData['im_ky'];
        $im_sd = $resultData['im_sd'];
        $im_sm = $resultData['im_sm'];
        $im_sy = $resultData['im_sy'];
        $sei_flag = $resultData['sei_flag'];

        $mother_ar=[0,10,9,2,1,4,3,6,5,8,7,];    // 母の干支決定テーブル
        $kango_ar=[0,6,7,8,9,10,1,2,3,4,5];      // パートナー決定テーブル（干合）
        $inyo_rev=[0,2,1,4,3,6,5,8,7,10,9];      // 陰陽逆の干支
        $mykan_ar=[$im_kd,$im_km,$im_ky,$this->calc_ura_zokan($im_sd,1),$this->calc_ura_zokan($im_sm,1),$this->calc_ura_zokan($im_sy,1),$this->calc_ura_zokan($im_sd,2),$this->calc_ura_zokan($im_sm,2),$this->calc_ura_zokan($im_sy,2),$this->calc_ura_zokan($im_sd,3),$this->calc_ura_zokan($im_sm,3),$this->calc_ura_zokan($im_sy,3)];
        $myupline=[0,$im_kd,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        // [0,自分,自母,自父,母祖母,母祖父,父祖母,父祖父,母母曾祖母,母母曾祖父,母父曾祖母,母父曾祖父,父母曾祖母,父母曾祖父,父父曾祖母,父父曾祖父]		16要素
        // パートナー側　宣言
        $partner=[0,$kango_ar[$im_kd],0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        // [0,partner,p母,p父,p母祖母,p母祖父,p父祖母,p父祖父,p母母曾祖母,p母母曾祖父,p母父曾祖母,p母父曾祖父,p父母曾祖母,p父母曾祖父,p父父曾祖母,p父父曾祖父]		16要素
        // パートナー1決定　　$partner[1]
        if (array_search($kango_ar[$im_kd],$mykan_ar) !==false ) {
            $partner[1]=$kango_ar[$im_kd];
        } else {
            if (array_search($inyo_rev[$kango_ar[$im_kd]],$mykan_ar)!==false) {
                $partner[1]=$inyo_rev[$kango_ar[$im_kd]];
            } else {
                if ($this->calc_ura_zokan($im_sd,3)!=0){
                    $partner[1]=$this->calc_ura_zokan($im_sd,3);
                }else if($this->calc_ura_zokan($im_sd,2)!=0){
                    $partner[1]=$this->calc_ura_zokan($im_sd,2);
                }else if($this->calc_ura_zokan($im_sd,1)!=0){
                    $partner[1]=$this->calc_ura_zokan($im_sd,1);
                }else{
                    $partner[1]="E";
                }					// 99:該当なし
            }
        }
        //  自分の先祖　　-----------------------
        $myupline[2]=$this->calc_mother(1,$im_kd,$im_sy,$mykan_ar,$myupline);          // 母
        $myupline[3]=$this->calc_mykango(2,$im_kd,$im_ky,$mykan_ar,$myupline);        //　父
        $myupline[4]=$this->calc_mother(2,$im_kd,$im_sy,$mykan_ar,$myupline);         //　母祖母
        $myupline[5]=$this->calc_mykango(4,$im_kd,$im_ky,$mykan_ar,$myupline) ;     // 母祖父
        $myupline[6]=$this->calc_mother(3,$im_kd,$im_sy,$mykan_ar,$myupline);
        $myupline[7]=$this->calc_mykango(6,$im_kd,$im_ky,$mykan_ar,$myupline) ;
        $myupline[8]=$this->calc_mother(4,$im_kd,$im_sy,$mykan_ar,$myupline);
        $myupline[9]=$this->calc_mykango(8,$im_kd,$im_ky,$mykan_ar,$myupline) ;
        $myupline[10]=$this->calc_mother(5,$im_kd,$im_sy,$mykan_ar,$myupline);
        $myupline[11]=$this->calc_mykango(10,$im_kd,$im_ky,$mykan_ar,$myupline) ;
        $myupline[12]=$this->calc_mother(6,$im_kd,$im_sy,$mykan_ar,$myupline);
        $myupline[13]=$this->calc_mykango(12,$im_kd,$im_ky,$mykan_ar,$myupline);
        $myupline[14]=$this->calc_mother(7,$im_kd,$im_sy,$mykan_ar,$myupline);
        $myupline[15]=$this->calc_mykango(14,$im_kd,$im_ky,$mykan_ar,$myupline) ;

        //  パートナーの先祖　　-----------------------

        $partner[2]=$this->calc_mother_p(1,$partner,$mykan_ar);// パートナー母
        $partner[3]=$this->calc_pkango(2,$partner,$mykan_ar);// パートナー父
        $partner[4]=$this->calc_mother_p(2,$partner,$mykan_ar);// パートナー母祖母
        $partner[5]=$this->calc_pkango(4,$partner,$mykan_ar);
        $partner[6]=$this->calc_mother_p(3,$partner,$mykan_ar);
        $partner[7]=$this->calc_pkango(6,$partner,$mykan_ar);
        $partner[8]=$this->calc_mother_p(4,$partner,$mykan_ar);
        $partner[9]=$this->calc_pkango(8,$partner,$mykan_ar);
        $partner[10]=$this->calc_mother_p(5,$partner,$mykan_ar);
        $partner[11]=$this->calc_pkango(10,$partner,$mykan_ar);
        $partner[12]=$this->calc_mother_p(6,$partner,$mykan_ar);
        $partner[13]=$this->calc_pkango(12,$partner,$mykan_ar);
        $partner[14]=$this->calc_mother_p(7,$partner,$mykan_ar);
        $partner[15]=$this->calc_pkango(14,$partner,$mykan_ar);
        // 子供決定　ロジック　-------------------------------------
        $child_ar=[0,4,3,6,5,8,7,10,9,2,1,];    // 自分かパートナーの干支で子の干支決定テーブル
        $child=[0,0];                           // 子の干支
        $child_flag=0;                          // 子の干支存在フラグ
        // 自分が男
        if ($sei_flag==1){;
            if ( in_array($child_ar[$partner[1]],$mykan_ar) && in_array($inyo_rev[$child_ar[$partner[1]]],$mykan_ar) ) {;
                $child_flag=2;
                $child[0]=$child_ar[$partner[1]];
                $child[1]=$inyo_rev[$child_ar[$partner[1]]];
            }
            if ( in_array($child_ar[$partner[1]],$mykan_ar) && !in_array($inyo_rev[$child_ar[$partner[1]]],$mykan_ar) ) {;
                $child_flag=1;
                $child[0]=$child_ar[$partner[1]];
            }
            if ( !in_array($child_ar[$partner[1]],$mykan_ar) && in_array($inyo_rev[$child_ar[$partner[1]]],$mykan_ar) ) {;
                $child_flag=1;
                $child[0]=$inyo_rev[$child_ar[$partner[1]]];
            }
            if ( !in_array($child_ar[$partner[1]],$mykan_ar) && !in_array($inyo_rev[$child_ar[$partner[1]]],$mykan_ar) ) {;
                $child_flag=0;
                $child[0]=11;
                $child[1]=0;            // 該当なし
            }
        }
        //　自分が女
        if ($sei_flag==-1){
            if ( in_array($child_ar[$im_kd],$mykan_ar) && in_array($inyo_rev[$child_ar[$im_kd]],$mykan_ar)) {
                $child_flag=2;
                $child[0]=$child_ar[$im_kd];
                $child[1]=$inyo_rev[$child_ar[$im_kd]];
            }
            if ( in_array($child_ar[$im_kd],$mykan_ar) && !in_array($inyo_rev[$child_ar[$im_kd]],$mykan_ar)) {
                $child_flag=1;
                $child[0]=$child_ar[$im_kd];
            }
            if ( !in_array($child_ar[$im_kd],$mykan_ar) && in_array($inyo_rev[$child_ar[$im_kd]],$mykan_ar) ) {
                $child_flag=1;
                $child[0]=$inyo_rev[$child_ar[$im_kd]];
            }
            if ( !in_array($child_ar[$im_kd],$mykan_ar) && !in_array($inyo_rev[$child_ar[$im_kd]],$mykan_ar)) {
                $child_flag=0;
                $child[0]=11;
                $child[1]=0;        // 該当なし
            }
        }
        $output['resultData'] = array();
        $output['resultData']['myupline'] = $myupline;
        $output['resultData']['partner'] = $partner;
        $output['resultData']['child_flag'] = $child_flag;
        $output['resultData']['child'] = $child;

        $output['baseData']['d_10kan2'] = array("","甲","乙","丙","丁","戊","己","庚","辛","壬","癸","×");;

        return $output;
    }

    // -----------------------------------------
    // 自分側　母決定ルーチン  ---------------------------------------------

    // 　$i:子干位置　$i*2:母干位置
    function calc_mother($i,$im_kd,$im_sy,$mykan,$myup) {

        $myupline=$myup;
        $mother_ar=[0,10,9,2,1,4,3,6,5,8,7,11];    // 母の干支決定テーブル
        $inyo_rev=[0,2,1,4,3,6,5,8,7,10,9,11];      // 陰陽逆の干支
        $mykan_ar=$mykan;
        $x=0;
        if ($myupline[$i]!=11){
            //iの相生の陰陽逆干支が陰占にある
            if (array_search($mother_ar[$myupline[$i]],$mykan_ar)!==false) {
                $x=$mother_ar[$myupline[$i]];
            } else {
                ///iの相生の干支が陰占にある
                if (array_search($inyo_rev[$mother_ar[$myupline[$i]]],$mykan_ar)!==false) {
                    $x=$inyo_rev[$mother_ar[$myupline[$i]]];
                } else {
                    if ($i==1){
                        //蔵干の本元を探す（下から）
                        if ($this->calc_ura_zokan($im_sy,3)!=0){
                            $x=$this->calc_ura_zokan($im_sy,3);
                        }else if($this->calc_ura_zokan($im_sy,2)!=0){
                            $x=$this->calc_ura_zokan($im_sy,2);
                        }else if($this->calc_ura_zokan($im_sy,1)!=0){
                            $x=$this->calc_ura_zokan($im_sy,1);
                        }else{
                            $x=99;
                        }     // 99:error
                    }else{
                        $x=11;
                    }	                        // 11:該当なし
                }
            }
        }else{
            $x=11;
        }

        return $x;
    }

    //  自分側　母決定ルーチン　終わり　--------------------------------------------
    // 自分側 干合決定ルーチン　------------------------------------------------------
    function calc_mykango($i,$im_kd,$im_ky,$mykan,$myup) {           // 　i:決定元干支　*2:母干位置

        $myupline=$myup;
        $mother_ar=[0,10,9,2,1,4,3,6,5,8,7,11];    //
        $kango_ar=[0,6,7,8,9,10,1,2,3,4,5,11];      // パートナー決定テーブル（干合）
        $inyo_rev=[0,2,1,4,3,6,5,8,7,10,9,11];      // 陰陽逆の干支

        $mykan_ar=$mykan;
        $x=0;
        if ($myupline[$i]!=11){
            if (array_search($kango_ar[$myupline[$i]],$mykan_ar)!==false) {
                $x=$kango_ar[$myupline[$i]];
            } else {
                if (array_search($inyo_rev[$kango_ar[$myupline[$i]]],$mykan_ar)!==false) {
                    $x=$inyo_rev[$kango_ar[$myupline[$i]]];
                } else {         // 陰占にない
                    if ($i==2){
                        $x=$im_ky;
                    }else{
                        $x=11;
                    }               // 20:該当なし
                }
            }
        }else{
            $x=11;
        }

        return $x;
    }

    // パートナー側母決定ルーチン  ---------------------------------------------
    function calc_mother_p($i,$partner,$mykan) {      // 　i:子干位置　i*2:母干位置
        $mother_ar=[0,10,9,2,1,4,3,6,5,8,7,11];    // 母の干支決定テーブル
        $inyo_rev=[0,2,1,4,3,6,5,8,7,10,9,11];      // 陰陽逆の干支

        $partner=$partner;
        $mykan_ar=$mykan;

        $x=0;
        if (array_search($mother_ar[$partner[$i]],$mykan_ar)!==false) {
            $x=$mother_ar[$partner[$i]];
        } else {
            if (array_search($inyo_rev[$mother_ar[$partner[$i]]],$mykan_ar)!==false){
                $x=$inyo_rev[$mother_ar[$partner[$i]]];
            } else {
                $x=11;
            }
        }
        return $x;
    }
    //  パートナー側　母決定ルーチン　終わり　--------------------------------------------
    //  パートナー側 干合決定ルーチン　------------------------------------------------------
    function calc_pkango($i,$partner,$mykan) {;// 　i:決定元干支　*2:母干位置

        $partner=$partner;
        $kango_ar=[0,6,7,8,9,10,1,2,3,4,5,11];      // パートナー決定テーブル（干合）
        $inyo_rev=[0,2,1,4,3,6,5,8,7,10,9,11];      // 陰陽逆の干支

        $mykan_ar=$mykan;
        $x=0;

        if ($partner[$i]!=11){
            if (array_search($kango_ar[$partner[$i]],$mykan_ar)!==false ) {
                $x=$kango_ar[$partner[$i]];
            } else {
                //　陰占にない
                if (array_search($inyo_rev[$kango_ar[$partner[$i]]],$mykan_ar)!==false) {
                    $x=$inyo_rev[$kango_ar[$partner[$i]]];
                } else {
                    $x=11;
                }// 該当なし
            }
        }else{
            $x=11;
        }
        return $x;
    }

    function no_of_kan($a,$inData){
        $im_kd = $inData['im_kd'];
        $im_km = $inData['im_km'];
        $im_ky = $inData['im_ky'];
        $im_sd = $inData['im_sd'];
        $im_sm = $inData['im_sm'];
        $im_sy = $inData['im_sy'];
        $taiun_shi_arr = $inData['taiun_shi_arr'];
        $zero_y = $inData['zero_y'];
        $taiun_kan = $inData['taiun_kan'];
        $no_of_kan=[0,0,0,0,0,0,0,0,0,0,0];
        $no_of_kan[$im_kd]=$no_of_kan[$im_kd]+1;//命式日干
        $no_of_kan[$im_km]=$no_of_kan[$im_km]+1;//命式月干
        $no_of_kan[$im_ky]=$no_of_kan[$im_ky]+1;//命式年干

        /* 裏蔵干の干の合計　*/
        for ($i = 1; $i < 4; $i++) {               //日支から
            $no_of_kan[$this->calc_ura_zokan($im_sd,$i)]++ ;
        }

        for ($i = 1; $i < 4; $i++) {//月支から
            $no_of_kan[$this->calc_ura_zokan($im_sm,$i)]++ ;
        }

        for ($i = 1; $i < 4; $i++) {                //年支から
            $no_of_kan[$this->calc_ura_zokan($im_sy,$i)]++;
        }

        /* 大運支からの干の算出 */
        for ($i = 1; $i < 4; $i++) {
            $no_of_kan[$this->calc_ura_zokan($taiun_shi_arr[$a],$i)]++ ;
        }

        /* 年運支からの干の算出 */
        for ($i = 1; $i < 4; $i++) {
            $no_of_kan[$this->calc_ura_zokan($this->calc_nenshi1912($zero_y+$a),$i)]++ ;
        }
        /* 年運　干を足す */
        $no_of_kan[$this->calc_nenkan1912($zero_y+$a)]++;

        /* 大運　干を算出　*/

        $no_of_kan[$taiun_kan[$a]]++;

        return $no_of_kan;
    }

    function calc_ttl_energy_all($a,$inData){
        $im_kd = $inData['im_kd'];
        $im_km = $inData['im_km'];
        $im_ky = $inData['im_ky'];
        $im_sd = $inData['im_sd'];
        $im_sm = $inData['im_sm'];
        $im_sy = $inData['im_sy'];
        $taiun_shi_arr = $inData['taiun_shi_arr'];
        $zero_y = $inData['zero_y'];
        $taiun_kan = $inData['taiun_kan'];

        /* 命式と裏蔵干と大運干と年運干から出した甲から癸までの個数　 [甲,乙,丙,丁,戊,己,庚,辛,壬,癸] */
        $no_of_kan=[0,0,0,0,0,0,0,0,0,0,0];
        $no_of_kan[$im_kd]=$no_of_kan[$im_kd]+1;//命式日干
        $no_of_kan[$im_km]=$no_of_kan[$im_km]+1;//命式月干
        $no_of_kan[$im_ky]=$no_of_kan[$im_ky]+1;     //命式年干

        /* 裏蔵干の干の合計　*/
        for ( $i= 1; $i< 4; $i++) {//日支から
            $no_of_kan[$this->calc_ura_zokan($im_sd,$i)]++ ;
        }
        for ($i= 1; $i< 4; $i++) {;//月支から
            $no_of_kan[$this->calc_ura_zokan($im_sm,$i)]++ ;
        }
        for ($i= 1; $i< 4; $i++) {;                  //年支から
            $no_of_kan[$this->calc_ura_zokan($im_sy,$i)]++;
        }
        /* 大運支からの干の算出 */
        for ($i= 1; $i< 4; $i++) {;
            $no_of_kan[$this->calc_ura_zokan($taiun_shi_arr[$a],$i)]++ ;
        }
        /* 年運支からの干の算出 */
        for ($i= 1; $i< 4; $i++) {;
            $no_of_kan[$this->calc_ura_zokan($this->calc_nenshi1912($zero_y+$a),$i)]++ ;
        };
        /* 年運　干を足す */
        $no_of_kan[$this->calc_nenkan1912($zero_y+$a)]++;
        /* 大運　干を算出　*/
        $no_of_kan[$taiun_kan[$a]]++;
        $x=0;
        $y=0;
        $energy_year=0;
        //[日支,月支,年支,大運支,年運支,小計,個数,干計,五行毎エネルギー（2,4,6,8,10列)]
        $ar_energy=[[0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0]];
        for ($k=1; $k<11; $k++) {;
            $ar_energy[$k][0]=$this->calc_12jyu($k,$im_sd);//日支
            $ar_energy[$k][1]=$this->calc_12jyu($k,$im_sm);//月支
            $ar_energy[$k][2]=$this->calc_12jyu($k,$im_sy);//年支
            $ar_energy[$k][3]=$this->calc_12jyu($k,$taiun_shi_arr[$a]); //大運支
            $ar_energy[$k][4]=$this->calc_12jyu($k,$this->calc_nenshi1912($zero_y+$a));//年運支
            $ar_energy[$k][5]=$ar_energy[$k][0]+$ar_energy[$k][1]+$ar_energy[$k][2]+$ar_energy[$k][3]+$ar_energy[$k][4];//小計
            $ar_energy[$k][6]=$no_of_kan[$k];//個数
            $ar_energy[$k][7]=$no_of_kan[$k]*$ar_energy[$k][5];//干計
            $energy_year=$energy_year+$ar_energy[$k][7];//エネルギー足し算
        }
        $gogyo_energy=[0,0,0,0,0,0];   //本能毎のエネルギー
        if ($im_kd==1 || $im_kd==2) {
            $gogyo_energy=[$ar_energy[1][7]+$ar_energy[2][7],$ar_energy[3][7]+$ar_energy[4][7],$ar_energy[5][7]+$ar_energy[6][7],$ar_energy[7][7]+$ar_energy[8][7],$ar_energy[9][7]+$ar_energy[10][7]];
        }
        if ($im_kd==3 || $im_kd==4){
            $gogyo_energy=[$ar_energy[3][7]+$ar_energy[4][7],$ar_energy[5][7]+$ar_energy[6][7],$ar_energy[7][7]+$ar_energy[8][7],$ar_energy[9][7]+$ar_energy[10][7],$ar_energy[1][7]+$ar_energy[2][7]];
        }
        if ($im_kd==5 || $im_kd==6) {
            $gogyo_energy=[$ar_energy[5][7]+$ar_energy[6][7],$ar_energy[7][7]+$ar_energy[8][7],$ar_energy[9][7]+$ar_energy[10][7],$ar_energy[1][7]+$ar_energy[2][7],$ar_energy[3][7]+$ar_energy[4][7]];
        }
        if ($im_kd==7 || $im_kd==8) {
            $gogyo_energy=[$ar_energy[7][7]+$ar_energy[8][7],$ar_energy[9][7]+$ar_energy[10][7],$ar_energy[1][7]+$ar_energy[2][7],$ar_energy[3][7]+$ar_energy[4][7],$ar_energy[5][7]+$ar_energy[6][7]];
        }
        if ($im_kd==9 || $im_kd==10) {
            $gogyo_energy=[$ar_energy[9][7]+$ar_energy[10][7],$ar_energy[1][7]+$ar_energy[2][7],$ar_energy[3][7]+$ar_energy[4][7],$ar_energy[5][7]+$ar_energy[6][7],$ar_energy[7][7]+$ar_energy[8][7]];
        }
        //alert(Math.round(($gogyo_energy.sort(sortNumber)[4]-$gogyo_energy.sort(sortNumber)[0])/$energy_year*1000)/1000)
        $a=$energy_year;//　総エネルギー
        $b=$gogyo_energy[0];// 攻撃
        $c=$gogyo_energy[1];// 習得
        $d=$gogyo_energy[2];// 守備
        $e=$gogyo_energy[3];// 伝達
        $f=$gogyo_energy[4];// 魅力
        /*$y=Math.round(($gogyo_energy.sort(sortNumber)[4]-$gogyo_energy.sort(sortNumber)[0])/$energy_year*1000)/1000;
        $energy_total=$energy_total+$energy_year;*/

        return [$a,$b,$c,$d,$e,$f];
    }

}