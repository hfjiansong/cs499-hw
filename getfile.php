<?php
$once = isset($_GET["once"])?$_GET["once"]:"";
$url = isset($_GET["url"])?$_GET["url"]:"";
$two = isset($_GET["two"])?$_GET["two"]:"";
$type = isset($_GET["type"])?$_GET["type"]:"";
$title = isset($_GET["title"])?$_GET["title"]:"";
$seach = isset($_GET["seach"])?$_GET["seach"]:"";

if($once!=""&&$url!=""){
    $res = array();
    $json = file_get_contents($url);
    $arr = json_decode($json,true);
    if($once==1){
        foreach ($arr["sources"] as $v){
            $res[] =  array("name"=>$v["name"],"url"=>$v["url"],"two"=>$v["groupfields"][1]);
        }
        print(json_encode($res));
    }else if($once==2&&$two!=""){
        foreach($arr[$two][0] as $k=>$v){
            $value = array();
            $va = array();
            foreach($arr[$two] as $vt){
                $va[] = $vt[$k];
            }
            $va = array_unique($va);
            foreach ($va as $val){
                $value[] = $val;
            }
            $res[] = array("key"=>$k,"value"=>$value);
        }
        print(json_encode($res));
    }else if($once==3&&$two!=""&&$type!=""&&$title!=""){
        $data = $arr[$two];
        if($type==1){
            foreach($data as $val){
                if($seach==""||strpos($val[$title],$seach)!==false){
                    $res[] = $val;
                }
            }
        }else if($type==2){
            $len=0;
            foreach ($data as $n){
                $len++;
            }
            for($i=1;$i<$len;$i++){
                for($k=0;$k<$len-$i;$k++){
                    if($data[$k][$title]>$data[$k+1][$title]){
                        $tmp=$data[$k+1];
                        $data[$k+1]=$data[$k];
                        $data[$k]=$tmp;
                    }
                }
            }
            $res = $data;
        }
        print(json_encode(array("comments"=>$arr["comments"])));
        foreach ($res as $e){
            print(json_encode($e)."<br/>");
        }
    }

}
