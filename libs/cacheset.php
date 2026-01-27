<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * User: 小灯泡设计
 * Blog: https://www.dpaoz.com/85
 * Date: 2019/4/24
 * Time: 20:43

 */



    /**
	 *  热门文章边栏-缓存数据
	**/	    

    $txtopcas = Helper::options()->txtopcas;
       
    if ($txtopcas == '1'){    
      
    $filehot = "./../txtcache/hot.txt";  
      
    if(file_exists($filehot)) {//判断文件 是否存在  
      
    $txtcache = file_get_contents("./../txtcache/hot.txt"); 
      
      
    
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache);   
    $arrtime = date("Y-m-d H:i:s",filemtime($filehot));    
    echo "<div class='miracles-pannel pannel_clo'><div class='pannel_ctxt'><i class='icon iconfont icon-icon-test13'></i> 缓存数据 - 配置中心</div>";
    echo '<form class="protected" action="?MiraclesBackup" method="post">
	<input type="submit" name="onecache" class="miracles-backup-button onecache" value="缓存一键更新" />
	</form> ';
	
	 if(isset($_POST['onecache'])){ 
    if($_POST["onecache"]=="缓存一键更新"){      
      
       getDatahot();
  
       likehot();
       
       getsping();
       
       getpmember();
       
       getliehot();
       
      
       getpagehot();
       
       echo "<script>alert('缓存一键更新完毕')</script>";
    }}  
	
	
    echo "<div class='pannel_box'><ul><p>热门文章-边栏-缓存数据 - 缓存时间：{$arrtime}</p>
    <hr>";  
    if(!empty($txtcache)){  
    foreach($arrmess as $m) {
    list($title,$link, $pic ,$view, $time,$i) = explode("&", $m);      
    echo "<li>{$i}&nbsp;&nbsp;<a href='{$pic}'><i class='icon iconfont icon-tupian'></i></a>&nbsp;&nbsp;<a href='{$link}'>{$title}</a>&nbsp;&nbsp;&nbsp;&nbsp;<span>访问量：{$view}&nbsp;&nbsp;时间：{$time}</span></li>"; 
    }
    }
    echo '</ul>';  
    echo '<form class="protected" action="?Miraclesliu" method="post">
      <input type="submit" name="hotbtn" class="miracles-backup-button backup" value="更新数据" />&nbsp;&nbsp;	
      <input type="submit" name="hotdele" class="miracles-backup-button backup" value="清空数据" />	
	  </form>';         
      
    if(isset($_POST['hotdele'])){ 
    if($_POST["hotdele"]=="清空数据"){      
       file_put_contents('./../txtcache/hot.txt','');
      echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script><?php    
    }}  

    if(isset($_POST['hotbtn'])){ 
    if($_POST["hotbtn"]=="更新数据"){
      getDatahot();
      echo "<script>alert('更新成功')</script>";
      echo '<div class="tongzhi">更新成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><?php    
    }}}

      
     /**
	 *  点赞文章-边栏-缓存数据
	**/	 

      
     $filehot = "./../txtcache/likehot.txt";  
      
    if(file_exists($filehot)) {//判断文件 是否存在  
      
    $txtcache = file_get_contents("./../txtcache/likehot.txt"); 
      
    
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache);   
    $arrtime = date("Y-m-d H:i:s",filemtime($filehot));    
    echo "<br/><ul><p>最多点赞-边栏-缓存数据 - 缓存时间：{$arrtime}</p><hr>";
    if(!empty($txtcache)){  
    foreach($arrmess as $m) {
    list($pid,$imgUrl,$title,$link, $pic ,$likes, $time,$i,$views) = explode("|||", $m); 
    echo "<li>{$i}&nbsp;&nbsp;<img src='{$imgUrl}' height='20' width='20' style='line-height: 30px; float: left; margin: 5px; border-radius: 50%;'><a href='{$pic}'><i class='icon iconfont icon-tupian'></i></a>&nbsp;&nbsp;<a href='{$link}'>{$title}</a>&nbsp;&nbsp;&nbsp;&nbsp;<span>点赞数：{$likes}&nbsp;&nbsp;时间：{$time}</span></li>"; 
    }
    }
    echo '</ul>';  
    echo '<form class="protected" action="?Miraclesliu" method="post">
      <input type="submit" name="likesbtn" class="miracles-backup-button backup" value="更新数据" />&nbsp;&nbsp;
      <input type="submit" name="likesdele" class="miracles-backup-button backup" value="清空数据" />	
	  </form>';         
      
    if(isset($_POST['likesdele'])){ 
    if($_POST["likesdele"]=="清空数据"){      
       file_put_contents('./../txtcache/likehot.txt','');
      echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script><?php    
    }}  

    if(isset($_POST['likesbtn'])){ 
    if($_POST["likesbtn"]=="更新数据"){
     likehot();
     echo "<script>alert('更新成功')</script>";
      echo '<div class="tongzhi">更新成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><?php    
    }}}  

       
    /**
	 *  热评文章-边栏-缓存数据
	**/	    
    

    $fileping = "./../txtcache/siderping.txt";  
      
    if(file_exists($fileping)) {//判断文件 是否存在  
      
    $txtcache = file_get_contents($fileping);      
    
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache); 
    $arrtime = date("Y-m-d H:i:s",filemtime($fileping));   
    echo "<br/><ul><p>热评文章-边栏-缓存数据 - 缓存时间：{$arrtime}</p><hr>";
    if(!empty($txtcache)){    
    foreach($arrmess as $m) {
      
    list($title,$link, $pnum) = explode("|", $m);      
    echo "<li><a href='{$link}'>{$title}</a>&nbsp;&nbsp;&nbsp;&nbsp;<span>评论：{$pnum}</span></li>";   
    }
    }  
    echo '</ul>';  
    echo '<form class="protected" action="?Miraclesliu" method="post"><input type="submit" name="siderpingbtn" class="miracles-backup-button backup" value="更新数据" />&nbsp;&nbsp;<input type="submit" name="siderpingdele" class="miracles-backup-button backup" value="清空数据" /></form>';         
      
    if(isset($_POST['siderpingdele'])){ 
    if($_POST["siderpingdele"]=="清空数据"){      
       file_put_contents('./../txtcache/siderping.txt','');
      echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script><?php    
    }}  

    if(isset($_POST['siderpingbtn'])){ 
    if($_POST["siderpingbtn"]=="更新数据"){
      getsping();
      echo "<script>alert('更新成功')</script>";
      echo '<div class="tongzhi">更新成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><?php    
    }}}


   /**
	 *  会员专栏-页面-缓存数据
	**/	    
    
    

    $filepmember = "./../txtcache/pagemember.txt";  
      
    if(file_exists($filepmember)) {//判断文件 是否存在  
      
    $txtcache = file_get_contents($filepmember);      
    
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache); 
    $arrtime = date("Y-m-d H:i:s",filemtime($filepmember));    
    echo "<br/><ul><p>会员专栏-页面-缓存数据 - 缓存时间：{$arrtime}</p><hr>";
    if(!empty($txtcache)){    
    foreach($arrmess as $m) {   
    list($i,$user_name,$user_img,$user_allpostnum,$user_commentnum,$user_allviewnum,$user_tximg1,$user_txlink1,$user_tximg2,$user_txlink2,$user_tximg3,$user_txlink3) = explode("|", $m);      
    echo "<li>{$i}&nbsp;&nbsp;<img src='{$user_img}' height='20' width='20' style='line-height: 30px; float: left; margin: 5px; border-radius: 50%;'>{$user_name}&nbsp;&nbsp;{$user_allpostnum}&nbsp;&nbsp;{$user_commentnum}&nbsp;&nbsp;{$user_allviewnum}&nbsp;&nbsp;<a href='{$user_tximg1}'><i class='icon iconfont icon-tupian'></i></a>&nbsp;&nbsp;<a href='{$user_tximg2}'><i class='icon iconfont icon-tupian'></i></a>&nbsp;&nbsp;<a href='{$user_tximg3}'><i class='icon iconfont icon-tupian'></i></a>&nbsp;&nbsp;</li>"; 
    }}  
    echo '</ul>';  
    echo '<form class="protected" action="?Miraclesliu" method="post"><input type="submit" name="pagememberbtn" class="miracles-backup-button backup" value="更新数据" />&nbsp;&nbsp;<input type="submit" name="pagememberdele" class="miracles-backup-button backup" value="清空数据" /></form>';         
      
    if(isset($_POST['pagememberdele'])){ 
    if($_POST["pagememberdele"]=="清空数据"){      
       file_put_contents('./../txtcache/pagemember.txt','');
      echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script><?php    
    }}  

    if(isset($_POST['pagememberbtn'])){ 
    if($_POST["pagememberbtn"]=="更新数据"){
      getpmember();
      echo "<script>alert('更新成功')</script>";
      echo '<div class="tongzhi">更新成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><?php    
    }}}


    
    /**
	 *  热门文章-页面-缓存数据
	**/	    
    

    $filephot = "./../txtcache/pagehot.txt";  
      
    if(file_exists($filephot)) {//判断文件 是否存在  
      
    $txtcache = file_get_contents($filephot);      
    
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache); 
    $arrtime = date("Y-m-d H:i:s",filemtime($filephot));  
    echo "<br/><ul><p>热门文章-页面-缓存数据 - 缓存时间：{$arrtime}</p>
    <hr>";
    if(!empty($txtcache)){    
    foreach($arrmess as $m) {
    list($title,$link, $pic,$tdesc,$aid,$aimg,$user,$created,$view,$pnum,$i) = explode("|", $m);      
    echo "<li>{$i}&nbsp;&nbsp;<img src='{$aimg}' height='20' width='20' style='line-height: 30px; float: left; margin: 5px; border-radius: 50%;'>{$user}&nbsp;&nbsp;<a href='{$pic}'><i class='icon iconfont icon-tupian'></i></a>&nbsp;&nbsp;<a href='{$link}'>{$title}</a>&nbsp;&nbsp;&nbsp;&nbsp;<span>访问量：{$view}&nbsp;&nbsp;时间：{$created}</span></li>"; 
    }  
    }  
    echo '</ul>';  
    echo '<form class="protected" action="?Miraclesliu" method="post"><input type="submit" name="pagehotbtn" class="miracles-backup-button backup" value="更新数据" />&nbsp;&nbsp;<input type="submit" name="pagehotdele" class="miracles-backup-button backup" value="清空数据" /></form>';         
      
    if(isset($_POST['pagehotdele'])){ 
    if($_POST["pagehotdele"]=="清空数据"){      
       file_put_contents('./../txtcache/pagehot.txt','');
      echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script><?php    
    }}  

    if(isset($_POST['pagehotbtn'])){ 
    if($_POST["pagehotbtn"]=="更新数据"){
      getpagehot();
      echo "<script>alert('更新成功')</script>";
      echo '<div class="tongzhi">更新成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><?php    
    }}}


     
   /**
	 *  热门推荐-列表-缓存数据
	**/	    
    
         

      
    $fileshot = "./../txtcache/sequhot.txt";  
      
    if(file_exists($fileshot)) {//判断文件 是否存在  
      
    $txtcache = file_get_contents($fileshot);      
    
    $txtcache = rtrim($txtcache, "[n]");     
    $arrmess = explode("[n]", $txtcache);   
    $arrtime = date("Y-m-d H:i:s",filemtime($fileshot));  
    echo "<br/><ul><p>热门推荐-列表-缓存数据 - 缓存时间：{$arrtime}</p>
    <hr>";
    if(!empty($txtcache)){    
    foreach($arrmess as $m) {
    list($title,$link, $pic ,$view, $time) = explode("&", $m);      
    echo "<li><a href='{$pic}'><i class='icon iconfont icon-tupian'></i></a>&nbsp;&nbsp;<a href='{$link}'>{$title}</a>&nbsp;&nbsp;&nbsp;&nbsp;<span>访问量：{$view}&nbsp;&nbsp;时间：{$time}</span></li>";    
    }}
    echo '</ul>';  
    echo '<form class="protected" action="?Miraclesliu" method="post"><input type="submit" name="sequhotbtn" class="miracles-backup-button backup" value="更新数据" />&nbsp;&nbsp;<input type="submit" name="sequhotdele" class="miracles-backup-button backup" value="清空数据" /></form></div><span id="Close" class="Close" href="javascript:;"></span></div>';         
      
    if(isset($_POST['sequhotdele'])){ 
    if($_POST["sequhotdele"]=="清空数据"){      
       file_put_contents('./../txtcache/sequhot.txt','');
      echo '<div class="tongzhi">删除成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script><?php    
    }}  

    if(isset($_POST['sequhotbtn'])){ 
    if($_POST["sequhotbtn"]=="更新数据"){
      getliehot();
      echo "<script>alert('更新成功')</script>";
      echo '<div class="tongzhi">更新成功，请等待自动刷新，如果等不到请点击';
 ?><a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div><?php    
    }}}}


   /**
	 *  缓存数据执行
	**/


     /*热评文章-边栏-缓存数据*/

     function getsping($limit = 6){
     
     $filename = "./../txtcache/siderping.txt";
  
     if(file_exists($filename)) {//判断文件 是否存在
     
     file_put_contents($filename,'');
  
     $db = Typecho_Db::get();
     $result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
        ->limit($limit)
        ->order('commentsNum', Typecho_Db::SORT_DESC)
    );
    if($result){
        foreach($result as $val){            
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $post_title = htmlspecialchars($val['title']);
            $permalink = $val['permalink'];
            $mess = "{$post_title}|{$permalink}|{$val['commentsNum']}[n]";               
            writemessage($filename, $mess);//向文件写进内容
        }}
     }  
    }



     /*会员专栏-页面-缓存数据*/

     function getpmember($limit = 10){
    
     $filename = "./../txtcache/pagemember.txt";
  
     if(file_exists($filename)) {//判断文件 是否存在
     
     file_put_contents($filename,'');
  
     $db = Typecho_Db::get();
        
        $limit = is_numeric($limit) ? $limit : 10;
        $posts = $db->fetchAll($db->select()->from('table.users')
                 ->where('group <> ? ', 'subscriber')                               
                 ->limit($limit)
                 ->order('uid', Typecho_Db::SORT_ASC)              
                 );
        if ($posts) {
            foreach ($posts as $post) {
                
                $user_id = number_format($post['uid']);
                $user_name = $post['screenName'];
				$user_img = getGravatar($post['mail']);
                $user_allpostnum = allpostnum($post['uid']); 
                $user_commentnum = commentnum($post['uid']); 
                $user_allviewnum = allviewnum($post['uid'],false);
              
                $result = $db->fetchAll($db->select()->from('table.contents')
                ->where('authorId = ?',$user_id)
                ->where('status = ?','publish')
                ->where('type = ?', 'post')
                ->limit(3)
                ->order('cid', Typecho_Db::SORT_DESC)
                );
              
                if($result){
                $html = '';
                $text = '';
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
                         $img="/usr/themes/spimes/images/thumbs/adimg.png";
						}                        						 
					}
                $strimg = stcdn($img); 
                $html=$html.'|'.$strimg.'|'.$permalink;
                
                }                
                }
                else{ $html = ''; }
                $user_html = $html;
                $str = stcdn($img);   
                $mess = "{$user_id}|{$user_name}|{$user_img}|{$user_allpostnum}|{$user_commentnum}|{$user_allviewnum}{$user_html}[n]";               
                writemessage($filename, $mess);//向文件写进内容             
            }
        } else {         
        } 
      
     }  
    }


    /*边栏热门文章生成*/

     function getDatahot($limit = 4){
    
     $filename = "./../txtcache/hot.txt";
  
     if(file_exists($filename)) {//判断文件 是否存在       
     
     file_put_contents($filename,'');     
  
     $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 4;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('views', Typecho_Db::SORT_DESC)
                 ->limit($limit)
                 );
        $i=1;
        if ($posts) {
            foreach ($posts as $post) {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                $post_views = convert($result['views']); 
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
				$created = date('m-d', $result['created']);            
			    $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$result['cid']));
					if(count($img) !=0){
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($result['text'],0);
						}                        						 
					}									
                        
                $str = stcdn($img);   
                $mess = "{$post_title}&{$permalink}&{$img}&{$post_views}&{$created}&{$i}[n]";               
                writemessage($filename, $mess);//向文件写进内容 
                $i += 1;
            }
        } else {         
        } 
     
     }  
    }


