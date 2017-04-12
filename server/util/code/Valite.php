<?php
// author email: ugg.xchj@gmail.com
// 本代码仅供学习参考，不提供任何技术保证。
// 切勿使用本代码用于非法用处，违者后果自负。


include_once("files.php");
class valite
{
    public function Draw()
    {
        for($i=0; $i<$this->ImageSize[1]; ++$i)
        {
            echo implode("",$this->DataArray[$i]);
            echo "\n";
        }
    }
    public function x2y($DataArray) {
        for($i=0; $i<count($DataArray[0]); ++$i)
        {
            // Y 坐标
            for($j=0; $j<count($DataArray); ++$j){
                $test[$i][$j] = $DataArray[$j][$i];
            }
        }
        return $test;
    }
    public function setImage($Image)
    {
        $this->ImagePath = $Image;
    }
    public function getData()
    {
        return $this->data;
    }

    public function study($info)
    {
        // 做成字符串
        $data = array();
        $i = 0;
        foreach($this->data as $key => $value)
        {
            $data[$i] = "";
            foreach($value as $skey => $svalue)
            {
                $data[$i] .= implode("",$svalue);
            }
            if(strlen($data[$i]) > $maxfontwith)
                ++$i;
        }

        if(count($data) != count($info))
        {
//			echo count($data)."\n";
//			print_r($data);
//			echo count($info)."\n";
            echo "$this->ImagePath\n";
            $this->Draw();
            return false;
        }

        // 设置N级匹配模式
        foreach($info as $key => $value)
        {
            if(isset($this->Keys[0][$value])){
//				print_r($value);
                $percent=0.0;
                similar_text($this->Keys[0][$value], $data[$key],$percent);
//				print_r($percent);
//				print_r(" \n");
                if(intval($percent) < 96)
                {
                    $i=1;
                    $OK = false;
                    while(isset($this->Keys[$i][$value]))
                    {
                        $percent=0.0;
//						print_r($value);
                        similar_text($this->Keys[$i][$value], $data[$key],$percent);
//						print_r($percent);
//						print_r(" \n");
                        if(intval($percent) > 96){
                            $OK = true;
                            break;
                        }
                        ++$i;
                    }
                    if(!$OK){
//						while(!isset($this->Keys[$i++][$value])){
//							print_r($i);
//						print_r($i);
//						print_r(" \n");
                        $this->Keys[$i][$value] = $data[$key];
//							$i++;
//						}
                    }
                }

            }else{
                $this->Keys[0][$value] = $data[$key];
            }
        }

        return true;

    }

