<?php
session_start();
header("Expires: Mon, 26 Jul 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");          
header("Cache-Control: no-cache, must-revalidate");      
header("Pragma: no-cache");
header('Content-type: text/json; charset=utf-8');
include_once "include/com_chk.php";
include_once("common/function.php");
include_once "include/address.mem.php";

//这里要进行时间判断
sessionBet($uid);
if($uid=='')
{
	echo "<script>alert('您未登录,请先登录!')</script>";
	session_destroy();
	echo "<script>location.href='/app/member/logout.php';</script>";
	exit;
}
global $mysqli;


function str_leng($str){ //取字符串长度
	mb_internal_encoding("UTF-8");
	return mb_strlen($str)*12;
}

//print_r($_REQUEST);exit;

function getdatable($ballsort)
{
	$t  = array(array("cn"=>"足球波胆","db_table"=>"bet_match"),
	array("cn"=>"足球单式","db_table"=>"bet_match"),
	array("cn"=>"足球上半场","db_table"=>"bet_match"),
	array("cn"=>"足球早餐","db_table"=>"bet_match"),
	array("cn"=>"足球滚球","db_table"=>"bet_match"),
	array("cn"=>"篮球单式","db_table"=>"lq_match"),
	array("cn"=>"篮球单节","db_table"=>"lq_match"),
	array("cn"=>"篮球滚球","db_table"=>"lq_match"),
	array("cn"=>"篮球早餐","db_table"=>"lq_match"),
	array("cn"=>"排球单式","db_table"=>"volleyball_match"),
	array("cn"=>"排球早餐","db_table"=>"volleyball_match"),
	array("cn"=>"网球单式","db_table"=>"tennis_match"),
	array("cn"=>"网球早餐","db_table"=>"tennis_match"),
	array("cn"=>"棒球单式","db_table"=>"baseball_match"),
	array("cn"=>"棒球早餐","db_table"=>"baseball_match"),
	array("cn"=>"其他单式","db_table"=>"other_match"),
	array("cn"=>"其他早餐","db_table"=>"other_match"),
	array("cn"=>"冠军","db_table"=>"t_guanjun"),
	array("cn"=>"金融","db_table"=>"t_guanjun"));
	foreach ($t as $m){
   		if($m['cn']==$ballsort){    
   	  		$db_table=$m['db_table'];
   		}
    }
	return $db_table;
}
function check_point($ballsort,$column,$match_id,$point,$rgg,$dxgg,$tid=0,$index=0){ 

	global $match_showtype; 
	$pk = array("Match_Ho","Match_Ao","Match_DxDpl","Match_DxXpl","Match_BHo","Match_BAo","Match_Bdpl","Match_Bxpl"); //让球大小盘口
	$t  = array(array("cn"=>"足球波胆","db_table"=>"bet_match"),
	array("cn"=>"足球单式","db_table"=>"bet_match"),
	array("cn"=>"足球上半场","db_table"=>"bet_match"),
	array("cn"=>"足球早餐","db_table"=>"bet_match"),
	array("cn"=>"足球滚球","db_table"=>"zqgq_match"),
	array("cn"=>"篮球单式","db_table"=>"lq_match"),
	array("cn"=>"篮球单节","db_table"=>"lq_match"),
	array("cn"=>"篮球滚球","db_table"=>"lqgq_match"),
	array("cn"=>"篮球早餐","db_table"=>"lq_match"),
	array("cn"=>"排球单式","db_table"=>"volleyball_match"),
	array("cn"=>"排球早餐","db_table"=>"volleyball_match"),
	array("cn"=>"网球单式","db_table"=>"tennis_match"),
	array("cn"=>"网球早餐","db_table"=>"tennis_match"),
	array("cn"=>"棒球单式","db_table"=>"baseball_match"),
	array("cn"=>"棒球早餐","db_table"=>"baseball_match"),
	array("cn"=>"其他单式","db_table"=>"other_match"),
	array("cn"=>"其他早餐","db_table"=>"other_match"),
	array("cn"=>"冠军","db_table"=>"t_guanjun_team"),
	array("cn"=>"金融","db_table"=>"t_guanjun_team"));
	foreach ($t as $m){
   		if($m['cn']==$ballsort){    
   	  		$db_table=$m['db_table'];
   		}
    }
	//把水位和让球与大小盘口设为字符串形式，以便下面绝对判断
	$rgg		=	"".$rgg;
	$dxgg		=	"".$dxgg;
	$point		=	"".sprintf("%.2f", $point);

   	if($db_table=="zqgq_match" || $db_table=="lqgq_match"){ //足球滚球、篮球滚球不验证数据库，直接验证缓存文件
		if($db_table == "zqgq_match"){
			include_once("cache/uid.php");
			
			if($hguid!="")
			{
				include_once("include/function_cj.php");
				if(zqgq_cj()){ //不管怎样，重新采集一次
					include("cache/zqgq.php"); //重新载入
				}else{
					error2("网络异常,交易失败");
				}
			}else{
				include("cache/zqgq.php"); //重新载入
			}
			
			
			if(time()-$lasttime > 10){ //超时
				error2("盘口已关闭,交易失败830");
			}
			for($i=0; $i<count($zqgq);$i++){
				if(@$zqgq[$i]['Match_ID'] == $match_id) break;
			}
			$match_showtype=$zqgq[$i]['Match_ShowType'];
			if($zqgq[$i][$column] < 0.01){
				error2("盘口已关闭,交易失败801");
			}
			$zqgq[$i][$column]=sprintf("%01.2f", $zqgq[$i][$column]);
			if($zqgq[$i][$column] == $point){
				if(in_array($column,$pk)){ //盘口
					if(($column=="Match_Ho" || $column=="Match_Ao") && $zqgq[$i]["Match_RGG"] != $rgg){ //全场让球盘口改已变
						if($zqgq[$i]["Match_RGG"] == ''){
							error2("盘口已关闭,交易失败802");
						}else{
							error1('盘口改变,重新下注803');
						}
					}elseif(($column=="Match_BHo" || $column=="Match_BAo") && $zqgq[$i]["Match_BRpk"] != $rgg){ //上半场让球盘口改已变
						if($zqgq[$i]["Match_BRpk"] == ''){
							error2("盘口已关闭,交易失败804");
						}else{
							error1('盘口改变,重新下注805');
						}
					}elseif(($column=="Match_DxDpl" || $column=="Match_DxXpl") && $zqgq[$i]["Match_DxGG"] != $dxgg){ //全场大小盘口改已变
						if($zqgq[$i]["Match_DxGG"] == ''){
							error2("盘口已关闭,交易失败806");
						}else{
							error1('盘口改变,重新下注807');
						}
					}elseif(($column=="Match_Bdpl" || $column=="Match_Bxpl") && $zqgq[$i]["Match_Bdxpk"] != $dxgg){ //上半场大小盘口改已变
						if($zqgq[$i]["Match_Bdxpk"] == ''){
							error2("盘口已关闭,交易失败808");
						}else{
							error1('盘口改变,重新下注809');
						}
					}
				}
				return  true;
			}else{//水位变动
				error1('赔率改变,重新下注810');
			}
		}else{
			include_once("cache/uid.php");
			if($hguid!="")
			{
				include_once("include/function_cj.php");
				if(lqgq_cj()){ //不管怎样，重新采集一次
					include("cache/lqgq.php"); //重新载入
				}else{
					error2("网络异常,交易失败");
				}
			}else{
				include("cache/lqgq.php"); //重新载入
			}
			if(time()-$lasttime > 10){ //超时
				error2("盘口已关闭,交易失败831");
			}
			for($i=0; $i<count($lqgq);$i++){
				if(@$lqgq[$i]['Match_ID'] == $match_id) break;
			}
			$match_showtype=$lqgq[$i]['Match_ShowType'];
			if($lqgq[$i][$column] < 0.01){
				error2("盘口已关闭,交易失败811");
			}
			$lqgq[$i][$column]=sprintf("%01.2f", $lqgq[$i][$column]);
			if($lqgq[$i][$column] == $point){
				if(in_array($column,$pk)){ //盘口
					if(($column=="Match_Ho" || $column=="Match_Ao") && $lqgq[$i]["Match_RGG"] != $rgg){ //全场让球盘口改已变
						if($lqgq[$i]["Match_RGG"] == '' || $lqgq[$i]["Match_RGG"] == 0){
							error2("盘口已关闭,交易失败812");
						}else{
							error1('盘口改变,重新下注813');
						}
					}elseif(($column=="Match_DxDpl" || $column=="Match_DxXpl") && $lqgq[$i]["Match_DxGG"] != $dxgg){ //全场大小盘口改已变
						if($lqgq[$i]["Match_DxGG"] == '' || $lqgq[$i]["Match_DxGG"] == 0){
							error2("盘口已关闭,交易失败814");
						}else{
							error1('盘口改变,重新下注815');
						}
					}
				}
				return  true;
			}else{//水位变动
				error1('赔率改变,重新下注816');
			}
		}
	}else{
		global $mysqli;
		if($db_table	==	"t_guanjun_team"){
			if($tid){
				$sql		=	"select t.point from t_guanjun_team t,t_guanjun g where t.tid=$tid and t.xid=g.x_id and g.Match_CoverDate>'$et_time_now' limit 1"; //赛事未结束
				$query		=	$mysqli->query($sql);
				$rs			=	$query->fetch_array();
				$newpoint	=	"".sprintf("%.2f",$rs["point"]);
				if($newpoint==$point){
					return  true;
				}else{   //水位变动
					if($newpoint == 0){
						error2("盘口已关闭,交易失败817");
					}else{
						error1('赔率改变,重新下注818');
					}
				}
			}
		}else{
			global	$touzhutype;
			$other		=	"";
			if($db_table == "bet_match") $other = ",Match_BRpk,Match_Bdxpk";
			$sql		=	"select match_showtype,Match_RGG,Match_DxGG,$column $other from $db_table where match_id=$match_id and Match_CoverDate>'$et_time_now' limit 1"; //赛事未结束
			$query		=	$mysqli->query($sql);
			$rs			=	$query->fetch_array();
			$match_showtype=$rs['match_showtype'];
			$newpoint	=	"".sprintf("%.2f",$rs["$column"]);
			if($newpoint==$point){
				if(in_array($column,$pk)){ //盘口
					if(($column=="Match_Ho" || $column=="Match_Ao") && $rs["Match_RGG"] != $rgg){ //全场让球盘口改已变
						error1('盘口改变,重新下注819');
					}elseif(($column=="Match_DxDpl" || $column=="Match_DxXpl") && $rs["Match_DxGG"] != $dxgg){ //全场大小盘口改已变
						error1('盘口改变,重新下注!820');
					}elseif(($column=="Match_BHo" || $column=="Match_BAo") && $rs["Match_BRpk"] != $rgg){ //上半场让球盘口改已变
						error1('盘口改变,重新下注!821');
					}elseif(($column=="Match_Bdpl" || $column=="Match_Bxpl") && $rs["Match_Bdxpk"] != $dxgg){ //上半场大小盘口改已变
						error1('盘口改变,重新下注!822');
					}
				}
				
				return  true;
			}else{   //水位变动
				if($newpoint == 0){
					error2("盘口已关闭,交易失败823");
				}else{
					error1('赔率改变,重新下注824');
				}
			}
		}
	}
}


