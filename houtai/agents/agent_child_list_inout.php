<?php
session_start();
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");

echo "<script>if(self == top) parent.location='" . BROWSER_IP . "'</script>\n";

$C_Patch=$_SERVER['DOCUMENT_ROOT'];
include_once($C_Patch."/app/member/include/address.mem.php");
include_once($C_Patch."/app/member/include/config.inc.php");
include_once($C_Patch."/app/member/common/function.php");
include_once($C_Patch."/app/member/utils/convert_name.php");

include_once("../class/admin.php");
include_once("../common/login_check.php");
include_once("../lottery/getContentName.php");

check_quanxian("查看代理信息");

if($_GET["id"]){
    $id = $_GET["id"];
}
if($_GET["angent_name"]){
    $angent_name = $_GET["angent_name"];
}
$s_time = $_GET["s_time"];
if(!$s_time){
    $s_time = date('Y-m-d');
}
$e_time = $_GET["e_time"];
if(!$e_time){
    $e_time = date('Y-m-d');
}

$user_group = $_GET["user_group"];
$user_ignore_group = $_GET["user_ignore_group"];

$date_month = $_GET['date_month'];

?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Welcome</title>
    <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
</head>
<script type="text/javascript" charset="utf-8" src="../js/jquery-1.7.2.min.js" ></script>
<script language="javascript">
    function setDate(dateType){
        var dateNow= new Date();
        var dateStart;
        var dateEnd;
        if(dateType=="today"){
            dateStart = dateNow.Format("yyyy-MM-dd");
            dateEnd = dateNow.Format("yyyy-MM-dd");
        }else if(dateType=="yesterday"){
            dateNow.addDays(-1);
            dateStart = dateNow.Format("yyyy-MM-dd");
            dateEnd = dateNow.Format("yyyy-MM-dd");
        }else if(dateType=="lastSeven"){//最近7天
            dateEnd = dateNow.Format("yyyy-MM-dd");
            dateNow.addDays(-6);
            dateStart = dateNow.Format("yyyy-MM-dd");
        }else if(dateType=="lastThirty"){//最近30天
            dateEnd = dateNow.Format("yyyy-MM-dd");
            dateNow.addDays(-29);
            dateStart = dateNow.Format("yyyy-MM-dd");
        }else if(dateType=="thisWeek"){//本周
            dateEnd = dateNow.Format("yyyy-MM-dd");
            dateNow.addDays(-dateNow.getDay());
            dateStart = dateNow.Format("yyyy-MM-dd");
        }else if(dateType=="lastWeek"){//上周
            dateNow.addDays(-dateNow.getDay()-1);
            dateEnd = dateNow.Format("yyyy-MM-dd");
            dateNow.addDays(-6);
            dateStart = dateNow.Format("yyyy-MM-dd");
        }else if(dateType=="thisMonth"){//本月
            dateEnd = dateNow.Format("yyyy-MM-dd");
            dateNow.addDays(-dateNow.getDate()+1);
            dateStart = dateNow.Format("yyyy-MM-dd");
        }else if(dateType=="lastMonth"){//上月
            dateNow.addDays(-dateNow.getDate());
            dateEnd = dateNow.Format("yyyy-MM-dd");
            dateNow.addDays(-dateNow.getDate()+1);
            dateStart = dateNow.Format("yyyy-MM-dd");
        }
        $("#s_time").val(dateStart);
        $("#e_time").val(dateEnd);
        $("#form1").submit();
    }

    function check(){
        if(!$("#s_time").val() || !$("#e_time").val() ){
            alert("请输入开始/结束日期。")
        }
        return true;
    }

    function onChangeMonth(value){
        if(value==""){
            return;
        }
        var dateNow= new Date();
        var dateStart;
        var dateEnd;

        dateNow.addDays(-dateNow.getDate()+1);
        dateNow.addMonths(-dateNow.getMonth()+parseInt(value)-1);
        dateStart = dateNow.Format("yyyy-MM-dd");
        dateNow.addMonths(1);
        dateNow.addDays(-1);
        dateEnd = dateNow.Format("yyyy-MM-dd");

        $("#s_time").val(dateStart);
        $("#e_time").val(dateEnd);
        $("#form1").submit();
    }

    Date.prototype.Format = function (fmt) { //author: meizz
        var o = {
            "M+": this.getMonth() + 1, //月份
            "d+": this.getDate(), //日
            "h+": this.getHours(), //小时
            "m+": this.getMinutes(), //分
            "s+": this.getSeconds(), //秒
            "q+": Math.floor((this.getMonth() + 3) / 3), //季度
            "S": this.getMilliseconds() //毫秒
        };
        if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    };
    Date.prototype.addDays = function(d)
    {
        this.setDate(this.getDate() + d);
    };

    Date.prototype.addWeeks = function(w)
    {
        this.addDays(w * 7);
    };

    Date.prototype.addMonths= function(m)
    {
        var d = this.getDate();
        this.setMonth(this.getMonth() + m);

        if (this.getDate() < d)
            this.setDate(0);
    };

    Date.prototype.addYears = function(y)
    {
        var m = this.getMonth();
        this.setFullYear(this.getFullYear() + y);

        if (m < this.getMonth())
        {
            this.setDate(0);
        }
    };
    //测试 var now = new Date(); now.addDays(1);//加减日期操作 alert(now.Format("yyyy-MM-dd"));

    Date.prototype.dateDiff = function(interval,endTime)
    {
        switch (interval)
        {
            case "s":   //計算秒差
                return parseInt((endTime-this)/1000);
            case "n":   //計算分差
                return parseInt((endTime-this)/60000);
            case "h":   //計算時差
                return parseInt((endTime-this)/3600000);
            case "d":   //計算日差
                return parseInt((endTime-this)/86400000);
            case "w":   //計算週差
                return parseInt((endTime-this)/(86400000*7));
            case "m":   //計算月差
                return (endTime.getMonth()+1)+((endTime.getFullYear()-this.getFullYear())*12)-(this.getMonth()+1);
            case "y":   //計算年差
                return endTime.getFullYear()-this.getFullYear();
            default:    //輸入有誤
                return undefined;
        }
    }
    //测试 var starTime = new Date("2007/05/12 07:30:00");     var endTime = new Date("2008/06/12 08:32:02");     document.writeln("秒差: "+starTime .dateDiff("s",endTime )+"<br>");     document.writeln("分差: "+starTime .dateDiff("n",endTime )+"<br>");     document.writeln("時差: "+starTime .dateDiff("h",endTime )+"<br>");     document.writeln("日差: "+starTime .dateDiff("d",endTime )+"<br>");     document.writeln("週差: "+starTime .dateDiff("w",endTime )+"<br>");     document.writeln("月差: "+starTime .dateDiff("m",endTime )+"<br>");     document.writeln("年差: "+starTime .dateDiff("y",endTime )+"<br>");

