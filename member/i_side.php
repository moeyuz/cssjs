<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="member_i_side col-md-3 widget-area <?php if (($this->is('post')) && ($this->options->postimask == '1') ): ?>post_sider<?php endif; ?>" id="secondary">

    <?php if ($this->options->auadside): ?>
     <section class="widget_img"><div class="adTags"><div class="adTag">广告</div> <a target="_blank" href=""> <?php $this->options->auadside(); ?> </a></div> </section>
     <?php endif; ?>

    <section class="widget abautor">
        <div class="box-img" style="background-image:url(https://s3.pstatp.com/bcy/image/default_banner.c6e8da.jpg);"></div>
        <div class="widget-list meb_autor_top"> 
        <div class="meb_v">  
		<?php $email=$mymail; $imgUrl = getGravatar($email);echo '<img class="widget-about-image" src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" >'; ?>
        
        <?php if ($this->options->viphonor): ?><div class="av_v_honor"><img src="<?php $this->options->viphonor(); ?>" title="注册用户"></div><?php endif; ?>      
        </div>
        <div class="widget-about-intro">
        <div class="name"><?php echo $myscreenName; ?></div>
        <div class="widget-intro"><?php echo reintro($this->author->uid); ?></div>
		<div class="widget-about-desc work">发表文章 <?php echo allpostnum($this->author->uid); ?>篇</div>
        </div>           
        </div>
        
        <!--扩展资料-->
        <ul class="user__list"> 
        <li><span><i class="icon iconfont icon-icon-test24"></i> 会员类型：</span> <span><?php echo yonghuzu($myuid); ?></span></li> 
        <li><span><i class="icon iconfont icon-icon-test"></i> 访问人气：</span> <span><?php echo authorviews($this->author->uid); ?> 人气</span></li> 
        <li><span><i class="icon iconfont icon-rili"></i> 最近登录：</span> <span><?php echo get_last_login($myuid); ?></span></li>
        </ul>
        <!--扩展资料-->
        
    </section>
    
    <!--<section class="widget">
    <div class="user-auth">
     <i class="icon iconfont icon-qinghuiyuan"></i>  个人认证：创作者
     </div>
    </section>-->

</div>
