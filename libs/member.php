<?php

/**
 * menber.php
 * Author     : 小灯泡设计
 * Date       : 2020/4/3
 * Version    : 1.0
 * Description: 会员功能
 **/

// 会员页判断是否会员id
function userok($id){
$db = Typecho_Db::get();
$userinfo=$db->fetchRow($db->select()->from ('table.users')->where ('table.users.uid=?',$id));
return $userinfo;
}

//判断用户组
function yonghuzu($uid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('group')->from('table.users')->where('uid = ?', $uid));
    $group = $prow['group'];

       // 变判断的值为常量
    switch($group){
    case 'subscriber':
    return '普通会员';
    break;   // 跳出循环
    case 'administrator':
    return '管理员';
    break;
    case 'editor':
    return '编辑';
    break;
    case 'contributor':
    return '认证作者';
    break;
     }

}  


//调用用户注册时间
function reg_login($userid){
    $now = time();
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $row = $db->fetchRow($db->select('created')->from('table.users')->where('uid = ?', $userid));
    $ti = Typecho_I18n::dateWord($row['created'], $now);
    $d1 = $row['created'];//过去的某天，你来设定
    $d2 = ceil((time()-$d1)/60/60/24);//现在的时间减去过去的时间，ceil()进一函数
    return $d2;
}


/**判断会员积分是否可以申请认证会员**/
function apply_get($uid){
    $jife = get_jifei($uid);
    if($jife>1000){
        echo "";
    }
    else{
        echo "disabled='disabled'";
    }
}

/**输出作者文章总数，可以指定*/
function allpostnum($id){
    $db = Typecho_Db::get();
    $postnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allpostnum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=?', 'post'));
    $postnum = $postnum['allpostnum'];
	if($postnum=='0')
    {
		return 0;
	}
	else{
	   return $postnum;
	}
}

//调用最近登录时间
function get_last_login($userid){
    $now = time();
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $row = $db->fetchRow($db->select('activated')->from('table.users')->where('uid = ?', $userid));
    return Typecho_I18n::dateWord($row['activated'], $now);
}

/**输出作者人气*/
function allviewnum($id,$sta){
    $db = Typecho_Db::get();
    $postnum=$db->fetchRow($db->select(array('Sum(views)'=>'allviewnum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=?', 'post'));
    $postnum = $postnum['allviewnum'];
    if($sta){
    $exist = convert($postnum);
    }else{
    $exist =$postnum;
    }
	return $exist == 0 ? '0 ' : $exist;
}

/**输出作者获得点赞数*/
function allagreenum($id){
    $db = Typecho_Db::get();
    $postnum=$db->fetchRow($db->select(array('Sum(agree)'=>'allagreenum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=?', 'post'));
    $postnum = $postnum['allagreenum'];
    
    $exist = convert($postnum);

	return $exist;
}


/**输出作者评论总数，可以指定*/
function commentnum($id){
    $db = Typecho_Db::get();
    $commentnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'commentnum'))->from ('table.comments')->where ('table.comments.authorId=?',$id)->where('table.comments.type=?', 'comment'));
    $commentnum = $commentnum['commentnum'];    
	return $commentnum;
}

/** 输出该作者最近文章列表 */
function authorPosts($authorid){
    if($authorid){ 
        $limit = 5;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$authorid)
            ->where('status = ?','publish')
            ->where('type = ?', 'post')
            ->limit($limit)
            ->order('cid', Typecho_Db::SORT_DESC)        
        );
        if($result){
            foreach($result as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
				$commentsNum = $val['commentsNum'];
                echo '<li><div class="widget-posts-text"><a class="widget-posts-title" href="'.$permalink.'" title="'.$post_title.'"><i class="icon iconfont icon-icon-test29"></i> '.$post_title.'</a><div class="widget-posts-meta"><i>' . $commentsNum.' 评论</i></div></div></li>';
            }
        }
        
    }else{
        echo '请设置要调用的作者ID';
    }
}


/**
* 显示用户等级，按邮箱
*/
function autvip($i){
    $db=Typecho_Db::get();
    $mail=$db->fetchAll($db->select(array('COUNT(cid)'=>'rbq'))->from('table.comments')->where('mail = ?', $i)/**->where('authorId = ?','0')**/);
    foreach ($mail as $sl){
    $rbq=$sl['rbq'];}
    if($rbq<1){
    echo '<span class="autlv aut-0">Lv.0</span>';
    }elseif ($rbq<10 && $rbq>0) {
    echo '<span class="autlv aut-1">Lv.1</span>';
    }elseif ($rbq<20 && $rbq>=10) {
    echo '<span class="autlv aut-2">Lv.2</span>';
    }elseif ($rbq<40 && $rbq>=20) {
    echo '<span class="autlv aut-3">Lv.3</span>';
    }elseif ($rbq<80 && $rbq>=40) {
    echo '<span class="autlv aut-4">Lv.4</span>';
    }elseif ($rbq<100 && $rbq>=80) {
    echo '<span class="autlv aut-5">Lv.5</span>';
    }elseif ($rbq>=100) {
    echo '<span class="autlv aut-6">Lv.6</span>';
    }
}


