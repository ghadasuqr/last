
<?php
try{
    $host="localhost";
    $db="projectcopy";
    $user="root";
    $password="";
    $conn= new PDO("mysql:host=$host;dbname=$db" ,$user,$password);
    $conn->query("SET NAMES utf8"); 
    $conn->query("SET CHARACTER SET utf8");  
    }catch(PDOException $ex ){
     
        echo "Error !".$ex;
    
    
    }

if(isset ($_POST['categoryNo'])){
            $sql2="select * from imodels where categoryNo=".$_POST['categoryNo'] ;
            $result=$conn->query($sql2);           

            ?>
        <option value disabled selected>اختر موديل </option>

            <?php 
            while ($row=$result->fetch()) {
            ?>
 
        <option value="<?php echo $row["modelNo"]; ?>"><?php echo $row["modelName"]; ?></option>

        

    

        <?php
        }//model
        
    }//if post
        ?>