    public function getResult()
    {
        return $this->DataArray;
    }
    public function getHec($name)
    {
        $res = imagecreatefrompng($this->ImagePath);
        $size = getimagesize($this->ImagePath);
        $data = array();
        for($i=0; $i < $size[1]; ++$i) {

            for($j=0; $j < $size[0]; ++$j)
            {
                $rgb = imagecolorat($res,$j,$i);
                $rgbarray = imagecolorsforindex($res, $rgb);
                if($name == 'asiamachinery') {
                    if ($rgbarray['red'] == 255 && $rgbarray['green'] == 255 && $rgbarray['blue'] == 255 ||
                        ($rgbarray['red'] < 255 && $rgbarray['red'] > 10
                            && $rgbarray['green'] < 255 && $rgbarray['green'] > 10
                            && $rgbarray['blue'] < 255 && $rgbarray['blue'] > 10)
                    ) {
                        $data[$i][$j] = 1;
                    } else {
                        $data[$i][$j] = 0;
                    }
                } else if($name == 'aunetads') {
                    if ($rgbarray['red'] == 0 && $rgbarray['green'] == 0 && $rgbarray['blue'] == 255) {
                        $data[$i][$j] = 1;
                    } else {
                        $data[$i][$j] = 0;
                    }

                } else if($name == 'b2bage') {
                    if ($rgbarray['red'] > 240 && $rgbarray['green'] > 240 && $rgbarray['blue'] > 240) {
                        $data[$i][$j] = 1;
                    } else {
                        $data[$i][$j] = 0;
                    }

                } else if($name == 'b2btrademarketing') {
                    if (($i>0 && $j>0 && $j<55) &&
                        (($rgbarray['red'] > 220 && $rgbarray['green'] > 240 && $rgbarray['blue'] > 240)||
                            ($rgbarray['red'] > 240 && $rgbarray['green'] > 220 && $rgbarray['blue'] > 240) ||
                            ($rgbarray['red'] > 240 && $rgbarray['green'] > 240 && $rgbarray['blue'] > 220) ||
                            ($rgbarray['red'] < 45 && $rgbarray['green'] < 45 && $rgbarray['blue'] < 45))) {
                        $data[$i][$j] = 1;
                    } else {
                        $data[$i][$j] = 0;
                    }

                } else if($name == 'asianproducts') {
                    if ($rgbarray['red'] <48 && $rgbarray['green'] < 48 && $rgbarray['blue'] < 48) {
                        $data[$i][$j] = 1;
                    } else {
                        $data[$i][$j] = 0;
                    }

                } else if($name == '21chemnet') {
                    $num = 0;
                    $rgbarray2 = $rgbarray;
                    if ($rgbarray2['red'] < 20 || $rgbarray2['green'] < 20 || $rgbarray2['blue'] < 20 ) {
                        // 上
                        if ($i >=0) {
                            $rgb = imagecolorat($res,$j,$i - 1);
                            $rgbarray = imagecolorsforindex($res, $rgb);
                            if ($rgbarray['red'] == 102 && $rgbarray['green'] == 102 && $rgbarray['blue'] == 102)
                                $num = $num + 1;
                        }
                        // 下
                        if ($i < $size[1]) {
                            $rgb = imagecolorat($res,$j,$i + 1);
                            $rgbarray = imagecolorsforindex($res, $rgb);
                            if ($rgbarray['red'] == 102 && $rgbarray['green'] == 102 && $rgbarray['blue'] == 102)
                                $num = $num + 1;

                        }
                        // 左
                        if ($j >= 0) {
                            $rgb = imagecolorat($res,$j - 1,$i);
                            $rgbarray = imagecolorsforindex($res, $rgb);
                            if ($rgbarray['red'] == 102 && $rgbarray['green'] == 102 && $rgbarray['blue'] == 102)
                                $num = $num + 1;
                        }
                        // 右
                        if ($j < $size[0]) {
                            $rgb = imagecolorat($res,$j + 1,$i);
                            $rgbarray = imagecolorsforindex($res, $rgb);
                            if ($rgbarray['red'] == 102 && $rgbarray['green'] == 102 && $rgbarray['blue'] == 102)
                                $num = $num + 1;
                        }
                    }
                    if ($rgbarray2['red'] == 102 && $rgbarray2['green'] == 102 && $rgbarray2['blue'] == 102 || $num > 1) {
                        $data[$i][$j] = 1;
                        //$data[$i][$j]='1,'.$rgbarray['red'].','.$rgbarray['green'].','.$rgbarray['blue'];
                    } else {
                        $data[$i][$j] = 0;
                        //$data[$i][$j]='0,'.$rgbarray['red'].','.$rgbarray['green'].','.$rgbarray['blue'];
                    }
                }
            }
        }

        // 如果1的周围数字不为1，修改为了0
        for($i=0; $i < $size[0]; ++$i)
        {
            for($j=0; $j < $size[1]; ++$j)
            {
                $num = 0;
                if($data[$j][$i] == 1)
                {
                    // 左
                    if(isset($data[$j][$i-1])){
                        $num = $num + $data[$j][$i-1];
                    }
                    // 右
                    if(isset($data[$j][$i+1])){
                        $num = $num + $data[$j][$i+1];
                    }
                    // 上
                    if(isset($data[$j-1][$i])){
                        $num = $num + $data[$j-1][$i];
                    }
                    // 下
                    if(isset($data[$j+1][$i])){
                        $num = $num + $data[$j+1][$i];
                    }
                    // 上左
                    if(isset($data[$j-1][$i-1])){
                        $num = $num + $data[$j-1][$i-1];
                    }
                    // 上右
                    if(isset($data[$j+1][$i-1])){
                        $num = $num + $data[$j+1][$i-1];
                    }
                    // 下左
                    if(isset($data[$j-1][$i+1])){
                        $num = $num + $data[$j-1][$i+1];
                    }
                    // 下右
                    if(isset($data[$j+1][$i+1])){
                        $num = $num + $data[$j+1][$i+1];
                    }
                }
                if($name == 'asiamachinery' ) {
                    if ($num == 0) {
                        $data[$j][$i] = 0;
                    }
                } else if($name == '21chemnet' || $name == 'b2btrademarketing') {
                    if ($num <= 1) {
                        $data[$j][$i] = 0;
                    }
                } else if($name == 'asianproducts') {
                    if ($num <= 2) {
                        $data[$j][$i] = 0;
                    }
                }
            }
        }

        $this->DataArray = $data;
        $this->ImageSize = $size;
    }

