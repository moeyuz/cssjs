<?php
define("THEME_URL", str_replace('//usr', '/usr', str_replace(Helper::options()->siteUrl, Helper::options()->rootUrl . '/', Helper::options()->themeUrl)));
$str1 = explode('/themes/', (THEME_URL . '/'));
$str2 = explode('/', $str1[1]);
define("THEME_NAME", $str2[0]);



/**
* 判断缓存文件存在
*/
function exicache($fis){
$i = false;
  
if($fis =='pagehot'){
  if(file_exists("txtcache/pagehot.txt")&&(!empty(file_get_contents("txtcache/pagehot.txt")))) { $i = true; } 
}
if($fis =='sequhot'){
  if(file_exists("txtcache/sequhot.txt")&&(!empty(file_get_contents("txtcache/sequhot.txt")))) { $i = true; } 
}
if($fis =='hot'){  
  if(file_exists("txtcache/hot.txt")&&(!empty(file_get_contents("txtcache/hot.txt"))) ) { $i = true; } 
}
if($fis =='pagemember'){  
  if(file_exists("txtcache/pagemember.txt")&&(!empty(file_get_contents("txtcache/pagemember.txt"))) ) { $i = true; } 
}  
if($fis =='siderping'){  
  if(file_exists("txtcache/siderping.txt")&&(!empty(file_get_contents("txtcache/siderping.txt"))) ) { $i = true; } 
}   
if($fis =='likehot'){  
  if(file_exists("txtcache/likehot.txt")&&(!empty(file_get_contents("txtcache/likehot.txt"))) ) { $i = true; } 
}    

 return $i;  
  
}

/**
* 缓存输出
*/
function fosmember(){
    $html='';
    $fileshot = "txtcache/pagemember.txt";  
    if(file_exists($fileshot)) {//判断文件 是否存在       
    $txtcache = file_get_contents($fileshot);  
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache); 
    $viphonor = '/usr/themes/spimes/images/authen.svg';
    $i =1;
    $siteUrl = Helper::options()->siteUrl;  
    if(Helper::options()->rewrite==0){  $siteUrl = $siteUrl.'index.php/'; }   
    foreach($arrmess as $m) {
    if($i<=5){  
    
    list($i,$user_name,$user_img,$user_allpostnum,$user_commentnum,$user_allviewnum,$user_tximg1,$user_tximg2,$user_tximg3,$user_txlink1,$user_txlink2,$user_txlink3) = explode("|", $m); 
    $user_intro=reintro($i);
    $html=$html.'<li><div class="item"><div class="hunter-avatar author-infos" data-id="'.$i.'"><a href="'.$siteUrl.'author/'.$i.'"><div class="vatar"><img src="' . $user_img . '"><img class="va_v_honor" src="'.$viphonor.'" title="认证用户"></div></a>
        	<div class="author-info-card">
					   <!--作者卡片-->
                       <!--作者卡片-->
					</div>
        </div><div class="item-main"><div class="work">' . $user_name . ' <span>文章 '.$user_allpostnum.' 篇</span><div class="work_desc">' . $user_intro . '  </div></div></div></li>  ';
    } 
    }    
    echo $html;      
    }
}

/**
* 点赞最多
*/
function foslikehot(){
    $html='';
    $fileshot = "txtcache/likehot.txt";  
    if(file_exists($fileshot)) {//判断文件 是否存在       
    $txtcache = file_get_contents($fileshot);  
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache); 
    $viphonor = '/usr/themes/spimes/images/authen.svg';
    $i =1;
    $siteUrl = Helper::options()->siteUrl;  
    if(Helper::options()->rewrite==0){  $siteUrl = $siteUrl.'index.php/'; }   
    foreach($arrmess as $m) {
    if($i<=5){  
    list($pid,$imgUrl,$title,$link, $pic ,$likes, $time,$i,$view) = explode("|||", $m);  
    $pic=stcdnimg($pic);
    $html=$html.'<div class="box-top"><a href="' .$link. '"><div class="box-img" style="background-image:url(' .$pic. ');"></div></a><div class="box-avatar"><div class="box-avatar-left author-infos" data-id="' .$pid. '"><img class="rounded-circle" src="' .$imgUrl. '" width="40px" height="40px"><div class="author-info-card"></div></div><div class="box-avatar-right"><span><a href="' .$link. '">' .$title. '</a></span></div></div></div><div class="widget-box-intro"><i class="icon iconfont icon-dianzan1"></i> '.$likes.'赞，<i class="icon iconfont icon-remen"></i> 阅读：'.$view.'</div>';
    } 
    }    
    echo $html;      
    }
}


function fopagemember(){
    $html='';
    $fileshot = "txtcache/pagemember.txt";  
    if(file_exists($fileshot)) {//判断文件 是否存在       
    $txtcache = file_get_contents($fileshot);  
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache); 
    $viphonor = '/usr/themes/spimes/images/authen.svg';
    $siteUrl = Helper::options()->siteUrl;  
    if(Helper::options()->rewrite==0){  $siteUrl = $siteUrl.'index.php/'; } 
    foreach($arrmess as $m) {

    list($i,$user_name,$user_img,$user_allpostnum,$user_commentnum,$user_allviewnum,$user_tximg1,$user_txlink1,$user_tximg2,$user_txlink2,$user_tximg3,$user_txlink3) = explode("|", $m);  
    
    if($user_txlink1 ==null){ $user_txlink1 =$siteUrl.'author/'.$i; $user_tximg1 = "/usr/themes/spimes/images/thumbs/adimg.png";  }
    
    if($user_txlink2 ==null){ $user_txlink2 =$siteUrl.'author/'.$i; $user_tximg2 = "/usr/themes/spimes/images/thumbs/adimg.png";  }
    else{  $user_tximg2=stcdnimg($user_tximg2); }
    
    if($user_txlink3 ==null){ $user_txlink3 =$siteUrl.'author/'.$i; $user_tximg3 = "/usr/themes/spimes/images/thumbs/adimg.png";  }
    else{  $user_tximg3=stcdnimg($user_tximg3); }
    
    $user_tximg1=stcdnimg($user_tximg1);
    $user_intro=reintro($i);

    $html=$html.'<article class="nercontt"> <div class="ner-container author-infos" data-id="'.$i.'"> <a class="avatar" href="'.$siteUrl.'author/'.$i.'"><img src="'.$user_img.'" srcset="'.$user_img.'" height="60" width="60"></a> <div class="ner_v_honor"><img src="'.$viphonor.'" title="认证用户"></div>
        <div class="author-info-card">
					   <!--作者卡片-->
                       <!--作者卡片-->
		</div>
        </div> <div class="ner-info">  <p class="ner-info-title"> <a href="'.$siteUrl.'author/'.$i.'"  target="_blank" class="title-content" z-st="user_content_card_1_user_name">'.$user_name.'</a> </p> <div class="info-num "> <div class="work"> <span> 文章 '.$user_allpostnum.'篇</span>   <i></i> <span> 评论 '.$user_commentnum.'次 </span> </div> </div> <div class="signature"> <p>'.$user_intro.' </p> </div> </div> <div class="work-show"> <ul class="work-con-box"> <li class="work-show-item"><div class="feaimg"><a class="block-fea" href="'.$user_txlink1.'"  style="background-image: url('.$user_tximg1.');"></a></div></li><li class="work-show-item"><div class="feaimg"><a class="block-fea" href="'.$user_txlink2.'"  style="background-image: url('.$user_tximg2.');"></a></div></li><li class="work-show-item"><div class="feaimg"><a class="block-fea" href="'.$user_txlink3.'"  style="background-image: url('.$user_tximg3.');"></a></div></li> </ul> </div> </article> ';  
    }    
    echo $html;      
    }
}

