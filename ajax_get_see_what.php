<?php
    include("connect.php");
    $product_id = $_REQUEST['prouct_id'];
	$product_details = $db->getData("review_img","*","id=".$product_id." AND isDelete=0");
	$prod_row = mysqli_fetch_assoc($product_details);

   //  echo $prod_row['image_path']; 
// $response1 ="
//                  <div class='social-insta-modal-box'>
// 					 <div class='container p-0'>
// 						 <div class='row'>
// 							 <div class='col-md-8'>
//                              <a href='".SITEURL."product-details/".$prod_row['product_id']."' >
//                 <img src='".SITEURL."img/home/".$prod_row['image_path']."' class='product-social-image'>
//                 </a>
// 							  </div>
// 							  <div class='col-md-4'>
//                                    <div class='social-insta-modal-box-content'>
//                                         <h4> ".$prod_row['title']."</h4>
// 							       </div>
                               
// 								    <div class='hastages'>
// 								        <p> ".$prod_row['description']."</p>
// 							        </div>

//                                     <div class='social-insta-modal-box-content'>
//                                         <h5>@".$prod_row['name']."</h5>
// 							       </div>
// 							   </div>
// 						  </div>
// 					 </div>
//       </div>";

    $response1 ="
                 <div class='social-insta-modal-box'>
                     <div class='container p-0'>
                         <div class='row'>
                             <div class='col-md-8'>
                <img src='".SITEURL."img/home/".$prod_row['image_path']."' class='product-social-image'>
                              </div>
                              <div class='col-md-4'>
                                   <div class='social-insta-modal-box-content'>
                                        <h4> ".$prod_row['title']."</h4>
                                   </div>
                               
                                    <div class='hastages'>
                                        <p> ".$prod_row['description']."</p>
                                    </div>

                                    <div class='social-insta-modal-box-content'>
                                        <h5>@".$prod_row['name']."</h5>
                                   </div>
                               </div>
                          </div>
                     </div>
      </div>";

    //   $response='<form>
    //             <div class="form-group">
    //                 <label>Created Date</label>
    //                 <input type="text" class="form-control" value="789" readonly>
    //             </div>
    //             <div class="form-group">
    //                 <label>Author Name</label>
    //                 <input type="text" class="form-control" value="789" readonly>
    //             </div>
    //             <div class="form-group">
    //                 <label>Description</label>
    //                 <textarea rows="4" cols="50" class="form-control" readonly>789</textarea>
    //             </div>
    //         </form>';
 
// echo $response;
echo $response1;
exit;