<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5 p-4">
    <div class="container">
        <a class="navbar-brand" href="./index.php">Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
            <form action="./search.php" method="post" class="form-inline my-2 my-lg-0" style="margin-left: 250px">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" name="searchButton" type="submit">Search</button>
            </form>
        </div>

        <ul class="navbar-nav">
            <?php if (!isset($_SESSION['user_name'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="./login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./register.php">Register</a>
            </li>
            <?php else: ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['user_name'] ?>
                    </button>
                    <div class="dropdown-menu">
                        <form action="../controller/index.php" method="post">
                            <button class="dropdown-item" type="submit" name="logout">Log out</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </ul>
    </div>
</nav>