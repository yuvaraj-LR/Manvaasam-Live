<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <!--include fav icon to all pages-->
    <link rel="icon" type="image/x-icon" href="images/fav_icon.png">

    <!-- fontawsome links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap links -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
      integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
      integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk"
      crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- custom css file link -->
    <link href="/css/HomepageStyle.css" rel="stylesheet">
    <link href="/css/GeneralStyle.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <link href="/css/AboutStyle.css" rel="stylesheet">
 

    <!--for playstore icon-->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>LMS Enquiry Form</title>
  </head>

<body style="background-image: url('images/bg.png');">
  <div class="enquiry-form pt-5">
      
     <h1 class="text-center mb-5" style="font-weight: bold; color:black; ">Booking a demo for Manvaasam Learning Management System</h1>

      <div class="container-fluid">
          <div class="col-lg-8 mx-auto">
              
            <div class="card mt-2 mx-auto p-4 card-body ">
                
                <div class="container">
                  <form id="contactform" method="post" action="https://formsubmit.co/training@manvaasam.com" role="form">
                      
                      <!--refer formsubmit.com documentation  -->
                      
                      <input type="hidden" name="_template" value="table">
                      <input type="hidden" name="_next" value="https://manvaasam.com/#lms">

                      <input type="hidden" name="_subject" value="LMS Demo request from manvaasam.com">
                      <input type="hidden" name="_autoresponse" 
                             value="Thank you for Booking a demo session with Manvaasam Learning System. Our team will contact you soon. Happy Learning! ">
                      
                      
                      <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="form_name">Name</label>
                            <input id="form_name" type="text" name="name" class="form-control"
                              placeholder="Enter your name *" required="required"
                              data-error="Firstname is required.">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="form_contactno">Mobile Number </label>
                            <input id="form_contactno" type="tel" name="phone number" class="form-control"
                              placeholder="Enter your mobile number *" required="required"
                              data-error="Lastname is required.">
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="form_date">Date </label>
                            <input id="form_date" type="date" name="date" class="form-control"
                              placeholder="Date *" required="required" min="<?php echo date("Y-m-d");?>"
                              data-error="Valid email is required.">
                        </div>
                      </div>
                        
                      <div class="row">
                          <div class="col-md-6 form-group">
                              <label for="form_email">Email </label>
                              <input id="form_email" type="email" name="email" value="" class="form-control"
                                placeholder="Enter your email id *" required="required"
                                data-error="Valid email is required.">
                          </div>
                          <div class="col-md-6 form-group">
                              <label for="form_timings">Please select your timimg </label>
                              <select id="form_timings" name="timings" class="form-control" required="required"
                                data-error="Please specify your TIME ">
                                <option value="" selected disabled>--Select Your time--</option>
                                <option>7:00 PM - 9:00 PM</option>
                                <option>10:00 AM - 12:00 PM</option>
                                <option>3:00 PM - 5:00 PM</option>
                              </select>
                          </div>
                     </div>
                        
                      <div class="row">
                          <div class="col-md-12 form-group">
                              <label for="form_message">Message </label>
                              <textarea id="form_message" name="message" class="form-control"
                                placeholder="Write your message here." rows="4"
                                data-error="Please, leave us a message."></textarea>
                          </div>
                      </div>
                      
                     <div class="row">
                          <div class="col-md-12 d-flex justify-content-center">
                            <input type="submit" class="btn btn-success btn-send m-2  pt-2 btn-block" value="Schedule">
                          </div>
                    </div>

                  </form>
                </div>


            </div>
            <!-- /.8 -->

          </div>
          <!-- /.row-->

        </div>
    </div>
  
</body>
        <script>
            function myFunc(){
                windows.alert("Your demo has been scheduled successfully. Our team will connect with you shortly");
            }
        </script>

</html>