/** 输出该作者审核文章列表 */
function authorwaiting($authorid,$lock){
    if($authorid){ 
        $limit = 10;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$authorid)
            ->where('status = ?','waiting')
            ->where('type = ?', 'post')
            ->limit($limit)
            ->order('created', Typecho_Db::SORT_DESC)        
        );
        if($result){
            foreach($result as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
				$commentsNum = $val['commentsNum'];
				$post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($val['text'])); //获取内容
				$cont_text = cutArticle($post_text,150);
			    $post_views = convert($val['views']);
			    $post_agree = $val['agree'];
				$cont_time = Typecho_I18n::dateWord($val['created'], $now);
				$post_jifen = get_v_jifen($post_views,$commentsNum,$post_agree); //(阅读量,评论数,点赞数)
				$siteUrl = Helper::options()->siteUrl;
						$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($val['text'],0);
						}                        						 
					}	 
		
                
                echo '<article class="post-list contt blockimg "> <div class="entry-container"><span class="laid_title_l"></span> <div class="block-image feaimg"> <div class="block-fea scrollLoading" data-url="'.$img.'" title="'.$post_title.'" style="background-image:url('.$img.')"></div></div> <header class="entry-header"><span class="entry-title">[待审核] '.$post_title.'</span></header> <div class="entry-summary ss"><p>'.$cont_text.'</p></div></div>
                    <div class="d_meta">
                    <time datetime="'.$cont_time.'"><i class="icon iconfont icon-icon-test4"></i> '.$cont_time.'</time>
                    </p>
                    </article>';
            }
        }
        
        else{ echo ''; }
        
    }else{
        echo '请设置要调用的作者ID';
    }
}



/** 输出该作者最近草稿文章列表 */
function authordraft($authorid,$lock){
    if($authorid){ 
        $limit = 10;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$authorid)
            //->where('status = ?','publish')
            ->where('type = ?', 'post_draft')
            ->limit($limit)
            ->order('created', Typecho_Db::SORT_DESC)        
        );
        if($result){
            foreach($result as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
				$commentsNum = $val['commentsNum'];
				$post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($val['text'])); //获取内容
				$cont_text = cutArticle($post_text,150);
			    $post_views = convert($val['views']);
			    $post_agree = $val['agree'];
				$cont_time = Typecho_I18n::dateWord($val['created'], $now);
				$post_jifen = get_v_jifen($post_views,$commentsNum,$post_agree); //(阅读量,评论数,点赞数)
				$siteUrl = Helper::options()->siteUrl;
				$gaoedit = Helper::options()->gaoedit;
				if($lock == 0){ $edit = '<span class="aut_edit"><a href="'.$siteUrl.''.$gaoedit.'.html?tid='.$val['cid'].'">编辑</a></span>';}
				else{ $edit ='';}
				
				//删除
		        Typecho_Widget::widget('Widget_Security')->to($security);

				
				$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($val['text'],0);
						}                        						 
					}	 
		
                     
                
                echo '<article class="post-list contt blockimg "> <div class="entry-container"><span class="laid_title_l"></span> <div class="block-image feaimg"> <div class="block-fea scrollLoading" data-url="'.$img.'" title="'.$post_title.'" style="background-image:url('.$img.')"></div></div> <header class="entry-header"><span class="entry-title">[草稿] '.$post_title.'</span></header> <div class="entry-summary ss"><p>'.$cont_text.'</p></div></div>
                    <div class="d_meta">
                    <time datetime="'.$cont_time.'"><i class="icon iconfont icon-icon-test4"></i> '.$cont_time.'</time>
                    ';
                     ?>
                     <?php if ($lock==0): ?>
                     <span class="aut_edit">
                     <a href="<?php $security->index('/action/contents-post-edit?do=delete&cid='.$val['cid'].''); ?>" onclick="javascript:return p_del()">删除</a></span>
                     <?php endif; ?>
                     <?php 
                  echo  $edit.'</p></article>';
            }
        }
        
        else{ echo ''; }
        
    }else{
        echo '请设置要调用的作者ID';
    }
}