    public function run()
    {
        $result="";

        // 做成字符串
        // 做成字符串
        $data = array();
        $i = 0;
        foreach($this->data as $key => $value)
        {
            $data[$i] = "";
            foreach($value as $skey => $svalue)
            {
                $data[$i] .= implode("",$svalue);
            }
            if(strlen($data[$i]) > $maxfontwith)
                ++$i;
        }

        // 进行关键字匹配
        foreach($data as $numKey => $numString)
        {
//			print_r($numString);
            $max=0.0;
            $num = 0;
            foreach($this->Keys as $key => $value)
            {
                $FindOk = false;
//				print_r($value);
                foreach($value as $skey => $svalue)
                {
//					print_r($svalue);
                    $percent=0.0;
                    similar_text($svalue, $numString,$percent);
//					print_r($percent);
//					echo " ";
                    if(intval($percent) > $max)
                    {
                        $max = $percent;
                        $num = $skey;
                        if(intval($percent) > 96){
                            $FindOk = true;
                            break;
                        }
                    }
                }
                if($FindOk)
                    break;
            }
//			echo "\n max=";
//			echo $max;
//			echo "\n";
//			echo $num."\n";
            $result.=$num;
        }

        // 查找最佳匹配数字
        return $result;
    }

    public function bmp2png($file, $degrees=0, $compress=0){
        $res = $this->imagecreatefrombmp($file);
        if(!$res)
            $res = imagecreatefrompng($file);
        if(!$res)
            $res = imagecreatefromgif($file);
        if(!$res)
            $res = imagecreatefromjpeg($file);


        if($degrees) {
            $white = imagecolorallocate($res, 255, 255, 255);
            $rotate = imagerotate($res, $degrees, $white, 0);
            $res = $rotate;
        }
        if($compress) {
            $width = imagesx($res);
            $height = imagesy($res);
            $thumb = imagecreatetruecolor($width/$compress, $height/$compress);
            imagecopyresized($thumb, $res, 0, 0, 0, 0, $width/$compress, $height/$compress, $width, $height);
            $res = $thumb;
        }
        imagepng($res, $file);
    }