function error1($msg)//重新下
{
		echo "<div class=\"match_error\">".$msg."</div>";
		echo "<script>";
		echo "$(\"#post_s\").css(\"display\",\"none\");";
		echo "$(\"#touzhudiv\").css(\"display\",\"block\");";
		echo "waite();";
		echo "clear_input();";
		echo "$(\"#bet_money\").val(\"\");";
		echo "</script>";

		exit;
}

function error2($msg)//关闭
{
		echo "<div class=\"match_error\">".$msg."</div>";
		echo "<script>";
		echo "$(\"#post_s\").css(\"display\",\"none\");";
		echo "$(\"#touzhudiv\").html('');";
		echo "window.clearTimeout(winRedirect);";
		echo "clear_input();";
		echo "$(\"#bet_money\").val(\"\");";
		echo "$(\"#okclose\").css(\"display\",\"none\");";
		echo "$(\"#okbtn\").css(\"display\",\"none\");";
		echo "$(\"#closebtn\").css(\"display\",\"block\");";
		echo "$(\"#cg_num\").html('0');";
		echo "$(\"#cg_msg\").css(\"display\",\"none\");";
		echo "cg_count=0;";
		echo "</script>";

		exit;
}

function msgok($msg,$msg2,$money)//关闭
{
		echo "<div class=\"match_ok\">".$msg."</div>";
		echo "<div class=\"match_ok\">".$msg2."</div>";
		echo "<script>";
		echo "$(\"#post_s\").css(\"display\",\"none\");";
		echo "$(\"#touzhudiv\").html('');";
		echo "window.clearTimeout(winRedirect);";
		echo "clear_input();";
		echo "$(\"#bet_money\").val(\"\");";
		echo "$(\"#okclose\").css(\"display\",\"none\");";
		echo "$(\"#okbtn\").css(\"display\",\"none\");";
		echo "$(\"#closebtn\").css(\"display\",\"block\");";
		echo "$(\"#user_money\").html('".$money."');";
		echo "$(\"#cg_num\").html('0');";
		echo "$(\"#cg_msg\").css(\"display\",\"none\");";
		echo "cg_count=0;";

		echo "</script>";
		
		exit;
}

