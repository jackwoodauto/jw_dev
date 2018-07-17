<?php

include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_header_v2.0.php");

?>





         <div class="container">
           <div class="row">
             <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
               <div class="contact-form-area">
                 <h2>Contact form</h2>
                   <form method="post" name="contact_form" action="contact_form_handler">
                     <fieldset>
                       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                         <div class="form-group">
                           <label>Name : </label>
                           <input type="text" name="name" class="form-control" value="<?php echo $_SESSION['$cap_name']; ?>" required>
                         </div>
                       </div>
                       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                         <div class="form-group">
                           <label>E-mail : </label>
                           <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['$cap_email']; ?>"   required>
                         </div>
                       </div>
                       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                         <div class="form-group">
                           <label>Phone Number : </label>
                           <input type="tel" name="telephone" class="form-control" value="<?php echo $_SESSION['$cap_telephone']; ?>" required>
                         </div>
                       </div>
                       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                         <div class="form-group">
                           <label>Message : </label>
                           <textarea cols="40" rows="5" type="text" name="message" class="form-control" value="<?php echo $_SESSION['$cap_message']; ?>" required><?php echo $_SESSION['$cap_message']; ?> </textarea>
                         </div>
                       </div>
                       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                         <div class="form-group">
                           <button class="btn-send submit-buttom" type="submit">SEND APPLICATION</button>
                         </div>
                       </div>
                     </fieldset>
                 </form>
               </div>
             </div>
						 </div>
						 </div>
<?php

	 include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");

?>
