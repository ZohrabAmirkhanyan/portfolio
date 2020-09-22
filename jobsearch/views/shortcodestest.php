<?php
$jobs = new zga_zip_api();
?>
<?php $job = $jobs->get_jobs($api_args)['jobs'];?>
<?php for( $x = 0; $x<count($job); $x++){ ?>
<li>
	<a href="<?php echo $job[$x]->url;?>">
    	<div class="job-content-wrapper">
         	<!-- Job Company -->
         	
         	<!-- Job Title & Info -->
         	<div class="job-content-main">
             	<div class="job-title">
             		<h5 class="title">
             			<?php echo $job[$x]->title;?>
             		</h5>  
             		<h5 class="tagline">
             			<?php echo $job[$x]->tagline;?>
             		</h5>           						 		
             	</div>
             	<div class="job-info">
             		<span class="company">
             			<i class="fa fa-building-o"></i>
             			<?php echo $job[$x]->company;?>
             		</span>
             		<span class="location">
             			<i class="icon-location-pin"></i>
             			<?php echo $job[$x]->location;?>
             		</span>
             		<span class="salary">
             			<i class="fa fa-money"></i>
            	 			<?php echo '$'.$job[$x]->salary_min;?> - <?php echo '$'.$job[$x]->salary_max;?>
             		</span>
             	</div>
             </div>	
        </div>
     </a>
</li>
<?php }?>
<?php 