</script>
<script language="JavaScript" src="/js/calendar.js"></script>
<body>
<div id="pageMain">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td valign="top">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
    <form name="form1" id="form1" method="get" action="<?=$_SERVER["REQUEST_URI"]?>" onSubmit="return check();">
        <tr>
            <td align="left" bgcolor="#FFFFFF">
                &nbsp;&nbsp;
                日期：<input name="s_time" type="text" id="s_time" value="<?=$s_time?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
                ~
                <input name="e_time" type="text" id="e_time" value="<?=$e_time?>" onClick="new Calendar(2008,2020).show(this);" size="10" maxlength="10" readonly="readonly" />
                &nbsp;&nbsp;
                <input type="button" value="今日" onclick="setDate('today')"/>
                <input type="button" value="昨日" onclick="setDate('yesterday')"/>
                <input type="button" value="本周" onclick="setDate('thisWeek')"/>
                <input type="button" value="上周" onclick="setDate('lastWeek')"/>
                <input type="button" value="本月" onclick="setDate('thisMonth')"/>
                <input type="button" value="上月" onclick="setDate('lastMonth')"/>
                <input type="button" value="最近7天" onclick="setDate('lastSeven')"/>
                <input type="button" value="最近30天" onclick="setDate('lastThirty')"/>
                <select name="date_month" id="date_month" onchange="onChangeMonth(this.value)">
                    <option value="" <?=$date_month=='' ? 'selected' : ''?>>选择月份</option>
                    <option value="1"  <?=$date_month==1 ? 'selected' : ''?>>1月</option>
                    <option value="2"  <?=$date_month==2 ? 'selected' : ''?>>2月</option>
                    <option value="3"  <?=$date_month==3 ? 'selected' : ''?>>3月</option>
                    <option value="4"  <?=$date_month==4 ? 'selected' : ''?>>4月</option>
                    <option value="5"  <?=$date_month==5 ? 'selected' : ''?>>5月</option>
                    <option value="6"  <?=$date_month==6 ? 'selected' : ''?>>6月</option>
                    <option value="7"  <?=$date_month==7 ? 'selected' : ''?>>7月</option>
                    <option value="8"  <?=$date_month==8 ? 'selected' : ''?>>8月</option>
                    <option value="9"  <?=$date_month==9 ? 'selected' : ''?>>9月</option>
                    <option value="10" <?=$date_month==10 ? 'selected' : ''?>>10月</option>
                    <option value="11" <?=$date_month==11 ? 'selected' : ''?>>11月</option>
                    <option value="12" <?=$date_month==12 ? 'selected' : ''?>>12月</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="left" bgcolor="#FFFFFF">
                &nbsp;&nbsp;
                会员名：<input name="user_group" value="<?=$user_group?>" style="width: 200px;" type="text"> (多个用户用 , 隔开)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                忽略会员名：<input name="user_ignore_group" value="<?=$user_ignore_group?>" type="text" style="width: 200px;"> (多个用户用 , 隔开)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="gtype" type="hidden" id="gtype" value="<?=$gtype?>" />
                <input type="submit" name="Submit" value="搜索">
                <br/><br/>
                <span style="color: red;font-size: 14px;margin-left: 10px;">活动金额：在加款扣款界面，如果理由包含'用于活动'这四个字，那此次金额就属于活动金额，不算在盈利范围内。</span>

                <input name="id" type="hidden" value="<?=$id?>">
                <input name="angent_name" type="hidden" value="<?=$angent_name?>">
            </td>
        </tr>
    </form>