/*热门文章-页面-缓存数据*/

function getpagehot($limit = 12){
     
     $filename = "./../txtcache/pagehot.txt";
  
     if(file_exists($filename)) {//判断文件 是否存在  
       
     
     file_put_contents($filename,'');
                
         $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 12;
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
				
                $mess = "{$post_title}|{$permalink}|{$img}|{$tdesc}|{$result['authorId']}|{$imgUrl}|{$author}|{$created}|{$post_views}|{$pnum}|{$i}[n]";               
                writemessage($filename, $mess);//向文件写进内容    
              
                 $i += 1;
              
			}
        } else {
           
        } 
       
     }  
    }



     /*热门推荐-列表-缓存数据*/

     function getliehot($limit = 8){
     
     $filename = "./../txtcache/sequhot.txt";
  
     if(file_exists($filename)) {//判断文件 是否存在 
       
      
       file_put_contents($filename,'');
                
        $period = time() - 2592000; // 单位: 秒, 时间范围: 30天
       
        $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 4;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('views', Typecho_Db::SORT_DESC)
                 ->where('created > ?', $period )
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
                $str = stcdn($img);   
                $mess = "{$post_title}&{$permalink}&{$img}&{$post_views}&{$created}[n]";               
                writemessage($filename, $mess);//向文件写进内容             
            }
        } else {         
        }  
  
     }  
    }