function foDatahot(){
    $html='';
    $fileshot = "txtcache/hot.txt";  
    if(file_exists($fileshot)) {//判断文件 是否存在       
    $txtcache = file_get_contents($fileshot);  
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache);  
    foreach($arrmess as $m) {
    list($title,$link, $pic ,$view,$time,$i) = explode("&", $m); 
    $pic=stcdnimg($pic);
    $html=$html.'<div class="py-2"><div class="ricon_rank rank'.$i.'">'.$i.'</div><div class="list-item list-overlay-content"><div class="media media-2x1"><a class="media-content" href="'.$link.'"  style="background-image:url('.$pic.');"><span class="overlay"></span></a></div><div class="list-content"><div class="list-body"><a href="'.$link.'" class="list-title h-2x">'.$title.'</a></div><div class="list-footer"><div class="text-muted text-xs">'.$view.' 阅读 ，<time class="d-inline-block">'.$time.'</time></div></div></div></div></div>'; 
    }    
    echo $html;      
    }
}
function fosping(){
    $html='';
    $fileshot = "txtcache/siderping.txt";  
    if(file_exists($fileshot)) {//判断文件 是否存在       
    $txtcache = file_get_contents($fileshot);  
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache);  
    foreach($arrmess as $m) {
    list($title,$link, $pnum) = explode("|", $m); 
    $html=$html.'<li><div class="widget-posts-text"><a class="widget-posts-title" href="' .$link. '" title="' .$title. '"><i class="icon iconfont icon-icon-test29"></i>' .$title. '</a><div class="widget-posts-meta"><i>' . $pnum . ' 评论</i></div></div></li>'; 
    }    
    echo $html;      
    }
}
function fopagehot(){
    $html='';
    $filephot = "txtcache/pagehot.txt";  
    if(file_exists($filephot)) {//判断文件 是否存在       
    $txtcache = file_get_contents($filephot);  
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache);  
    foreach($arrmess as $m) {
    list($title,$link, $pic,$tdesc,$aid,$aimg,$user,$created,$view,$pnum,$i) = explode("|", $m);  
    $pic=stcdnimg($pic);
    $html=$html.' <article class="post-list contt blockimg"><div class="entry-container"><div class="block-image feaimg"><a class="block-fea" href="'.$link.'"  style="background-image: url('.$pic.');"></a><div class="entyr-icon"><i class="icon iconfont icon-paihangbang"></i></div></div><header class="entry-header"><span class="entry-title"><a href="'.$link.'">'.$title.'</a></span></header><div class="entry-summary ss"><p>'.$tdesc.'</p></div><div class="entry-meta"><a href="/index.php/author/'.$aid.'" ><img src="'.$aimg.'" class="avatar avatar-140 photo" height="25" width="25">'.$user.'</a><span class="separator">/</span><time datetime="'.$created.'">'.$created.'</time><span class="separator">/</span>'.$view.' 阅读<span class="separator">/</span>'.$pnum.' 评论 </div><div class="top-num top-'.$i.'"><span><i> NO.'.$i.'</i></span></div></div></article>';        
    }        
    echo $html;      
    }
}
function foliehot(){
    $html='';
    $filelhot = "txtcache/sequhot.txt";  
    if(file_exists($filelhot)) {//判断文件 是否存在       
    $txtcache = file_get_contents($filelhot);  
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache);  
    foreach($arrmess as $m) {
    list($title,$link, $pic ,$view, $time) = explode("&", $m); 
    $pic=stcdnimg($pic);
    $html=$html.' <li class="aui-slide-item-item"><a class="sle_i" href="'.$link.'" ><img class="scrollLoading" data-url="'.$pic.'" src="/usr/themes/spimes/images/pixel.gif" alt=""><div class="picsum-icon"><i class="icon iconfont icon-yanjing"></i> '.$view.'</div><h2>'.$title.'</h2></a></li>';
    }        
    echo $html;      
    }
}
/**
* 是否开启加速更换CDN域名功能
*/
function stcdn($i) {
   $cdnopen = Helper::options()->cdnopen;
   $cdnurla = Helper::options()->cdnurla;
   $cdnurlb = Helper::options()->cdnurlb; 
   if ($cdnopen == '0'){
   $i = $i;
   return $i;
   }else {
   $i = str_replace($cdnurla,$cdnurlb,$i);
   return $i;
   } 
}

/**
* 是否开启加速更换CDN域名功能(正文)
*/
function stcdnimg($i) {
   $cdnopen = Helper::options()->cdnopen;
   $cdnurla = Helper::options()->cdnurla;
   $cdnurlb = Helper::options()->cdnurlb; 
   $imageView = Helper::options()->imageView;
   if ($cdnopen == '0'){
   $i = $i;
   return $i;
   }else {
   $i = str_replace($cdnurla,$cdnurlb,$i);
   return $i.$imageView;  
   } 
}



/**
* 评论者主页链接新窗口打开
* 调用<?php CommentAuthor($comments); ?>
*/
function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL) {    //后两个参数是原生函数自带的，为了保持原生属性，我并没有删除，原版保留
    $options = Helper::options();
    $autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;    //原生参数，控制输出链接（开关而已）
    $noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;    //原生参数，控制输出链接额外属性（也是开关而已...）
    if ($obj->url && $autoLink) {
        echo '<a href="'.$obj->url.'"'.($noFollow ? ' rel="external nofollow"' : NULL).(strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"').'>'.$obj->author.'</a>';
    } else {
        echo $obj->author;
    }
}

/** 输出文章缩略图 */
function showThumbnail($widget,$imgnum){ //获取两个参数，文章的ID和需要显示的图片数量
    // 当文章无图片时的默认缩略图
    $rand = rand(1,20); 
    $random = $widget->widget('Widget_Options')->themeUrl . '/images/thumbs/adimg.png'; // 缩略图路径
    $attach = $widget->attachments(1)->attachment;
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i'; 
    $patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|png))/i';
    $patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|png))/i';
    //如果文章内有插图，则调用插图
    if (preg_match_all($pattern, $widget->content, $thumbUrl)) { 
        return $thumbUrl[1][$imgnum];
    }    
    //如果是内联式markdown格式的图片
    else if (preg_match_all($patternMD, $widget->content, $thumbUrl)) {
        return $thumbUrl[1][$imgnum];
    }
    //如果是脚注式markdown格式的图片
    else if (preg_match_all($patternMDfoot, $widget->content, $thumbUrl)) {
        return $thumbUrl[1][$imgnum];
    }
    //没有就调用第一个图片附件
    else if ($attach && $attach->isImage) {
        return $attach->url; 
    } 
    //如果真的没有图片，就调用一张随机图片
    else{
        if($imgnum==-1){
        return false;
        }
        else{  return $random; }
    }
}

