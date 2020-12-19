<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php include ("conn.php");?>
    <link href="css.css" rel="stylesheet" type="text/css">
    <title></title>
</head>
<body>
<table width="500" border="0" align="center" cellpadding="5" bgcolor="#add3ef">
    <?php
    $sql="select * from message order by id desc";
    $res=$conn->query($sql);
    foreach ($res as $row){?>
        <tr bgcolor="#eff3ff">
            <td>标题：<?php echo $row['title'];?>用户：<?php echo $row['user'];?></td>
        </tr>
        <tr bgcolor="#ffffff">
            <td><div align="right">时间：<?php echo $row['lastdate'];?></div></td>
        </tr>
        <?php
    }
    ?>
    <tr bgcolor="#f0fff0">
        <td><div align="right"><a href="add.html">返回留言</div></td>
    </tr>
</table>
</body>
</html>