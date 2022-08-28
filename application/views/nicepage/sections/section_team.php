<?php
$team_max = 0;
$get_team_max    = $this->model_utama->view_where('tbl_nicepage',array('key' => 'team_max'))->row_array();
if(isset($get_team_max['value'])){
	if(!empty($get_team_max['value'])){
		$team_max = json_decode($get_team_max['value'],true);
	}
}

$get_section_team    = $this->model_utama->view_where('tbl_nicepage',array('key' => 'section_team'))->row_array();
if(isset($get_section_team['value'])){
	if(!empty($get_section_team['value'])){
		$section_team = json_decode($get_section_team['value'],true);
	}
}

// koleksi id team
$get_personal_id = array(); 
for($i = 1; $i <= ((int) $team_max); $i++) {
    if(!empty($section_team['person_' . $i])) {
        array_push($get_personal_id, (int) $section_team['person_'. $i]);
    };
} 

// get personal
$get_personal = array();
if(!empty($get_personal_id)) {
    $get_personal = $this->db->query("
                SELECT 
                    team.id_team as id,
                    team.nama as nama,
                    team.jabatan as jabatan,
                    team.socmed_fb as socmed_fb,
                    team.socmed_twitter as socmed_twitter,
                    team.socmed_ig as socmed_ig,
                    team.socmed_linkedin as socmed_linkedin,
                    team.photo as photo
                FROM 
                    tbl_nicepage_team as team
                WHERE
                    team.id_team IN(". implode(',',$get_personal_id) .")
            ")->result_array(); 
} 
?>

<div class="container">
    <div class="card py-4">
        <?php if( !empty($section_team['judul'])) { ?>
        <h2 class="card-header section-title">
            <?php echo strtoupper($section_team['judul']);?>
        </h2>
        <?php } ?>
        <?php if( !empty($section_team['deskripsi'])) { ?>
        <div class="section-description">
            <?php echo $section_team['deskripsi'];?>
        </div>
        <?php } ?> 
        <div class="card-body">
            <?php if( !empty($get_personal)) {?>
                <div class="row justify-content-center">
                    <?php
                        switch ((int) $section_team['layout']) { 
                            case 2:
                                $layout = '6'; 
                                break;                                    
                            case 3:
                                $layout = '4'; 
                                break;                                    
                            case 4:
                                $layout = '3'; 
                                break;                          
                            default:                             
                                $layout = '6'; 
                                break;
                        }
                    ?>
                    <div class="mb-4 mt-4 col-md-12">
                        <div id="carouselTeam" class="carousel slide" data-ride="carousel">
                            <div class="carousel-team-inner" role="listbox">
                                <?php foreach($get_personal as $i => $person ) {?>
                                <div class="carousel-item <?php echo ($i == 0 ? 'active': '');?>">
                                    <?php $class_is_grid_variant = ($grid_variant == true) ? 'd-block d-md-none' : '';?>
                                    <center>
                                        <div class="row">
                                            <div class="col-md-3 col-1"></div>
                                            <div class="mb-4 col-md-6 col-10">
                                                <div class="body-container animate shadow-team-card h-100" style="border-radius: 15px;"> 
                                                    <img style="border-top-left-radius: 15px;border-top-right-radius: 15px;" src="<?php echo base_url();?>asset/img_nicepage/team/<?php echo $person['photo'];?>" alt="<?php echo $person['nama'];?>">                                            
                                                    <h4 class="body-title center">
                                                        <?php echo $person['nama'];?>
                                                    </h4>
                                                    <div class="body-content center">
                                                        <div class="team-title">
                                                            <?php echo $person['jabatan'];?>
                                                        </div>
                                                        <div class="team-socmed">
                                                            <a target="_blank" href="<?php echo $person['socmed_fb'];?>">
                                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                                            </a>
                                                            <a target="_blank" href="<?php echo $person['socmed_twitter'];?>">
                                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                                            </a>
                                                            
                                                            <a target="_blank" href="<?php echo $person['socmed_ig'];?>">
                                                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                                            </a>
                                                            
                                                            <a target="_blank" href="<?php echo $person['socmed_linkedin'];?>">
                                                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>                             
                                                </div>
                                            </div>  
                                            <div class="col-md-3 col-1"></div>
                                        </div>
                                    </center>
                                </div>                  
                                <?php }?>
                            </div>
                            <ol class="carousel-indicators" style="bottom:-10%;">
                                <?php for($t = 0 ; $t < count($get_personal);$t++) {?>
                                    <li data-target="#carouselTeam"  data-slide-to="<?php echo $t;?>" <?php echo ($t == 0) ? ' class="active"':'';?> style="background-color: #28a745!important;"></li> 
                                <?php } ?>
                            </ol> 
                        </div>
                    </div>  
                </div>
                <br>
                <br>
                <div class="row justify-content-center">
                    <div class="col-12 mt-4 text-center">
                        <a href="<?php echo base_url('teams');?>" class="read-more">                                    
                            <?php echo (empty(trim($section_team['label_link'])) ? 'Selengkapnya' : $section_team['label_link']);?>
                        </a> 
                    </div> 
                </div>
            <?php }?>
        </div>
    </div>
</div> 