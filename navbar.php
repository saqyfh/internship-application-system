<style>
/****** START ADMIN NAVBAR *****/

.headerMenu
{
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    z-index: 1002;
    background: #fff;
    min-height: 30px!important; /* Reduced height */
    padding: 10px !important; /* Reduced padding */
    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
}

.nav-item-button
{
    padding: 10px;
    line-height: 1;display: block;
    border: 1px solid #f0f0f8;
    background-color: #fff;
    text-decoration: none;
    border-radius: 3px;
    color: #66686d;
}

.dropdown .nav-item-button:hover,.dropdown .nav-item-button:focus
{
    color: white;
    background-color: #06adef !important;
    border-color: #06adef !important;
}

.navbar-brand 
{
    font-family: inherit;
    color: #323f52;
    height: inherit;
    padding: 0px;
    line-height: 1px;
    font-weight: bolder;
    font-size: 20px;
}

.sidenav-menu-heading
{
    padding: 1.25rem 1rem 0.75rem;
    font-size: 0.7rem;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.01em;
    color: #a2acba;
}

.active_link 
{
    text-decoration: none;
    background: #06adef;
    color: #fff !important;
}

.active_link i
{
    color: #fff !important;
}

.angleBottom
{
    position:absolute;
    right:0;    
    padding-right: 20px;
    font-size: large;
}

.nav .open>a, .nav .open>a:focus, .nav .open>a:hover 
{
    background-color: #06adef;
    border-color: #06adef;
}

.sub
{
    display: none; 
    color:white;
    overflow:hidden; 
    padding:0
}

.sub-nav-item>.a-verMenu
{
    padding-left: 35px;
    color: rgba(255,255,255,.8);
}

.vertical-menu
{
    width:200px;
    float: left;
    height: 100%;
    position: fixed;
    background: #fff;
    top: 0;
    bottom: 0;
    z-index: 300;
    -moz-box-shadow: -3px 0 10px 0 #555;
    -webkit-box-shadow: -3px 0 10px 0 #555;
    box-shadow: -3px 0 10px 0 #555;
    overflow-y: scroll;
}

.vertical-menu .menu-bar
{
    padding:0px;
    margin:0px;
    margin-top: 75px;
    position: relative;
}

.a-verMenu 
{
    display: -webkit-box;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    line-height: normal;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    position: relative;
    color: #1f2d41;
    padding: 0.75rem 1rem;
    transition: 0.3s;
}

.icon-ver 
{
    width: 25px;
    height: 18px;
    text-align: center;
    font-size: 15px;
    background: none;
    margin: 0;
    padding: 0;
    color: #a2acba;
    font-weight: 900;
    display: block;
}

.top-menu 
{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}

.webpage-btn .nav-item-button 
{
    font-weight: 700;
    color: #fff;
    background: #26dd7d;
    border: 1px solid #26dd7d;
}

.top-nav .top-menu .main-li 
{
    float: left;
    margin-left: 10px;
}

.a-verMenu:hover 
{
    text-decoration: none;
    background: #06adef;
    color: #fff;
}

.a-verMenu:hover i 
{
    color: #fff !important;
}

.icon-button{
    position: relative;
    display:flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    color: black;
    background: none;
    border: none;
    outline: none;
    border-radius: 50%;
}

.icon-button:hover{
    cursor: pointer;
    background: #cccccc;
}

.icon-button:active{
    background: #cccccc;
}

.icon-button__badge{
    position: absolute;
    top: -10px;
    right: -10px;
    width: 20px;
    height: 20px;
    background: red;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
}

.sub {
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.sub-nav-item {
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    color: #66686d;
}

.sub-nav-item:hover {
    background-color: #f0f0f8;
    color: #06adef;
}



/**** END ADMIN NAVBAR  ***/
</style> 
    
    <!-- ADMIN NAVBAR HEADER -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=notifications" />
    <link rel="stylesheet" href="style.css">
    <header class="headerMenu сlearfix sb-page-header" style="min-height: 50px; padding: 5px 10px;>   
        <div class="nav-header">
            <a class="navbar-brand" href="#">
                Admin Panel
            </a> 
        </div>

        <div class="nav-controls top-nav">
            <ul class="nav top-menu">
                <li id="user-btn" class="main-li dropdown" style="background:none;">
                   <button type="button" class="icon-button">
                   <span class="material-symbols-outlined">notifications</span>
                   <span class="icon-button__badge">2</span>
                    </button> 
                </li>
                <li class="main-li webpage-btn">
                    <a class="nav-item-button " href="position.php" target="_blank">
                        <i class="fas fa-eye"></i>
                        <span>View website</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <!-- VERTICAL NAVBAR -->

    <aside class="vertical-menu" id="vertical-menu">
        <div>
            <ul class="menu-bar">
                <div class="sidenav-menu-heading">
                    Core
                </div>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="dashboard.php" class="a-verMenu dashboard_link">
                        <i class="fas fa-tachometer-alt icon-ver"></i>
                        <span style="padding-left:6px;">Dashboard</span>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <div class="sidenav-menu-heading">
                    Menus
                </div>
                <div class="dropdown-divider"></div>
                <li>
                    <a href="applicationView.php" class="a-verMenu content_categories_link">
                        <i class="fas fa-list icon-ver"></i>
                        <span style="padding-left:6px;">Applications</span>
                    </a>
                    <a href="appView.php" class="a-verMenu">
                        <i class="far fa-address-card icon-ver"></i>
                        <span style="padding-left:6px;">Applicants</span>   
                     </a>
                    <a href="positionView.php" class="a-verMenu positions_link">
                        <i class="far fa-user icon-ver"></i>
                        <span style="padding-left:6px;">Departments</span>
                    </a>
                </li>

                <div class="dropdown-divider"></div>
                <br><br>
                <li>
                    <a href="viewAdminDetailsInfo.php" class="a-verMenu admin_link">
                        <i class="far fa-user icon-ver"></i>
                        <span style="padding-left:6px;">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="viewAdminDetailsInfo.php" class="a-verMenu admin_link">
                        <i class="far fa-user icon-ver"></i>
                        <span style="padding-left:6px;">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <script>
    function toggleDropdown(event, dropdownId) {
        event.preventDefault();
        const dropdown = document.getElementById(dropdownId);
        if (dropdown) {
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }
    }
    </script>


    <!-- START BODY CONTENT  -->

    <div id="content" style="margin-left:240px;"> 
        <section class="content-wrapper" style="width: 100%;padding: 70px 0 0;">
            <div class="inside-page" style="padding:20px">
                <div class="page_title_top" style="margin-bottom: 1.5rem!important;">
                    <h1 style="color: #5a5c69!important;font-size: 1.75rem;font-weight: 400;margin-top:-100px;">
                        <?php echo $pageTitle; ?>
                    </h1>
                </div>