function cg_ok($str)////判断是否允许串关
{

			if(strpos($str,"滚球")){
				return "滚球未开放串关功能";
			}
			if(strpos($str,"半全场")){
		    	return "半全场未开放串关功能";
			}
			if(strpos($str,"角球數")){
		    	return "角球數未开放串关功能";
			}
			if(strpos($str,"角球数")){
		    	return "角球數未开放串关功能";
			}
			if(strpos($str,"先開球")){
		    	return "先開球未开放串关功能";
			}
			if(strpos($str,"先开球")){
		    	return "先开球未开放串关功能";
			}
			if(strpos($str,"入球数")){
		    	return "入球数未开放串关功能";
			}
			if(strpos($str,"波胆")){
		    	return "波胆未开放串关功能";
			}
			if(strpos($str,"网球")){
		    	return "网球未开放串关功能";
			}
			if(strpos($str,"排球")){
		    	return "排球未开放串关功能";
			}
			if(strpos($str,"棒球")){
		    	return "棒球未开放串关功能";
			}

			//if(data.indexOf("冠军")>=0){
		    //	alert("冠军未开放串关功能");
			//	return ;
			//}
			if(strpos($str,"主场")){
		    	return "同场赛事不能重复参与串关";
			}

			return "ok";
}

$bet_money		=	trim($_POST["bet_money"]);
$touzhutype		=	trim($_POST["touzhutype"]);