/** 输出该作者最近已发布文章列表
function authorpage($authorid,$lock){
    if($authorid){ 
        $limit = 20;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$authorid)
            ->where('status = ?','publish')
            ->where('type = ?', 'post')
            ->limit($limit)
            ->order('created', Typecho_Db::SORT_DESC)        
        );
        if($result){
            foreach($result as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
				$commentsNum = $val['commentsNum'];
				$post_text = preg_replace('/($s*$)|(^s*^)/m', '',strip_tags($val['text'])); //获取内容
				$cont_text = cutArticle($post_text,150);
			    $post_views = convert($val['views']);
			    $post_agree = $val['agree'];
				$cont_time = Typecho_I18n::dateWord($val['created'], $now);
				$post_jifen = get_v_jifen($post_views,$commentsNum,$post_agree); //(阅读量,评论数,点赞数)
				$siteUrl = Helper::options()->siteUrl;
				$gaoedit = Helper::options()->gaoedit;
				if($lock == 0){ $edit = '<span class="aut_edit"><a href="'.$siteUrl.''.$gaoedit.'.html?tid='.$val['cid'].'">编辑</a></span>';}
				else{ $edit ='';}
				
				//删除
		        Typecho_Widget::widget('Widget_Security')->to($security);
				
				
				$img =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','img',$val['cid']));
					if(count($img) !=0){
						//var_dump($img);
						$img=$img['0']['str_value'];						
                        if($img){}
						else{
                          $img= Thumbnail($val['text'],0);
						}                        						 
					}	 
					$Copyrightnew =  $db->fetchAll($db->select()->from('table.fields')->where('name = ? AND cid = ?','Copyrightnew',$val['cid']));
					if(count($Copyrightnew) !=0){
						//var_dump($img);
						$Copyrightnew=$Copyrightnew['0']['str_value'];	
						}	 
				
					if($Copyrightnew==0){ $Copyright = "原创";}
					else if($Copyrightnew==2){ $Copyright = "转载";}
					else { $Copyright = "投稿"; }
                     
                
                echo '<article class="post-list contt blockimg "> <div class="entry-container"><span class="laid_title_l"></span> <div class="block-image feaimg"> <a class="block-fea scrollLoading" data-url="'.$img.'" href="'.$permalink.'" title="'.$post_title.'" style="background-image:url('.$img.')"></a></div> <header class="entry-header"><span class="entry-title"><a href="'.$permalink.'">'.$post_title.'</a></span></header> <div class="entry-summary ss"><p>'.$cont_text.'</p></div></div>
                    <div class="d_meta">
                    <time datetime="'.$cont_time.'"><i class="icon iconfont icon-icon-test4"></i> '.$cont_time.'</time>
                    <span class="separator">/</span>
                    <i class="icon iconfont icon-taolunqu"></i> '.$commentsNum.' 评论
                    <span class="separator">/</span>
                    <i class="icon iconfont icon-icon-test"></i> '.$post_views.' 阅读
                    <span class="separator">/</span>
                    <i class="icon iconfont icon-dianzan"></i> '.$post_agree.' 赞
                    <span class="separator">/</span>
                    <i class="icon iconfont icon-anquan"></i> '.$Copyright.'
                    <span class="separator">/</span>
                    <i class="icon iconfont icon-qinghuiyuan"></i> 积分 '.$post_jifen.' 
                    ';
                    ?>
                     <?php if ($lock==0): ?>
                     <span class="aut_edit"><a href="<?php $security->index('/action/contents-post-edit?do=delete&cid='.$val['cid'].''); ?>" onclick="javascript:return p_del()">删除</a></span>
                     <?php endif; ?>
                     <?php 
                echo $edit.'</p>
                    </article>';
            }
        }
        
        else{ echo '<div class="allcomment-empy">暂无文章</div>'; }
        
    }else{
        echo '请设置要调用的作者ID';
    }
}
 **/

/*输出作者发表的评论*/
class Widget_Post_AuthorComment extends Widget_Abstract_Comments
{
    public function execute()
    {
        global $AuthorCommentId;//全局作者id
        $select  = $this->select()->limit($this->parameter->pageSize)
        ->where('table.comments.status = ?', 'approved')
        ->where('table.comments.authorId = ?', $AuthorCommentId)//获取作者id
        ->where('table.comments.type = ?', 'comment')
        ->order('table.comments.coid', Typecho_Db::SORT_DESC);//根据coid排序
        $this->db->fetchAll($select, array($this, 'push'));
    }
}

/**
* 获取当前自媒体创作者的文章阅读量，点赞，评论等计算公式(阅读量,评论数,点赞数)
*/
function get_psum($uid){
   $allview =  (int)allviewnum($uid,false); //总访问量
   $allcomm =  (int)commentnum($uid); //评论总数
   $allagree =  (int)allagreenum($uid); //点赞总数
   $alls = get_v_jifen($allview,$allcomm,$allagree);
   return $alls;
}

