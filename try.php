<html>
    <head>
        <meta charset="UTF-8"/>
        <title> Menu Bar | Khadijah Saqifah</title>
        <link rel="stylesheet" href="stye.css"/>
        <link rel = "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<style>
    *{
        margin:0;
        padding:0;
        outline: none;
        border: none;
        text-decoration: none;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body{
        background: #dfe9f5;
    }

    nav{
        position:absolute;
        top: 0;
        bottom:0;
        height:100%;
        left:0;
        background: #fff;
        width: 90px;
        overflow: hidden;
        transition: width 0.2s linear;
        box-shadow: 0.20px 35px rggba(0, 0, 0, 0.1);
    }

    .logo{
        text-align: center;
        display: flex;
        transition: all 0.5s ease;
        margin: 10px 0 0 10px;
    }

    .logo img{
        width:45px;
        height:45px;
        border-radius: 50%;
    }

    .logo span{
        font-weight:bold;
        padding-left: 15px;
        font-size: 18px;
        text-transform: uppercase;
    }

    a{
        position: relative;
        color: #153448;
        font-size: 14px;
        display: table;
        width: 300px;
        padding: 10px;
    }

    .fas{
        position: relative;
        width: 70px;
        height: 40px;
        top: 14px;
        font-size: 20px;
        text-align: center;
    }

    .nav-item{
        position: relative;
        top: 12px;
        margin-left: 10px;
    }

    a:hover{
        background: #eee;
    }

    nav:hover{
        width:280px;
        transition: all 0.5s ease;
    }

    .logout{
        position: absolute;
        bottom:0;
    }

</style>
<body>
     <nav>
        <ul>
            <li>
                <a href="#" class="logo">
                    <img src = "/logo.jpg" alt="">
                    <span class="nav-item">InternTracker</span>
                </a>
            </li>
            <li><a href="#">
                <i class="fas fa-user"></i>
                <span class="nav-item">Dashboard</span>
            </a></li>
            <li><a href="#">
                <i class="fas fa-user"></i>
                <span class="nav-item">Applicant</span>
            </a></li>
            <li><a href="#">
                <i class="fas fa-home"></i>
                <span class="nav-item">Applications</span>
            </a></li>
            <li><a href="#">
                <i class="fas fa-home"></i>
                <span class="nav-item">Departments</span>
            </a></li>
            <li><a href="#">
                <i class="fas fa-home"></i>
                <span class="nav-item">Settings</span>
            </a></li>
            <li><a href="#">
                <i class="fas fa-home"></i>
                <span class="nav-item">Report</span>
            </a></li>
            <li><a href="#" class="logout">
                <i class="fas fa-home"></i>
                <span class="nav-item">Logout</span>
            </a></li>
            
</body>
</html>