<?php 

function getCurrentTime()
{
    date_default_timezone_set("Asia/Kolkata");
    return date("g:i a");
}

function getChats()
{
    include "config.php";
    $timestamp = getCurrentTime();

    if(isset($_POST["send"]))
    {
        $result = mysqli_query($conn, "SELECT * FROM chat_history");

        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                echo "
                    <li class='chat__${row['role']}'>
                        <div class='chat'>
                            ${row['message']}
                        </div>
                        <div class='timestamp'>
                            <img src='./images/bxs-time.svg' alt='time'>
                            ${row['timestamp']}
                        </div>
                    </li>
                ";
            }
        }
        
        $massage = mysqli_real_escape_string($conn, $_POST["massage"]);

        $sql = "SELECT reply FROM chat WHERE question LIKE '%${massage}%'";
        $result = mysqli_query($conn, $sql);

        mysqli_query($conn,
            "INSERT INTO chat_history(message, timestamp, role)
             VALUES('$massage', '$timestamp', 'user')"
        );

        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $botMassage = $row["reply"];
            
            mysqli_query($conn,
                "INSERT INTO chat_history(message, timestamp, role)
                VALUES('$botMassage', '$timestamp', 'bot')"
            );
        } 
        else
        {
            $botMassage = "Sorry not be able to understand you";

            mysqli_query($conn,
                "INSERT INTO chat_history(message, timestamp, role)
                 VALUES('$botMassage', '$timestamp', 'bot')"
            );
        }

        echo "
            <li class='chat__user'>
                <div class='chat'>
                    ${massage}
                </div>
                <div class='timestamp'>
                    <img src='./images/bxs-time.svg' alt='time'>
                    ${timestamp}
                </div>
            </li>
            <li class='chat__bot'>
                <div class='chat'>
                    ${botMassage}
                </div>
                <div class='timestamp'>
                    <img src='./images/bxs-time.svg' alt='time'>
                    ${timestamp}
                </div>
            </li>
        ";
    }
    else
    {
        mysqli_query($conn, "TRUNCATE TABLE chatbot.chat_history");

        echo "
            <li class='chat__bot'>
                <div class='chat'>
                    Welcome, how can I help you?
                </div>
                <div class='timestamp'>
                    <img src='./images/bxs-time.svg' alt='time'>
                    ${timestamp}
                </div>
            </li>
        ";
    }
}