/** 处理文章缩略图 */
function Thumbnail($contx,$imgnum){ 
  
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i'; 
    $patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|png))/i';
    $patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|png))/i';
    //如果文章内有插图，则调用插图
    if (preg_match_all($pattern, $contx, $thumbUrl)) { 
        return $thumbUrl[1][$imgnum];
    }    
    //如果是内联式markdown格式的图片
    else if (preg_match_all($patternMD, $contx, $thumbUrl)) {
        return $thumbUrl[1][$imgnum];
    }
    //如果是脚注式markdown格式的图片
    else if (preg_match_all($patternMDfoot, $contx, $thumbUrl)) {
        return $thumbUrl[1][$imgnum];
    }

    //如果真的没有图片，就调用一张随机图片
    else{
        $adimg = "/usr/themes/spimes/images/thumbs/adimg.png"; // 缩略图路径
        return $adimg;
    }

}



/* 解析头像 */
function getGravatar($mail, $re = 0, $id = 0)
{
    $a = Typecho_Widget::widget('Widget_Options')->JGravatars;
    $b = 'https://' . $a . '/';
    $c = strtolower($mail); //转为小写
    $d = md5($c);
    $f = str_replace('@qq.com', '', $c);
    if (strstr($c, "qq.com") && is_numeric($f) && strlen($f) < 11 && strlen($f) > 4) {
        $g = '//thirdqq.qlogo.cn/g?b=qq&nk=' . $f . '&s=100';
        if ($id > 0) {
        $g = Helper::options()->rootUrl . '?id=' . $id . '" data-type="qqtx';
        }
    } else {
        $g = $b . $d . '?d=mm';
    }
    if ($re == 1) {
        return $g;
    } else {
        return $g;
    }
}


//jQuery动态生成字母头像
function gtxtname($name){
    
  $n = $name;    
    
  ?>
  
   <script type="text/javascript">
//开始处理
//名字
name = <?php $n; ?>" || '';
//图像大小
size = 60;

color = "#9b59b6";

//背景颜色
var colours = [
"#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
"#f1c40f", "#e67e22", "#e74c3c", "#00bcd4", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"
],
nameSplit = String(name).split(' '),
initials, charIndex, colourIndex, canvas, context, dataURI;
if (nameSplit.length == 1) {
initials = nameSplit[0] ? nameSplit[0].charAt(0) : '?';
} else {
initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
}
//上面对名字进行一系列处理，下面找到绘图元素
var canvas = document.getElementById('headImg');
charIndex = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
colourIndex = charIndex % 20;
//图像大小
canvas.width = size;
canvas.height = size;
context = canvas.getContext("2d");
//图像背景颜色
context.fillStyle = color ? color : colours[colourIndex - 1];
context.fillRect(0, 0, canvas.width, canvas.height);
//字体大小
context.font = Math.round(canvas.width / 2) + "px 'Microsoft Yahei'";
context.textAlign = "center";
//字体颜色
context.fillStyle = "#FFF";

context.fillText(initials, size / 2, size / 1.5);
//显示图像
$(this).attr('src', canvas.toDataURL("image/png"));
//开始处理
</script>

<?php

}

//文章目录
function createCatalog($obj) {    //为文章标题添加锚点
    global $catalog;
    global $catalog_count;
    $catalog = array();
    $catalog_count = 0;
    $obj = preg_replace_callback('/<h([2])(.*?)>(.*?)<\/h\1>/i', function($obj) {
        global $catalog;
        global $catalog_count;
        $catalog_count ++;
        $catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
        return '<h'.$obj[1].$obj[2].'><a name="cl-'.$catalog_count.'"></a>'.$obj[3].'</h'.$obj[1].'>';
    }, $obj);
    return $obj;
}

function getCatalog() {    //输出文章目录容器
    global $catalog;
    $index = '';
    if ($catalog) {
        $index = '<ul>'."\n";
        $prev_depth = '';
        $to_depth = 0;
        foreach($catalog as $catalog_item) {
            $catalog_depth = $catalog_item['depth'];
            if ($prev_depth) {
                if ($catalog_depth == $prev_depth) {
                    $index .= '</li>'."\n";
                } elseif ($catalog_depth > $prev_depth) {
                    $to_depth++;
                    $index .= '<ul>'."\n";
                } else {
                    $to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
                    if ($to_depth2) {
                        for ($i=0; $i<$to_depth2; $i++) {
                            $index .= '</li>'."\n".'</ul>'."\n";
                            $to_depth--;
                        }
                    }
                    $index .= '</li>';
                }
            }
            $index .= '<li><a href="#cl-'.$catalog_item['count'].'">'.$catalog_item['text'].'</a>';
            $prev_depth = $catalog_item['depth'];
        }
        for ($i=0; $i<=$to_depth; $i++) {
            $index .= '</li>'."\n".'</ul>'."\n";
        }
    $index = '<div id="mArticle" class="article_click">'."\n".'<span class="icon iconfont icon-icon-test25" style="cursor:pointer"></span>'."\n".'<div class="fn_article_nav">'."\n".'<div class="toc-arrow"></div>'."\n".'<div class="toc">'."\n".$index.'</div>'."\n".'</div>'."\n".'</div>';
    }
    echo $index;
}


//搜索 - 热门文章
function sosoViewed($limit = 4, $before = '<br/> - ( views: ', $after = ' times ) ')
    {
        
        $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 4;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('views', Typecho_Db::SORT_DESC)
                 ->limit($limit)
                 );
        $i = 1;       
                 
        if ($posts) {
            foreach ($posts as $post) {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                $post_views = convert($result['views']);  
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
				$created = date('m-d', $result['created']); 
				$post_title = mb_strlen($post_title, 'utf-8') > 25 ? mb_substr($post_title, 0, 25, 'utf-8').'....' : $post_title; //格式化内容
                    echo '<li><a href="' .$permalink. '"><span class="rank ran'.$i.'">'.$i.'</span> ' .$post_title. ' <i class="view">'.$post_views.' 阅读</i></a></li>';  
                    $i++;
			 }
        } else {
          echo "<li>N/A</li>\n";
        }
}




//热门访问量文章
function theMostViewed($limit = 4, $before = '<br/> - ( views: ', $after = ' times ) ')
    {
        $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 4;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('views', Typecho_Db::SORT_DESC)
                 ->limit($limit)
                 );
        if ($posts) {
            foreach ($posts as $post) {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                $post_views = convert($result['views']);  
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
				$created = date('m-d', $result['created']);            
			    $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$result['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($result['text'],0);
						}                        						 
					}									
					// var_dump($img);
					// if($img == ""){
					// 	$img = "wu";
					// }                           
                $str = stcdnimg($img); 
                echo "<div class='py-2'><div class='list-item list-overlay-content'><div class='media media-2x1'><a class='media-content' href='$permalink'  style='background-image:url(";
                print_r($str);
                echo ");'><span class='overlay'></span></a></div><div class='list-content'><div class='list-body'><a href='$permalink' class='list-title h-2x'>$post_title</a></div><div class='list-footer'><div class='text-muted text-xs'>$post_views 阅读 ，<time class='d-inline-block'>$created</time></div></div></div></div></div>";
			 }
        } else {
          echo "<li>N/A</li>\n";
        }
}

