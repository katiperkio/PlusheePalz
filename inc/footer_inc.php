</main>
<footer>
    <p class="copyright">
        &copy;
        <script>
            document.write(new Date().getFullYear());
        </script>
        Plushee Palz
        <br>
        Icons created by <a href="https://www.flaticon.com/free-icons/lullaby" title="lullaby icons">Freepik - Flaticon</a>
    </p>
</footer>
<?php include "./ajax/like.php"; ?>
<script src=" ./js/main.js"></script>
<script>
    <?php
    if ($_SESSION['add_palz'] == "success") {
    ?>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your Palz has been added",
            showConfirmButton: false,
            timer: 2500,
            didOpen: function() {
                <?php
                unset($_SESSION['add_palz']);
                ?>
            }
        });
    <?php
    }
    ?>
</script>
</body>

</html>