</table>
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;" bgcolor="#798EB9">
    <tr style="background-color:#3C4D82; color:#FFF">
        <td style="width: 13%" align="center"><strong>代理用户名</strong></td>
        <td style="width: 13%" align="center" height="25"><strong>下属会员名</strong></td>
        <td style="width: 13%" align="center"><strong>汇款金额</strong></td>
        <td style="width: 13%" align="center"><strong>存款金额(排除活动金额)</strong></td>
        <td style="width: 12%" align="center"><strong>取款金额(排除活动金额)</strong></td>
        <td style="width: 12%" align="center"><strong>合计盈利(排除活动金额)</strong></td>
        <td style="width: 12%" align="center"><strong>后台加钱(用于活动)</strong></td>
        <td style="width: 12%" align="center"><strong>后台扣钱(用于活动)</strong></td>
    </tr>
    <?php
    include("../../include/pager.class.php");

    $inUserString = "";

    if($user_group || $user_ignore_group){
        $userArray = array();
        $userIgnoreArray = array();
        $userArrayString = "";
        $userIgnoreArrayString = "";
        $sql_sub = "";

        if(strpos($user_group,",")!==false){
            $userArray = explode(",",trim($user_group));
        }elseif(strpos($user_group,"，")!==false){
            $userArray = explode("，",trim($user_group));
        }elseif($user_group){
            $userArrayString = "'".$user_group."'";
        }
        if(strpos($user_ignore_group,",")!==false){
            $userIgnoreArray = explode(",",trim($user_ignore_group));
        }elseif(strpos($user_ignore_group,"，")!==false){
            $userIgnoreArray = explode("，",trim($user_ignore_group));
        }elseif($user_ignore_group){
            $userIgnoreArrayString = "'".$user_ignore_group."'";
        }
        if($userArray){
            foreach($userArray as $key => $value){
                $userArrayString .= "'".trim($value)."'".",";
            }
            $userArrayString = substr($userArrayString, 0, -1);
        }
        if($userIgnoreArray){
            foreach($userIgnoreArray as $key => $value){
                $userIgnoreArrayString .= "'".trim($value)."'".",";
            }
            $userIgnoreArrayString = substr($userIgnoreArrayString, 0, -1);
        }

        $sql		=	"SELECT user_id FROM user_list";
        if($userArrayString && $userIgnoreArrayString){
            $sql_sub = " WHERE user_name IN($userArrayString) AND user_name NOT IN($userIgnoreArrayString)";
        }elseif($userArrayString && !$userIgnoreArrayString){
            $sql_sub = " WHERE user_name IN($userArrayString)";
        }elseif(!$userArrayString && $userIgnoreArrayString){
            $sql_sub = " WHERE user_name NOT IN($userIgnoreArrayString)";
        }

        $sql .= $sql_sub;
        $query	=	$mysqli->query($sql)or die ("error!");
        $rs = array();
        while($row = $query->fetch_array()){
            $rs[] = $row;
        }
        if(count($rs)>0){
            foreach($rs as $key => $value){
                $inUserString .= "'".$value["user_id"]."'".",";
            }
            $inUserString = "(".substr($inUserString, 0, -1).")";
        }elseif(count($rs)==0){
            $inUserString = "('')";
        }
    }

    $sql	=	"SELECT u.id FROM agents_list a,user_list u
                WHERE a.id=$id AND a.id=u.top_id AND u.top_id!=0 ";

    if($inUserString != "") $sql .= " AND u.user_id IN $inUserString ";

    $sql .= " GROUP by u.id ";

    $query	=	$mysqli->query($sql);
    $sum		=	$mysqli->affected_rows; //总页数
    $thisPage	=	1;
    $pagenum	=	$sum;
    if($_GET['page']){
        $thisPage	=	$_GET['page'];
    }
    $CurrentPage=isset($_GET['page'])?$_GET['page']:1;
    $myPage=new pager($sum,intval($CurrentPage),$pagenum);
    $pageStr= $myPage->GetPagerContent();

    $bid		=	'';
    $i		=	1; //记录 bid 数
    $start	=	($thisPage-1)*$pagenum+1;
    $end		=	$thisPage*$pagenum;
    while($row = $query->fetch_array()){
        if($i >= $start && $i <= $end){
            $bid .=	$row['id'].',';
        }
        if($i > $end) break;
        $i++;
    }
    if($bid){
        $bid	=	rtrim($bid,',');
        $sql_main = "select id,user_id,user_name from user_list where id in($bid) ORDER BY money DESC ";
        $query_main	=	$mysqli->query($sql_main);
        $list_main = array();
        while ($rows = $query_main->fetch_array()) {
            $list_main[] = $rows;
        }

        $sql_ck	=	"SELECT SUM(m.order_value) ck_money_total, u.top_id, u.id
                    FROM user_list u,money m
                    WHERE u.top_id=$id AND u.top_id!=0 AND u.user_id=m.user_id AND (m.type='在线支付' or m.type='后台充值') AND m.about not like '%用于活动%' AND m.status='成功'
                    ";
        if($s_time) $sql_ck.=" and m.update_time>='".$s_time." 00:00:00' ";
        if($e_time) $sql_ck.=" and m.update_time<='".$e_time." 23:59:59' ";
        $sql_ck .= " GROUP BY u.id ORDER BY u.money DESC ";
        $query_ck	=	$mysqli->query($sql_ck);
        $list_ck = array();
        while ($rows_ck = $query_ck->fetch_array()) {
            $list_ck[] = $rows_ck;
        }

        $sql_hk	=	"SELECT SUM(m.order_value) hk_money_total, u.top_id, u.id
                    FROM user_list u,money m
                    WHERE u.top_id=$id AND u.top_id!=0 AND u.user_id=m.user_id AND m.type='银行汇款' AND m.about not like '%用于活动%' AND m.status='成功'
                    ";
        if($s_time) $sql_hk.=" and m.update_time>='".$s_time." 00:00:00' ";
        if($e_time) $sql_hk.=" and m.update_time<='".$e_time." 23:59:59' ";
        $sql_hk .= " GROUP BY u.id ORDER BY u.money DESC ";
        $query_hk	=	$mysqli->query($sql_hk);
        $list_hk = array();
        while ($rows_hk = $query_hk->fetch_array()) {
            $list_hk[] = $rows_hk;
        }

        $sql_qk	=	"SELECT SUM(m.order_value) qk_money_total, u.top_id, u.id
                    FROM user_list u,money m
                    WHERE u.top_id=$id AND u.top_id!=0 AND u.user_id=m.user_id AND (m.order_value<0) AND m.about not like '%用于活动%' AND m.status='成功'
                    ";
        if($s_time) $sql_qk.=" and m.update_time>='".$s_time." 00:00:00' ";
        if($e_time) $sql_qk.=" and m.update_time<='".$e_time." 23:59:59' ";
        $sql_qk .= " GROUP BY u.id ORDER BY u.money DESC ";
        $query_qk	=	$mysqli->query($sql_qk);
        $list_qk = array();
        while ($rows_qk = $query_qk->fetch_array()) {
            $list_qk[] = $rows_qk;
        }

        $sql_ck_hd	=	"SELECT SUM(m.order_value) ck_money_total_hd, u.top_id, u.id
                    FROM user_list u,money m
                    WHERE u.top_id=$id AND u.top_id!=0 AND u.user_id=m.user_id AND (m.type='在线支付' or m.type='后台充值') AND m.about like '%用于活动%' AND m.status='成功'
                    ";
        if($s_time) $sql_ck_hd.=" and m.update_time>='".$s_time." 00:00:00' ";
        if($e_time) $sql_ck_hd.=" and m.update_time<='".$e_time." 23:59:59' ";
        $sql_ck_hd .= " GROUP BY u.id ORDER BY u.money DESC ";
        $query_ck_hd	=	$mysqli->query($sql_ck_hd);
        $list_ck_hd = array();
        while ($rows_ck_hd = $query_ck_hd->fetch_array()) {
            $list_ck_hd[] = $rows_ck_hd;
        }

        $sql_qk_hd	=	"SELECT SUM(m.order_value) qk_money_total_hd, u.top_id, u.id
                    FROM user_list u,money m
                    WHERE u.top_id=$id AND u.top_id!=0 AND u.user_id=m.user_id AND (m.order_value<0) AND m.about like '%用于活动%' AND m.status='成功'
                    ";
        if($s_time) $sql_qk_hd.=" and m.update_time>='".$s_time." 00:00:00' ";
        if($e_time) $sql_qk_hd.=" and m.update_time<='".$e_time." 23:59:59' ";
        $sql_qk_hd .= " GROUP BY u.id ORDER BY u.money DESC ";
        $query_qk_hd	=	$mysqli->query($sql_qk_hd);
        $list_qk_hd = array();
        while ($rows_qk_hd = $query_qk_hd->fetch_array()) {
            $list_qk_hd[] = $rows_qk_hd;
        }

        foreach($list_main as $key => $value){
            $total_bet_money = 0;
            $total_win_money = 0;
            $color = "#FFFFFF";
            $over	 = "#EBEBEB";
            $out	 = "#ffffff";

            $ck_money = 0;
            foreach($list_ck as $key1 => $value_ck){
                if($value["id"] == $value_ck["id"]){
                    $ck_money = $value_ck["ck_money_total"];
                    $total_win_money += $ck_money;
                    break;
                }
            }

            $hk_money = 0;
            foreach($list_hk as $key2 => $value_hk){
                if($value["id"] == $value_hk["id"]){
                    $hk_money = $value_hk["hk_money_total"];
                    $total_win_money += $hk_money;
                    break;
                }
            }

            $qk_money = 0;
            foreach($list_qk as $key3 => $value_qk){
                if($value["id"] == $value_qk["id"]){
                    $qk_money = $value_qk["qk_money_total"];
                    $total_win_money += $qk_money;
                    break;
                }
            }

            $ck_money_hd = 0;
            foreach($list_ck_hd as $key4 => $value_ck_hd){
                if($value["id"] == $value_ck_hd["id"]){
                    $ck_money_hd = $value_ck_hd["ck_money_total_hd"];
                    break;
                }
            }

            $qk_money_hd = 0;
            foreach($list_qk_hd as $key5 => $value_qk_hd){
                if($value["id"] == $value_qk_hd["id"]){
                    $qk_money_hd = $value_qk_hd["qk_money_total_hd"];
                    break;
                }
            }

            ?>
            <tr align="center" onMouseOver="this.style.backgroundColor='<?=$over?>'" onMouseOut="this.style.backgroundColor='<?=$out?>'" style="background-color:<?=$color?>; line-height:20px;">
                <td height="40" align="center" valign="middle"><?=$angent_name?></td>
                <td height="40" align="center" valign="middle"><?=$value['user_name']?></td>
                <td align="center" valign="middle"><?=$hk_money?></td>
                <td align="center" valign="middle"><?=$ck_money?></td>
                <td align="center" valign="middle"><?=-$qk_money?></td>
                <td align="center" valign="middle"><?=$total_win_money?></td>
                <td align="center" valign="middle"><?=$ck_money_hd?></td>
                <td align="center" valign="middle"><?=-$qk_money_hd?></td>
            </tr>
        <?php
        }
    }
    ?>
    <tr style="background-color:#FFFFFF;">
        <td colspan="8" align="center" valign="middle"><?php echo $pageStr;?></td>
    </tr>

</table></td>
</tr>
</table>
</div>
</body>
</html>