//热门列表页
function hotlistViewed($limit = 12, $before = '<br/> - ( views: ', $after = ' times ) ')
    {
        $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 5;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('views', Typecho_Db::SORT_DESC)
                 ->limit($limit)
                 );
        if ($posts) {
			    $i=1;
            foreach ($posts as $post) {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                $post_views = convert($result['views']);  
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
				$created = date('m-d', $result['created']);
				$pnum = $result['commentsNum'];
                $pdid = $result['authorId'];
				$auinfo =  $db->fetchAll($db->select()->from('table.users')->where('uid = ?',$pdid));
				if(count($auinfo) !=''){
						//var_dump($img);
						$mail=$auinfo['0']['mail'];					
                        $imgUrl = getGravatar($mail);
						$author= $auinfo['0']['screenName'];
					}            
			    $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$result['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($result['text'],0);
						}                        						 
					}	              
                $tdescs =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','tdesc',$result['cid']));
					if(count($tdescs) !=0){
						//var_dump($img);
						$tdesc=$tdescs['0']['str_value'];						
                        if($tdesc){}
						else{     
                          $post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($result['text'])); //获取内容
                         $tdesc = mb_strlen($post_text, 'utf-8') > 80 ? mb_substr($post_text, 0, 80, 'utf-8').'....' : $post_text; //格式化内容
						}                        						 
					}
            else{    $post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($result['text'])); //获取内容
$tdesc = mb_strlen($post_text, 'utf-8') > 80 ? mb_substr($post_text, 0, 80, 'utf-8').'....' : $post_text; //格式化内容
                } 
                

                echo ' <article class="post-list contt blockimg"><div class="entry-container"><div class="block-image feaimg"><a class="block-fea" href="'.$permalink.'"  style="background-image: url('.$img.');"></a>
					<div class="entyr-icon"><i class="icon iconfont icon-paihangbang"></i></div></div>
                    <header class="entry-header"><span class="entry-title"><a href="'.$permalink.'">'.$post_title.'</a></span></header>
                    <div class="entry-summary ss"><p>'.$tdesc.'</p></div><div class="entry-meta"><a href="/index.php/author/'.$result['authorId'].'" ><img src="'.$imgUrl.'" class="avatar avatar-140 photo" height="25" width="25">'.$author.'</a><span class="separator">/</span><time datetime="'.$created.'">'.$created.'</time><span class="separator">/</span>'.$post_views.' 阅读<span class="separator">/</span>'.$pnum.' 评论 </div>
					<div class="top-num top-'.$i.'"><span><i> NO.'.$i.'</i></span></div></div></article>';
                    $i += 1;
			}
        } else {
            echo "<li>N/A</li>\n";
        }
}



//热门评论文章
function getHotPosts($limit = 10){
    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
        ->limit($limit)
        ->order('commentsNum', Typecho_Db::SORT_DESC)
    );
    if($result){
            $i=1;
        foreach($result as $val){ 
            $img_url="";
            $wu_url="/usr/themes/spimes/images/dian2.png";
            $mails =  $db->fetchAll($db->select()->from('table.comments')->where('cid = ?',$val['cid'])->limit(6)->order('created', Typecho_Db::SORT_DESC) );
			if($mails && $i<=2){	
              foreach($mails as $avimg){                 
               $imgUrl = getGravatar($avimg['mail']);
            $img_url=$img_url.'<img data-url="'.$imgUrl.'" src="'.$wu_url.'" class="avatar avatar-140 photo sider_pimg scrollLoading" height="25" title="'.$avimg['author'].'">';                 
              }
            $img_url=$img_url.'<img src="'.$wu_url.'" class="avatar avatar-140 photo sider_pimg" height="25">';
            }
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $post_title = htmlspecialchars($val['title']);
            $permalink = $val['permalink'];
            echo '<li class="c_li"><div class="widget-posts-text"><a class="widget-posts-title" href="' .$permalink. '" title="' .$post_title. '"><span class="hotge hotge'.$i.'">'.$i.'</span>' .$post_title. '</a><div class="widget-posts-meta"><i>' . $val['commentsNum'] . ' 评论</i></div></div></li>'.$img_url.'';  
            $i += 1;
          
        }}}

/**
* 显示下一篇
*
* @access public
* @param string $default 如果没有下一篇,显示的默认文字
* @return void
*/
function theNext($widget, $default = NULL)
{
$db = Typecho_Db::get();
$sql = $db->select()->from('table.contents')
->where('table.contents.created > ?', $widget->created)
->where('table.contents.status = ?', 'publish')
->where('table.contents.type = ?', $widget->type)
->where('table.contents.password IS NULL')
->order('table.contents.created', Typecho_Db::SORT_ASC)
->limit(1);
$content = $db->fetchRow($sql);
if ($content) {
 $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$content['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                         $img="/usr/themes/spimes/images/thumbs/adimg.png";
						}                        						 
					}									
$strimg = stcdnimg($img); 
$content = $widget->filter($content);
echo '<div class="entry-page-next j-lazy" style="background-image: url(';
print_r($strimg);
echo ')"><a href="' . $content['permalink'] . '"><span>' . $content['title'] . '</span> </a><div class="entry-page-info"> <span class="pull-right">下一篇  »</span> <span class="pull-left">' . date('m-d', $content['created']) . '</span></div></div>';
} else { echo $default; }}

/**
* 显示上一篇
*
* @access public
* @param string $default 如果没有下一篇,显示的默认文字
* @return void
*/
function thePrev($widget, $default = NULL)
{
$db = Typecho_Db::get();
$sql = $db->select()->from('table.contents')
->where('table.contents.created < ?', $widget->created)
->where('table.contents.status = ?', 'publish')
->where('table.contents.type = ?', $widget->type)
->where('table.contents.password IS NULL')
->order('table.contents.created', Typecho_Db::SORT_DESC)
->limit(1);
$content = $db->fetchRow($sql);
if ($content) {
 $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$content['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                         $img="/usr/themes/spimes/images/thumbs/adimg.png";
						}                        						 
					}									
$strimg = stcdnimg($img);    
$content = $widget->filter($content);
echo '<div class="entry-page-prev j-lazy" style="background-image: url(';
print_r($strimg);
echo ')"><a href="' . $content['permalink'] . '"> <span>' . $content['title'] . '</span> </a><div class="entry-page-info"> <span class="pull-left">« 上一篇</span> <span class="pull-right">' . date('m-d', $content['created']) .'</span></div></div>';
}   
else {
echo $default;
}}



