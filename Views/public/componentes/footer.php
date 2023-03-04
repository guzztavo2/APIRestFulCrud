
</section>
<div class="w100 flexRow" style="height:10%; padding:1%; justify-content:center; align-items:center; background-color:black">
<h4 style="color:white;">Copyright 2023</h4>
</div>

<?php if(file_exists('./code/'.explode('.', $page)[0] . 'File.js')): ?>
    <script src="http://localhost/CRUD_PHP/code/<?php echo explode('.', $page)[0] . 'File' ?>.js"></script>
    <?php endif; ?>
</body>
</html>