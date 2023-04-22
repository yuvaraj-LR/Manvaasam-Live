<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

  <!-- fancy box links -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  
  <!--for playstore icon-->
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- custom css file link -->
 <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="/css/HomepageStyle.css" rel="stylesheet" type="text/css">
  <link href="/css/GeneralStyle.css" rel="stylesheet" type="text/css">
  
  <title>Gallery - Manvaasam</title>
  <link rel="icon" type="images/x-icon" href="images/fav_icon.png">
  
<style type="text/css">
a{
      text-decoration:none;
}
.item {
      transition: .5s ease-in-out;
}

.item:hover {
    filter: brightness(80%);
}
        /*deepsea 😉*/

/*playstore floating icon styles  */
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
/*playstore floating icon styles  */

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


  </style>

</head>

<body>
<?php include('navbar.php'); ?>
  <section class="gallery" style="background-color:#ffffff;">
    <div class="container-fluid p-3">
   <div class="section-title">
        <h1 data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500"> <br><br>
          Our Gallery
        </h1>
        <span data-aos="fade-up" data-aos-easing="linear" data-aos-duration="2000">Check out the great services.
          Take a look at our precious moments </span>
      </div>
      <div class="row mt-4">

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/1.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/1.jpg" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/2.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/2.jpg" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/3.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/3.jpg" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/4.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/4.jpg" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3">
        <a href="images/gallery/5.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/5.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/6.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/6.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/7.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/7.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/8.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/8.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/9.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/9.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/10.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/10.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/11.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/11.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/12.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/12.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/13.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/13.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/14.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/14.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/15.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/15.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/16.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/16.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/17.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/17.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/18.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/18.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/19.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/19.jpg" width="100%" height="100%">
          </a>
        </div>
        
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/20.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/20.jpg" width="100%" height="100%">
          </a>
        </div>

        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/21.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/21.jpg" width="100%" height="100%">
          </a>
        </div>
        <!--<div class="item col-sm-6 col-md-4 mb-3">-extra corrected by depak
          <a href="images/gallery/40.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/40.jpg" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/39.jpg" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/39.jpg" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/52.png" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/52.png" width="100%" height="100%">
          </a>
        </div>
       <div class="item col-sm-6 col-md-4 mb-3">
          <a href="images/gallery/53.png" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/53.png" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3"> 
          <a href="images/gallery/48.png" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/48.png" width="100%" height="100%">
          </a>
        </div>
        <div class="item col-sm-6 col-md-4 mb-3"> 
          <a href="images/gallery/54.png" class="fancybox" data-fancybox="gallery1">
            <img src="images/gallery/54.png" width="100%" height="100%">
          </a>
        </div>-->
      </div>
    </div>

  </section>
  
  <!--Playstore floating icon-->
  <a href="https://play.google.com/store/apps/details?id=com.manvaasam.student" class="floats" target="_blank">
        <i class="fab fa-google-play my-float" id="ps"></i>
  </a>
  <a href="https://chat.whatsapp.com/Jmb1DBNVkTPIWLQO7EYA64" class="floats2" target="_blank">
        <i class="fa fa-whatsapp my-float2" id="ps2"></i>
  </a>
  
  
   <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
   
   
  <!-- Footer -->
  <?php include('footer.php'); ?><!-- End Footer -->
  <!-- Footer -->
  
  
   <script>
  const toggleMenu = () => {
	document.body.classList.toggle("open");
};
</script>
  <script>
    $(function () {
      $("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
    });
  </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgy"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>