/*边栏最多点赞文章生成*/

     function likehot($limit = 4){
     
     $filename = "./../txtcache/likehot.txt";
  
     if(file_exists($filename)) {//判断文件 是否存在       
     
     file_put_contents($filename,'');     
  
     $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 4;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('agree', Typecho_Db::SORT_DESC)
                 ->limit($limit)
                 );
        $i=1;
        if ($posts) {
            foreach ($posts as $post) {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                
                $post_views = convert($result['views']);   
                $post_likes = $result['agree'];
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
				$created = date('m-d', $result['created']);  
                $pdid = $result['authorId'];
              
                $auinfo =  $db->fetchAll($db->select()->from('table.users')->where('uid = ?',$pdid));
				if(count($auinfo) !=''){
						//var_dump($img);
						$mail=$auinfo['0']['mail'];					
                        $imgUrl = getGravatar($mail);						
					}  
              
			    $img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$result['cid']));
			    $post_cid = $result['cid'];
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
                $str = stcdn($img);   
                $mess = "{$pdid}|||{$imgUrl}|||{$post_title}|||{$permalink}|||{$img}|||{$post_likes}|||{$created}|||{$i}|||{$post_views}[n]";               
                writemessage($filename, $mess);//向文件写进内容 
                $i += 1;
            }
        } else {         
        } 
     
     }  
    }

function writemessage($filename, $mess) {
    $fp = fopen($filename, "a");//在尾部执行写的操作，且不删除原来的文件内容
    fwrite($fp, $mess);//写入文件     
    fclose($fp);//关闭文件  
    ?><script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'");</script>><?php
}     




