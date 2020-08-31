<!DOCTYPE html>
<head>
    <title>Twitter-like App </title>
</head>
<html>
<body>

<input type="search" id="messagesearch" name="messagesearch" placeholder="Search...">
<input type="button" id="search-button" value="Search">
<input type="date" id="created-at" name="filter-created-at">
<?php
    $messages = $this->messages;

    if (empty($messages)) {
        echo "<p><i>No results to display</i></p>";
        echo "<hr>";
    }

    $userTimezone = new DateTimeZone('America/Bogota');
    $myDateTime = new DateTime();
    $myDateTime->setTimeZone($userTimezone);

    foreach ($messages as $message) {
        $myDateTime->setTimestamp($message['created_at']);
        $created_at = $myDateTime->format('Y-m-d');
        echo "<p><strong>{$created_at}</strong></p>";
        echo "<p>{$message['content']}</p>";
        echo "<p><strong>By: {$message['username']}</strong></p>";
        echo "<hr>";
    }
?>

<textarea id="new-message" name="new-message" rows="4" cols="50" placeholder="Write a comment...">
</textarea>
<input type="button" id="post-message" value="Submit">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

var searchValue = '<?php echo $this->searchValue; ?>';
var currentDateFilter = '<?php echo $this->currentDateFilter; ?>';
$(function() {
    $('#messagesearch').val(searchValue);

    if (currentDateFilter) {
        $('#created-at').val(currentDateFilter);
    } else {
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0,10);
        });

        $('#created-at').val(new Date().toDateInputValue());
    }


    $('#new-message').val('');

    $("#search-button").click(function(e){
        e.preventDefault();

        let untilDate = $('#created-at').val();

        let data = "created_at=" + untilDate + "&content=" +  $('#messagesearch').val();

        let URL = '/twitter-like-app/messages/search';
        $.post(URL,
            data,
            function(data, textStatus, jqXHR)
            {
                location.reload();
            }).fail(function(jqXHR, textStatus, errorThrown) 
            {
                alert('An error has occurred. Please try again'); 
            });
    });

    $("#post-message").click(function(e){
        e.preventDefault();

        if ($('#new-message').val().length > 0) {
            let data = "content=" +  $('#new-message').val();
            let URL = '/twitter-like-app/messages/add';
            $.post(URL,
                data,
                function(data, textStatus, jqXHR)
                {
                    alert('New mesage was successfully posted'); 
                    location.reload();
                }).fail(function(jqXHR, textStatus, errorThrown) 
                {
                    alert('An error has occurred. Please try again'); 
                });
            }

    });
});
</script>

</body>
</html>