  <head>
    <title>Warranty Card</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>
        /* BASIC STYLES */
body {
  margin: 0;
  padding: 0;
  font-family: 'Roboto', sans-serif;
}

header {
  width: 100%;
}

ul {
  list-style: none;
}

/* NAV BAR */
#nav_bar {
  float: right;
}

#nav_bar li {
  display: inline-block;
  padding: 8px;
}

#nav_bar #sign_in {
  background: #4887ef; 
  margin-right: 25px;
  padding: 7px 15px;
  border-radius: 3px; 
  font-weight: bold;
}

.nav-links {
  color: #404040;
}

a {
  text-decoration: none;
  color: inherit;
}

li.nav-links a:hover {
  text-decoration: underline;
}

#sign_in:hover { 
  box-shadow: 1px 1px 5px #999;
}

#sign_in {
  color: #fff;
}

/* GOOGLE AREA */
.google #google_logo {
  text-align: center;
  display: block;
  margin: 0 auto;
  clear: both;
  padding-top: 112px;
  padding-bottom: 20px;
}

.form {
  text-align: center;
}

#form-search { 
  width: 450px;
  line-height: 32px;
  padding: 20px 10px;
}

.form #form-search {
  padding: 0 8px;
}

/*#form-search:hover {
  border-color: #e4e4e4;
  padding-top: 0;
}*/

.buttons {
  text-align: center;
  padding-top: 30px;
  margin-bottom: 300px;
}

/* FOOTER */
footer  {
  background: #f2f2f2;
  border-top: solid 2px #e4e4e4;
/*   position: fixed; */
  bottom: 0;
  padding-bottom: 0;
  width: 100%;
  
}

footer ul li {
  display: inline;
  color: #666666;
  font-size: 14px;
  padding: 13px;
}

footer ul {
  float: left;
  padding: 1px;
}

footer ul a:hover {
  text-decoration: underline;
}

.footer-right {
  float: right;
}

/* MEDIA QUERIES */

@media screen and (max-width: 400px) {
 
 li.nav-links a {
    display: none;
  }
  
 #google_logo {
   padding: 0;
 }
  
 .buttons {
   display: none;
 }
  
 #form-search {
   width: 80%;

 }
  
 footer {
   bottom: 0;
 }
  
 footer ul {
   float: none;
   padding-bottom: 2px;
    
 }
  
 .footer-left {
   text-align: center;
   margin: auto; 
   padding-top: 10px;
    
 }
  
 .footer-right {
   float: none;
   text-align: center;
   
 }
}

@media screen and (max-width: 565px) {
 
  li.nav-links a {
    display: none;
  }
  
  
 #google_logo {
   padding: 0;
 }
  
 .buttons {
   display: none;
 }
  
 #form-search {
   width: 80%;

 }
  
 footer {
/*    bottom: 0;
   postion: absolute; */
   position:absolute;
   bottom:0;
   width:100%;
   height:60px;
 }
  
 footer ul {
   float: none;
   padding-bottom: 2px;
    
 }
  
 .footer-left {
   text-align: center;
   margin: auto; 
   padding-top: 10px;
    
 }
  
 .footer-right {
   float: none;
   text-align: center;
   
 }
}
    </style>
  </head>
  
  <body>
    
    <!-- GOOGLE IMG -->  
    <div class="google">
      <a href="#" id="google_logo"><img src="https://www.rpddentalart.com/wp-content/uploads/2020/07/Logo-with-Tagline-1-1-2048x638.png" style="width: 180px"/></a>
    </div>
    
    <!-- FORM SEARCH -->  
    <div class="form">  
      	<form action="<?= base_url('validate/warrantycard');?>" method="post">
    		<input type="text" name="wc" placeholder="Enter Card Number"/>
    		<input type="submit" name="btn" value="Download" />
    	</form>
    </div>  
      
  </body>