// 积分公式

function get_v_jifen($a,$b,$c){ //阅读，评论，点赞
 
    //$autjifen = Helper::options()->autjifen; 
    
    //$alls = sprintf($autjifen, $a,$b,$c);
    //$alls = ceil(($a*0.001)+$b+($c*5));
    
    //eval("\$alls = \"$alls\";");
    //echo $alls;

   $alls = ceil(($a*0.001)+$b+($c*5));
   return $alls;
   //return $a.'|'.$b.'|'.$c;
}

/**
* 单篇文章+积分
**/

function get_pid_v($cid){
    
     $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select()->from('table.contents')->where('cid = ?', $cid));
    $sum = get_v_jifen($prow['views'],$prow['commentsNum'],$prow['agree']);
    return $sum;
    
}


/**
* 自媒体创作者积分
* 调用<?php get_points($uid,数值积分); ?>
*/
function get_points_v($uid,$upsum) {
    if(get_psum($uid)!=null){ $secy = get_psum($uid);}
    else{ $secy = 0;}
    $db = Typecho_Db::get();
    $cid = $uid;
    if (!array_key_exists('points', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `points` INT(10) DEFAULT NULL;');         
        }
    
    $exist = $db->fetchRow($db->select('points')->from('table.users')->where('uid = ?', $cid))['points']; 
   // $vid = 'DP'.$cid;
    if($exist == null){   
   
               
            $db->query($db->update('table.users')
                ->rows(array('points' =>$secy))
                ->where('uid = ?',$cid));
       $exist = $db->fetchRow($db->select('points')->from('table.users')->where('uid = ?', $cid))['points'];        
    }
    else{
         if($upsum!=null){
         $db->query($db->update('table.users')
                ->rows(array('points' =>(int)$secy+$upsum))
                ->where('uid = ?',$cid));
         }
         else{
         $db->query($db->update('table.users')
                ->rows(array('points' =>(int)$secy))
                ->where('uid = ?',$cid));    
         }
         
         $exist = $db->fetchRow($db->select('points')->from('table.users')->where('uid = ?', $cid))['points'];   
    }
  
    return $exist;
}


//普通游客积分
function get_pointy($uid,$upsum) {
    $db = Typecho_Db::get();
    $cid = $uid;
    if (!array_key_exists('pointy', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `pointy` INT(10) DEFAULT NULL;');         
        }
    
    $exist = $db->fetchRow($db->select('pointy')->from('table.users')->where('uid = ?', $cid))['pointy']; 
   // $vid = 'DP'.$cid;
    if($exist == null){       
       $secy = 0;          
            $db->query($db->update('table.users')
                ->rows(array('pointy' =>$secy))
                ->where('uid = ?',$cid));
       $exist = $db->fetchRow($db->select('pointy')->from('table.users')->where('uid = ?', $cid))['pointy'];        
    }
    else{
         if($upsum!=null){
         $db->query($db->update('table.users')
                ->rows(array('pointy' =>(int)$exist+$upsum))
                ->where('uid = ?',$cid));
         }  
         
         $exist = $db->fetchRow($db->select('pointy')->from('table.users')->where('uid = ?', $cid))['pointy'];   
    }
  
    return $exist;
}
  

  
//输出积分
function get_jifei($uid) {
   
    if(yonghuzu($uid)){ 
       $exist = get_points_v($uid,$upsum)+get_pointy($uid,$upsum); //创作者积分
    }
    else{
       $exist = get_pointy($uid,$upsum); //会员积分
    }
    return $exist;
}


/**
* 个人签名
* 调用<?php getintro($this); ?>
*/
function getintro($uid,$intros) {
    $db = Typecho_Db::get();
    
    if (!array_key_exists('introduce', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `introduce` varchar(200) DEFAULT NULL;');
    }
    
    $exist = $db->fetchRow($db->select('introduce')->from('table.users')->where('uid = ?', $uid))['introduce'];
    
    $db->query($db->update('table.users')
                ->rows(array('introduce' => $intros))
                ->where('uid = ?', $uid));
}

function reintro($uid) {
    $db = Typecho_Db::get();
    
    if (!array_key_exists('introduce', $db->fetchRow($db->select()->from('table.users')))) {
        $db->query('ALTER TABLE `'.$db->getPrefix().'users` ADD `introduce` varchar(200) DEFAULT NULL;');
    }
    
    $exist = $db->fetchRow($db->select('introduce')->from('table.users')->where('uid = ?', $uid))['introduce'];
    if($exist==''){$exist = '作者有点忙，还没写简介';}
    return $exist;
}
  