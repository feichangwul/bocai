<?php

$odds = odds_lottery_normal::getOdds($lottery_name,"(中三)和数");

echo '
document.getElementById("Game").innerHTML = \'<form id="formB5" name="D3_018" action="/member/quickB5_act.php" method="post" onsubmit="return false">\'+
\'<input type="hidden" name="gid" value="343390"/>\'+
\'<input type="hidden" name="MyRtype" value="602"/>\'+
\'<input type="hidden" name="gtype" value="'.$gType.'"/>\'+
\'<input type="hidden" name="gold_gmax" value="'.$maxMoney.'"/>\'+
\'<input type="hidden" name="gold_gmin" value="'.$lowestMoney.'"/>\'+
\'<input type="hidden" name="SC" value="50000"/>\'+
\'<input type="hidden" name="SO" value="5000"/>\'+
\'<input type="hidden" name="Maxcredit" value="'.$userMoney.'"/>\'+
\'<input type="hidden" id="D3type" name="D3type" value="A"/>\'+
\'<div class="InfoBar">\'+
    \'<div class="Range" style="display:none">\'+
        \'<span class="On"><input type="radio" name="jjomj" value="0" checked="checked"/> 000~199</span>\'+
        \'<span><input type="radio" name="jjomj" value="2"/>200~399</span>\'+
        \'<span><input type="radio" name="jjomj" value="4"/>400~599</span>\'+
        \'<span><input type="radio" name="jjomj" value="6"/>600~799</span>\'+
        \'<span><input type="radio" name="jjomj" value="8"/>800~999</span>\'+
        \'</div>\'+
    \'<input type="hidden" name="Start" value="0"/>\'+
    \'</div>\'+
\'<div class="round-table">\'+
\'<table class="GameTable">\'+
\'<tr class="title_line">\'+
    \'<td>号码</td>\'+
    \'<td>赔率</td>\'+
    \'<td>金额</td>\'+
    \'<td>号码</td>\'+
    \'<td>赔率</td>\'+
    \'<td>金额</td>\'+
    \'<td>号码</td>\'+
    \'<td>赔率</td>\'+
    \'<td>金额</td>\'+
    \'<td>号码</td>\'+
    \'<td>赔率</td>\'+
    \'<td>金额</td>\'+
    \'<td>号码</td>\'+
    \'<td>赔率</td>\'+
    \'<td>金额</td>\'+
    \'</tr>\'+
