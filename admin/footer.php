<?php
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header('Location: login.php');
    }
?>

<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>

<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        <a href="logout.php" type="button" class="btn btn-default">Logout</a>
    </div>
    <strong>Copyright &copy; 2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>
</div>

</body>

</html>