function autlist($i){
    $db=Typecho_Db::get();
    $mail=$db->fetchAll($db->select(array('COUNT(cid)'=>'rbq'))->from('table.comments')->where('mail = ?', $i)/**->where('authorId = ?','0')**/);
    foreach ($mail as $sl){
    $rbq=$sl['rbq'];}
    if($rbq<1){
    echo '<span class="utitle_v">'.$rbq.'</span>';
    }elseif ($rbq<10 && $rbq>0) {
    echo '<span class="utitle_lv1">'.$rbq.'</span>';
    }elseif ($rbq<20 && $rbq>=10) {
    echo '<span class="utitle_lv2">'.$rbq.'</span>';
    }elseif ($rbq<40 && $rbq>=20) {
    echo '<span class="utitle_lv3">'.$rbq.'</span>';
    }elseif ($rbq<80 && $rbq>=40) {
    echo '<span class="utitle_lv4">'.$rbq.'</span>';
    }elseif ($rbq<100 && $rbq>=80) {
    echo '<span class="utitle_lv5">'.$rbq.'</span>';
    }elseif ($rbq>=100) {
    echo '<span class="utitle_lv6">'.$rbq.'</span>';
    }
}
/**
* 首页随机文章
*/
function getRandomindex($random=5){
    $db = Typecho_Db::get();
    $adapterName = $db->getAdapterName();//兼容非MySQL数据库
    if($adapterName == 'pgsql' || $adapterName == 'Pdo_Pgsql' || $adapterName == 'Pdo_SQLite' || $adapterName == 'SQLite'){
        $order_by = 'RANDOM()';
    }else{
        $order_by = 'RAND()';
    }
    $sql = $db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('table.contents.created <= ?', time())
        ->where('type = ?', 'post')
        ->limit($random)
        ->order($order_by);

$result = $db->fetchAll($sql);
if($result){
    foreach($result as $val){
        $obj = Typecho_Widget::widget('Widget_Abstract_Contents');
        $val = $obj->push($val);
        $post_title = htmlspecialchars($val['title']);
        $permalink = $val['permalink'];
		$created = date('m-d', $val['created']);
		$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                         $img=showThumbnail($obj,0);
						}                        						 
					}

            $strimg = stcdnimg($img);   
            $limg="/usr/themes/spimes/images/pixel.gif";
            if ($strimg){$strimg=$strimg;}else{$strimg = "/usr/themes/spimes/images/thumbs/adimg.png";}
 


      echo '<li class="aui-slide-item-item"><a class="sle_i" href="'.$permalink.'" ><img class="scrollLoading" data-url="'.$strimg.'" src="'.$limg.'" alt=""><h2>'.$post_title.'</h2></a></li>';


    }
}
}

/**
* 随机文章
*/
function getRandomPosts($random=5){
    $db = Typecho_Db::get();
    $adapterName = $db->getAdapterName();//兼容非MySQL数据库
    if($adapterName == 'pgsql' || $adapterName == 'Pdo_Pgsql' || $adapterName == 'Pdo_SQLite' || $adapterName == 'SQLite'){
        $order_by = 'RANDOM()';
    }else{
        $order_by = 'RAND()';
    }
    $sql = $db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('table.contents.created <= ?', time())
        ->where('type = ?', 'post')
        ->limit($random)
        ->order($order_by);

$result = $db->fetchAll($sql);
if($result){
    foreach($result as $val){
        $obj = Typecho_Widget::widget('Widget_Abstract_Contents');
        $val = $obj->push($val);
        $post_title = htmlspecialchars($val['title']);
        $permalink = $val['permalink'];
		$created = date('m-d', $val['created']);
		$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                         $img=showThumbnail($obj,0);
						}                        						 
					}

            $strimg = stcdnimg($img);   
            if ($strimg){$strimg=$strimg;}else{$strimg = "/usr/themes/spimes/images/thumbs/adimg.png";}
        echo '<div class="item"><div class="hunter-item"><a href="'.$permalink.'"><div class="hunter-thumb"><i class="thumb " style="background-image:url(';
print_r($strimg);
echo ')"></i></div><h2>'.$post_title.'</h2><!--<h4><span class="hunter-tag btn btn-default">' . $val['commentsNum'] .' 评论</span> <span class="hunter-product">'.$created.'</span></h4>--></a></div></div>';
    }
}
}

/** 会员列表中输出作者最近文章列表带图 */
function nerPosts($authorid){
    if($authorid){ 
        $limit = 3;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$authorid)
            ->where('status = ?','publish')
            ->where('type = ?', 'post')
            ->limit($limit)
            //->order('created', Typecho_Db::SORT_DESC)  
            
        );
        if($result){
            foreach($result as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
				$commentsNum = $val['commentsNum'];
				$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                         $img='/usr/themes/spimes/images/thumbs/adimg.png';
						}                        						 
					}
                $strimg = stcdnimg($img);   
                $html= $html.'<li class="work-show-item"><div class="feaimg"><a class="block-fea" href="'.$permalink.'" title="'.$post_title.'" style="background-image: url('.$strimg.');"></a></div></li>';				
            }
        }
        else{ $html='暂无相关信息'; }
    }else{
        
    }
    return $html;
}


// 生成地图
function getxml(){

        $doc = new \DOMDocument('1.0','utf-8');//引入类并且规定版本编码
        $urlset = $doc->createElement("urlset");//创建节点 
        
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
        ->limit(100)
        ->order('created', Typecho_Db::SORT_DESC)
        );
        if($result){
        foreach($result as $val){            
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $permalink = $val['permalink'];
            $created = date('Y-m-d', $val['created']);   
                
        /*循环输出节点*/        
        $url = $doc->createElement("url");//创建节点  
		$loc = $doc->createElement("loc");//创建节点
		$lastmod = $doc->createElement("lastmod");//创建节点
		$urlset->appendChild($url);//
        $url->appendChild($loc);//讲loc放到url下
		$url->appendChild($lastmod );
        $content = $doc -> createTextNode($permalink);//设置标签内容
        $contime = $doc -> createTextNode($created);//设置标签内容
        $loc  -> appendChild($content);//将标签内容赋给标签
		$lastmod  -> appendChild($contime);//将标签内容赋给标签    
        
        }}

        $doc->appendChild($urlset);//创建顶级节点
        $doc->save("./../sitemap.xml");//保存代码
        echo "<script>alert('地图生成')</script>";
}



// 添加OwO表情
function parsePaopaoBiaoqingCallback($match)
    {
        return '<img class="biaoqing" src="/usr/themes/spimes/owo/img/paopao/'. str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }
function parseAruBiaoqingCallback($match)
    {
        return '<img class="biaoqing" src="/usr/themes/spimes/owo/img/aru/'. str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }
function parseQuyinBiaoqingCallback($match)
    {
        return '<img class="biaoqing" src="/usr/themes/spimes/owo/img/quyin/'. str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }
function parseadaiBiaoqingCallback($match)
    {
        return '<img class="biaoqing" src="/usr/themes/spimes/owo/img/adai/'. str_replace('%', '', urlencode($match[1])) . '.gif">';
    }

function parseBiaoQing($content)
    {
        $content = preg_replace_callback('/\:\:\(\s*(呵呵|哈哈|吐舌|惊恐|酷|发飙|嗯哼|流汗|大哭|尴尬|黑脸|超赞|金钱|疑问|尬脸|吐|哦豁|委屈|眯眼笑|哟嚯|超开心|滑稽|眨眼|羡慕|入眠|惊哭|气呼呼|震惊|喷水|爱心|心碎|玫瑰|礼物|咖啡|OK|小无奈|偷笑|坏笑|卧槽|要死|亚麻跌|笑哭了|犀利|理一下|坐端正|完美|吃瓜|摊手|困狗|靠墙看|发现|饮酒|忍笑|警告|炸黑|滑稽汗|打脸|胖次|低看)\s*\)/is',
'parsePaopaoBiaoqingCallback', $content);

		$content = preg_replace_callback('/\:\*\(\s*(愤怒|装酷|委屈|鄙视|尴尬|魔鬼|惊恐|亲亲|喜欢|猪头|抠鼻|伤心|吃惊|微笑|邪笑|失落|冒汗|闭嘴)\s*\)/is',
'parseadaiBiaoqingCallback', $content);

        $content = preg_replace_callback('/\:\@\(\s*(发火|羡慕|吐血倒地|吐血|抱抱|鼓掌|呆滞|流泪|嫌疑|灵魂出窍|囧|惊慌|流口水|送花花|不高兴|阴险|捅死你|暗中观察|哲学思考|无奈|嘟嘴|大佬|闭嘴|害羞|脸红|黑线|举白旗|赞|吐舌头)\s*\)/is',
'parseAruBiaoqingCallback', $content);

		$content = preg_replace_callback('/\:\&\(\s*(蛆音滑稽|蛆音震惊|蛆音生气|蛆音吓哭|蛆音血躺|蛆音疑惑|蛆音捡肥皂|蛆音捂脸|蛆音吐血石化|蛆音哼气|蛆音大笑|蛆音偷看|蛆音卖萌|蛆音好的|蛆音惊吓|蛆音摇头|蛆音睡觉|蛆音无语|蛆音吃瓜|蛆音自恋)\s*\)/is',
'parseQuyinBiaoqingCallback', $content);
        return $content;
}




