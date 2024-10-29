<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/template/header.php"); ?>

<form action="index.php" method="POST" id="add_form">
    <table>
        <tr>
            <label for="events">Выберите событие:</label>
            <select id="event" name="event">
                <?php $events = $event->getEvents();?>
                <script>
                    var events = <?= json_encode($events) ?>;
                </script>
                <?php
                foreach ($events as $event) { ?>
                    <option value="<?=$event['id']?>"><?=$event['event_name']?></option>
                <?php }?>
            </select>
        </tr>
        <tr>
            <div id="results"></div>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Купить билет"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="hidden" id="submit" name="submit" value="true"></td>
        </tr>
    </table>
</form>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/template/footer.php"); ?>
