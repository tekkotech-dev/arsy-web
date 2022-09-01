<?php
$this->load->helper('text');
$feature_max = 0;
$get_feature_max    = $this->model_utama->view_where('tbl_nicepage',array('key' => 'feature_max'))->row_array();
if(isset($get_feature_max['value'])){
	if(!empty($get_feature_max['value'])){
		$feature_max = json_decode($get_feature_max['value'],true);
	}
}

$get_section_feature    = $this->model_utama->view_where('tbl_nicepage',array('key' => 'section_feature'))->row_array();
if(isset($get_section_feature['value'])){
	if(!empty($get_section_feature['value'])){
		$section_feature = json_decode($get_section_feature['value'],true);
	}
}

// koleksi halaman
$get_halaman_id = array(); 
for($i = 1; $i <= ((int) $feature_max); $i++) {
    if(!empty($section_feature['page_' . $i])) {
        array_push($get_halaman_id, (int) $section_feature['page_'. $i]);
    };
}
// get halaman
$get_halaman = array();
if(!empty($get_halaman_id)) {
    $get_halaman = $this->db->query("
                SELECT 
                    hal.id_halaman as id,
                    hal.judul as judul,                
                    hal.judul_seo as judul_seo,
                    hal.isi_halaman as isi,
                    hal.gambar as gambar
                FROM 
                    halamanstatis  hal
                WHERE
                    hal.id_halaman IN(". implode(',',$get_halaman_id) .")
            ")->result_array(); 
} 
?>

<div class="container">
    <div class="card py-4">
        <?php if( !empty($section_feature['judul'])) { ?>
        <h2 class="card-header section-title">
            <?php echo strtoupper($section_feature['judul']);?>
        </h2>
        <?php } ?>
        <?php if( !empty($section_feature['deskripsi'])) { ?>
        <div class="section-description">
            <?php echo $section_feature['deskripsi'];?>
        </div>
        <?php } ?> 
        <div class="card-body">
            <div class="row justify-content-center mb-4  mt-4">
                <?php if( !empty($get_halaman)) {?>                 
                    <?php
                        switch ((int) $section_feature['layout']) {
                            case 0: 
                                $layout = '4';
                                $grid_variant = true;
                                break; 
                            case 2:
                                $layout = '6'; 
                                $grid_variant = false;
                                break;                                    
                            case 3:
                                $layout = '4'; 
                                $grid_variant = false;
                                break;                  
                            default:                             
                                $layout = '4';
                                $grid_variant = true;
                                break;
                        }
                    ?>
                    <div class="mb-4 mt-4 col-lg-12">
                        <!-- carousel -->
                        <section id="slide-layanan" class="splide" aria-labelledby="carousel-heading">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <!-- <li class="splide__slide">Slide 01</li>
                                    <li class="splide__slide">Slide 02</li>
                                    <li class="splide__slide">Slide 03</li> -->
                                    <!-- <div class="row"> -->
                                        <?php foreach($get_halaman as $i => $hal) {?>
                                            <li class="splide__slide">
                                                <div class="body-container animate shadow-team-card" style="border-radius: 15px;"> 
                                                    <img style="border-top-left-radius: 15px;border-top-right-radius: 15px;" src="<?php echo base_url();?>asset/foto_statis/<?php echo $hal['gambar'];?>" alt="<?php echo $hal['judul'];?>">    
                                                    <a href="<?php echo base_url('halaman/detail/'.$hal['judul_seo']);?>" >                                        
                                                        <h4 class="body-title center">
                                                            <?php echo $hal['judul'];?>
                                                        </h4>
                                                    </a>
                                                    <div class="body-content center"> 
                                                        <?php $limit_word =  (empty(trim($section_feature['max_kata'])) ? 15 : (int) $section_feature['max_kata']);?>
                                                        <?php echo word_limiter($hal['isi'],$limit_word);?>  
                                                    </div>                     
                                                </div>
                                            </li>
                                        <?php }?>
                                    <!-- </div> -->
                                </ul>
                            </div>
                        </section>

                    </div>
                    <?php if(!empty(trim($section_feature['url_link'])) ){ ?>
                        <div class="col-12 mt-4 text-center">
                            <a href="<?php echo $section_feature['url_link'];?>" class="read-more">                                    
                                <?php echo (empty(trim($section_feature['label_link'])) ? 'Selengkapnya' : $section_feature['label_link']);?>
                            </a> 
                        </div>
                    <?php } ?>
                <?php }?>
            </div>
        </div>
    </div>
</div>  