if(is_numeric($bet_money) && is_int($bet_money*1)){

$sql_group	=	"SELECT sports_bet,sports_bet_reb,sports_lower_bet FROM user_group where group_id='".@$_SESSION["group_id"]."' limit 0,1";
	$query_group	=	$mysqli->query($sql_group);
	$group_db	=	$query_group->fetch_array();

	$bet_money	=	$bet_money*1;
	//会员余额
	$balance	=	0;//投注后
	$assets		=	0;//投注前
	$sql		= 	"select money from user_list where user_id='$userid' limit 1";
	$query 		=	$mysqli->query($sql);
	$rs			=	$query->fetch_array();
	if($rs['money']){
		$assets	=	round($rs['money'],2);
		$balance=	$assets-$bet_money;
	}else{
		error2("账户异常,请联系客服!");
	}

	$sql		= 	"select balance from money_log where user_id='$userid' order by id desc limit 0,1";
	$query 		=	$mysqli->query($sql);
	$rs_l			=	$query->fetch_array();
	if(floatval($rs_l['balance'])!=floatval($assets)){
		$sql = "update user_list set online=0,Oid='',status='异常',remark='体育下注时发现资金异常$bj_time_now' where user_id='$userid'";//设置异常用户
		$mysqli->query($sql);
		error2("账户资金异常,请联系客服!");
	}
	
	if($balance<0){ //投注后，用户余额不能小于0
		error1("账户余额不足!");
	}
	if($bet_money<$group_db['sports_lower_bet']){
		error1("最低交易金额:".$group_db['sports_lower_bet']);
	}

	$arr_add		=	array('Match_Ho','Match_Ao','Match_DxDpl','Match_DxXpl','Match_BHo','Match_BAo','Match_Bdpl','Match_Bxpl');

    if(strpos($str,"篮球")){
        return "同场赛事不能重复参与串关";
    }

	if($touzhutype		==	0){ //单式
		$match_id		=	intval($_POST["match_id"][0]);
		$ball_sort		=	strip_tags($_POST["ball_sort"][0]);
		$point_column	=	strip_tags($_POST["point_column"][0]);
		$bet_point		=	strip_tags($_POST["bet_point"][0]*1);
		$column			=	strip_tags($_POST["point_column"][0]);
		$tid			=	intval($_POST["tid"][0]);

		$ben_add=0;
		$bet_win		=	$bet_money*$bet_point; //可赢金额=交易金额*当前水位
		if(in_array($point_column,$arr_add)){ //让球，大小，半场让球，半场大小，可赢金额要加上本金
			$bet_win	+=	$bet_money;
			$ben_add=1;
		}
		
		$db_t=getdatable($ball_sort);
		if($db_t=="t_guanjun"){
			include_once("class/guanjun.php");
		}else{
			include_once("class/".$db_t.".php");
		}

        /*关闭篮球独赢
		if($point_column=="Match_BzM" || $point_column=="Match_BzG")
		{
			if($db_t=="lq_match")
			{
				error2("篮球独赢已关闭");
			}
		}
		*/
		
		
		if($ball_sort == "冠军"){
            error2("冠军数据不正确，临时关闭下注。");
			//获取比赛详细信息
			$rows=bet_match::getmatch_info($tid);
			$master_guest	=	$rows["match_name"];
			$match_time		=	$rows['match_time'];
			$match_endtime	=	$rows['Match_CoverDate'];
			$match_rgg		=	'';
			$match_dxgg		=	'';
			$match_type		=	$rows['match_type'];
			$match_showtype =	'';
			$match_nowscore =	'';
			$match_name		=	$rows['x_title'];
			$game_type		=	$rows['game_type'];
		}else{
			
			//获取比赛详细信息
			$rows=bet_match::getmatch_info($match_id,$point_column,$ball_sort);
			$master_guest	=	$rows["match_master"]."VS.".$rows["match_guest"];
			$match_time		=	$rows['match_time'];
			$match_endtime	=	$rows['Match_CoverDate'];
			$match_rgg		=	$rows['match_rgg'];
			$match_dxgg		=	$rows['match_dxgg'];
			$match_type		=	$rows['match_type'];
			$match_showtype =	$rows['match_showtype'];
			$match_nowscore =	$rows['Match_NowScore'];
			$match_name		=	$rows['match_name'];
			$game_type		=	'';

		}

		

		if($et_time>strtotime($match_endtime) && !strpos($ball_sort,"滚球")){ //不是滚球，赛事已结束，无法投注
			error2("赛事已结束,交易失败");
		}elseif(strpos($master_guest,'先开球') && $et_time+300>strtotime($match_endtime)){ //先開球提前 5 分钟关盘
			error2("盘口已关闭,交易失败");
		}

		check_point($ball_sort,$column,$match_id,$bet_point,$match_rgg,$match_dxgg,$tid); //验证水位是否变动

		if($bet_point>0.8)//如果赔率大于0.8则计算有效金额
		{
			$bet_yx=$bet_money;
		}else{
			$bet_yx=0;
		}

		$ksTime = $match_endtime; //赛事开赛时间

		if($ball_sort == "足球滚球"){ //足球滚球要记录红牌（赛事自动审核需要）
			$Match_HRedCard = $rows['Match_HRedCard'];
			$Match_GRedCard = $rows['Match_GRedCard'];
			$lose_ok=0; //走地需要确认
			if($match_time>88)//如果下注的时候，比赛已经大于88分钟，则停止下注 
			{
				error2("盘口已关闭,交易失败");
			}
		}else{ //不是滚球不需要确认
			$lose_ok=1; 
		}  

		if(!$match_type || $match_type=="") $match_type='1'; //为空统一为单式;(1：单式、2：滚球)

		$bet_info	=	write_bet_info($ball_sort,$column,$master_guest,$bet_point,$match_showtype,$match_rgg,$match_dxgg,$match_nowscore,$tid);

		$ip_addr = get_ip();
		$bet_reb=$group_db['sports_bet_reb'];
		include_once("class/bet_ds.php");

		if(bet_ds::dx_add($userid,$ball_sort,strtolower($column),$match_name,$master_guest,$match_id,$bet_info,$bet_money,$bet_point,$ben_add,$bet_win,$match_time,$match_endtime,$lose_ok,$match_showtype,$match_rgg,$match_dxgg,$match_nowscore,$match_type,$Match_HRedCard,$Match_GRedCard,$ksTime,$ip_addr,BROWSER_IP,$bet_reb,$et_time_now,$game_type,$bet_yx)){

		$mysqli->close();
			if($lose_ok==0){
				msgok($bet_info,"交易确认中",$balance);
			}else{
				msgok($bet_info,"交易成功",$balance);
			}	 
		}else{
			error2("交易失败");
		}


	}else{//串关
	
		//限额判断
		if(count($_POST["match_name"])<3)
		{
			error1("串关最少投注3场");
		}

		if(count($_POST["match_name"])>8)
		{
			error1("串关最多投注8场");
		}

		
		$db_t=getdatable($_POST["ball_sort"][0]);
			if($db_t=="t_guanjun"){
				include_once("class/guanjun.php");
			}else{
				include_once("class/".$db_t.".php");
			}
		$width		=	0; //宽
		$name1		=	''; //保存联赛名称
		$guest1		=	''; //保存队伍名称
		$info1		=	''; //保存交易信息
		$bet_win	=	0; //可赢金额默认为0
		$point		=	1; //水位默认为1
		$ksTime		=	strip_tags($_POST["match_endtime"][0]); //赛事开赛时间,默认取第一个的日期时间
		for($i=0;$i<count($_POST["match_id"]);$i++){

			

			//获取比赛详细信息
			$rows=bet_match::getmatch_info(intval($_POST["match_id"][$i]),strip_tags($_POST["point_column"][$i]),strip_tags($_POST["ball_sort"][$i]));
			$cg_ok_m=cg_ok($rows["match_master"]);
			$cg_ok_g=cg_ok($rows["match_guest"]);
			if($cg_ok_m!="ok" || $cg_ok_g!="ok" )
			{
				error1($cg_ok_m);
			}
			$master_guest	=	$rows["match_master"]."VS.".$rows["match_guest"];
			$match_time		=	$rows['Match_Time'];
			$match_endtime	=	$rows['Match_CoverDate'];
			$match_rgg		=	$rows['match_rgg'];
			$match_dxgg		=	$rows['match_dxgg'];
			$match_type		=	$rows['match_type'];
			$match_showtype =	$rows['match_showtype'];
			$match_nowscore =	$rows['match_nowscore'];
			$match_name		=	$rows['match_name'];

			check_point($_POST["ball_sort"][$i],$_POST["point_column"][$i],$_POST["match_id"][$i],$_POST["bet_point"][$i],$match_rgg,$match_dxgg,0,$i);

			$bet_point		=	strip_tags($_POST["bet_point"][$i]*1);
			$point_column	=	strip_tags($_POST["point_column"][$i]);
			if(in_array($point_column,$arr_add)){ //让球，大小，半场让球，半场大小，可赢金额要加上本金
				$bet_point+=1;
			}

			if(str_leng($name1) < str_leng($match_name)) $name1		=	$match_name;
			if(str_leng($guest1) < str_leng($master_guest)) $guest1	=	$master_guest;
			if(str_leng($info1) < str_leng($_POST["bet_info"][$i])) $info1			=	strip_tags($_POST["bet_info"][$i]);
			if(strtotime($match_endtime) > strtotime($ksTime)) $ksTime =	$match_endtime;
			$point *= $bet_point; //串关水位为相乘
		}

		
		$width		=	str_leng($_POST["match_name"][0].'===='.$name1.'='.$guest1.'='.$info1.$match_showtype.$bet_money.'='.$bj_time_now); //宽
		$height		=	20*$i; //高
		$im			=	imagecreate($width,$height);
		$bkg		=	imagecolorallocate($im,255,255,255); //背景色
		$font		=	imagecolorallocate($im,150,182,151); //边框色
		$sort_c		=	imagecolorallocate($im,0,0,0); //字体色 
		$name_c		=	imagecolorallocate($im,243,118,5); //字体色 
		$guest_c	=	imagecolorallocate($im,34,93,156); //字体色 
		$info_c		=	imagecolorallocate($im,51,102,0); //字体色
		$money_c	=	imagecolorallocate($im,255,0,0); //字体色 
		$fnt		=	"ttf/simhei.ttf";
			
		$bet_yx=$bet_money;//串关的有效金额直接等于下注金额
		$cg_count	=	count($_POST["match_name"]); //串关条数
		$bet_win	=	$point*$bet_money; //可赢金额=交易金额*水位
		$bet_reb=$group_db['sports_bet_reb'];
		$order_num=date("YmdHis") . rand(100,999);
		$sql	=	"insert into k_bet_cg_group(user_id,order_num,cg_count,bet_money,bet_win,balance,assets,ip,www,match_coverdate,bet_reb,bet_time,bet_time_et,bet_yx) values('$userid','$order_num','$cg_count','$bet_money','$bet_win',$balance,$assets,'$ip_addr','".BROWSER_IP."','$ksTime','$bet_reb',now(),'$et_time_now','$bet_yx')"; //添加投注

			$mysqli->query($sql);
			$q1		=	$mysqli->affected_rows;
			if($q1!=1){
				error2("交易失败830");
			}
			$gid 	=	$mysqli->insert_id;
			$sql	=	"insert into k_bet_cg(user_id,gid,ball_sort,point_column,match_name,master_guest,match_id,bet_info,bet_money,bet_point,ben_add,match_endtime,match_showtype,match_rgg,match_dxgg,match_nowscore,bet_time,bet_time_et) values";
			for($i=0;$i<$cg_count;$i++){

				//获取比赛详细信息
				$rows=bet_match::getmatch_info(intval($_POST["match_id"][$i]),strip_tags($_POST["point_column"][$i]),strip_tags($_POST["ball_sort"][$i]));

				$master_guest	=	$rows["match_master"]."VS.".$rows["match_guest"];
				$match_time		=	$rows['Match_Time'];
				$match_endtime	=	$rows['Match_CoverDate'];
				$match_rgg		=	$rows['match_rgg'];
				$match_dxgg		=	$rows['match_dxgg'];
				$match_type		=	$rows['match_type'];
				$match_showtype =	$rows['match_showtype'];
				$match_nowscore =	$rows['match_nowscore'];
				$match_name		=	$rows['match_name'];
				$match_id		=	intval($_POST["match_id"][$i]);
				$ball_sort		=	strip_tags($_POST["ball_sort"][$i]);
				$column			=	strip_tags($_POST["point_column"][$i]);
				$bet_info		=	strip_tags($_POST["bet_info"][$i]);
				$bet_point		=	strip_tags($_POST["bet_point"][$i]);

				$tid			=	intval($_POST["tid"][$i]);
				
				$ben_add=0;
				if(in_array($column,$arr_add)){ //让球，大小，半场让球，半场大小，可赢金额要加上本金
					$ben_add=1;
				}

				$bet_info		=	write_bet_info($ball_sort,$column,$master_guest,$bet_point,$match_showtype,$match_rgg,$match_dxgg,$match_nowscore,$tid);
				$sql		   .=	"('$userid','$gid','$ball_sort','".strtolower($column)."','$match_name','$master_guest','$match_id','$bet_info','$bet_money','$bet_point','$ben_add','$match_endtime','$match_showtype','$match_rgg','$match_dxgg','$match_nowscore',now(),'$et_time_now'),";
				
				imagettftext($im,10,0,7,18*($i+1),$sort_c,$fnt,$ball_sort); //赛事类型
				imagettftext($im,10,0,str_leng('======'),18*($i+1),$name_c,$fnt,$match_name); //联赛名称
				imagettftext($im,10,0,str_leng('====='.$match_name.$name1),18*($i+1),$guest_c,$fnt,$master_guest); //队伍名称
				imagettftext($im,10,0,str_leng('======'.$match_name.$name1.$guest1),18*($i+1),$info_c,$fnt,$bet_info); //交易明细
				imagettftext($im,10,0,str_leng('======'.$match_name.$name1.$guest1.$info1),18*($i+1),$info_c,$fnt,$match_showtype); //主、客让
				imagettftext($im,10,0,str_leng('====='.$match_name.$name1.$guest1.$info1.$match_showtype.'=='),18*($i+1),$money_c,$fnt,$bet_money); //交易金额
				imagettftext($im,10,0,str_leng('====='.$match_name.$name1.$guest1.$info1.$match_showtype.$bet_money.'==='),18*($i+1),$sort_c,$fnt,$bj_time_now); //交易时间
			}

			$sql				=	rtrim($sql,",");
			$mysqli->query($sql);
			$q2					=	$mysqli->affected_rows;
			if($q2!=$i){
				$sql	=	"delete from k_bet_cg_group where id=$gid";//操作失败，删除订单
				$mysqli->query($sql);
				
				error2("交易失败831");
			}

			$sql	=	"update user_list set money=$balance where money>=$bet_money and $balance>=0 and user_id='$userid'";//扣钱
			$mysqli->query($sql);
			$q3		=	$mysqli->affected_rows;
			if($q3!=1){
				$sql	=	"delete from k_bet_cg_group where id=$gid";//操作失败，删除订单
				$mysqli->query($sql);
				$sql	=	"delete from k_bet_cg where gid=$gid";//操作失败，删除订单
				$mysqli->query($sql);
				error2("交易失败832");
			}

			$sql = "INSERT INTO `money_log` (`user_id`,`order_num`,`about`,`update_time`,`type`,`order_value`,`assets`,`balance`) VALUES ('$userid','$order_num','体育串关',now(),'体育下注','$bet_money','$assets','$balance');";
			$mysqli->query($sql);
			$q8		=	$mysqli->affected_rows;
			if($q8!=1){
				$sql	=	"delete from k_bet_cg_group where id=$gid";//操作失败，删除订单
				$mysqli->query($sql);
				$sql	=	"delete from k_bet_cg where gid=$gid";//操作失败，删除订单
				$mysqli->query($sql);
				$sql	=	"update user_list set money=money+$bet_money where user_id='$userid'";//操作失败，还原客户资金
				$mysqli->query($sql);
				error2("交易失败833");
			}
			$log_id 	=	$mysqli->insert_id;
			
			imagerectangle($im,0,0,$width-1,$height-1,$font); //画边框
			$C_Patch=$_SERVER['DOCUMENT_ROOT'];
			if(!is_dir($C_Patch."\\order\\".substr($order_num,0,8))) mkdir($C_Patch."\\order\\".substr($order_num,0,8));
			$q4 = imagejpeg($im,$C_Patch."\\order\\".substr($order_num,0,8)."/$order_num.jpg"); //生成图片
			imagedestroy($im);

			if($q4!=1){
				$sql	=	"delete from k_bet_cg_group where id=$gid";//操作失败，删除订单
				$mysqli->query($sql);
				$sql	=	"delete from k_bet_cg where gid=$gid";//操作失败，删除订单
				$mysqli->query($sql);
				$sql	=	"update user_list set money=money+$bet_money where user_id='$userid'";//操作失败，还原客户资金
				$mysqli->query($sql);
				$sql	=	"delete from money_log where id=$log_id";//操作失败，删除订单
				$mysqli->query($sql);
				error2("交易失败834");
			}

			//验证一下账户金额
			$usermoney=0;
			$sql		= 	"select money from user_list where user_id='$userid' limit 1";
			$query 		=	$mysqli->query($sql);
			$rs			=	$query->fetch_array();

			$usermoney=$rs['money'];


			$sql		= 	"select balance from money_log where user_id='$userid' order by id desc limit 0,1";
			$query 		=	$mysqli->query($sql);
			$rs_l			=	$query->fetch_array();
			if($rs_l['balance']!=$usermoney){
				$sql = "update user_list set online=0,Oid='',status='异常',remark='体育串关($ordernum)下注后资金异常$bj_time_now' where user_id='$userid'";
				$mysqli->query($sql);
				error2("交易失败,账户金额异常!");
			}
			$mysqli->close();
			msgok($cg_count."串1","交易成功",$balance);
	}

	




}
else{
	error1("交易金额错误!");
}
$mysqli->close();
exit;

