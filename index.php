<?php include "functions.php"; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ======== Style ======== -->
        <link rel="stylesheet" href="./css/style-new.css">

        <!-- ======== Title ======== -->
        <title>Chatbot</title>
    </head>
    <body>
        <main class="main">
            <div class="header__text">
                Chatbot
            </div>

            <div class="chat__window">
                <ul class="chats">
                    <?php echo getChats() ?>
                </ul>
                <div class="chat__input">
                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
                        <input type="text" name="massage" placeholder="Type something..." autocomplete="off" required>
                        <button type="submit" name="send">
                            <img src="./images/bxs-send.svg.png" alt="send">
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>