<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Form</title>
    <style>
        .form{
            margin: auto;
            width: 550px;
            height: 370px;
            /*background-color: yellow;*/
            border-style: solid;
            border-width: 2px;
            border-radius: 5px;
            border-color: yellow;
        }
        .titles{
            margin-left: 5px;
        }
        h3{
            text-align: center;
            color: green;
        }
        p{
            text-align: center;
            color: red;
        }
        .error{
            color: orange;
        }
        .boxbutton{
            /*background-color: #8E9CB2;*/
            width: 200px;
            height: 50px;
            margin:auto;
        }
        .record{
            width: 230px;
            height: 20px;
            margin: 15px auto;
            /*background-color: gray;*/
        }
        .record .new{
            color: red;
        }
        .button{
            margin-top: 10px;
            margin-left: 50px;
            width: 100px;
            height: 40px;
            border-style: solid;
            border-width: thin;
            border-color: black;
            border-radius: 5px;
            background-color: red;
            cursor: pointer;
            box-shadow: 4px 4px 5px #888888;
            outline: none;
        }
        .button:active{
            box-shadow: none;
        }
        @media only screen and (max-width: 1000px) {
            .form{
                margin: auto;
                width: 400px;
                height: 420px;
                /*background-color: yellow;*/
                border-style: solid;
                border-width: 2px;
                border-radius: 5px;
                border-color: yellow;
            }
            .titles{
                margin-left: 5px;
            }
            .error{
                color: orange;
            }
            .boxbutton{
                /*background-color: #8E9CB2;*/
                width: 200px;
                height: 60px;
                margin:auto;
            }
            .button{
                position: fixed;
                margin-top: 10px;
                margin-left: 50px;
                width: 100px;
                height: 40px;
                border-style: solid;
                border-width: 1px;
                border-color: black;
                border-radius: 5px;
                background-color: green;
                cursor: pointer;
                box-shadow: 4px 4px 5px #888888;
                outline: none;
            }
            .button:active{
                box-shadow: none;
            }
            .record{
                width: 230px;
                height: 20px;
                margin: 15px auto;
                /*background-color: gray;*/
            }
            .record .new{
                color: red;
            }
        }
    </style>
</head>

<?php
$name_Err = $surname_Err = $email_Err = $institute_Err = $phone_Err = "";
$name = $surname = $email = $institute = $phonenumber = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["myname"])) {
        $name_Err = "Name is Required";
    } else {
        $name = $_POST["myname"];
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $name_Err = "There should exist only letters and whitespaces";
        }
    }
    if (empty($_POST["mysurname"])) {
        $surname_Err = "Surname is Required";
    } else {
        $surname = $_POST["mysurname"];
        if (!preg_match("/^[a-zA-Z ]*$/", $surname)) {
            $surname_Err = "There should exist only letters and whitespaces";
        }
    }
    if (empty($_POST["myemail"])) {
        $email_Err = "Email is Required";
    } else {
        $email = $_POST["myemail"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_Err = "Email is not valid";
        }
    }
    if (empty($_POST["myinstitute"])) {
        $institute = "";
    } else {
        $institute = $_POST["myinstitute"];
        if (!preg_match("/^[a-zA-Z ]*$/", $institute)) {
            $institute_Err = "There should exist only letters and whitespaces";
        }
    }
    if (empty($_POST["mynumber"])) {
        $phonenumber = "";
    } else {
        $phonenumber = $_POST["mynumber"];
        if (!preg_match("/^[1-9][0-9]{0,8}$/", $phonenumber)) {
            $phone_Err = "There should exist only 9 integers ";
        }
    }
}
$servername = "localhost";
$username = "root";
$password = "MeriumHazem#1997";
$dbname = "";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (!empty($_POST["myname"]) && !empty($_POST["mysurname"]) && !empty($_POST["myemail"]) && !empty($_POST["myinstitute"])
    && !empty($_POST["mynumber"]) && preg_match("/^[a-zA-Z ]*$/", $name) && preg_match("/^[a-zA-Z ]*$/", $surname)
    && filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[a-zA-Z ]*$/", $institute) &&
    preg_match("/^[1-9][0-9]{0,8}$/", $phonenumber)){

    $sql = "INSERT INTO sys.form (name, surname, email, institute, phonenumber)
    VALUES ('$name' , '$surname' , '$email' , '$institute' , '$phonenumber')";

    if (mysqli_query($conn, $sql)) {
        $new_record = "*New record created successfully!*";
    }
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<body>

<div class="form">
    <h3>Fill the form please</h3>
    <p>* is Required</p>

    <form method="post" action="form.php" >
       <div class="titles"> Name:<input type="text" name="myname"/>
        <span class="error">*<?php echo $name_Err; ?></span>
        <br><br>
        Surname:<input type="text" name="mysurname"/>
        <span class="error">*<?php echo $surname_Err; ?></span>
        <br><br>
        E-mail:<input type="text" name="myemail"/>
        <span class="error">*<?php echo $email_Err; ?></span>
        <br><br>
        Institute:<input type="text" name="myinstitute"/>
        <span class="error"><?php echo $institute_Err; ?></span>
        <br><br>
        PhoneNumber:<input type="number" name="mynumber"/>
        <span class="error"><?php echo $phone_Err; ?></span>
        <br><br>
       </div>
        <div class="boxbutton"><input class="button" type="submit" name="Submit"/></div>
    </form>
</div>

<div class="record"><span class="new"><?php echo $new_record; ?></span></div>


</body>
</html>
