<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'suggestion';
	$ctable1 	= 'Suggestion';
	$main_page 	= 'Suggestion'; //for sidebar active menu
	$page		= 'suggestion';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$title = "";
	$track_link = "";
	$book_expert_link = "";
	$book_class_link = "";
	$shop_link = "";
	$download_link = "";
	$email_cta = "";
	$descr = "";
	$involved = "";
	$days = "";
	$day_started = "";
	$isCompleted = "";
	$suggestion_id = "";

	$isMedical = "";
	$isComplementary = "";
	$hrt_risk = "";
	$medication = "";
	$smoker = "";
	$caffeine = "";
	$alcohol = "";
	$period_frequency = "";
	
	if(isset($_REQUEST['submit']))
	{
		//print_r($_REQUEST); exit;
		$title = $db->clean($_REQUEST['title']);
		$track_link = $db->clean($_REQUEST['track_link']);
		$book_expert_link = $db->clean($_REQUEST['book_expert_link']);
		$book_class_link = $db->clean($_REQUEST['book_class_link']);
		$shop_link = $db->clean($_REQUEST['shop_link']);
		$download_link = $db->clean($_REQUEST['download_link']);
		$email_cta = $db->clean($_REQUEST['email_cta']);
		$descr = $db->clean($_REQUEST['descr']);
		$involved = $db->clean($_REQUEST['involved']);
		$days = $db->clean($_REQUEST['days']);
		$day_started = $db->clean($_REQUEST['day_started']);
		$isCompleted = $db->clean($_REQUEST['isCompleted']);

		$symptom = $_REQUEST['symptom'];

		$isMedical = $db->clean($_REQUEST['isMedical']);
		$isComplementary = $db->clean($_REQUEST['isComplementary']);
		$hrt_risk = $_REQUEST['hrt_risk'];
		$medication = $_REQUEST['medication'];
		$smoker = $_REQUEST['smoker'];
		$caffeine = $_REQUEST['caffeine'];
		$alcohol = $_REQUEST['alcohol'];
		$period_frequency = $db->clean($_REQUEST['period_frequency']);

		$hrt_risk = implode(',', $hrt_risk);
		$medication = implode(',', $medication);
		$smoker = implode(',', $smoker);
		$caffeine = implode(',', $caffeine);
		$alcohol = implode(',', $alcohol);

		$rows 	= array(
			'title' => $title,
			'track_link' => $track_link,
			'book_expert_link' => $book_expert_link,
			'book_class_link' => $book_class_link,
			'shop_link' => $shop_link,
			'download_link' => $download_link,
			'email_cta' => (int) $email_cta,
			'descr' => $descr,
			'involved' => $involved,
			'days' => (int) $days,
			'day_started' => (int) $day_started,
			'isCompleted' => (int) $isCompleted,
			'isMedical' => (int) $isMedical,
			'isComplementary' => (int) $isComplementary,
			'hrt_risk' => $hrt_risk,
			'medication' => $medication,
			'smoker' => $smoker,
			'caffeine' => $caffeine,
			'alcohol' => $alcohol,
			'period_frequency' => $period_frequency,
		);

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$rsdupli = $db->getData($ctable, '*', 'title = "'.$title.'" AND isArchived=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{
				$max_order = (int) $db->getValue($ctable, 'MAX(display_order)', 'isArchived=0');
				$rows["display_order"] = $max_order+1;

				$suggestion_id = $db->insert($ctable, $rows);

				// add symptoms
				foreach ($symptom as $symptom_id) {
					$rows = array(
							'suggestion_id' => $suggestion_id, 
							'symptom_id' => $symptom_id, 
						);
					$db->insert('symptom_suggestion', $rows);
				}
				
				$_SESSION['MSG'] = 'Inserted';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$suggestion_id = $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'title = "'.$title.'" AND id <> ' . $suggestion_id . ' AND isArchived=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$suggestion_id.'/');
				exit;
			}
			else
			{
				$db->update($ctable, $rows, 'id='.$suggestion_id);

				// delete existing symptoms
				$db->delete('symptom_suggestion', 'suggestion_id=' . (int) $suggestion_id);

				// add symptoms
				foreach ($symptom as $symptom_id) {
					$rows = array(
							'suggestion_id' => $suggestion_id, 
							'symptom_id' => $symptom_id, 
						);
					$db->insert('symptom_suggestion', $rows);
				}
								
				$_SESSION['MSG'] = 'Updated';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 		= ' id='.$_REQUEST['id'].' AND isArchived=0';
		$ctable_r 	= $db->getData($ctable, '*', $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$suggestion_id = $ctable_d['id'];
		$title = stripslashes($ctable_d['title']);
		$track_link = stripslashes($ctable_d['track_link']);
		$book_expert_link = stripslashes($ctable_d['book_expert_link']);
		$book_class_link = stripslashes($ctable_d['book_class_link']);
		$shop_link = stripslashes($ctable_d['shop_link']);
		$download_link = stripslashes($ctable_d['download_link']);
		$email_cta = stripslashes($ctable_d['email_cta']);
		$descr = stripslashes($ctable_d['descr']);
		$involved = stripslashes($ctable_d['involved']);
		$days = stripslashes($ctable_d['days']);
		$day_started = stripslashes($ctable_d['day_started']);
		$isCompleted = stripslashes($ctable_d['isCompleted']);

		$isMedical = stripslashes($ctable_d['isMedical']);
		$isComplementary = stripslashes($ctable_d['isComplementary']);
		$hrt_risk = explode(',', $ctable_d['hrt_risk']);
		$medication = explode(',', $ctable_d['medication']);
		$smoker = explode(',', $ctable_d['smoker']);
		$caffeine = explode(',', $ctable_d['caffeine']);
		$alcohol = explode(',', $ctable_d['alcohol']);
		$period_frequency = stripslashes($ctable_d['period_frequency']);
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id = $_REQUEST['id'];
		$rows = array('isArchived' => '1');
		
		$db->update($ctable, $rows, 'id='.$id);
		
		$_SESSION['MSG'] = 'Deleted';
		$db->location(ADMINURL.'manage-'.$page.'/');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $page_title . ' | ' . ADMINTITLE; ?></title>
		<?php include('include/css.php'); ?>
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	</head>

	<body>
		<div class="container-scroller">
			<?php include("include/header.php"); ?>
			<div class="container-fluid page-body-wrapper">
				<?php include("include/left.php"); ?>
				<div class="main-panel">
					<div class="content-wrapper">
						<div class="page-header">
							<h3 class="page-title">
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi-contacts"></i>
							</span> <?php echo $page_title; ?> </h3>
						</div>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
									<form class="forms-sample" role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="title">Title <code>*</code></label>
														<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" value="<?php echo $title; ?>" maxlength="250">
													</div>
												</div>

												<fieldset class="mb-4 mt-0">
													<legend>CTA Links</legend>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="track_link">CTA Try & Track Link </label>
																<input type="text" name="track_link" id="track_link" class="form-control" placeholder="Enter Download Link" value="<?php echo $track_link; ?>" maxlength="400">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="book_expert_link">CTA Book an Expert Link </label>
																<input type="text" name="book_expert_link" id="book_expert_link" class="form-control" placeholder="Enter Download Link" value="<?php echo $book_expert_link; ?>" maxlength="400">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="book_class_link">CTA Book a Class Link </label>
																<input type="text" name="book_class_link" id="book_class_link" class="form-control" placeholder="Enter Download Link" value="<?php echo $book_class_link; ?>" maxlength="400">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="shop_link">CTA Shop (Buy Now) Link </label>
																<input type="text" name="shop_link" id="shop_link" class="form-control" placeholder="Enter Download Link" value="<?php echo $shop_link; ?>" maxlength="400">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="download_link">CTA Download Link </label>
																<input type="text" name="download_link" id="download_link" class="form-control" placeholder="Enter Download Link" value="<?php echo $download_link; ?>" maxlength="400">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<input type="checkbox" name="email_cta" id="email_cta" value="1" <?php if($email_cta) echo ' checked'; ?>>
																<label for="email_cta">Email CTA? </label>
															</div>
														</div>
													</div>
												</fieldset>
												<div class="col-md-6">
													<div class="form-group">
														<label for="descr">Description <code>*</code></label>
														<textarea name="descr" id="descr" rows="15" class="form-control summernote"><?php echo $descr; ?></textarea>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="involved">What's Involved? <code>*</code></label>
														<textarea name="involved" id="involved" rows="15" class="form-control summernote"><?php echo $involved; ?></textarea>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="days">Days </label>
														<input type="number" name="days" id="days" class="form-control" placeholder="Enter Days" value="<?php echo $days; ?>" maxlength="2">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="day_started">Day Started </label>
														<input type="number" name="day_started" id="day_started" class="form-control" placeholder="Enter Day Started" value="<?php echo $day_started; ?>" maxlength="2">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<div class="button-list">	
															<div class="btn-switch btn-switch-dark pull-right">
																<input type="checkbox" name="isCompleted" id="isCompleted" value="1" <?php if($isCompleted=="1"){ echo "checked";}?>/>
																<label for="isCompleted" class="btn btn-rounded btn-dark waves-effect waves-light">
																	<em class="mdi mdi-check"></em>
																	<strong> Is Completed? </strong>
																</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<div class="button-list">	
															<div class="btn-switch btn-switch-dark pull-right">
																<input type="checkbox" name="isMedical" id="isMedical" value="1" <?php if($isMedical=="1"){ echo "checked";}?>/>
																<label for="isMedical" class="btn btn-rounded btn-dark waves-effect waves-light">
																	<em class="mdi mdi-check"></em>
																	<strong> For Medical? </strong>
																</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<div class="button-list">	
															<div class="btn-switch btn-switch-dark pull-right">
																<input type="checkbox" name="isComplementary" id="isComplementary" value="1" <?php if($isComplementary=="1"){ echo "checked";}?>/>
																<label for="isComplementary" class="btn btn-rounded btn-dark waves-effect waves-light">
																	<em class="mdi mdi-check"></em>
																	<strong> For Complementary? </strong>
																</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<label for="smoker[]">Smoker?</label>
													<div class="form-group">
														<input type="checkbox" name="smoker[]" value="1" <?php if(in_array(1, $smoker)) echo 'checked'; ?>> Yes
														<input type="checkbox" name="smoker[]" value="0" <?php if(in_array(0, $smoker)) echo 'checked'; ?>> No
													</div>
												</div>
												<div class="col-md-4">
													<label for="caffeine[]">Caffeine?</label>
													<div class="form-group">
														<input type="checkbox" name="caffeine[]" value="1" <?php if(in_array(1, $caffeine)) echo 'checked'; ?>> Yes
														<input type="checkbox" name="caffeine[]" value="0" <?php if(in_array(0, $caffeine)) echo 'checked'; ?>> No
													</div>
												</div>
												<div class="col-md-4">
													<label for="alcohol[]">Alcohol?</label>
													<div class="form-group">
														<input type="checkbox" name="alcohol[]" value="1" <?php if(in_array(1, $alcohol)) echo 'checked'; ?>> Yes
														<input type="checkbox" name="alcohol[]" value="0" <?php if(in_array(0, $alcohol)) echo 'checked'; ?>> No
													</div>
												</div>
												<div class="col-md-4">
													<label for="medication[]">Medication?</label>
													<div class="form-group">
														<input type="checkbox" name="medication[]" value="1" <?php if(in_array(1, $medication)) echo 'checked'; ?>> Yes
														<input type="checkbox" name="medication[]" value="0" <?php if(in_array(0, $medication)) echo 'checked'; ?>> No
													</div>
												</div>
												<div class="col-md-4">
													<label for="hrt_risk[]">HRT Risk?</label>
													<div class="form-group">
														<input type="checkbox" name="hrt_risk[]" value="1" <?php if(in_array(1, $hrt_risk)) echo 'checked'; ?>> Yes
														<input type="checkbox" name="hrt_risk[]" value="0" <?php if(in_array(0, $hrt_risk)) echo 'checked'; ?>> No
													</div>
												</div>
											</div>
											<fieldset>
												<legend>Symptoms</legend>
												<div class="row">
												<?php
													$arsymptom_id = array();
													$arsymptom = $db->getData('symptom_suggestion', 'symptom_id', 'suggestion_id=' . (int) $suggestion_id);
													foreach ($arsymptom as $symp) {
														array_push($arsymptom_id, $symp['symptom_id']);
													}
													$symptoms = $db->getData('symptom', '*', 'isArchived=0', 'name');
													foreach ($symptoms as $symptom) {
												?>
													<div class="col-md-4">
														<input type="checkbox" name="symptom[]" value="<?php echo $symptom['id']; ?>" <?php if(in_array($symptom['id'], $arsymptom_id)) echo 'checked'; ?>> <label><?php echo $symptom['name']; ?></label>
													</div>
												<?php
													}
												?>
												</div>
											</fieldset>
										</div>
										<div class="card-footer">
											<button type="submit" name="submit" id="submit" title="Submit" class="btn btn-gradient-success btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
											<button type="button" title="Back" class="btn btn-gradient-light btn-icon-text" onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/'"><i class="mdi mdi-step-backward"></i> </button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- content-wrapper ends -->
					<?php include("include/footer.php"); ?>
				</div>
				<!-- main-panel ends -->
			</div>
			<!-- page-body-wrapper ends -->
		</div>
		<?php include('include/js.php'); ?>
		<script type="text/javascript" src="<?php echo ADMINURL; ?>assets/js/ckeditor/ckeditor.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
		<script type="text/javascript">
			//CKEDITOR.replace('descr');
			//CKEDITOR.replace('involved');

			$(function(){
				$('.summernote').summernote({
		            toolbar: [
		                ['style', ['style']],
		                  ['font', ['bold', 'underline', 'clear']],
		                  ['fontsize', ['fontsize']],
		                  ['fontname', ['fontname']],
		                  ['color', ['color']],
		                  ['para', ['ul', 'ol', 'paragraph']],
		                  ['table', ['table']],
		                  ['insert', ['link', 'picture', 'video']],
		                  ['view', ['fullscreen', 'codeview', 'help']],
		              ],
		            height: 240,                 // set editor height
		            minHeight: 240,             // set minimum height of editor
		            maxHeight: null,             // set maximum height of editor
		            focus: false                 // set focus to editable area after initializing summernote
		        });

				$("#frm").validate({
					ignore: "",
					rules: {
						title:{required:true}, 
						//download_link:{required:true}, 
						descr:{required:function() { 
							//CKEDITOR.instances.descr.updateElement(); 
						}},
						involved:{required:function() { 
							//CKEDITOR.instances.involved.updateElement(); 
						}},
					},
					messages: {
						title:{required:"Please enter title."},
						//download_link:{required:"Please enter CTA download link."},
						descr:{required:"Please enter description."},
						involved:{required:"Please enter what's involved."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>