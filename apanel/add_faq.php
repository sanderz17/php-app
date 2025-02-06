<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'faq';
	$ctable1 	= 'FAQ';
	$main_page 	= 'faq'; //for sidebar active menu
	$page		= 'faq';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$question = "";
	$answer	= "";

	if(isset($_REQUEST['submit']))
	{
		$max_order = (int) $db->getValue($ctable, 'MAX(display_order)', 'isDelete=0');

		$question 	= $db->clean($_REQUEST['question']);
		$answer 	= $db->clean($_REQUEST['answer']);
		
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$rows 	= array(
				'question'		=> $question,
				'answer' => $answer,
				'display_order' => $max_order+1,
			);

			$user_id = $db->insert($ctable, $rows);
			
			$_SESSION['MSG'] = 'Inserted';
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$rows 	= array(
				'question'=> $question,
				'answer' => $answer,
			);
			$db->update($ctable, $rows, 'id='.$id);
							
			$_SESSION['MSG'] = 'Updated';
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 		= ' id='.$_REQUEST['id'].' AND isDelete=0';
		$ctable_r 	= $db->getData($ctable, '*', $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$question = stripslashes($ctable_d['question']);
		$answer 	= stripslashes($ctable_d['answer']);
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id = $_REQUEST['id'];
		$rows = array('isDelete' => '1');
		
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
												<div class="col-md-9">
													<div class="form-group">
														<label for="question">Question <code>*</code></label>
														<input type="text" class="form-control" name="question" id="question" placeholder="Question" value="<?php echo $question; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-9">
													<div class="form-group">
														<label for="answer"> Answer <code>*</code></label>
														<textarea rows="6" cols="50" class="form-control" name="answer" id="answer" placeholder="Answer"><?php echo $answer; ?>
														</textarea>
													</div>
												</div>
											</div>
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
		<script src="<?php echo ADMINURL; ?>assets/js/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script type="text/javascript">

			$(function(){
				CKEDITOR.replace('answer');

				$("#frm").validate({
					ignore: "",
					rules: {
						question:{required:true}, 
						answer:{required:true},
					},
					messages: {
						question:{required:"Please enter question."},
						answer:{required:"Please enter answer."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>