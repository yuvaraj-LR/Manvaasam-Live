<html>
    <!--fa fa icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
     
  
      <style>
    /*navbar styles*/
    
.toggle,
[id^="drop"] {
  display: none;
}

/* Giving a background-color to the nav container. */
nav {
  margin: 0;
  padding: 0;
  background-color: #fff;
  position:fixed;
  top:0;
  width:100%;
  z-index:100;
  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
  

}
.menu {

}
#logo {
  display: block;
  padding: 0 20px;
  float: left;
  font-size: 20px;
  line-height: 60px;
}

/* Since we'll have the "ul li" "float:left"
 * we need to add a clear after the container. */

nav:after {
  content: "";
  display: table;
  clear: both;
}

/* Removing padding, margin and "list-style" from the "ul",
 * and adding "position:reltive" */
nav ul {
  float: right;
  padding: 0;
  margin: 0;
  list-style: none;
  position: relative;
}

/* Positioning the navigation items inline */
nav ul li {
  margin: 0px;
  display: inline-block;
  float: left;
  background-color: white;
}

/* Styling the links */
nav a {
  display: block;
  padding: 14px 20px;
  color: #333;
  font-size: 17px;
  text-decoration: none;
}

/* Background color change on Hover */
nav a:hover {
  color: green;
  font-weight: 600;

  border-radius: 50px;
}

/* Hide Dropdowns by Default
 * and giving it a position of absolute */
nav ul ul {
  display: none;
  position: absolute;
  /* has to be the same number as the "line-height" of "nav a" */
  top: 60px;
}

/* Display Dropdowns on Hover */
nav ul li:hover > ul {
  display: inherit;
}

/* Fisrt Tier Dropdown */
nav ul ul li {
  width: 170px;
  float: none;
  display: list-item;
  position: relative;
}

/* Second, Third and more Tiers	
 * We move the 2nd and 3rd etc tier dropdowns to the left
 * by the amount of the width of the first tier.
*/
nav ul ul ul li {
  position: relative;
  top: -60px;
  /* has to be the same number as the "width" of "nav ul ul li" */
  left: 170px;
}

/* Change ' +' in order to change the Dropdown symbol */
li > a:after {
  content: " +";
}
li > a:only-child:after {
  content: "";
}

/* Media Queries
--------------------------------------------- */

@media all and (max-width: 768px) {
  #logo {
    display: block;
    padding: 0;
    width: 100%;
    text-align: center;
    float: none;
  }

  nav {
    margin: 0;
  }

  /* Hide the navigation menu by default */
  /* Also hide the  */
  .toggle + a,
  .menu {
    display: none;
  }

  /* Stylinf the toggle lable */
  .toggle {
    display: block;
    background-color: rgb(7, 84, 35);
    padding: 14px 20px;
    color: #fff;
    font-size: 17px;
    text-decoration: none;
    border: none;
  }

  /* Display Dropdown when clicked on Parent Lable */
  [id^="drop"]:checked + ul {
    display: block;
  }

  /* Change menu item's width to 100% */
  nav ul li {
    display: block;
    width: 100%;
  }

  nav ul ul .toggle,
  nav ul ul a {
    padding: 0 40px;
  }

  nav ul ul ul a {
    padding: 0 80px;
  }

  nav ul li ul li .toggle,
  nav ul ul a,
  nav ul ul ul a {
    padding: 14px 20px;
    color: #fff;
    font-size: 17px;
  }

  nav ul li ul li .toggle,
  nav ul ul a {
    background-color: rgb(243, 255, 243);
    color: #00b803;
  }

  /* Hide Dropdowns by Default */
  nav ul ul {
    float: none;
    position: static;
    color: #ffffff;
    /* has to be the same number as the "line-height" of "nav a" */
  }

  /* Hide menus on hover */
  nav ul ul li:hover > ul,
  nav ul li:hover > ul {
    display: none;
  }

  /* Fisrt Tier Dropdown */
  nav ul ul li {
    display: block;
    width: 100%;
  }

  nav ul ul ul li {
    position: static;
    /* has to be the same number as the "width" of "nav ul ul li" */
  }
}

@media all and (max-width: 330px) {
  nav ul li {
    display: block;
    width: 94%;
  }
}

    /*navbar style end*/
</style>
      <nav>
      <div id="logo">

        <a href="#">
          <img src="images/manvasam_logo.png" height="47" alt="logo" loading="lazy"
            style="margin-top: -1px;" />
        </a>
      </div>

      <label for="drop" class="toggle">Menu</label>
      <input type="checkbox" id="drop" />
      <ul class="menu">
        <li><a href="./index.php">HOME</a></li>

        <li><a target="_blank" href="https://www.manvaasam.in/">PRODUCTS</a></li>
        <li><a target="_blank" href="https://manvaasam.com/farm.php">FARM</a></li>
        <li><a target="_blank" href="https://lmsmanvaasam.newzenler.com/courses">COURSES</a></li>
        <li><a href="./gallery.php">GALLERY</a></li>
        <li><a href="./about.php">ABOUT US</a></li>
        <li>
          <!-- First Tier Drop Down -->
          <label for="drop-1" class="toggle">Login</label>
          <a href="#">LOGIN</a>
          <input type="checkbox" id="drop-1" />
          <ul>
            <li><a href="https://employee.manvaasam.com" target="_blank">MANVAASAM</a></li>
            <li><a href="https://lmsmanvaasam.newzenler.com/login" target="_blank">STUDENT LMS</a></li>
          </ul>
        </li>
        <li><a target="_blank" href="https://play.google.com/store/apps/details?id=com.manvaasam.student">
            <img src="images/gplay.png" height="35">
          </a>
        </li>
        <li><a target="_blank"
            href="https://docs.google.com/forms/d/e/1FAIpQLSdU3temNU7_tPoLRX__95b2Tdbw9frmZGswBFFx5AAM4tmZuA/viewform">
            <button style="background:green;color:white; padding:5px;border:none;border-radius:5px;">
              Join us</button></a>
        </li>

        <li><a target="_blank" href="https://chat.whatsapp.com/L419in2xs11E02ga8UTN2u">
            <button style="background:green;color:white; padding:6px;border:none;border-radius:5px;"><i class="fa fa-whatsapp"></i>
             Updates </button></a>
        </li>
      </ul>

    </nav>
</html>