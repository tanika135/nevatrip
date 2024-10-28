<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/template/header.php"); ?>

</table>

<table>
    <form action="index.php" method="POST" id="add_form">
        <input type="hidden" name="task_id" value="'.$taskId.'">
        <tr>
            <label for="events">Выберите событие:</label>
            <select id="event" name="event">
                <?php $events = $event->getEvent();
                foreach ($events as $event) { ?>
                    <option value="<?=$event[0]?>"><?=$event[0]?></option>
                <?php }?>
            </select>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Купить билет"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="hidden" id="submit" name="submit" value="true"></td>
        </tr>
    </form>
</table>
<div id="results"></div>

<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/template/footer.php"); ?>