    public function filterInfo($name='')
    {
        $data=array();
        $num = 0;
        $b = false;
        $Continue = 0;
        $XStart = 0;

        // X 坐标
        for ($i = 0; $i < $this->ImageSize[0]; ++$i) {
            // Y 坐标
            for ($j = 0; $j < $this->ImageSize[1]; ++$j) {
                if ($this->DataArray[$j][$i] == "1") {
                    $b = true;
                    ++$Continue;
                    break;
                } else {
                    $b = false;
                }
            }
            if ($b == true) {
                for ($jj = 0; $jj < $this->ImageSize[1]; ++$jj) {
                    $data[$num][$jj][$XStart] = $this->DataArray[$jj][$i];
                }
                ++$XStart;

            } else {
                if ($Continue > 0) {
                    $XStart = 0;
                    $Continue = 0;
                    ++$num;
                }
            }
        }

        $this->data = $data;
        // 去掉0数据
        for($num = 0; $num < count($this->data); ++$num)
        {
            if(count($this->data[$num]) != $this->ImageSize[1])
            {
                return "分割字符错误";
            }

            for($i=0; $i < $this->ImageSize[1]; ++$i)
            {
                $str = implode("",$this->data[$num][$i]);
                $pos = strpos($str, "1");
                if($pos === false)
                {
                    unset($this->data[$num][$i]);
                }
            }
        }

//                for($j=0; $j<count($this->data); $j++) {
//                    for ($i = 0; $i < count($data[$j]); ++$i) {
//                        echo implode("", $data[$j][$i]);
//                        echo "\n";
//                    }
//                    echo "\n================\n";
//                    for ($i = 0; $i < count($data[$j]); ++$i) {
//                        echo implode("", $this->data[$j][$i]);
//                        echo "\n";
//                    }
//                    echo "\n\n\n===================================\n\n\n";
//                }


    }

    public function freadbyte($f)
    {
        return ord(fread($f,1));
    }

    public function freadword($f)
    {
        $b1=$this->freadbyte($f);
        $b2=$this->freadbyte($f);
        return $b2*256+$b1;
    }

    public function freaddword($f)
    {
        $b1=$this->freadword($f);
        $b2=$this->freadword($f);
        return $b2*65536+$b1;
    }

    public function __construct()
    {
        //$keysfiles = new files;
        //$this->Keys = $keysfiles->funserialize();
        //if($this->Keys == false)
        $this->Keys = array();
        //unset($keysfiles);
    }
    public function __destruct()
    {
        $keysfiles = new files;
        $keysfiles->fserialize($this->Keys);
//		print_r($this->Keys);
    }
    protected $ImagePath;
    protected $DataArray;
    protected $ImageSize;
    protected $data;
    protected $Keys;
    protected $NumStringArray;
    public $maxfontwith = 16;