/**输出点赞数*/
function zannum($archive){
    $db = Typecho_Db::get();
    $cid = $archive->cid;
    $exist = 0;
    $prefix = $db->getPrefix();
    //  判断点赞数量字段是否存在
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }
    if (array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {   
    $exist = $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $cid))['agree'];
    }
    echo $exist == 0 ? '0 ' : $exist.'';
}

/**点赞**/

function agreeNum($cid) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    //  判断点赞数量字段是否存在
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }

    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    //  获取记录点赞的 Cookie
    $AgreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断记录点赞的 Cookie 是否存在
    if (empty($AgreeRecording)) {
        //  如果不存在就写入 Cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array(0)));
    }

    //  返回
    return array(
        //  点赞数量
        'agree' => $agree['agree'],
        //  文章是否点赞过
        'recording' => in_array($cid, json_decode(Typecho_Cookie::get('typechoAgreeRecording')))?true:false
    );
}

function agree($cid) {
    $db = Typecho_Db::get();
    //  根据文章的 `cid` 查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));

    //  获取点赞记录的 Cookie
    $agreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    //  判断 Cookie 是否存在
    if (empty($agreeRecording)) {
        //  如果 cookie 不存在就创建 cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array($cid)));
    }else {
        //  把 Cookie 的 JSON 字符串转换为 PHP 对象
        $agreeRecording = json_decode($agreeRecording);
        //  判断文章是否点赞过
        if (in_array($cid, $agreeRecording)) {
            //  如果当前文章的 cid 在 cookie 中就返回文章的赞数，不再往下执行
            echo "<script> showMessage('已经点过赞了哦...',2000,true,'bounceInDown-hastrans','bounceOutDown-hastrans');</script>";
            return $agree['agree'];
        }
        //  添加点赞文章的 cid
        array_push($agreeRecording, $cid);
        
        echo "<script> showMessage('点赞+1',2000,true,'bounceInDown-hastrans','bounceOutDown-hastrans');</script>";
        //弹出点赞提示
        //  保存 Cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode($agreeRecording));
    }
    //  更新点赞字段，让点赞字段 +1
    $db->query($db->update('table.contents')->rows(array('agree' => (int)$agree['agree'] + 1))->where('cid = ?', $cid));
    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    //  返回点赞数量
    return $agree['agree'];
}



/** HTML压缩功能 */
function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}

/**
 * 文章内容替换为内链
 * @param $content
 * @return mixed
 */
function get_glo_keywords($content)
{   
	$settings = Helper::options()->Keywordspress;	
	$keywords_list = array();
	if (strpos($settings,'|')) {
			//解析关键词数组
			$kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
			foreach ($kwsets as $kwset) {
			$keywords_list[] = explode('|',$kwset);
			}
		}
	ksort($keywords_list);  //对关键词排序，短词排在前面
	
    if($keywords_list){
        $readnum = 0;
		$i = 0;
		$j = 1;
        foreach ($keywords_list as $key => $val) {
			
            $title = $val[$i];
            $len = strlen($title);
            $str = '<a href="'.$val[$j].'" target="_blank">'.$title.'</a>';
            $str_index = mb_strpos($content, $title);            
			$content = preg_replace('/(?!<[^>]*)'.$title.'(?![^<]*>)/',$str,$content,1); 
			
            if(is_numeric($str_index)){
                $readnum += 1;
            }
            if($readnum == 8) {
			return $content; //匹配到8个关键词就退出
			$i += 2;
            $j += 2;
            }
		}
    }
    return $content;
}



/**处理边栏快讯**/
function get_kuaixun()
{
    
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('authorId <> ?', '1')
        ->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
        ->limit(5)
        ->order('created', Typecho_Db::SORT_DESC)
        );
        
        if($result){
        foreach($result as $val){            
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $permalink = $val['permalink'];
            $created = date('Y-m-d', $val['created']);
            $post_title = htmlspecialchars($val['title']);
            $html = $html.'<li class="kx-item"> 
            <a class="kx-title" href="'.$permalink.'">'.$post_title.'</a><div class="kx-meta clearfix"> <span class="kx-time">'.$created.'</span>
            
            </div></li>';
        }}
    
        return '<div class="column-newsflash-vertiacl-line"></div>'.$html;
    
}

/**
 * 高级导航菜单
 */
function navtopinfo()
{
	$settings = Helper::options()->navtops;	
	$navtops_list = array();	
    $naslist = Helper::options()->naslist;	
	if (strpos($settings,'|')) {
			//解析关键词数组
			$kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
			foreach ($kwsets as $kwset) {
			$navtops_list[] = explode('|',$kwset);
			}
		}
	ksort($navtops_list);  //对关键词排序，短词排在前面	
    if($navtops_list){
        $readnum = 0;
		$i = 0;
		$j = 1;
		$z = 2;
        $y = 3;
        foreach ($navtops_list as $key => $val) {			
            $title = $val[$i]; 
               if($naslist == '0') {          
			   $str = '<li class="aui-down-menu-list-item aui-top-border">
                                            <a href="'.$val[$j].'">
                                                <p class="aui-down-menu-list-title">
                                                    <i class="icon iconfont icon-huatifuhao"></i>
                                                    '.$title.'
                                                </p>
                                                <p class="aui-down-menu-list-text">'.$val[$z].'</p>
                                            </a>
                                        </li>';	
               }
               else{  
                 $str = '<li class="nav-s"><a href="'.$val[$j].'" title="'.$val[$z].'"><i class="icon iconfont '.$val[$y].'"></i> '.$title.'</a></li>';	
                }          
                $readnum += 1;
				echo $str;
                //$content = substr_replace($content,$str,$str_index,$len);
                //$content = $this->str_replace_limit($title,$str,$content,$this->limit);          
            if($readnum == 12) {
			//匹配到12个退出
			$i += 4;
            $j += 4;
            $z += 4;
            $y += 4;
            }
		}
    }
}

/**
 * 幻灯片下方栏目pjax处理数组
 */
