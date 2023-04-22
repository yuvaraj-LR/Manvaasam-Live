<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Logistics - Manvaasam</title>
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

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
    integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk"
    crossorigin="anonymous"></script>
  <!-- custom css file link -->

  <link href="/css/LogisticStyle.css" rel="stylesheet">
  <link href="/css/GeneralStyle.css" rel="stylesheet" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
  <!--for playstore icon-->
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  

  <style>
    a{
      text-decoration: none;
    }
        /*deepsea 😉*/

*{
	
	
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	text-decoration: none;
	outline: none;
	list-style: none;

}


*,
*::before,
*::after {
    margin: 0;
	padding: 0;
	box-sizing: border-box;
	text-decoration: none;
	outline: none;
	list-style: none;
}

        .floats{
        	position:fixed;
        	width:53px;
        	height:53px;
        	bottom:100px;
        	right:24px;
        	background-color:#FFFF00;
        	color:#000;
        	border-radius:50px;
        	text-align:center;
        	box-shadow: 2px 2px 3px #999;
        }
        .floats:hover{
          background-color:#111;
          color:#FFF;
        }
        .floats2{
    	position:fixed;
    	width:53px;
    	height:53px;
    	bottom:30px;
    	right:24px;
        background-color:#00FF00;
    	color:#fff;
    	border-radius:50px;
    	text-align:center;
    	box-shadow: 2px 2px 3px #999;
    }
    .my-float{
    	margin-top:15px;
    }
    .my-float2{
    	margin-top:11px;
    }
    #ps{
       font-size: 26px;
    }
    #ps2{
        font-size: 30px;
    }


:root {
  --step--2: clamp(0.69rem, calc(0.58rem + 0.60vw), 1.00rem);
  --step--1: clamp(0.83rem, calc(0.67rem + 0.81vw), 1.25rem);
  --step-0: clamp(1.00rem, calc(0.78rem + 1.10vw), 1.56rem);
  --step-1: clamp(1.20rem, calc(0.91rem + 1.47vw), 1.95rem);
  --step-2: clamp(1.44rem, calc(1.05rem + 1.95vw), 2.44rem);
  --step-3: clamp(1.73rem, calc(1.21rem + 2.58vw), 3.05rem);
  --step-4: clamp(2.07rem, calc(1.39rem + 3.40vw), 3.82rem);
  --step-5: clamp(2.49rem, calc(1.60rem + 4.45vw), 4.77rem);
	
	/* Font style */
	
	--ff-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
	
	/* Color style */
	
	/*
	--color-primary:#c51350;
	--color-secondary:#ff9a3c;
	--color-body:#333;
	--color-bg: #006600;
	--color-primary-dark:#007f67;
	--color-error:#cc3333;
	--color-success:#4bb544;
	--color-link:#cdcdcc;
	--color-border:darkgrey;
	--bs:#ffa857;
	*/
	
	--color-primary: #0575E6;
	--color-secondary: #6dd5ed;
	--color-primary-light:#8dc6ff;
	--color-primary-dark:#021B79;
	--color-error:#cc3333;
	--color-success:#4bb544;
	--color-link:#606470;
	--color-header-dark:#393e46;
	--color-background:#f5f9ee;
	--color-border-sc:#ececec;
	--color-border-focus:#a9d7f6;
	--color-border:#eeeeee;
	--bs:#ffa857;
	--color-percentage:#5f6769;
	--color-header-light:#9ba6a5;
	--color-border-focus:#a9d7f6;
	--color-input-background:#f5f9ee;
	--gradient: linear-gradient(135deg var(--color-primary), var(--color-secondary));
	
	
}

/* Remove default margin */


/* Remove list styles on ul, ol elements with a list role, which suggests default styling will be removed */

ul[role='list'],
ol[role='list'] {
  list-style: none;
}

/* Set core root defaults */
html:focus-within {
  scroll-behavior: smooth;
}

/* Set core body defaults */


/* A elements that don't have a class get default styles */
a:not([class]) {
 text-decoration-skip-ink: auto;
}

/* Make images easier to work with */

/* Inherit fonts for inputs and buttons */
input,
button,
textarea,
select {
  font: inherit;
}

/* Remove all animations, transitions and smooth scroll for people that prefer not to see them */
@media (prefers-reduced-motion: reduce) {
  html:focus-within {
   scroll-behavior: auto;
  }
  
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}

html, body {
  height: 100%;
}


@media only screen and (max-width: 600px) {
  #content_box{
    flex-direction:column;
  }
}

@keyframes appear {
	0% {
		opacity: 0;
		transform: translate(0, 50px);
	}
	
	100% {
		opacity: 1;
	}
}
  </style>
</head>
 
<body style="background-color:#ffffff;">

<?php include('navbar.php'); ?>

  <!--Content starts here-->
  <div class="row container-fluid" id="content_box">
    <div class="col">
         <img src="mathi/images/logistics_imgs/log.jpeg" alt="Transport Systems" width="100%" height="100%" style="object-fit:contain;" class="image-fluid mt-5">
    </div>
    <div class="col pt-5" id="content_area">
        <br><br><br>
        <div class="col-m-6 p-5 pb-1">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">TRACK YOUR COURIERS HERE</h5> <br>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Courier ID" aria-label="Courier ID" aria-describedby="button-addon">
                <button class="btn btn-success" type="button" id="button-addon">TRACK NOW</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-m-6 p-5 pb-0">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">WANT TO BECOME A DEALER IN MANVAASAM LOGISTICS ?</h5> <br>
              <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
              <a href="https://forms.gle/kanHYMLLnMPuFkLa9" class="btn btn-success" target="_blank">JOIN NOW</a>
            </div>
          </div>
        </div>
        <div class="img-fluid" id="moving">
          <img src="images/logistics_imgs/log1-removebg-preview.png" alt="shipment" width="150px" height="150px" style="object-fit:cover;">
        </div>
    </div>
  </div>
  
    <!--Playstore floating icon-->
  <a href="https://play.google.com/store/apps/details?id=com.manvaasam.student" class="floats" target="_blank">
        <i class="fab fa-google-play my-float" id="ps"></i>
  </a>
  <a href="https://chat.whatsapp.com/Jmb1DBNVkTPIWLQO7EYA64" class="floats2" target="_blank">
        <i class="fa fa-whatsapp my-float2" id="ps2"></i>
  </a>

    <!-- Footer -->
<?php include('footer.php'); ?><!-- End Footer -->


<script>
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "https://manvaasam.com/Logistics/track.php");
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        console.log(xhr.status);
        console.log(xhr.responseText);
      }};

    let data = `{
      "Id": 78912,
      "Customer": "Jason Sweet",
      "Quantity": 1,
      "Price": 18.00
    }`;

    xhr.send(data);

</script>
 <script>
  const toggleMenu = () => {
	document.body.classList.toggle("open");
};
</script>
</body>
</html>