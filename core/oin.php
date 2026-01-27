<?php

function getcateid($id){  //获取栏目id
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.relationships')->where ('cid=?',$id));
   return  $postnum['mid']; 
}

function catename($cateid){  //获取栏目名
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.metas')->where ('mid=?',$cateid)->where('type=?', 'category'));
   return  $postnum['name']; 
}

function geipuid($cid){  //文章获取用户id
  Typecho_Widget::widget('Widget_Archive@geipuid'.$cid.'', 'pageSize=1&type=post', 'cid='.$cid)->to($jis);
  $useruid=$jis->author->uid;
  return  $useruid; 
}

function getuname($uid){  //会员id获取用户名
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.users')->where ('uid=?',$uid));
   return  $postnum['name']; 
}

function getumail($uid){  //会员id获取用户邮箱
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.users')->where ('uid=?',$uid));
   return  $postnum['mail']; 
}


/**
* 网站主色调
*/
function vartheme() {
     $vartheme = Helper::options()->vartheme;
	 if($vartheme){ echo $vartheme; }
	 else { echo'29d'; }
     
}


/**
* 阅读统计
* 调用<?php get_post_view($this); ?>
*/
function Postviews($archive) {
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if ($archive->is('single')) {
        $cookie = Typecho_Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => (int)$exist+1))
                ->where('cid = ?', $cid));
            $exist = (int)$exist+1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('contents_views', $cookie);
        }
    }
    
    if( $exist == 0 ){
      echo '0';
    }
    else{      
      $exist = convert($exist);
      echo $exist;
    }
}


/**
* 个人主页统计
* 调用<?php get_post_view($this); ?>
*/
function authorviews($uid) {
    $db = Typecho_Db::get();
    if (!array_key_exists('uviews', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `uviews` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('uviews')->from('table.users')->where('uid = ?', $uid))['uviews'];
    
        $cookie = Typecho_Cookie::get('author_uviews');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($uid, $cookie)) {
            $db->query($db->update('table.users')
                ->rows(array('uviews' => (int)$exist+1))
                ->where('uid = ?', $uid));
            $exist = (int)$exist+1;
            array_push($cookie, $uid);
            $cookie = implode(',', $cookie);
            Typecho_Cookie::set('author_uviews', $cookie);
        }
    
    
    if( $exist == 0 ){
      return '0';
    }
    else{      
      $exist = convert($exist);
      return $exist;
    }
}


/** 阅读数友好化 */
function convert($num) 
{
    if ($num >= 100000)
    {
        $num = round($num / 10000) .'w';
    } 
    else if ($num >= 10000) 
    {
        $num = round($num / 10000, 1) .'w';
    } 
    else if($num >= 1000) 
    {
        $num = round($num / 1000, 1) . 'k';
    }
    return $num;
}

//博客最后更新时间
function get_last_update(){
    $num   = '1'; //取最近的一笔就好了
    $now = time();
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $create = $db->fetchRow($db->select('created')->from('table.contents')->limit($num)->order('created',Typecho_Db::SORT_DESC));
    $update = $db->fetchRow($db->select('modified')->from('table.contents')->limit($num)->order('modified',Typecho_Db::SORT_DESC));
    if($create>=$update){  //发表时间和更新时间取最近的
      echo Typecho_I18n::dateWord($create['created'], $now); //转换为更通俗易懂的格式
    }else{
      echo Typecho_I18n::dateWord($update['modified'], $now);
    }
}


/**
 * 时间友好化
 *
 * @access public
 * @param mixed
 * @return
 */
function formatTime($time){
    if (!$time)
 
        return false;
 
    $fdate = '';
 
    $d = time() - intval($time);
 
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
 
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
 
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
 
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
 
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
 
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
 
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
 
    if ($d == 0) {
 
        $fdate = '刚刚';
 
    } else {
 
        switch ($d) {
 
            case $d < $atd:
 
                $fdate = date('Y-m-d', $time);
 
                break;
 
            case $d < $td:
 
                $fdate = '后天' . date('H:i', $time);
 
                break;
 
            case $d < 0:
 
                $fdate = '明天' . date('H:i', $time);
 
                break;
 
            case $d < 60:
 
                $fdate = $d . '秒前';
 
                break;
 
            case $d < 3600:
 
                $fdate = floor($d / 60) . '分钟前';
 
                break;
 
            case $d < $dd:
 
                $fdate = floor($d / 3600) . '小时前';
 
                break;
 
            case $d < $yd:
 
                $fdate = '昨天' . date('H:i', $time);
 
                break;
 
            case $d < $byd:
 
                $fdate = '前天' . date('H:i', $time);
 
                break;
 
            case $d < $md:
 
                $fdate = date('m-d H:i', $time);
 
                break;
 
            case $d < $ld:
 
                $fdate = date('m-d', $time);
 
                break;
 
            default:
 
                $fdate = date('Y-m-d', $time);
 
                break;
        }
 
    }
 
    return $fdate;

}


/**
* 文章访问量等级
*/
function listdeng($archive){
   $db = Typecho_Db::get();
    $cid = $archive->cid;
    $time = $archive->created;
    $Copyr = $archive->fields->Copyrightnew;
    if($Copyr=='0'){
        echo '<span class="badge arc_cr">原创</span>';
    }
    else{
    $nowtime = time();
    $times =$nowtime - $time;
    $times = $times/(60*60*24)/30;
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    $exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
    if($times<=6){//6个月期限
    /**阅读量s**/
    if($exist<200){
    /** echo '<span class="badge arc_v1"></span>';**/
    }elseif ($exist<500 && $exist>200) {
    //echo '<span class="badge arc_v2">新秀</span>';
    }elseif ($exist<1000 && $exist>=500) {
    echo '<span class="badge arc_v3">推荐</span>';
    }elseif ($exist<5000 && $exist>=1000) {
    echo '<span class="badge arc_v4">热文</span>';
    }elseif ($exist<10000 && $exist>=5000) {
    echo '<span class="badge arc_v5">头条</span>';
    }elseif ($exist<30000 && $exist>=10000) {
    echo '<span class="badge arc_v6">火爆</span>';
    }elseif ($exist>=30000) {
    echo '<span class="badge arc_v7">神贴</span>';
    }
    /**阅读量s**/
    }
    else{}
    
    }
}



/**
* 获取文章图片数量
*/
function imgNum($content){
$output = preg_match_all('#<img(.*?) src="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#', $content,$s);
$cnt = count( $s[1] );
return $cnt;
}



/**
* 判断时间区间
*
* 使用方法  if(timeZone($this->date->timeStamp)) echo 'ok';
*/
function timeZone($from){
$now = new Typecho_Date(Typecho_Date::gmtTime());
return $now->timeStamp - $from < 24*60*60 ? true : false;
}



/** 输出文章ico样式 */
function imgNums($content){
$output = preg_match_all('#<img(.*?) src="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#', $content,$s);
$cnt = count( $s[1] );
    if(intval($cnt)==0){ //文章
    $c = '<i class="icon iconfont icon-paihangbang"></i>'; //输出
	return $c;
	} else { //小图
    $c = '<i class="icon iconfont icon-tupian"></i>'; //输出
	return $c;
	}
}