function navsecinfo()
{   
	$settings = Helper::options()->navsecs;	
	$navtops_list = array();
	if (strpos($settings,'|')) {
			//解析关键词数组
			$kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
			foreach ($kwsets as $kwset) {
			$navtops_list[] = explode('|',$kwset);
			}
		}
	ksort($navtops_list);  //对关键词排序，短词排在前面	
    if($navtops_list){
        $readnum = 0;
		$i = 0;
		$j = 1;		
        foreach ($navtops_list as $key => $val) {			
            $title = $val[$i]; 
            $str = '<li class="menu-item"><a data-post href="'.$val[$j].'"> '.$title.'</a></li> ';	            
                $readnum += 1;
				echo $str;
                //$content = substr_replace($content,$str,$str_index,$len);
                //$content = $this->str_replace_limit($title,$str,$content,$this->limit);
          
            if($readnum == 4) {
			//匹配到8个关键词就退出
			$i += 2;
            $j += 2;           
            }
		}
    }
}

// 获取浏览器信息
function getBrowser($agent)
{
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
        $outputer = '<i class="ua-icon icon-ie"></i>&nbsp;&nbsp;Internet Explore';
    } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Firefox/', $regs[0]);
$FireFox_vern = explode('.', $str1[1]);
        $outputer = '<i class="ua-icon icon-firefox"></i>&nbsp;&nbsp;FireFox';
    } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Maxthon/', $agent);
$Maxthon_vern = explode('.', $str1[1]);
        $outputer = '<i class="ua-icon icon-edge"></i>&nbsp;&nbsp;MicroSoft Edge';
    } else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
$outputer = '<i class="ua-icon icon-360"></i>&nbsp;&nbsp;360极速浏览器';
    } else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Edge/', $regs[0]);
$Edge_vern = explode('.', $str1[1]);
        $outputer = '<i class="ua-icon icon-edge"></i>&nbsp;&nbsp;MicroSoft Edge';
    } else if (preg_match('/UC/i', $agent)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = '<i class="ua-icon icon-uc"></i>&nbsp;&nbsp;UC浏览器';
    }  else if (preg_match('/QQ/i', $agent, $regs)||preg_match('/QQBrowser\/([^\s]+)/i', $agent, $regs)) {
                  $str1 = explode('rowser/',  $agent);
$QQ_vern = explode('.', $str1[1]);
        $outputer = '<i class= "ua-icon icon-qqq"></i>&nbsp;&nbsp;QQ浏览器';
    } else if (preg_match('/UBrowser/i', $agent, $regs)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = '<i class="ua-icon icon-uc"></i>&nbsp;&nbsp;UC浏览器';
    }  else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
        $outputer = '<i class= "ua-icon icon-opera"></i>&nbsp;&nbsp;Opera';
    } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
$str1 = explode('Chrome/', $agent);
$chrome_vern = explode('.', $str1[1]);
        $outputer = '<i class="ua-icon icon-chrome"></i>&nbsp;&nbsp;Chrome';
    } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
         $str1 = explode('Version/',  $agent);