\'<tr>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-0">\'+
            \'0\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-0"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-0" class="odds">\'+
            \''.$odds["h0"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h0"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-0"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-1">\'+
            \'1\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-1"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-1" class="odds">\'+
            \''.$odds["h1"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h1"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-1"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-2">\'+
            \'2\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-2"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-2" class="odds">\'+
            \''.$odds["h2"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h2"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-2"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-3">\'+
            \'3\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-3"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-3" class="odds">\'+
            \''.$odds["h3"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h3"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-3"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-4">\'+
            \'4\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-4"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-4" class="odds">\'+
            \''.$odds["h4"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h4"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-4"/>\'+
        \'</td>\'+
    \'\'+
    \'</tr>\'+
\'<tr>\'+\'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-5">\'+
            \'5\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-5"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-5" class="odds">\'+
            \''.$odds["h5"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h5"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-5"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-6">\'+
            \'6\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-6"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-6" class="odds">\'+
            \''.$odds["h6"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h6"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-6"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-7">\'+
            \'7\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-7"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-7" class="odds">\'+
            \''.$odds["h7"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h7"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-7"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-8">\'+
            \'8\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-8"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-8" class="odds">\'+
            \''.$odds["h8"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h8"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-8"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-9">\'+
            \'9\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-9"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-9" class="odds">\'+
            \''.$odds["h9"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h9"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-9"/>\'+
        \'</td>\'+
    \'\'+
    \'</tr>\'+
\'<tr>\'+\'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-10">\'+
            \'10\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-10"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-10" class="odds">\'+
            \''.$odds["h10"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h10"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-10"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-11">\'+
            \'11\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-11"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-11" class="odds">\'+
            \''.$odds["h11"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h11"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-11"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-12">\'+
            \'12\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-12"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-12" class="odds">\'+
            \''.$odds["h12"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h12"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-12"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-13">\'+
            \'13\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-13"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-13" class="odds">\'+
            \''.$odds["h13"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h13"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-13"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-14">\'+
            \'14\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-14"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-14" class="odds">\'+
            \''.$odds["h14"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h14"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-14"/>\'+
        \'</td>\'+
    \'\'+
    \'</tr>\'+
\'<tr>\'+\'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-15">\'+
            \'15\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-15"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-15" class="odds">\'+
            \''.$odds["h15"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h15"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-15"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-16">\'+
            \'16\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-16"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-16" class="odds">\'+
            \''.$odds["h16"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h16"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-16"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-17">\'+
            \'17\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-17"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-17" class="odds">\'+
            \''.$odds["h17"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h17"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-17"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-18">\'+
            \'18\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-18"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-18" class="odds">\'+
            \''.$odds["h18"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h18"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-18"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-19">\'+
            \'19\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-19"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-19" class="odds">\'+
            \''.$odds["h19"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h19"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-19"/>\'+
        \'</td>\'+
    \'\'+
    \'</tr>\'+
\'<tr>\'+\'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-20">\'+
            \'20\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-20"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-20" class="odds">\'+
            \''.$odds["h20"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h20"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-20"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-21">\'+
            \'21\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-21"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-21" class="odds">\'+
            \''.$odds["h21"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h21"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-21"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-22">\'+
            \'22\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-22"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-22" class="odds">\'+
            \''.$odds["h22"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h22"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-22"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-23">\'+
            \'23\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-23"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-23" class="odds">\'+
            \''.$odds["h23"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h23"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-23"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-24">\'+
            \'24\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-24"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-24" class="odds">\'+
            \''.$odds["h24"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h24"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-24"/>\'+
        \'</td>\'+
    \'\'+
    \'</tr>\'+
\'<tr>\'+\'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-25">\'+
            \'25\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-25"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-25" class="odds">\'+
            \''.$odds["h25"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h25"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-25"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-26">\'+
            \'26\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-26"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-26" class="odds">\'+
            \''.$odds["h26"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h26"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-26"/>\'+
        \'</td>\'+
    \'\'+
    \'<td class="num" style="width:30px">\'+
        \'<label for="602-27">\'+
            \'27\'+
            \'</label>\'+
        \'<input type="hidden" name="aConcede[]" value="602-27"/>\'+
        \'</td>\'+
    \'<td class="odds">\'+
        \'<label for="602-27" class="odds">\'+
            \''.$odds["h27"].'\'+
            \'</label>\'+
        \'<input type="hidden" name="aOdds[]" value="'.$odds["h27"].'"/>\'+
        \'</td>\'+
    \'<td class="odds" style="width:60px">\'+
        \'<input type="text" pattern="[0-9]*" min="0" max="99999999" class="G" name="gold[]" id="602-27"/>\'+
        \'</td>\'+

    \'</tr>\'+
\'</table>\'+
\'</div>\'+
\'<div id="SendB5">\'+
    \'<span class="credit">下注金额:<b id="total_bet">0.00</b></span>\'+
    \'<input type="button" name="Cancel" value="取消" class="cancel_cen"/>&nbsp;&nbsp;\'+
    \'<input type="button" name="SubmitA" value="确定" class="order"/>\'+
    \'</div>\'+
\'</form>\';
document.getElementById("c_rtype").innerHTML = "(中三)和数";
document.getElementById("sRtype").value = "602";
if (document.getElementById("memberTop")) {
var h1 = document.getElementById("memberTop").getElementsByTagName("h1")[0];
h1.innerHTML = "(中三)和数";
}

$("#YearNum").text("'.$qishu.'");
(self.GameB5.install) && self.GameB5.install();
';