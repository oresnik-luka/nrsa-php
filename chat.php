<?php
    include "userClass.php";
    session_start();
    $title = "Sporočila";

    include "header.php";
    include "db.php";

    $query = "SELECT * FROM car_brands";
    $brands = $conn->query($query);
?>

<?php
    if(isset($_SESSION["user"])){ ?>
        <div class="chat">
            <div class="side">
                <h3>Sporočila</h3>
                <?php
                    $userId = $_SESSION["user"]->id;
                    $query = "SELECT * FROM messages WHERE fromId = '$userId' OR toId = '$userId' ORDER BY date DESC";
                    $messages = $conn->query($query);

                    $query = "SELECT COUNT(*) as count FROM messages WHERE fromId = '$userId' OR toId = '$userId'";
                    $count = $conn->query($query);
                    $count = $count->fetch_assoc();

                    $existingContacts = array();

                    if(isset($_GET["user"]) && $count["count"] <= 0){ 
                        $newContactId = $_GET["user"];
                        $query = "SELECT * FROM users WHERE id = '$newContactId'";
                        $newContact = $conn->query($query);
                        $newContact = $newContact->fetch_assoc();
                        ?>
                        <script>
                            setTimeout(() => {
                                setSelectedUserId(<?php echo $newContactId; ?>);
                            }, 10)
                        </script>
                        <div class="contact selected" onclick="setSelectedUser(this, <?php echo $newContactId; ?>)">
                            <?php echo $newContact["display_name"]; ?>
                        </div>
                    <?php }
                    while($message = $messages->fetch_assoc()){
                        if($message["fromId"] != $userId && !in_array($message["fromId"], $existingContacts)){
                            $contactId = $message["fromId"];
                            $existingContacts[] = $message["fromId"];
                        }
                        else if($message["toId"] != $userId && !in_array($message["toId"], $existingContacts)){
                            $contactId = $message["toId"];
                            $existingContacts[] = $message["toId"];
                        }
                        else{
                            continue;
                        }

                        $query = "SELECT * FROM users WHERE id = '$contactId'";
                        $contact = $conn->query($query);
                        $contact = $contact->fetch_assoc();
                        ?>
                        <div class="contact" onclick="setSelectedUser(this, <?php echo $contactId; ?>)">
                            <?php echo $contact["display_name"]; ?>
                        </div>
                    <?php }
                ?>
            </div>
            <div class="content">
                <div class="history">
                </div>
                <form class="chatBox" onsubmit="sendMessage(event, this)">
                    <input type="hidden" name="target" id="target">
                    <input type="hidden" name="location" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input type="text" name="message">
                    <input type="submit" value="Pošlji" disabled>
                </form>
            </div>
        </div>

        <?php 
    }
    else{ ?>
        <h2>Za ogled sporočil je potrebna prijava!</h2>
    <?php }
?>

<script>
    var selectedUserId;

    var refreshInterval = window.setInterval(function(){
        if(selectedUserId !== null && selectedUserId !== undefined){
            refreshMessages();
        }
    }, 500)

    async function sendMessage(event, form){
        event.preventDefault();
        
        const data = new URLSearchParams();
        for(const pair of new FormData(form)){
            data.append(pair[0], pair[1]);
        }

        fetch(`sendChatAction.php`, {
            method: "POST",
            body: data
        })
        .then(async () => {
            await refreshMessages(true);
            document.querySelector(".chatBox input[type='text']").value = "";
        })
    }

    async function refreshMessages(scroll = false){
        const history = document.querySelector(".history");

        const response = await fetch(`chatLoadMessages.php`);
        var messages = await response.json();

        messages = messages.filter((message) => (message.fromId == selectedUserId && message.toId == <?php echo $userId; ?> ) || (message.toId == selectedUserId && message.fromId == <?php echo $userId; ?> ));
        history.innerHTML = "";
        for(var message of messages){
            const elWrapper = document.createElement("div");
            elWrapper.classList.add("messageLine");
            const el = document.createElement("div");
            el.classList.add("message");
            if(message.fromId == selectedUserId){
                el.classList.add("messageLeft");
            }
            else{
                el.classList.add("messageRight");
            }
            el.innerHTML = message.content;

            elWrapper.appendChild(el);
            history.appendChild(elWrapper);

            if(scroll){
                history.scrollTop = history.scrollHeight;
            }
        }
    }

    function setSelectedUser(sender, id){
        selectedUserId = id;
        document.querySelector(".selected")?.classList.remove("selected");
        sender.classList.add("selected");
        document.querySelector("#target").value = selectedUserId;
        document.querySelector(".chatBox input[type='submit']").disabled = false;

        refreshMessages();        
    }
    function setSelectedUserId(id){
        selectedUserId = id;
        document.querySelector("#target").value = selectedUserId;
        document.querySelector(".chatBox input[type='submit']").disabled = false;

        refreshMessages();
    }
</script>
<?php include "footer.php"; ?>