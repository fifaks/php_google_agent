<?php
error_reporting(0);
ini_set('zlib.output_compression', 'On');
ob_start();
header("Content-Encoding: gzip");
header("Vary: Accept-Encoding");
header("Expires: " . gmdate("r", time() + 28800 + 86400));
header("Cache-Control: max-age=86400,must-revalidate");

$q = isset($_GET['q']) ? urlencode($_GET['q']) : '';
$qv = urldecode($q);
$start = isset($_GET['start']) ? $_GET['start'] : 0;
$search = $resultStats = '';
if($q) {
    include('simple_html_dom.php');
    $url = 'http://www.google.com/search?hl=zh-CN&q=';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt ($ch, CURLOPT_URL, $url . $q . '&start=' . $start);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en; rv:1.9.2) Gecko/20100115 Firefox/3.6 GTBDFff GTB7.0');
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $str = curl_exec($ch);
    curl_close($ch);
    var_dump($str);
    $html = str_get_html($str);
    foreach($html->find('img') as $e) {
        $e->outertext = '';
    }
    $e = $html->find('table.nrgt', 0);
    $e->outertext = '';
    $search = $html->find('div#search', 0)->innertext;
    $search = str_replace('<a ', '<a target="_blank" ', $search);
    $search = str_replace('href="/url?q=', 'href="', $search);
    $search = str_replace('href="/search?q=', 'href="http://www.g.cn/search?q=', $search);
    $search = preg_replace('/&amp;sa=U&amp;[^"]+/', '', $search);
    $search = preg_replace('/href="([^"]+)"/e', "durldecode('\\1')", $search);
    $resultStats = $html->find('div#resultStats', 0)->innertext;
}
function durldecode($str) {
    return 'href="' . urldecode($str) . '"';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Google搜索</title>
<style type="text/css">body{color:#000;margin:3px 0}body,#leftnav,#tbdi,#hidden_modes,#hmp{background:#fff}#gog{background:#fff}#gbar,#guser{font-size:13px;padding-top:1px !important}#gbar{float:left;height:22px}#guser{padding-bottom:7px !important;text-align:right}.gbh,.gbd{border-top:1px solid #c9d7f1;font-size:1px}.gbh{height:0;position:absolute;top:24px;width:100%}#gbs,.gbm{background:#fff;left:0;position:absolute;text-align:left;visibility:hidden;z-index:1000}.gbm{border:1px solid;border-color:#c9d7f1 #36c #36c #a2bae7;z-index:1001}.gb1{margin-right:.5em}.gb1,.gb3{zoom:1}.gb2{display:block;padding:.2em .5em}.gb2,.gb3{text-decoration:none !important;border-bottom:none}a.gb1,a.gb4{text-decoration:underline !important}a.gb1,a.gb2,a.gb3,a.gb4{color:#00c !important}a.gb2:hover{background:#36c;color:#fff !important}#gbar .gbz0l{color:#000 !important;cursor:default;font-weight:bold;text-decoration:none !important}a.gb1,a.gb2,a.gb3,.link{color:#12c!important}.ts{border-collapse:collapse}.ts td{padding:0}.ti,.bl,#res h3{display:inline}.ti{display:inline-table}#tads a.mblink,#tads a.mblink b,#tadsb a.mblink,#tadsb a.mblink b,#tadsto a.mblink,#tadsto a.mblink b,#rhs a.mblink,#rhs a.mblink b{color:#1122cc!important}#tads .ch,#tadsb .ch,#tadsto .ch,#rhs .ch{margin-top:5px;}a:link,.w,#prs a:visited,#prs a:active,.q:active,.q:visited,.kl:active{color:#12c}.mblink:visited,a:visited{color:#61c}.vst:link{color:#61c}.cur,.b{font-weight:bold}.j{width:42em;font-size:82%}.s{max-width:42em}.sl{font-size:82%}.hd{position:absolute;width:1px;height:1px;top:-1000em;overflow:hidden}.f,.f a:link,.m,.c h2,#mbEnd h2,#tads h2,#tadsb h2,#tadsto h2,.descbox{color:#666}.a,cite,cite a:link,cite a:visited,.cite,.cite:link,#mbEnd cite b,#tads cite b,#tadsb cite b,#tadsto cite b,#ans>i,.bc a:link{color:#093;font-style:normal}.ng{color:#d14836}h1,ol,ul,li{margin:0;padding:0}li.g,body,html,.std,.c h2,#mbEnd h2,h1{font-size:small;font-family:arial,sans-serif}.c h2,#mbEnd h2,h1{font-weight:normal}.clr{clear:both;margin:0 8px}.blk a{color:#000}#nav a{display:block}#nav .i{color:#a90a08;font-weight:bold}.csb,.ss,.play_icon,.mini_play_icon,.micon,.licon,.close_btn,#tbp,.mbi,.inline_close_btn{background:url(/images/nav_logo86.png) no-repeat;overflow:hidden}.csb,.ss{background-position:0 0;height:40px;display:block}.ss{background-position:0 -91px;position:absolute;left:0;top:0}.cps{height:18px;overflow:hidden;width:114px}.spell{font-size:16px}.spell_orig{font-size:13px;text-decoration:none}a.spell_orig:hover{text-decoration:underline}.mbi{background-position:-153px -70px;display:inline-block;float:left;height:13px;margin-right:3px;margin-top:1px;width:13px}#nav td{padding:0;text-align:center}#logo span,.lsb{background:url(/images/nav_logo86.png) no-repeat;overflow:hidden}#logo{display:block;height:41px;margin:0;overflow:hidden;position:relative;width:114px}#logo img{background:#f5f5f5;border:0;left:-0px;position:absolute;top:-41px}#logo span{cursor:pointer}#logocont{z-index:1;padding-left:16px;padding-right:12px;}.big #logocont{padding-left:44px;padding-right:12px}@media only screen and (min-width:1222px){#logocont{padding-left:44px;padding-right:12px}} table.gssb_d{border:0}#gac_scont .gac_od{z-index:101}#gac_scont .gac_id,table.gssb_c{margin-left:1px}table.gssb_e{border:1px solid #ccc;border-top-color:#d9d9d9;box-shadow:0 2px 4px rgba(0,0,0,0.2);-mox-box-shadow:0 2px 4px rgba(0,0,0,0.2);-webkit-box-shadow:0 2px 4px rgba(0,0,0,0.2);margin:-1px}#gac_scont .gac_b,#gac_scont .gac_b td.gac_c,#gac_scont .gac_b td.gac_d,tr.gssb_i{background:#eee}.sfccl{font-size:11px;margin-right:0;position:relative;z-index:100}.sfccl .gl{display:block;margin-right:260px}.sfccl a.gl,.sfccl a.gl:visited{color:#36c}#sftab:hover .lst-tbb{border-color:#a0a0a0 #b9b9b9 #b9b9b9 #b9b9b9!important;}.lst-d-f .lst-tbb,.lst-d-f.lst-tbb,#sftab.lst-d-f:hover .lst-tbb{border-color:#4d90fe!important;}#bsb{display:block;margin-top:78px}.lst-b,.lst{border:1px solid #d9d9d9;height:25px}.sfqb .lst{border-left:none}.lst-b{background:white;border-top:1px solid #c0c0c0;height:27px;}.lst-b img{margin-top:2px;}.lst{-moz-box-sizing:content-box;background:#fff;border-top:1px solid #c0c0c0;color:#000;float:left;padding:1px 7px;line-height:25px!important;vertical-align:top;width:100%}.lst-td{padding-right:16px}.lst:focus{outline:none}.gsfi,.lst{font:17px arial,sans-serif}.gsfs{font:17px arial,sans-serif}button[name="btnG"],.tsf-p .lsb:active{background:transparent;color:transparent;font-size:0;overflow:hidden;position:relative;width:100%}.sbico{background:url(/images/nav_logo86.png) no-repeat -137px -243px;color:transparent;display:inline-block;height:15px;margin:0 auto;margin-top:-1px;width:15px}#sbds {border:0;margin-left:16px;}#sblsbb{height:27px;}.ds{border-right:1px solid #e7e7e7;position:relative;height:29px;z-index:100}.lsbb{background:#eee;border:1px solid #999;border-top-color:#ccc;border-left-color:#ccc;height:30px}.lsb{font:15px arial,sans-serif;background-position:bottom;border:0;color:#000;cursor:pointer;height:30px;margin:0;vertical-align:top}.lsb:active{background:#ccc}.tsf-p .kpbb{height:29px;margin:0;padding:0;width:70px}.kpbb,.kprb,.kpgb{-webkit-border-radius:2px;border-radius:2px;color:#fff}.kpbb:hover,.kprb:hover,.kpgb:hover{-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);color:#fff}.kpbb:active,.kprb:active,.kpgb:active{-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);box-shadow:inset 0 1px 2px rgba(0,0,0,0.3)}.kpbb{background-image:-webkit-gradient(linear,left top,left bottom,from(#4d90fe),to(#4787ed));background-image:-webkit-linear-gradient(top,#4d90fe,#4787ed);background-color:#4d90fe;background-image:linear-gradient(top,#4d90fe,#4787ed);border:1px solid #3079ed}.kpbb:hover{background-image:-webkit-gradient(linear,left top,left bottom,from(#4d90fe),to(#357ae8));background-image:-webkit-linear-gradient(top,#4d90fe,#357ae8);background-color:#357ae8;background-image:linear-gradient(top,#4d90fe,#357ae8);border:1px solid #2f5bb7}.kprb{background-image:-webkit-gradient(linear,left top,left bottom,from(#dd4b39),to(#d14836));background-image:-webkit-linear-gradient(top,#dd4b39,#d14836);background-color:#d14836;background-image:linear-gradient(top,#dd4b39,#d14836);border:1px solid #d14836}.kprb:hover{background-image:-webkit-gradient(linear,left top,left bottom,from(#dd4b39),to(#c53727));background-image:-webkit-linear-gradient(top,#dd4b39,#c53727);background-color:#c53727;background-image:linear-gradient(top,#dd4b39,#c53727);border:1px solid #b0281a;border-color-bottom:#af301f}.kprb:active{background-image:-webkit-gradient(linear,left top,left bottom,from(#dd4b39),to(#b0281a));background-image:-webkit-linear-gradient(top,#dd4b39,#b0281a);background-color:#b0281a;background-image:linear-gradient(top,#dd4b39,#b0281a);}.kpgb{background-image:-webkit-gradient(linear,left top,left bottom,from(#3d9400),to(#398a00));background-image:-webkit-linear-gradient(top,#3d9400,#398a00);background-color:#3d9400;background-image:linear-gradient(top,#3d9400,#398a00);border:1px solid #29691d;}.kpgb:hover{background-image:-webkit-gradient(linear,left top,left bottom,from(#3d9400),to(#368200));background-image:-webkit-linear-gradient(top,#3d9400,#368200);background-color:#368200;background-image:linear-gradient(top,#3d9400,#368200);border:1px solid #2d6200}form{display:inline}input{-moz-box-sizing:content-box;-moz-padding-start:0;-moz-padding-end:0}.tia input{border-right:none;padding-right:0}.lsd{font-size:11px;position:absolute;top:3px;left:16px}#searchform{position:absolute;top:px;width:100%;z-index:99}.sfbg{background:white;height:71px;left:0;position:absolute;width:100%}.sfbgg{background:#f5f5f5;border-bottom:1px solid #e5e5e5;height:71px}.tsf-p{top:-2px!important;}.ch{cursor:pointer}h3,.med{font-size:medium;font-weight:normal;padding:0;margin:0}.e{margin:2px 0 .75em}.slk div{padding-left:12px;text-indent:-10px}.fc{margin-top:.5em;padding-left:16px}#mbEnd cite{text-align:left}#rhs_block{margin-bottom:-20px}#bsf,.blk{border-top:1px solid #6b90da;background:#f0f7f9}#bsf{border-bottom:1px solid #6b90da}#cnt{clear:both}#res{padding-right:1em;margin:0 16px}.c{background:#fff8e7;margin:0 8px}.c li{padding:0 3px 0 8px;margin:0}#mbEnd li{margin:1em 0;padding:0}.xsm{font-size:x-small}ol li{list-style:none}#ncm ul li{list-style-type:disc}.sm li{margin:0}.gl,#foot a,.nobr{white-space:nowrap}#mbEnd .med{white-space:normal}.sl,.r{display:inline;font-weight:normal;margin:0}.r{font-size:medium}h4.r{font-size:small}.mr{margin-top:6px}h3.tbpr{margin-top:.4em;margin-bottom:1.2em}img.tbpr{border:0px;width:15px;height:15px;margin-right:3px}.jsb{display:block}.nojsb{display:none}.nwd{font-size:10px;padding:16px;text-align:center}.ri_cb{left:0;margin:6px;position:absolute;top:0;z-index:1}.ri_sp{display:-moz-inline-box;display:inline-block;text-align:center;vertical-align:top;margin-bottom:6px}.ri_of{opacity:0.40;}.ri_sp img{vertical-align:bottom}#vsrs,#vsrsr,#vspci,.vspib{background:url(/images/nav_logo86.png) no-repeat}#vspb{box-shadow:0 4px 16px rgba(0,0,0,0.2);-webkit-box-shadow:0 4px 16px rgba(0,0,0,0.2);outline:1px solid #ccc;background-color:#fff;display:none;padding:15px;position:absolute;top:0;visibility:hidden;z-index:110}#vspb.vspbv{padding-left:5px;padding-right:6px;padding-bottom:18px}#vsrs,#vsrsr{height:30px;position:absolute;width:17px}#vsrs{background-position:0 -212px;left:-16px}#vsrsr{background-position:-50px -212px;right:-16px;display:none}#vspc{background-color:#fff;border:none;padding:0;position:absolute;top:15px}.vspbv #vspc{top:25px}#vspci{background-position:-71px -111px;border-bottom:5px solid #fff;border-left:5px solid #fff;cursor:pointer;height:16px;position:absolute;right:7px;top:7px;-webkit-background-clip: padding-box;width:16px;z-index:16}.vspbv #vspci{right:4px;top:5px}.vspbv #vsic, #vsvpc{display:none}.vspbv #vsvpc{display:block}.vsvsn{left:3px;position:absolute;top:-20px}.vsvsnd{width:20px;height:16px}.vsvsndon{background:transparent url(images/video/audio_icons.png) no-repeat scroll -57px 0}.vsvsndon:hover{background:transparent url(images/video/audio_icons.png) no-repeat scroll -38px 0}.vsvsndoff{background-image:url(images/video/audio_icons.png)}.vsvsndoff:hover{background:transparent url(images/video/audio_icons.png) no-repeat scroll -19px 0}#vsvsna:focus{outline:none}.vsvptbl{margin-top:-2px}#vsic{overflow:hidden;z-index:-1}#vsli{border:none;display:block;left:50%;margin-left:-11px;width: 22px;height: 22px;position:absolute;top:50%;visibility:hidden}#vsm{font-size:16px;left:0;overflow:hidden;padding:10px;position:absolute;right:0;text-align:center;top:30%}#vsi,.vsi{border:none;display:block}#vsia{text-decoration:none}.vsbb{background-color:rgba(255, 245, 64, 0.2);border:4px solid #ff7f27;opacity:0.8;position:absolute;z-index:14}.vstb{-webkit-box-shadow:1px 1px 3px rgba(0,0,0,0.4);background-color:#fff;border:1px solid #ff7f27;color:#000;font-size:12px;left:-4px;overflow:hidden;padding:5px;position:absolute;right:-4px;text-overflow:ellipsis;z-index:15}a .vstb em, a .vstb b{text-decoration:none}div.vsc{display:inline-block;position:relative;width:100%}div.vsta{display:block}div.vsta{z-index:1}.vspi{bottom:-5px;left:-8px;position:absolute;right:-8px;top:-5px;z-index:-1}.vscl .vspi{left:-6px}.vsgv .vspi{right:7px;top:1px}.vsgb .vspi{bottom:0;top:-1px}.nulead .vspi{left:-6px;top:-3px;bottom:-4px}.nusec .vspi{left:-6px;top:-4px;bottom:-4px}.nurich .vspi{left:-6px;top:-4px;bottom:0}.vspib{background-position:-19px -213px;border:0;padding-right:0;cursor:pointer;display:inline;height:13px;margin-left:5px;margin-right:3px;vertical-align:0;width:13px}.vsgv .vspib{margin-top:2px}.vsc .ws,.vsc .wsa{margin-right:0}div.vsc:hover .vspib,#cnt.vse .vspib{background-position:-35px -213px}#cnt.vsh #ires div.vsc:hover>.vspi,#ires div.vso>.vspi,#cnt.vsh #rhs div.vsc:hover>.vspi,#rhs div.vso>.vspi{background:#ebf2fc;border:1px solid #cddcf9}#cnt.vsh #tads div.vsc:hover>.vspi,#tads div.vso>.vspi,#cnt.vsh #tadsto div.vsc:hover>.vspi,#tadsto div.vso>.vspi{background:#fbf3d4;border:1px solid #eddca6}div.vsc:hover #nqsbq,div.vso #nqsbq{background-color:#fff}div.fade>#center_col div.vsc:hover>.vspi{background:none !important;border:none !important}#gog{background:none}.tl{position:relative}.mbl{margin-top:7px}.vpvfl{vertical-align:bottom}.vshid{display:none}.vsinfo{font-size:small;position:absolute;bottom:5px}.so{margin-top:4px;position:relative;white-space:normal}.so img{border:0;margin-left:0;margin-right:1px;vertical-align:top}.son{position:relative}.so .soh{background-color:#FFFFD2;border:1px solid #FDF0BF;color:#000;display:none;font-size:8pt;padding:3px;position:absolute;white-space:nowrap;z-index:10}.soi{background:#ebeff9;line-height:22px;padding:0 4px;position:static;vertical-align:middle}.soi a{white-space:nowrap}.soi img{margin-top:-3px;vertical-align:middle}.soi .lsbb{display:inline-block;height:20px;margin-bottom:4px}.soi .lsb{background-repeat:repeat-x;font-size:small;height:20px;padding:0 5px}#rhs_block .so{display:block;font-size:11px}.siw{display:inline-block;position:relative}.sia{background-color:#4c4c4c;bottom:0;font-size:11px;margin:4px;padding-left:2px;position:absolute}.sia .f, .sia a.fl:link, .sia a.fl:visited{color:white!important;overflow:hidden;text-overflow:ellipsis;width:100%;white-space:nowrap}.ps-map{float:left}.ps-map img{border:1px solid #00c}a.tiny-pin,a.tiny-pin:link,a.tiny-pin:hover{text-decoration:none;color:12c}a.tiny-pin:hover span{text-decoration:underline}.tiny-pin table{vertical-align:middle}.tiny-pin p{background-image:url(/images/nav_logo86.png);background-position:-117px -91px;height:15px;margin:0;padding:0;top:-1px;overflow:hidden;position:relative;width:9px;}.pspa-price{font-size:medium;font-weight:bold}.pspa-call-price{font-size:small;font-weight:bold}.pspa-store-avail{color:#093}.pspa-out-of-stock{color:#d14836}li.ppl{margin-bottom:11px;padding:6px;position:relative}#ppldir #ppldone, #ppldir #pplundo, #ppldir #pplcancel{color:#00f;cursor:pointer;text-decoration:underline}#ppldir{background:rgb(247,243,181);display:none;line-height:1.5em;outline:1px solid rgb(255,185,23);padding:6px 4px 6px 6px;position:absolute;width:90%;z-index:20}#ppldir.working{display:block}.pplclustered .pplclusterhide{visibility:hidden}.pplclustered .pplfeedback, .pplclustered .pplclusterdrop{display:none !important}.pplfeedback{-webkit-box-shadow:inset 0 1px 0px rgba(255,255,255,.3), 0 1px 0px #aaa;right:5px;background:rgba(235, 242, 252, 1.0);border:1px solid #afafaf;color:#333 !important;cursor:pointer;display:none;font-size:1.0em;float:right;margin-top:5px;margin-right:5px;opacity:1.0;padding:5px 10px;position:absolute;text-decoration:none;top:5px;vertical-align:middle;white-space:nowrap}.pplfeedback:active{background:-webkit-gradient(linear,left top,left bottom,from(#ddd),to(#eee))}li.ppl:hover .pplfeedback{opacity:1.0}.pplclustered:hover{border:0px;background-color:'' !important;margin-left:0px !important}li.ppl:hover{background-color:#ebf2fc;border:1px solid #cddcf9;padding:5px}.pplselected{background-color:#EBF2FC}.ppldragging{background-color:#B2D2FF}li.g.ppld{margin-bottom:0px;padding:3px}li.g.ppld:hover{padding:2px}.ppl_thumb_src{color:#767676;font-size:0.8em;line-height:1.3em;overflow:hidden;text-overflow:ellipsis;padding:0;text-align:center;width:70px}a.pplatt:link{color:#767676;text-decoration:none}a.pplatt:hover{color:#767676;text-decoration:underline}li.ppl:hover .pplfeedback{display:block}.ppl_thy{color:#767676;margin-left:3px}.ppl_crc{margin:35px 10px 0px 0px;display:none}.fbbtn{margin-left:5px;width:35px}.son:hover .soh{display:block;left: 0pxtop: 24px;}.bili {vertical-align:top;display:inline-block;overflow:hidden;margin-top:0px;margin-right:6px;margin-bottom:6px;margin-left:0px;}.bilir {margin:0px 0px 6px 0px;}.bia {display:block;}.rg_il,.rg_ilbg,.rg_ils{bottom:0;color:#fff;font-size:11px;line-height:100%;padding-right:1px;position:absolute}.rg_il,.rg_ilbg{right:0}.rg_ilbg{background:#000;opacity:0.4;z-index:0}.rg_il{z-index:1}.rg_ils{background:#fff;-webkit-border-top-right-radius:1px;-moz-border-radius-topright:1px;border-top-right-radius:1px;left:0;white-space:nowrap;z-index:1}.rg_ils div.f{color:#fff}.rg_ils div.f a{color:#12c}.rg_h,.rg_hp,.rg_hv{display:none;position:fixed;visibility:hidden}.rg_h {height:0px;left:0px;top:0px;width:0px;}.rg_hv{background:#fff;border:1px solid #ccc;-moz-box-shadow:0 4px 16px rgba(0,0,0,0.2);-webkit-box-shadow:0 4px 16px rgba(0,0,0,0.2);-ms-box-shadow:0 4px 16px rgba(0,0,0,0.2);box-shadow:0 4px 16px rgba(0,0,0,0.2);margin:-8px;padding:8px;background-color:#fff;visibility:visible}.rg_hp,.rg_hv,#rg_hp.v{display:block;z-index:5000}#rg_hp{-moz-box-shadow:0px 2px 4px rgba(0,0,0,0.2);-webkit-box-shadow:0px 2px 4px rgba(0,0,0,0.2);box-shadow:0px 2px 4px rgba(0,0,0,0.2);display:none;opacity:.7;position:fixed}#rg_hpl{cursor:pointer;display:block;height:100%;outline-color:-moz-use-text-color;outline-style:none;outline-width:medium;width:100%}.rg_hi {border:0;display:block;margin:0 auto 4px}.rg_hx {opacity:0.5}.rg_hx:hover {opacity:1}.rg_hn,.rg_hr,.rg_ht,.rg_ha{margin:0 1px -1px;padding-bottom:1px;overflow:hidden}.rg_ht{font-size:123%;line-height:120%;max-height:1.2em;word-wrap:break-word}.rg_hn{line-height:120%;max-height:2.4em}.rg_hr{color:#093;white-space:nowrap}#rg_pos{margin:0}.rg_ha{color:#666;white-space:nowrap}a.rg_hal{color:#12c;text-decoration:none}a:hover.rg_hal {text-decoration:underline}.uh_h,.uh_hp,.uh_hv{display:none;position:fixed;visibility:hidden}.uh_h {height:0px;left:0px;top:0px;width:0px;}.uh_hv{background:#fff;border:1px solid #ccc;-moz-box-shadow:0 4px 16px rgba(0,0,0,0.2);-webkit-box-shadow:0 4px 16px rgba(0,0,0,0.2);-ms-box-shadow:0 4px 16px rgba(0,0,0,0.2);box-shadow:0 4px 16px rgba(0,0,0,0.2);margin:-8px;padding:8px;background-color:#fff;visibility:visible}.uh_hp,.uh_hv,#uh_hp.v{display:block;z-index:5000}#uh_hp{-moz-box-shadow:0px 2px 4px rgba(0,0,0,0.2);-webkit-box-shadow:0px 2px 4px rgba(0,0,0,0.2);box-shadow:0px 2px 4px rgba(0,0,0,0.2);display:none;opacity:.7;position:fixed}#uh_hpl{cursor:pointer;display:block;height:100%;outline-color:-moz-use-text-color;outline-style:none;outline-width:medium;width:100%}.uh_hi {border:0;display:block;margin:0 auto 4px}.uh_hx {opacity:0.5}.uh_hx:hover {opacity:1}.uh_hn,.uh_hr,.uh_ht,.uh_ha{margin:0 1px -1px;padding-bottom:1px;overflow:hidden}.uh_ht{font-size:123%;line-height:120%;max-height:1.2em;word-wrap:break-word}.uh_hn{line-height:120%;max-height:2.4em}.uh_hr{color:#0E774A;white-space:nowrap}.uh_ha{color:#777;white-space:nowrap}a.uh_hal{color:#36c;text-decoration:none}a:hover.uh_hal {text-decoration:underline}.speaker-icon-listen-off{background:url(//ssl.gstatic.com/dictionary/static/images/icons/1/pronunciation.png);opacity:0.55;filter:alpha(opacity=55);border:1px solid transparent;display:inline-block;float:none;height:16px;vertical-align:bottom;width:16px}.speaker-icon-listen-off:hover{opacity:1.0;filter:alpha(opacity=100);cursor:pointer;}.speaker-icon-listen-on{background:url(//ssl.gstatic.com/dictionary/static/images/icons/1/pronunciation.png);opacity:1.0;filter:alpha(opacity=100);border:1px solid transparent;display:inline-block;float:none;height:16px;vertical-align:bottom;width:16px}.speaker-icon-listen-on:hover{opacity:1.0;filter:alpha(opacity=100);cursor:pointer;}ul.lsnip{font-size:90%}.lsnip > li{overflow:hidden;text-overflow:ellipsis;-ms-text-overflow:ellipsis;-o-text-overflow:ellipsis;white-space:nowrap}table.tsnip{font-size:90%;border-spacing:0;border-collapse:collapse;border-style:hidden;margin:2px 0 0}table.tsnip td,table.tsnip th{padding:0 10px 0 0;border-top:1px solid #ddd;margin:0;line-height:15px;text-align:left}table.tsnip th{color:#777;font-weight:normal}.rsw-remove-inactive{visibility:hidden}.rsw-remove-active{background:url("/images/nav_logo86.png") no-repeat scroll -124px -230px transparent;height:7px;width:7px}.rsw-remove-active:hover{background-position:-132px -230px}.rsw-starred,.rsw-half-starred,.rsw-unstarred{background:url("/images/nav_logo86.png") no-repeat scroll transparent;float:left;overflow:hidden;position:relative;height:13px;width:13px}.rsw-unstarred{background-position:-68px -230px}.rsw-starred{background-position:-110px -230px}.rsw-half-starred{background-position:-82px -230px}.rsw-angry-active,.rsw-angry-inactive,.rsw-happy-active,.rsw-happy-inactive{background:url("/images/nav_logo86.png") no-repeat scroll transparent;height:12px;width:12px}.rsw-angry-active{background-position:-76px -243px}.rsw-angry-inactive{background-position:-102px -243px}.rsw-angry-inactive:hover{background-position:-89px -243px}.rsw-happy-active{background-position:-88px -111px}.rsw-happy-inactive{background-position:-63px -243px}.rsw-happy-inactive:hover{background-position:-50px -243px}.comment-box-tip{color:#666}.comment-box-readonly-quoted{font-style:italic}em,.rbt b,.c b,#mbEnd b{color:#d14836;font-style:normal;font-weight:normal}a em,a b{text-decoration:underline}body,td,div,.p,a{font-family:arial,sans-serif}#res,#res .j{line-height:120%}#res .std,.c,.slk{line-height:146%}.g{margin:.875em 0 1.3125em}.mbl{margin:1em 0 0}td.hc{width:39em}div.hc{max-width:39em}#ssb{margin:0 8px 14px}#tads,#tadsb,#tadsto{margin-bottom:1.4em}#res .r{line-height:1}#res .s{line-height:1.54}#res li .ts{max-width:42em}.fwtc{width:42em}#mbEnd li{line-height:1.54;margin:1.1em 0}#mbEnd h3,#mbEnd cite{line-height:1.3}#mbEnd h3{padding-bottom:1px}#guser{height:16px}li.w0 .ws,td.w0 .ws{opacity:0.5}li.w0:hover .ws,td.w0:hover .ws{opacity:1}ol,ul,li{border:0;margin:0;padding:0}li{line-height:1.2}li.g{margin-top:0;margin-bottom:20px}.ibk,#productbox .fmg{display:-moz-inline-box;display:inline-block;*display:inline;vertical-align:top;zoom:1}.tsw{width:595px}#cnt{min-width:817px;margin-left:0;padding-top:17px;}.mw{max-width:1181px}.big .mw{max-width:1219px}@media only screen and (min-width:1222px){.mw{max-width:1219px}}.gbh{top:24px}#gbar{margin-left:8px;height:20px}#guser{margin-right:8px;padding-bottom:5px!important}#rhs{width:264px}.tsf-p{padding-left:184px;margin-right:267px;max-width:739px}.big .tsf-p{padding-left:220px;margin-right:228px;}@media only screen and (min-width:1222px){.tsf-p{padding-left:220px;margin-right:228px;}}.mbi{margin-bottom:-1px}.uc{margin-left:181px}#center_col,#foot{margin-left:176px;margin-right:264px;padding:0 8px;padding:0 8px}.big #center_col,.big #foot{margin-left:212px;padding:0 8px}@media only screen and (min-width:1222px){#center_col,#foot{margin-left:212px;padding:0 8px}}#subform_ctrl{font-size:11px;min-height:19px;z-index:99;margin-right:480px;position:relative;}#subform_ctrl a.gl{color:#12c}#center_col{clear:both}#brs p{margin:0;padding-top:5px}.brs_col{display:inline-block;float:left;font-size:small;white-space:nowrap;padding-right:16px;margin-top:-1px;padding-bottom:1px}#tads,#tadsb,#tadsto{margin-bottom:11px!important;z-index:0}#tads li,#tadsb li,#tadsto li{padding:1px 0}#tads li.taf,#tadsb li.taf,#tadsto li.taf{padding:1px 0 0}#tads li.tam,#tadsb li.tam,#tadsto li.tam{padding:20px 0 0}#tads li.tal,#tadsb li.tal,#tadsto li.tal{padding:20px 0 1px}#res{border:0;margin:0;padding:0 8px}#ires{padding-top:6px}.mbl{margin-top:10px}.play_icon{background-position:;height:px;margin-left:64px;margin-top:44px;width:px}#leftnav li{display:block}.micon,.licon,.close_btn,.inline_close_btn{border:0}#leftnav h2{font-size:small;color:#767676;font-weight:normal;margin:8px 0 0;padding-left:8px;width:167px}#tbbc dfn{padding:4px}#tbbc.bigger .std{font-size:154%;font-weight:bold;text-decoration:none}.close_btn{background-position:-138px -84px;float:right;height:14px;width:14px}.inline_close_btn{display:inline-block;vertical-align:text_bottom;background-position:-138px -84px;height:14px;width:14px}.videobox{padding-bottom:3px}#leftnav a{text-decoration:none}#leftnav a:hover{text-decoration:underline}.mitem,#showmodes{border-bottom:1px solid transparent;line-height:29px;opacity:1.0;padding-left:15px}.mitem:hover,#showmodes:hover,#showmodes:hover{opacity:1.0;background-color:#eee}#ms a:hover{text-decoration:none}.mitem>.kl,#ms>.kl{color:#222;display:block}.msel{color:#d14836;cursor:pointer;font-weight:bold}.mitem>.kl,#ms>.kl,.msel{font-size:13px}.licon{background-position:-153px -99px;float:left;height:14px;margin-right:3px;width:14px}.open .msm,.msl{display:none}.open .msl{display:inline}.open #hidden_modes,.open #hmp{display:block}#swr li{border:0;font-size:13px;line-height:1.2;margin:0 0 4px;margin-right:8px;padding-left:1px}#tbd,#atd{display:block;min-height:1px}.tbt{font-size:13px;line-height:1.2}.tbnow{white-space:nowrap}.tbou,.tbos,.tbots,.tbotu{margin-right:8px;padding-left:16px;padding-bottom:3px;text-indent:-8px}.tbos,.tbots{font-weight:bold}#leftnav .tbots a{color:#000!important;cursor:default;text-decoration:none}.tbst{margin-top:8px}#season_{margin-top:8px}#iszlt_sel.tbcontrol_vis{margin-left:0}.tbpc,.tbpo,.lcsc,.lcso{font-size:13px}.tbpc,.tbo .tbpo,.lco .lcsc{display:inline}.tbo .tbpc,.tbpo,.lco .lcso,.lcsc,#set_location_section{display:none}.lco #set_location_section{display:block}.lcot{margin:0 8px;}.tbo #tbp,.lco .licon,.obsmo #obsmti{background-position:-138px -99px!important}#prc_opt label,#prc_ttl{display:block;font-weight:normal;margin-right:2px;white-space:nowrap}#cdr_opt,#loc_opt,#prc_opt{padding-left:8px;text-indent:0}#prc_opt{margin-top:-20px}.tbou #cdr_frm,.tbou #cloc_frm {display:none}#cdr_frm,#cdr_min,#cdr_max{color:rgb(102, 102, 102);}#cdr_min,#cdr_max{font-family:arial,sans-serif;width:100%}#cdr_opt label{display:block;font-weight:normal;margin-right:2px;white-space:nowrap}.cdr_lbl{float:left;padding-top:5px}.cdr_hl{height:0;visibility:hidden}.cdr_inp{min-width:64px;overflow:hidden;padding-right:6px}.cdr_ctr{clear:both;overflow:hidden;padding:1px 0}.cdr_inp.cdr_hint{font-size:84%;font-weight:normal;min-width:70px;padding-bottom:2px;padding-right:0}.cdr_inp.cdr_btn{min-width:70px;padding-right:0}.cdr_err{color:red;font-size:84%;font-weight:normal}.gb-button,.gb-button-hilite {border: solid 1px #aaa;border-radius: 2px;cursor: pointer;display: -moz-inline-box;display: inline-block;font: normal normal normal 13px/140% 'arial', 'sans-serif';margin: 0 0 4px 0;outline: none;padding: 1px 10px;position: relative;text-decoration: none !important;vertical-align: middle;text-align: center;user-select: none;text-shadow: none;white-space: nowrap;width: 80px;-webkit-border-radius: 3px;-webkit-user-select: none;-moz-border-radius: 3px;-moz-user-select: none;}* html .gb-button,* html .gb-button-hilite {display: inline;margin-bottom: 0;}* html input.gb-button,* html input.gb-button-hilite {padding: 0;height: 23px;}*:first-child+html .gb-button,*:first-child+html .gb-button-hilite {display: inline;margin-bottom: 0;}*:first-child+html input.gb-button,*:first-child+html input.gb-button-hilite {padding: 0;height: 23px;}.gb-button {background: #f0f0f0;background-image: -webkit-gradient(linear, 0% 25%, 0% 75%, from(#F9F9F9), to(#E3E3E3));background-image: -moz-linear-gradient(center top, #F9F9F9 25%, #E3E3E3 75%);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#F9F9F9, endColorstr=#E3E3E3);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#F9F9F9, endColorstr=#E3E3E3)";border-color: #ccc #ccc #a0a0a0 #ccc;color: #000 !important;text-shadow: 0 0 1px #eee;-moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);box-shadow: inset inset 0 1px 1px rgba(0,0,0,0.1);}.gb-button:active {background: #E3E3E3;background-image: -webkit-gradient(linear, 0% 25%, 0% 75%, from(#E3E3E3), to(#F9F9F9));background-image: -moz-linear-gradient(center top, #E3E3E3 25%, #F9F9F9 75%);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#E3E3E3, endColorstr=#F9F9F9);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#E3E3E3, endColorstr=#F9F9F9)";}.gb-button:hover {border-color: #666 #666 #444 #666;}.gb-button-hilite {background: #3d79d0;background-image: -webkit-gradient(linear, 0% 25%, 0% 75%, from(#4c91e8), to(#336ac1));background-image: -moz-linear-gradient(center top, #4c91e8 25%, #336ac1 75%);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c91e8, endColorstr=#336ac1);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c91e8, endColorstr=#336ac1)";border-color: #2525ea #2525ea #151596 #2525ea;color: #fff !important;font-weight: bold;-moz-box-shadow: inset 0 1px 1px rgba(255,255,255,0.5);-webkit-box-shadow: inset 0 1px 1px rgba(255,255,255,0.5);box-shadow: inset 0 1px 1px rgba(255,255,255,0.5);}.gb-button-hilite:active {background: #336ac1;background-image: -webkit-gradient(linear, 0% 25%, 0% 75%, from(#336ac1), to(#4c91e8));background-image: -moz-linear-gradient(center top, #336ac1 25%, #4c91e8 75%);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#336ac1, endColorstr=#4c91e8);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#336ac1, endColorstr=#4c91e8)";}.gb-button-hilite:hover {border-color: #0f0f68 #0f0f68 #08083a #0f0f68;}#mbEnd,.rhss{margin:0 0 32px;margin-left:8px}#mbEnd h2{color:#767676}#mbEnd li{margin:20px 0 0}a:link,.w,.q:active,.q:visited,.tbotu{color:#12c;cursor:pointer}a.fl:link,.fl a,.flt,a.flt,.gl a:link,a.mblink,.mblink b{color:#12c}.osl a,.gl a,#tsf a,a.mblink,a.gl,a.fl,.slk a,.bc a,.flt,a.flt u,.oslk a,#tads .ac a,#tadsb .ac a,#rhs .ac a,.blg a,#appbar a{text-decoration:none}.osl a:hover,.gl a:hover,#tsf a:hover,a.mblink:hover,a.gl:hover,a.fl:hover,.slk a:hover,.bc a:hover,.flt:hover,a.flt:hover u,.oslk a:hover,.tbotu:hover,#tads .ac a:hover,#tadsb .ac a:hover,#rhs .ac a:hover,.blg a:hover,#appbar a:hover{text-decoration:underline}#ss-box a:hover{text-decoration:none}#tads .mblink,#tadsb .mblink,#tadsto .mblink,#rhs .mblink{text-decoration:underline}.hpn,.osl{color:#767676}div#gbi,div#gbg{border-color:#a2bff0 #558be3 #558be3 #a2bff0}div#gbi a.gb2:hover,div#gbg a.gb2:hover,.mi:hover{background-color:#558be3}#guser a.gb2:hover,.mi:hover,.mi:hover *{color:#fff!important}#guser{color:#000}#imagebox_big img{margin:5px!important}#imagebox_bigimages .th{border:0}#productbox .fmg{margin-top:7px;padding-right:4px;text-align:left}#productbox .lfmg{padding-right:0}#productbox .fmp,#productbox .fml,#productbox .fmm{padding-top:3px}#foot .ftl{margin-right:12px}#foot a.slink{text-decoration:none;color:#12c}#fll a,#bfl a{color:#12c;margin:0 12px;text-decoration:none}.kqfl #fll a{margin:0 24px 0 0 !important}#foot a:hover{text-decoration:underline}#foot a.slink:visited{color:#61c}#blurbbox_bottom{color:#767676}.stp{margin:7px 0 17px}.ssp{margin:.33em 0 17px}#mss {margin:.33em 0 0;padding:0;display:table}.mss_col {display:inline-block;float:left;font-size:small;white-space:nowrap;padding-right:16px;}#mss p{margin:0;padding-top:5px}#gsr a:active,#srp a:active,a.fl:active,.fl a:active,.gl a:active{color:#d14836}body{color:#222}.s{color:#222}.s a:visited em{color:#61c}.s a:active em{color:#d14836}#tads .ac a:visited b,#tadsb .ac a:visited b,#rhs .ac a:visited b{color:#61c}#tads .ac a:active b,#tadsb .ac a:active b,#rhs .ac a:active b{color:#d14836}.sfcc,#tsf{max-width:1181px;min-width:817px}.big .sfcc{max-width:1219px}@media only screen and (min-width:1222px){.sfcc{max-width:1219px}}.ksfcccl{max-width:1219px}.ksfccl{font-size:11px;margin-right:258px;padding-right:8px;position:relative;z-index:100}.big .ksfccl{margin-right:260px;}@media only screen and (min-width:1222px){.ksfccl{margin-right:260px;}} .ksfccl .gl{color:#12c;display:block}#sform{height:33px!important}#topstuff .sp_cnt, #topstuff .ssp {padding-top:6px;}#ires h3,#res h3,#tads h3,#tadsb h3,#mbEnd h3{font-size:medium}.nrtd li{margin:7px 0 0 0}.osl{margin-top:4px}.osi{background:url(/images/nav_logo86.png) no-repeat;background-position:-115px -244px;float:left;height:10px;margin:3px 5px 0 0;width:10px}.slk{margin-top:6px!important}a.nlrl:link, a.nlrl:visited{color:#000}a.nlrl:hover, a.lrln:active{color:#12c}.st,.ac{line-height:1.24}.kv,.kvs{display:block;margin-bottom:2px}.kvs{margin-top:2px}.kvm{display:block;margin-bottom:1px}.kt{border-spacing: 2px 1px}.kb{display:block;margin-bottom:1px;margin-top:-1px}.kpbb,.kprb,.kpgb,.ksb{-webkit-border-radius:2px;-webkit-transition:all 0.218s;-webkit-user-select:none;border-radius:2px;cursor:pointer;font-family:arial,sans-serif;font-size:11px;font-weight:bold;height:28px;line-height:26px;margin:2px 0;min-width:54px;padding:0 8px;text-align:center}.ksb{background-image:-webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));background-image:-webkit-linear-gradient(top,#f5f5f5,#f1f1f1);background-color:#f5f5f5;background-image:linear-gradient(top,#f5f5f5,#f1f1f1);border:1px solid #dcdcdc;border:1px solid rgba(0, 0, 0, 0.1);color:#555}.kpbb:hover,.kprb:hover,.kpgb:hover,.ksb:hover{-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.1);-webkit-transition:all 0.0s;box-shadow:0 1px 1px rgba(0,0,0,0.1)}.ksb:hover{background-image:-webkit-gradient(linear,left top,left bottom,from(#f8f8f8),to(#f1f1f1));background-image:-webkit-linear-gradient(top,#f8f8f8,#f1f1f1);background-color:#f8f8f8;background-image:linear-gradient(top,#f8f8f8,#f1f1f1);border:1px solid #c6c6c6;color:#333}.ksb:active{background-image:-webkit-gradient(linear,left top,left bottom,from(#f6f6f6),to(#f1f1f1));background-image:-webkit-linear-gradient(top,#f6f6f6,#f1f1f1);-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);background-color:#f6f6f6;background-image:linear-gradient(top,#f6f6f6,#f1f1f1);box-shadow:inset 0 1px 2px rgba(0,0,0,0.1)}.ksb.sbm{min-width:35px;height:20px;line-height:18px}.ksb.sbf{min-width:35px;height:21px;line-height:21px}#sbfrm_l{visibility:inherit!important}#rcnt{margin-top:21px}#appbar{background:white;border-bottom:1px solid #dedede;height:58px;position:relative;z-index:1;-webkit-box-sizing:border-box;width:100%}#ab_name{color:#dd4b39;font:20px "Arial";margin-left:15px;position:absolute;top:17px}#ab_ctls{position:relative;right:200px;float:right}.ab_ctl{position:relative;display:inline-block;vertical-align:top;margin:0 10px 0 10px}.ab_dropdown,.gbom{right:auto;left:0;top:38px;position:absolute;display:inline-block;z-index:200;min-width:192px;background:-webkit-gradient(linear, left top, left 66, from(#4D4D4D),to(#3D3D3D));-webkit-box-shadow:2px 2px 5px rgba(0, 0, 0, 0.2);border-top:1px solid #777;visibility:hidden}.ab_dropdown:after,.gbom:after{content:"";position:absolute;border-style:solid;border-color:#4d4d4d transparent;top:-11px;left:10px;bottom:auto;right:auto;border-width:0 10px 10px}.ab_dropdown:before,.gbom:before{content:"";position:absolute;border-style:solid;border-color:#777 transparent;top:-11px;left:10px;bottom:auto;right:auto;border-width:0 11px 11px}.ab_button{background:-webkit-gradient(linear, left top, left bottom, from(#f8f8f8),to(#f1f1f1));border:1px solid #e5e5e5;border-radius:3px;font-weight:bold;font-size:12px;padding:6px 16px 6px 16px}.ab_icon{background:url(/images/nav_logo86.png) no-repeat;overflow:hidden;display:inline-block;vertical-align:middle}#ab_loc_icon{background-position:-80px -192px;height:19px;width:19px;}#ab_search_icon{background-position:-100px -192px;height:19px;width:19px;}#ab_opt_icon{background-position:-140px -192px;height:20px;width:20px}.tbt{margin-left:8px;margin-bottom:28px}#tbpi.pt.pi{margin-top:-20px}#tbpi.pi{margin-top:0}.tbo #tbpi.pt,.tbo #tbpi{margin-top:-20px}#tbpi.pt{margin-top:8px}#tbpi{margin-top:0}#tbrt{margin-top:-20px}.lnsep{border-bottom:1px solid #efefef;margin-bottom:14px;margin-left:8px;margin-right:4px;margin-top:14px}.tbos,.tbots,.tbotu{color:#d14836}#lc a,.tbou > a.q,#tbpi,#tbtro,.tbt label,#prc_opt,#set_location_section a,.tbtctlabel,#swr a{color:#222}.th{border:0px solid transparent;}#resultStats{color:#999;font-size:13px;margin-left:193px;position:absolute;top:23px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.big #resultStats{margin-left:229px}@media only screen and (min-width:1222px){#resultStats{margin-left:229px}} #leftnav{margin-left:0}#subform_ctrl{margin-left:193px;}.big #leftnav{margin-left:28px}.big #subform_ctrl{padding-right:2px;margin-left:229px;}.big #ab_name{margin-left:43px}.big .uc{margin-left:217px}@media only screen and (min-width:1222px){#leftnav{margin-left:28px}#subform_ctrl{padding-right:2px;margin-left:229px;}#ab_name{margin-left:43px}.uc{margin-left:217px}} .obsmo #obsmtxt, #obsltxt{display:none}.obsmo #obsltxt{display:inline}#obsmtc a{text-decoration:none}#obsmtc a:hover{text-decoration:underline}.authorship_aff{color:gray;display:block;}.authorship_link{color:#2b65ec;text-decoration:none;}.authorship_link:hover{cursor:pointer;text-decoration:underline;}.authorship_note{color:black;display:block;}.authorship_popup{background-color:white;border:solid #888888 1px;box-shadow:2px 2px 3px #cbc8c8;float:left;font-size:12px;left:0;padding:2px;position:absolute;text-align:left;text-decoration:none;top:0.2em;width:325px;z-index:300;-moz-box-shadow:2px 2px 3px #cbc8c8;-webkit-box-shadow:2px 2px 3px #cbc8c8;}.authorship_popup a:hover{cursor:pointer}.authorship_slk{color:#2b65ec;display:block;text-decoration:none;}.authorship_table{vertical-align:top}.authorship_title{color:#7a5dc7;display:block;font-size:13px;font-weight:bold}</style>
<style type="text/css">#pages{padding:30px 0 100px 50px;}#pages a{margin-right:20px; height:20px;}</style>
</head>
<body>
<div style="margin:18px 0 0 20px">
<div><a href="./"><img src="logo.gif" style="width:150px; height:55px; border:0;" /></a></div>
<div style="margin:8px 0 12px 0;">
<form method="get" action="index.php">
<input type="text" name="q" style="height:32px; width:400px; line-height:30px" value="<?php echo $qv; ?>" />&nbsp;<input type="submit" style="height:32px;" value=" Google搜索 " />
</form>
</div>
<div id="resultStats" style="left:0px;"><?php echo $resultStats; ?></div>
<div id="search"><?php echo $search; ?></div>
<div id="pages">
<?php
if($q && $resultStats) {
        for($i = 1; $i <= 10; $i ++) {
                $num = ($i - 1) * 10;
                echo "<a href=\"index.php?q=$q&start=$num\">$i</a>";
        }
        $next = $start + 10;
        echo "<a href=\"index.php?q=$q&start=$next\">下一页</a>";
}
?>
</div>
</div>
</body>
</html>
<?php
ob_end_flush();
?>