$safari_vern = explode('.', $str1[1]);
        $outputer = '<i class="ua-icon icon-safari"></i>&nbsp;&nbsp;Safari';
    } else{
        $outputer = '<i class="ua-icon icon-chrome"></i>&nbsp;&nbsp;Google Chrome';
    }
    echo $outputer;
}
// 获取操作系统信息
function getOs($agent)
{
    $os = false;
 
    if (preg_match('/win/i', $agent)) {
        if (preg_match('/nt 6.0/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class= "ua-icon icon-win1"></i>&nbsp;&nbsp;Win Vista&nbsp;/&nbsp;';
        } else if (preg_match('/nt 6.1/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class= "ua-icon icon-win1"></i>&nbsp;&nbsp;Win 7&nbsp;/&nbsp;';
        } else if (preg_match('/nt 6.2/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class="ua-icon icon-win2"></i>&nbsp;&nbsp;Win 8&nbsp;/&nbsp;';
        } else if(preg_match('/nt 6.3/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class= "ua-icon icon-win2"></i>&nbsp;&nbsp;Win 8.1&nbsp;/&nbsp;';
        } else if(preg_match('/nt 5.1/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class="ua-icon icon-win1"></i>&nbsp;&nbsp;Win XP&nbsp;/&nbsp;';
        } else if (preg_match('/nt 10.0/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class="ua-icon icon-win2"></i>&nbsp;&nbsp;Win 10&nbsp;/&nbsp;';
        } else{
            $os = '&nbsp;&nbsp;<i class="ua-icon icon-win2"></i>&nbsp;&nbsp;Win X64&nbsp;/&nbsp;';
        }
    } else if (preg_match('/android/i', $agent)) {
    if (preg_match('/android 9/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class="ua-icon icon-android"></i>&nbsp;&nbsp;Android&nbsp;/&nbsp;';
        }
    else if (preg_match('/android 8/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class="ua-icon icon-android"></i>&nbsp;&nbsp;Android&nbsp;/&nbsp;';
        }
    else{
            $os = '&nbsp;&nbsp;<i class="ua-icon icon-android"></i>&nbsp;&nbsp;Android&nbsp;/&nbsp;';
    }
    }
    else if (preg_match('/ubuntu/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="ua-icon icon-ubuntu"></i>&nbsp;&nbsp;Ubuntu&nbsp;/&nbsp;';
    } else if (preg_match('/linux/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class= "ua-icon icon-linux"></i>&nbsp;&nbsp;Linux&nbsp;/&nbsp;';
    } else if (preg_match('/iPhone/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="ua-icon icon-apple"></i>&nbsp;&nbsp;iPhone&nbsp;/&nbsp;';
    } else if (preg_match('/mac/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="ua-icon icon-mac"></i>&nbsp;&nbsp;MacOS&nbsp;/&nbsp;';
    }else if (preg_match('/fusion/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="ua-icon icon-android"></i>&nbsp;&nbsp;Android&nbsp;/&nbsp;';
    } else {
        $os = '&nbsp;&nbsp;<i class="ua-icon icon-linux"></i>&nbsp;&nbsp;Linux&nbsp;/&nbsp;';
    }
    echo $os;
}

/**
 * 手机底部列表菜单
 */
function navmobis()
{   
	$settings = Helper::options()->navmobi;	
	$navtops_list = array();
	if (strpos($settings,'|')) {
			//解析关键词数组
			$kwsets = array_filter(preg_split("/(\r|\n|\r\n)/",$settings));
			foreach ($kwsets as $kwset) {
			$navtops_list[] = explode('|',$kwset);
			}
		}
	ksort($navtops_list);  //对关键词排序，短词排在前面	
    if($navtops_list){
        $readnum = 0;
		$i = 0;
		$j = 1;		
        foreach ($navtops_list as $key => $val) { 
         $str = '<div class="navigation-tab-item"><a data-pjax href="'.$val[$j].'"><span class="navigation-tab__icon"><i class="icon iconfont  '.$val[$i].'"></i></span></a></div>';            
                $readnum += 1;
				echo $str;
                //$content = substr_replace($content,$str,$str_index,$len);
                //$content = $this->str_replace_limit($title,$str,$content,$this->limit);          
            if($readnum == 4) {
			//匹配到8个关键词就退出
			$i += 2;
            $j += 2;           
            }
		}
    }
}

//获取评论的锚点链接
function get_comment_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent,status')->from('table.comments')
        ->where('coid = ?', $coid));//当前评论
    $mail = "";
    $parent = @$prow['parent'];
    if ($parent != "0") {//子评论
        $arow = $db->fetchRow($db->select('author,status,mail')->from('table.comments')
            ->where('coid = ?', $parent));//查询该条评论的父评论的信息
        @$author = @$arow['author'];//作者名称
        $mail = @$arow['mail'];
        if(@$author && $arow['status'] == "approved"){//父评论作者存在且父评论已经审核通过
            if (@$prow['status'] == "waiting"){
                echo '<p class="commentReview">（评论审核中）)</p>';
            }
            echo '<a href="#comment-' . $parent . '">@' . $author . '</a>';
        }else{//父评论作者不存在或者父评论没有审核通过
            if (@$prow['status'] == "waiting"){
                echo '<p class="commentReview">（评论审核中）)</p>';
            }else{
                echo '';
            }
        }

    } else {//母评论，无需输出锚点链接
        if (@$prow['status'] == "waiting"){
            echo '<p class="commentReview">（评论审核中）)</p>';
        }else{
            echo '';
        }
    }
}

/** 阅读时间 */
function art_time ($cid){
    $db=Typecho_Db::get ();
    $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1));
    $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']);
    $text_word = mb_strlen($text,'utf-8');
    echo ceil($text_word / 200);
}




/** 列表衍射文章 */
function cosmore($str){
if ( strpos( $str, '[post')!== false) {//提高效率，避免每篇文章都要解析    
   preg_match_all("/\[post\](.*?)\[\/post\]/sm",$str,$strcid);   
   echo '<span class="lirekan"><i class="icon iconfont icon-chuangzuo1"></i> 看点 </span><ul class="lire">';  
   for($i=0;$i<count($strcid[1]);$i++){
    $scid =  $strcid[1][$i];     
    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.contents')->where('cid = ?', $scid));
    if($result){
        foreach($result as $val){ 
          $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $post_title = htmlspecialchars($val['title']);
            $permalink = $val['permalink'];
            $post_views = convert($val['views']);  
            $created = date('m-d', $val['created']);
            $strhtml = '<li><a href="'.$permalink.'"><i class="icon iconfont icon-icon-test29"></i> '.$post_title.'</a><div class="liretime">'.$created.'</div></li>';
            echo $strhtml;
        } } }
    echo  '</ul>';
} 
}

/**将正文转成摘要的代码*/
function cutArticle($data,$cut=0,$str="....")  
{     
    $data=strip_tags($data);//去除html标记  
    $pattern = "/&[a-zA-Z]+;/";//去除特殊符号  
    $data=preg_replace($pattern,'',$data);  
    if(!is_numeric($cut))  
        return $data;  
    if($cut>0)  
        $data=mb_strimwidth($data,0,$cut,$str); 
    return $data;  
} 

/** 后台编辑器文章输出 */
function costcn($cid,$mid,$str,$status){  
//回复可见
if ( strpos( $str, '[hide')!== false) {//提高效率，避免每篇文章都要解析 
$db = Typecho_Db::get();
$sql = $db->select()->from('table.comments')
    ->where('cid = ?',$cid)
    ->where('mail = ?', $mid)
    ->where('status = ?', 'approved')
//只有通过审核的评论才能看回复可见内容
    ->limit(1);
$result = $db->fetchAll($sql);
if($status || $result) {
    $str = preg_replace("/\[hide\](.*?)\[\/hide\]/sm",'<div class="reply2view">$1</div>',$str);
}
else{
    $str = preg_replace("/\[hide\](.*?)\[\/hide\]/sm",'<div class="reply2view"><i class="icon iconfont icon-icon-test17"></i> 此处内容需要评论回复后</div>',$str);
} }  

//提示框短代码
if ( strpos( $str, '[scode')!== false) {//提高效率，避免每篇文章都要解析
  //[scode class="red"]这里编辑标签内容//[/scode]   
   $str = preg_replace("/\[scode\](.*?)\[\/scode\]/sm",'<div class="tip ">$1</div>',$str);
}  
  
//按钮短代码
if ( strpos( $str, '[button')!== false) {//提高效率，避免每篇文章都要解析
  //[scode class="red"]这里编辑标签内容//[/scode]   
   $str = preg_replace("/\[button\ a=(.*?)\](.*?)\[\/button\]/sm",'<div class="btn_nt"><a class="btns" target="_blank" href="//$1"><i class="icon iconfont icon-icon-test14"></i> $2</a></div>',$str);
}  


  
//调用其他文章短代码
if ( strpos( $str, '[post')!== false) {//提高效率，避免每篇文章都要解析  
   preg_match_all("/\[post\](.*?)\[\/post\]/sm",$str,$strcid);
for($i=0;$i<count($strcid[1]);$i++){
    $scid =  $strcid[1][$i];     
    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.contents')->where('cid = ?', $scid));
    if($result){
        foreach($result as $val){            
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $post_title = htmlspecialchars($val['title']);
            $permalink = $val['permalink'];
            $post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($val['text'])); //获取内容
            $cont_text = cutArticle($post_text,150);
            $post_views = convert($val['views']);  
            $created = date('m-d', $val['created']);
            $pnum = $val['commentsNum'];
            $auinfo =  $db->fetchAll($db->select()->from('table.comments')->where('authorId = ?',$val['authorId']));
					if(count($auinfo) !=0){
						//var_dump($img);
						$mail=$auinfo['0']['mail'];					
                        $imgUrl = getGravatar($mail);
						$author= $auinfo['0']['author'];
					}
            $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$scid));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{ $img=showThumbnail($val,0); }                        						 
					}
            $strimg = stcdnimg($img);   
            $html='<div class="post-list contt blockimg"><div class="entry-container"><div class="block-image feaimg"><a class="block-fea" href="' .$permalink. '" title="' .$post_title. '" style="background-image: url(' .$strimg. ');"></a></div><header class="entry-header"><span class="entry-title"><a href="' .$permalink. '">' .$post_title. '</a></span></header><div class="entry-summary"><p>' . $cont_text . '</p></div></div></div>';  
        } }    
   $str = preg_replace("/\[post\](".$scid.")\[\/post\]/sm",$html,$str);  
  }  
}    
   return $cosen=parseBiaoQing($str);
}

/**
 * 加载时间
 * @return bool
 */
function timer_start() {
    global $timestart;
    $mtime     = explode( ' ', microtime() );
    $timestart = $mtime[1] + $mtime[0];
    return true;
}
timer_start();
function timer_stop( $display = 0, $precision = 3 ) {
    global $timestart, $timeend;
    $mtime  = explode( ' ', microtime() );
    $timeend  = $mtime[1] + $mtime[0];
    $timetotal = number_format( $timeend - $timestart, $precision );
    $r   = $timetotal < 1 ? $timetotal * 1000 . " ms" : $timetotal . " s";
    if ( $display ) {
    echo $r;
    }
    return $r;
}

/**
 * 回复触发
 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('ComWechat', 'sc_send');
class ComWechat {
    public static function sc_send($comment, $post)
    {
        
       if($comment['authorId']!=null){
       get_pointy($comment['authorId'],1);
       }    
        
       if ($comment['authorId'] == 1) {
            return $comment;
        }        
             
       $text = "有人在您的博客发表了评论";
       $desp = "**".$comment['author']."** 在 [「".$post->title."」](".$post->permalink." \"".$post->title."\") 中说到: \n\n > ".$comment['text'];
       
       Deng_Plugin::newsend($text,$desp);
      
       return $comment;
    }
}