    public function imagecreatefrombmp($file)
    {
        global  $CurrentBit, $echoMode;

        $f=fopen($file,"r");
        $Header=fread($f,2);

        if($Header=="BM")
        {
            $Size=$this->freaddword($f);
            $Reserved1=$this->freadword($f);
            $Reserved2=$this->freadword($f);
            $FirstByteOfImage=$this->freaddword($f);

            $SizeBITMAPINFOHEADER=$this->freaddword($f);
            $Width=$this->freaddword($f);
            $Height=$this->freaddword($f);
            $biPlanes=$this->freadword($f);
            $biBitCount=$this->freadword($f);
            $RLECompression=$this->freaddword($f);
            $WidthxHeight=$this->freaddword($f);
            $biXPelsPerMeter=$this->freaddword($f);
            $biYPelsPerMeter=$this->freaddword($f);
            $NumberOfPalettesUsed=$this->freaddword($f);
            $NumberOfImportantColors=$this->freaddword($f);

            if($biBitCount<24)
            {
                $img=imagecreate($Width,$Height);
                $Colors=pow(2,$biBitCount);
                for($p=0;$p<$Colors;$p++)
                {
                    $B=$this->freadbyte($f);
                    $G=$this->freadbyte($f);
                    $R=$this->freadbyte($f);
                    $Reserved=$this->freadbyte($f);
                    $Palette[]=imagecolorallocate($img,$R,$G,$B);
                };




                if($RLECompression==0)
                {
                    $Zbytek=(4-ceil(($Width/(8/$biBitCount)))%4)%4;

                    for($y=$Height-1;$y>=0;$y--)
                    {
                        $CurrentBit=0;
                        for($x=0;$x<$Width;$x++)
                        {
                            $C=freadbits($f,$biBitCount);
                            imagesetpixel($img,$x,$y,$Palette[$C]);
                        };
                        if($CurrentBit!=0) {$this->freadbyte($f);};
                        for($g=0;$g<$Zbytek;$g++)
                            $this->freadbyte($f);
                    };

                };
            };


            if($RLECompression==1) //$BI_RLE8
            {
                $y=$Height;

                $pocetb=0;

                while(true)
                {
                    $y--;
                    $prefix=$this->freadbyte($f);
                    $suffix=$this->freadbyte($f);
                    $pocetb+=2;

                    $echoit=false;

                    if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
                    if(($prefix==0)and($suffix==1)) break;
                    if(feof($f)) break;

                    while(!(($prefix==0)and($suffix==0)))
                    {
                        if($prefix==0)
                        {
                            $pocet=$suffix;
                            $Data.=fread($f,$pocet);
                            $pocetb+=$pocet;
                            if($pocetb%2==1) {$this->freadbyte($f); $pocetb++;};
                        };
                        if($prefix>0)
                        {
                            $pocet=$prefix;
                            for($r=0;$r<$pocet;$r++)
                                $Data.=chr($suffix);
                        };
                        $prefix=$this->freadbyte($f);
                        $suffix=$this->freadbyte($f);
                        $pocetb+=2;
                        if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
                    };

                    for($x=0;$x<strlen($Data);$x++)
                    {
                        imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
                    };
                    $Data="";

                };

            };


            if($RLECompression==2) //$BI_RLE4
            {
                $y=$Height;
                $pocetb=0;

                /*while(!feof($f))
                echo $this->freadbyte($f)."_".$this->freadbyte($f)."<BR>";*/
                while(true)
                {
                    //break;
                    $y--;
                    $prefix=$this->freadbyte($f);
                    $suffix=$this->freadbyte($f);
                    $pocetb+=2;

                    $echoit=false;

                    if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
                    if(($prefix==0)and($suffix==1)) break;
                    if(feof($f)) break;

                    while(!(($prefix==0)and($suffix==0)))
                    {
                        if($prefix==0)
                        {
                            $pocet=$suffix;

                            $CurrentBit=0;
                            for($h=0;$h<$pocet;$h++)
                                $Data.=chr(freadbits($f,4));
                            if($CurrentBit!=0) freadbits($f,4);
                            $pocetb+=ceil(($pocet/2));
                            if($pocetb%2==1) {$this->freadbyte($f); $pocetb++;};
                        };
                        if($prefix>0)
                        {
                            $pocet=$prefix;
                            $i=0;
                            for($r=0;$r<$pocet;$r++)
                            {
                                if($i%2==0)
                                {
                                    $Data.=chr($suffix%16);
                                }
                                else
                                {
                                    $Data.=chr(floor($suffix/16));
                                };
                                $i++;
                            };
                        };
                        $prefix=$this->freadbyte($f);
                        $suffix=$this->freadbyte($f);
                        $pocetb+=2;
                        if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
                    };

                    for($x=0;$x<strlen($Data);$x++)
                    {
                        imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
                    };
                    $Data="";

                };

            };


            if($biBitCount==24)
            {
                $img=imagecreatetruecolor($Width,$Height);
                $Zbytek=$Width%4;

                for($y=$Height-1;$y>=0;$y--)
                {
                    for($x=0;$x<$Width;$x++)
                    {
                        $B=$this->freadbyte($f);
                        $G=$this->freadbyte($f);
                        $R=$this->freadbyte($f);
                        $color=imagecolorexact($img,$R,$G,$B);
                        if($color==-1) $color=imagecolorallocate($img,$R,$G,$B);
                        imagesetpixel($img,$x,$y,$color);
                    }
                    for($z=0;$z<$Zbytek;$z++)
                        $this->freadbyte($f);
                };
            };
            return $img;

        };


        fclose($f);
    }

}
?>